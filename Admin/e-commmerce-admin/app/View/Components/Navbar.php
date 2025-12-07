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

     
        return view('components.navbar', [
                'user' => $this->user,
                'userData' => $this->getUserData(),
                'isAuthenticated' => $this->isAuthenticated()
            ]);
        
        
        
    }
}