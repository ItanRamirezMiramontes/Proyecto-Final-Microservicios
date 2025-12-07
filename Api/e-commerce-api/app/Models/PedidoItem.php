<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;
    
    // Define explícitamente la tabla de la base de datos
    protected $table = 'pedido_items';
    
    // Permite asignación masiva para estos campos 
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario'
    ];
    
    protected $casts = [
        'precio_unitario' => 'decimal:2'
    ];
    
    // Relación inversa: Un ítem pertenece a un Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
    
    // Relación: Un ítem corresponde a un Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}