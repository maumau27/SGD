<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Acesso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routeArray = app('request')->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $action) = explode('@', $controllerAction);
        list($controller, $empty) = explode("Controller", $controller);

        //se a ação é do tipo post. remover _post
        if(str_contains($action, "_post"))
            list($action, $empty) = explode('_post', $action);

        $permissoes = DB::table("Perfil")
                        ->join("UsuarioPerfil", "UsuarioPerfil.idPerfil", "=" ,"Perfil.id")
                        ->join("Usuarios", "Usuarios.id", "=" ,"UsuarioPerfil.idUsuario")
                        ->join("PerfilPermissoes", "PerfilPermissoes.idPerfil", "=" ,"Perfil.id")
                        ->join("Permissoes", "Permissoes.id", "=" ,"PerfilPermissoes.idPermissoes")
                        ->select('Permissoes.Controller', 'Permissoes.Action')
                        ->where('Usuarios.id', '=', Auth::user()->id)
                        ->distinct('Permissoes.id')
                        ->get();
             
        foreach($permissoes as $permissao)
        {
            if(strtolower($permissao->Controller) == strtolower($controller) && strtolower($permissao->Action) == strtolower($action))
                return $next($request);
        }

        return redirect()->back()->withErrors([
            'Acesso' => 'Usuario não tem acesso a essa função.',
        ]);
    }
}
