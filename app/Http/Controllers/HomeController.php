<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function index(Request $request)
    {
        $consultas = Consulta::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return Inertia::render('Home', [
            'consultas' => $consultas,
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'consulta_reciente' => $request->session()->get('consulta_reciente'),
            'auth' => [
                'user' => [
                    'name' => Auth::user()->name,
                    'curp' => Auth::user()->curp,
                ]
            ]
        ]);
    }


}
