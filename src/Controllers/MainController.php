<?php

namespace JorarMarfin\MiPaquete\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return "Hola mundo";
    }
    public function youtube()
    {
        return 'youtube';
    }
}