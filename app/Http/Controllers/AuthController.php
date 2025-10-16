<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm(){
        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /* ************************************************************************
     *
     * PARA LA API
     *
    *************************************************************************** */

    public function login_api(Request $request){

        $request->validate([
            'curp' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('curp', $request->curp)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'curp' => ['Las credenciales son incorrectas.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken
        ]);
    }


}
