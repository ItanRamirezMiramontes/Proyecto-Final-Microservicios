<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
     
    protected $table = 'usuarios'; 

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'direccion',
        'imagen',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function isAdmin()
    {
        return $this->rol_id === 1; 
    }

    public function isCliente()
    {
        return $this->rol_id === 2; 
    }

    public function carritoItems()
    {
        return $this->hasMany(CarritoItem::class, 'usuario_id');
    }
}