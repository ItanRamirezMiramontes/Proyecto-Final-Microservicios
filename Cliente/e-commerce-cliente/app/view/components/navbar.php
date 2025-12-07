<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Navbar extends Component
{
    /**
     * El usuario autenticado (o null).
     * Esta propiedad se pasa automáticamente a la vista seleccionada.
     * @var User|null
     */
    public $user;

   

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    

    /**
     * Determine if the user is authenticated
     */
    public function isAuthenticated()
    {
        return $this->user !== null;
    }

    /**
     * Get user data for the navbar
     */
    public function getUserData()
    {
        if (!$this->user) {
            return null;
        }

        return [
            'nombre' => $this->user->nombre,
            'apellido' => $this->user->apellido,
            'nombre_completo' => $this->user->nombre . ' ' . $this->user->apellido,
            'imagen' => $this->user->imagen,
            'rol_id' => $this->user->rol_id
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * Aquí es donde decidimos qué vista mostrar basándonos
     * en los archivos que creaste.
     */
    public function render()
    {
        // 1. Si NO hay usuario (Invitado)
        if (!$this->user) {
            // Carga: components.navbar-publico
            return view('components.navbar_public');
        }

        // 2. Si hay usuario Y es Admin (rol_id == 1)
        if ($this->user->rol_id == 1) { 
            // Carga: components.navbar-admin
            // La vista recibirá automáticamente la variable $user
            return view('components.navbar_admin', [
                'user' => $this->user,
                'userData' => $this->getUserData(),
                'isAuthenticated' => $this->isAuthenticated()
            ]);
        }
        
        // 3. Si hay usuario Y NO es Admin (es Cliente)
        // Carga: components.navbar-cliente
        return view('components.navbar_cliente', [
            'user' => $this->user,
            'userData' => $this->getUserData(),
            'isAuthenticated' => $this->isAuthenticated()
        ]);
    }
}