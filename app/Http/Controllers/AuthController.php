<?php

namespace App\Http\Controllers;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Passowrd: josemar@2005 || Email: josemar21@outlook.pt
    // Metódo de login
    public function logar(AuthRequest $request)
    {
        $request->validated();
        // dd(password_hash('josemar@2005', PASSWORD_DEFAULT)); 
        $credencials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        $permanecerLogado = false;

        if (! empty($request->keep)) {
           $permanecerLogado = true;
        }

        $autenticado = Auth::attempt($credencials, $permanecerLogado);

        if ($autenticado === false) {
            return redirect()->back()->withInput()->with('erro', 'Email ou senha inválida!');
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
