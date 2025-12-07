<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'direccion_envio',
        'metodo_pago',
        'subtotal',     
        'impuestos',    
        'total',        
        'estado',
        'fecha_pedido'
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con los items 
    public function items()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_id');
    }
}