<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

// Modelos
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\CarritoItem;
use App\Models\Producto;

class PedidoController extends Controller
{
    /**
     * 
     * Convierte los items del carrito (BD) en una orden confirmada.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'direccion_envio' => 'required|string|max:500',
            'metodo_pago'     => 'required|string|in:tarjeta,efectivo,transferencia',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Usamos el helper auth() o Auth facade
            $usuario = Auth::user(); 
            
            // 2. Obtener items del carrito de la Base de Datos
            // Usamos 'lockForUpdate' para prevenir problemas de concurrencia en el stock
            $carritoItems = CarritoItem::where('usuario_id', $usuario->id)
                ->with(['producto' => function($query) {
                    $query->lockForUpdate(); 
                }])
                ->get();

            if ($carritoItems->isEmpty()) {
                DB::rollBack();
                return response()->json([
                    'success' => false, 
                    'message' => 'Tu carrito está vacío. Agrega productos antes de confirmar el pedido.'
                ], 400);
            }
            
            $subtotal = 0;
            
            // 3. Validar Stock y Calcular Totales
            foreach ($carritoItems as $item) {
                // Verificar si el producto aún existe
                if (!$item->producto) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Uno de los productos en tu carrito ya no existe.'], 409);
                }

                // Verificar stock disponible
                if ($item->producto->stock < $item->cantidad) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false, 
                        'message' => "Stock insuficiente para: {$item->producto->nombre}. Disponibles: {$item->producto->stock}"
                    ], 400);
                }
                
                // Sumar al subtotal
                $subtotal += $item->producto->precio * $item->cantidad;
            }
            
            // Cálculos finales
            $impuestos = $subtotal * 0.16; // 16% IVA
            $total     = $subtotal + $impuestos;
            
            // 4. Crear el Pedido (Padre)
            $pedido = Pedido::create([
                'usuario_id'      => $usuario->id,
                'direccion_envio' => $request->direccion_envio,
                'metodo_pago'     => $request->metodo_pago,
                'subtotal'        => $subtotal,
                'impuestos'       => $impuestos,
                'total'           => $total,
                'estado'          => 'pendiente',
                'fecha_pedido'    => now()
            ]);
            
            // 5. Crear los Items del Pedido y Descontar Stock
            foreach ($carritoItems as $item) {
                PedidoItem::create([
                    'pedido_id'       => $pedido->id,
                    'producto_id'     => $item->producto_id,
                    'cantidad'        => $item->cantidad,
                    'precio_unitario' => $item->producto->precio // Guardamos el precio histórico
                ]);
                
                // Restar del inventario
                $item->producto->decrement('stock', $item->cantidad);
            }
            
            // 6. Limpiar el Carrito 
            CarritoItem::where('usuario_id', $usuario->id)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Pedido creado exitosamente',
                'data'    => $pedido->load('items') 
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Error al procesar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function index()
    {
        $usuario = Auth::user();
        $pedidos = Pedido::where('usuario_id', $usuario->id)
            ->with('items.producto')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['success' => true, 'data' => $pedidos]);
    }

    public function show($id)
    {
        $usuario = Auth::user();
        $pedido = Pedido::where('usuario_id', $usuario->id)
            ->where('id', $id)
            ->with(['items.producto'])
            ->first();
            
        if (!$pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        }
        
        return response()->json(['success' => true, 'data' => $pedido]);
    }
    /**
 * Cancelar un pedido pendiente
 */
public function cancelar($id)
{
    try {
        DB::beginTransaction();
        
        $usuario = Auth::user();
        
        // Buscar el pedido del usuario
        $pedido = Pedido::where('usuario_id', $usuario->id)
            ->where('id', $id)
            ->lockForUpdate() 
            ->first();
            
        if (!$pedido) {
            return response()->json([
                'success' => false, 
                'message' => 'Pedido no encontrado'
            ], 404);
        }
        
        // Solo se pueden cancelar pedidos pendientes
        if ($pedido->estado !== 'pendiente') {
            return response()->json([
                'success' => false, 
                'message' => 'Solo se pueden cancelar pedidos en estado pendiente. Estado actual: ' . $pedido->estado
            ], 400);
        }
        
        // Devolver el stock a los productos
        foreach ($pedido->items as $item) {
            $producto = Producto::find($item->producto_id);
            if ($producto) {
                $producto->increment('stock', $item->cantidad);
            }
        }
        
        // Cambiar estado del pedido
        $pedido->estado = 'cancelado';
        $pedido->fecha_cancelacion = now();
        $pedido->save();
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Pedido cancelado exitosamente',
            'data' => $pedido
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false, 
            'message' => 'Error al cancelar el pedido: ' . $e->getMessage()
        ], 500);
    }
}
}