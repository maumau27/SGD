<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Auth;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Função de initialização. Chama o __contruct pai e inicializa os middleware a serem ultilizados.
     *
    */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //Compatilha a variavel para todas as views
            View::share('itensMenu', $this->getUsuarioMenu());
            return $next($request);
        });
    }

    /**
     * Cria a lista com os itemMenu do usuario logado. ItemMenu do usuario são pegos atraves das permissões que ele tem dado seus perfils
     *
     * @return {array} retorna uma array com os itensMenu do usuario que está logado no sistema
    */
    public function getUsuarioMenu()
    {
        //Checa que o usuario está logado
        if(Auth::check())
        {
            //Array para armazenar os itensMenu
            $itens = array();
            //Pega o usuario logado
            $usuario = Auth::user();

            //TODO - corrigir para funcionar para todos os perfis
            //Para cada permissão do usuario
            foreach($usuario->perfil[0]->permissoes as $permissao)
            {
                //Pega o itemMenu vinculado a essa permissão
                $item = $permissao->itemMenu;
                //Testa se o item não é null
                if($item != null)
                {
                    //single menu. Caso o Menu do item seja null, temos um unico item de menu
                    if($item->Menu == null)
                    {
                        //Adiciona a array de ItemMenu o novo item, com os devidos parametros
                        $itens[$item->Item] = ["SubMenu" => false, "Nome" => $item->Item, "Controller" => $permissao->Controller, "Action" => $permissao->Action];
                    }
                    //cascading menu. Caso o Menu do item não seja null, temos um menu em cascata.
                    else
                    {
                        //Se não existe o menu na array
                        if(!array_key_exists($item->Menu, $itens))
                            //Adiciona o nove menu com os devidos parametros
                            $itens[$item->Menu] = ["SubMenu" => true, "Itens" => [["Nome" => $item->Item, "Controller" => $permissao->Controller, "Action" => $permissao->Action]]];
                        //Caso o menu ja exista
                        else
                            //Adiciona o novo item, com os devidos parametros
                            array_push($itens[$item->Menu]["Itens"], ["Nome" => $item->Item, "Controller" => $permissao->Controller, "Action" => $permissao->Action]);
                    }
                }
                    
            }
    
            //Retorna a array de itemMenu
            return $itens;
        }

        //Retorna null, caso falhe de encontrar o usuario
        return null;
    }
}
