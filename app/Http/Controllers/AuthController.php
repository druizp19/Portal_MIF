<?php

namespace App\Http\Controllers;

use App\Application\UseCases\LoginWithMicrosoftUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(
        private LoginWithMicrosoftUseCase $loginUseCase
    ) {}

    public function showLogin()
    {
        if (Session::has('usuario')) {
            return redirect()->route('sistemas.index');
        }
        
        return view('auth.login');
    }

    public function redirectToMicrosoft()
    {
        return $this->loginUseCase->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            \Log::info('Iniciando callback de Microsoft');
            
            $result = $this->loginUseCase->handleCallback();
            
            \Log::info('Resultado del callback:', $result);

            if (!$result['success']) {
                \Log::warning('Login fallido: ' . $result['message']);
                return redirect()->route('login')
                    ->with('error', $result['message']);
            }

            \Log::info('Redirigiendo a sistemas');
            return redirect()->route('sistemas.index');
        } catch (\Exception $e) {
            \Log::error('Excepción en handleMicrosoftCallback: ' . $e->getMessage());
            \Log::error('Stack: ' . $e->getTraceAsString());
            
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Session::forget('usuario');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }

    public function logoutSSO(Request $request)
{
    Session::forget('usuario');
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
}


}
