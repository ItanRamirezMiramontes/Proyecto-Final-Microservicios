<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardProduct extends Component
{
    public $producto;
    
    /**
     * Create a new component instance.
     */
    public function __construct($producto)
    {
        $this->producto = $producto;
    }

}