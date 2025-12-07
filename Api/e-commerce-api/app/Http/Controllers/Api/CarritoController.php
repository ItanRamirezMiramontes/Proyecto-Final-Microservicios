<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarritoController extends Controller
{
    /**
     * Listar items del carrito y calcular totales
     */
    public function index(Request $request)
    {
        try {
            $usuario = auth()->user();
            
            // Cargamos el producto para obtener precio y nombre actual
            $carritoItems = CarritoItem::with('producto')
                ->where('usuario_id', $usuario->id)
                ->get();
            
            $subtotal = 0;
            $itemsLimpios = [];

            foreach ($carritoItems as $item) {
                if ($item->producto) {
                    $costoItem = $item->producto->precio * $item->cantidad;
                    $subtotal += $costoItem;

                    $itemsLimpios[] = [
                        'id' => $item->id,
                        'producto_id' => $item->producto_id,
                        'nombre' => $item->producto->nombre,
                        'precio' => $item->producto->precio,
                        'cantidad' => $item->cantidad,
                        'imagen' => $item->producto->imagen, 
                        'subtotal' => $costoItem,
                        'stock_disponible' => $item->producto->stock
                    ];
                }
            }
            
            $impuestos = $subtotal * 0.16; 
            $total = $subtotal + $impuestos;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'items' => $itemsLimpios,
                    'resumen' => [
                        'subtotal' => round($subtotal, 2),
                        'impuestos' => round($impuestos, 2),
                        'total' => round($total, 2),
                        'cantidad_items' => $carritoItems->sum('cantidad')
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Agregar item (o sumar cantidad si ya existe)
     */
    public function agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|integer|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            $usuario = auth()->user();
            $producto = Producto::find($request->producto_id);
            
            // Buscar si ya existe
            $itemExistente = CarritoItem::where('usuario_id', $usuario->id)
                ->where('producto_id', $request->producto_id)
                ->first();
            
            $cantidadNueva = $request->cantidad + ($itemExistente ? $itemExistente->cantidad : 0);
            
            // Validar Stock
            if ($producto->stock < $cantidadNueva) {
                DB::rollBack();
                return response()->json([
                    'success' => false, 
                    'message' => "Stock insuficiente. Solo quedan {$producto->stock} unidades."
                ], 400);
            }
            
            if ($itemExistente) {
                $itemExistente->cantidad = $cantidadNueva;
                $itemExistente->save();
            } else {
                $itemExistente = CarritoItem::create([
                    'usuario_id' => $usuario->id,
                    'producto_id' => $request->producto_id,
                    'cantidad' => $request->cantidad
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Producto agregado al carrito',
                'data' => $itemExistente
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Actualizar cantidad de un item específico
     */
    public function actualizar(Request $request, $id)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);
        
        try {
            $usuario = auth()->user();
            $item = CarritoItem::with('producto')
                ->where('usuario_id', $usuario->id)
                ->where('id', $id)
                ->first();
                
            if (!$item) {
                return response()->json(['success' => false, 'message' => 'Item no encontrado'], 404);
            }
            
            if ($item->producto->stock < $request->cantidad) {
                return response()->json([
                    'success' => false, 
                    'message' => "Stock insuficiente. Máximo disponible: {$item->producto->stock}"
                ], 400);
            }
            
            $item->cantidad = $request->cantidad;
            $item->save();
            
            return response()->json(['success' => true, 'message' => 'Cantidad actualizada']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Eliminar item del carrito
     */
    public function eliminar($id)
    {
        $usuario = auth()->user();
        $deleted = CarritoItem::where('usuario_id', $usuario->id)->where('id', $id)->delete();
        
        return $deleted 
            ? response()->json(['success' => true, 'message' => 'Eliminado del carrito'])
            : response()->json(['success' => false, 'message' => 'Item no encontrado'], 404);
    }
}