<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos'; 

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'marca_id',
        'imagen_1',
        'imagen_2',
        'imagen_3',
    ];

    protected $casts = [
        'precio' => 'decimal:2', 
        'stock' => 'integer',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

}