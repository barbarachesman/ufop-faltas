<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Renderiza a página inicial do sistema.
     */
    public function home()
    {
        return view('inicio');
    }

    public function tutorial()
    {
        return view('tutorial');
    }

    /**
     * Renderiza a view contento informações sobre o sistema.
     */
    public function sobre()
    {
        return view('sobre');
    }
}
