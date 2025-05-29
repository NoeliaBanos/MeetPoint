<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/HomeController.php
class HomeController extends Controller
{
    public function index()
    {
        return view('index');   // o la vista que quieras
    }
}
