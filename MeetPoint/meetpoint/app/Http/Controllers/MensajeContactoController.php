<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MensajeContactoController extends Controller
{
    public function create()
    {
        return view('contacto.create'); // Asegúrate de tener la vista 'contacto.create'
    }

    public function store()
    {
        // Lógica para guardar un mensaje de contacto
    }
}
