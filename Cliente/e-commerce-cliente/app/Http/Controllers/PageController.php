<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Muestra la página "Sobre Nosotros"
     */
    public function sobreNosotros()
    {
        return view('sobre_nosotros');
    }

    /**
     * Muestra la página de contacto
     */
    public function contacto()
    {
        return view('contacto');
    }

    /**
     * Muestra los términos y condiciones
     */
    public function terminosCondiciones()
    {
        return view('terminos_condiciones');
    }
}