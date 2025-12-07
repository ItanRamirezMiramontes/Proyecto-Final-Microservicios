<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    use HasFactory;
    
    protected $table = 'carrito_items';
    
    protected $fillable = [
        'usuario_id',
        'producto_id',
        'cantidad'
    ];
    
    protected $casts = [
        'cantidad' => 'integer'
    ];
    
    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    
    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
    // Calcular subtotal del item
    public function getSubtotalAttribute()
    {
        if ($this->producto) {
            return $this->producto->precio * $this->cantidad;
        }
        return 0;
    }
}