<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->action([SubscribedController::class, 'index']);
        }
        return view('user.login');
    }

    public function handleLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $this->validate(
            $request,
            [
                'email' => "required",
                "password" => "required"
            ],
            [
                "email.required" => "Email obrigatório",
                "password.required" => "Senha obrigatório"
            ]
        );

        try {
            if (Auth::guard()->attempt(['email' => $email, 'password' => $password], false)) {
                return redirect()->action([SubscribedController::class, 'index']);
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Email ou senha inválida');
            }
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
