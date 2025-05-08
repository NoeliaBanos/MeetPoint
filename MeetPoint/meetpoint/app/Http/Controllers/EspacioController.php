<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espacio;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::all();
        return view('espacios.index', compact('espacios')); // Asegúrate de tener la vista 'espacios.index'
    }

    public function show($id)
    {
        $espacio = Espacio::findOrFail($id);
        return view('espacios.show', compact('espacio')); // Asegúrate de tener la vista 'espacios.show'
    }

    public function adminDashboard()
    {
        return view('admin.dashboard'); // Asegúrate de tener la vista 'admin.dashboard'
    }
}
