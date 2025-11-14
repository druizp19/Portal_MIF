<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\UsuarioRepositoryInterface;
use App\Services\SSOTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SistemaController extends Controller
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository,
        private SSOTokenService $ssoTokenService
    ) {}

    public function index()
    {
        if (!Session::has('usuario')) {
            return redirect()->route('login');
        }

        $usuario = $this->usuarioRepository->findByEmail(Session::get('usuario.correo'));
        
        // Debug: Log del usuario
        \Log::info('Usuario ID: ' . $usuario->idUsuario);
        \Log::info('Usuario correo: ' . $usuario->correo);
        
        // Obtener los sistemas a los que el usuario tiene acceso desde TAB_USUARIO_ROL
        $sistemasDisponibles = \DB::table('ODS.TAB_USUARIO_ROL')
            ->join('ODS.TAB_SISTEMA', 'ODS.TAB_USUARIO_ROL.idSistema', '=', 'ODS.TAB_SISTEMA.idSistema')
            ->where('ODS.TAB_USUARIO_ROL.idUsuario', $usuario->idUsuario)
            ->pluck('ODS.TAB_SISTEMA.sistema')
            ->unique()
            ->toArray();

        // Debug: Log de sistemas encontrados
        \Log::info('Sistemas disponibles: ', $sistemasDisponibles);
        \Log::info('Config sistemas: ', array_keys(config('sistemas.sistemas')));

        return view('sistemas.index', compact('sistemasDisponibles'));
    }

    public function redirectToSistema(Request $request, string $sistemaKey)
    {
        if (!Session::has('usuario')) {
            return redirect()->route('login');
        }

        $usuario = $this->usuarioRepository->findByEmail(Session::get('usuario.correo'));

        // Obtener el rol del usuario y la URL del sistema
        $sistemaInfo = \DB::table('ODS.TAB_USUARIO_ROL')
            ->join('ODS.TAB_SISTEMA', 'ODS.TAB_USUARIO_ROL.idSistema', '=', 'ODS.TAB_SISTEMA.idSistema')
            ->join('ODS.TAB_ROL', 'ODS.TAB_USUARIO_ROL.idRol', '=', 'ODS.TAB_ROL.idRol')
            ->where('ODS.TAB_USUARIO_ROL.idUsuario', $usuario->idUsuario)
            ->where('ODS.TAB_SISTEMA.sistema', $sistemaKey)
            ->select('ODS.TAB_ROL.rol', 'ODS.TAB_ROL.idRol', 'ODS.TAB_SISTEMA.urlSistema')
            ->first();

        if (!$sistemaInfo) {
            return redirect()->route('sistemas.index')
                ->with('error', 'No tienes acceso a este sistema');
        }

        // Generar token SSO con información del rol
        $token = $this->ssoTokenService->generateToken([
            'idUsuario' => $usuario->idUsuario,
            'correo' => $usuario->correo,
            'usuario' => $usuario->usuario,
            'sistema' => $sistemaKey,
            'rol' => $sistemaInfo->rol ?? null,
            'idRol' => $sistemaInfo->idRol ?? null
        ]);

        // Usar la URL de la base de datos
        $url = $sistemaInfo->urlSistema;

        if (!$url) {
            return redirect()->route('sistemas.index')
                ->with('error', 'URL del sistema no configurada');
        }

        // Redirigir con el token
        return redirect()->away($url . '/sso/login?token=' . $token);
    }
}
