<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

//        dd($consultas);

        return Inertia::render('Home', [
            'consultas' => $consultas
        ]);
    }
}
