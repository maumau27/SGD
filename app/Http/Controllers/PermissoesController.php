<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use App\Models\Permissoes;


/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class PermissoesController extends Controller
{
    /**
     * Função de initialização. Chama o __contruct pai e inicializa os middleware a serem ultilizados.
     *
    */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('acesso');
    }

    /**
     * Efetua o filtro e a ordenação da tabela, pagina e retorna a view para o index
     *
     * @param {request} contem o request do formulario, enviado por POST
     * @return {view} retorna a view index, contendo os filtros e a tabela ja paginada e filtrada
    */
    public function index(Request $request)
    {
        //Aplica o filtro, ordenação e paginação
        $permissoes = Permissoes::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('permissoes.index', ['permissoes' => $permissoes])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de permissoes.
     *
     * @return {view} retorna a view add
    */
    public function add(Request $request)
    {
        //Retorna a view
        return view('permissoes.add');
    }

    /**
     * Efetua a inserção de uma nova permissão no banco. 
     *
     * @param {request} contem o request do formulario, com as informações da permissão a ser adicionada
     * @return {redirect} retorna um redirecionamento para permissoes/index
    */
    public function add_post(Request $request)
    {
        //valida os dados do request
        $validatedData = $request->validate([
            'Nome' => '',
            'Controller' => '',
            'Action' => '', 
        ]);

        //Cria a permissão com os dados validados
        $permissao = Permissoes::create($validatedData);

        //redireciona para permissoes/index
        return redirect('/permissoes/index')->with("MensagensToast", ["Permissao registrada com sucesso!"]);
    }
    
    /**
     * Display a pagina de edit de permissão.
     *
     * @param {permissao} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit com a permissão a ser editada
    */
    public function edit(Permissoes $permissao)
    {
        //Retorna a view com os parametros necessarios
        return view('permissoes.edit', ['permissao' => $permissao]);
    }

    /**
     * Efetua a atualização de uma permissão no banco.
     *
     * @param {permissao} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações da permissão a ser atualizada
     * @return {view} retorna um redirecionamento para permissoes/index
    */
    public function edit_post(Request $request, Permissoes $permissao)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Nome' => '',
            'Controller' => '',
            'Action' => '', 
        ]);

        //Atualiza a permissão com os dados validados
        $permissao->update($validatedData);

        //redireciona para permissoes/index
        return redirect('/permissoes/index')->with(['MensagensToast' => ['Permissao atualizada com sucesso!']]);
    }

    /**
     * Deleta a permissão recebida como parametro. Remove os vinculos com perfil e itemMenu
     *
     * @param {permissao} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para permissoes/index
    */
    public function delete(Permissoes $permissao)
    {
        //Desvincula as relações com os perfils que tem a permissão
        $permissao->perfil()->detach();
        //Desvincula o itemMenu associado a permissão
        if($permissao->itemMenu != null)
        {
            $permissao->itemMenu->idPermissoes = 0;
            $permissao->itemMenu->save();
        }
        //deleta a permissão
        $permissao->delete();

        //redireciona para permissoes/index
        return redirect('/permissoes/index')->with(["MensagensToast" => ["Permissao Removida Com Sucesso!"]]);
    }
}
