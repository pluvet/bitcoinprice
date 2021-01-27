<?php

namespace App\Http\Controllers;

use App\Models\Bitcoin;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function show(){

        $consultas = Bitcoin::all();

        return $consultas;
    }
}
