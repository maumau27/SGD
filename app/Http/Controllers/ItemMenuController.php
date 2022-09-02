<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use App\Models\ItemMenu;
use App\Models\Permissoes;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class ItemMenuController extends Controller
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
        $itemMenus = ItemMenu::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('itemMenu.index', ['itemMenus' => $itemMenus])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de itemMenu.
     *
     * @return {view} retorna a view add, contendo todas as permissões
    */
    public function add(Request $request)
    {
        //Retorna a view com os parametros necessarios
        return view('itemMenu.add', ["Permissoes" => Permissoes::all()]);
    }

    /**
     * Efetua a inserção de um novo itemMenu no banco. 
     *
     * @param {request} contem o request do formulario, com as informações do itemMenu a ser adicionada
     * @return {redirect} retorna um redirecionamento para itemMenu/index
    */
    public function add_post(Request $request)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Menu' => '',
            'Item' => 'required',
            'idPermissoes' => '',
        ]);

        //Cria o itemMenu com os dados validados
        $itemMenu = ItemMenu::create($validatedData);

        //redireciona para itemMenu/index
        return redirect('/itemMenu/index')->with("MensagensToast", ["ItemMenu registrado com sucesso!"]);
    }

    /**
     * Display a pagina de edit de itemMenu.
     *
     * @param {itemMenu} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit, contendo todas as permissões, e o itemMenu a ser editado
    */
    public function edit(ItemMenu $itemMenu)
    {
        //Retorna a view com os parametros necessarios
        return view('itemMenu.edit', ['itemMenu' => $itemMenu, 'Permissoes' => Permissoes::all()]);
    }

    /**
     * Efetua a atualização de um itemMenu no banco.
     *
     * @param {itemMenu} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações do itemMenu a ser atualizado
     * @return {view} retorna um redirecionamento para itemMenu/index
    */
    public function edit_post(Request $request, ItemMenu $itemMenu)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Menu' => '',
            'Item' => 'required',
            'idPermissoes' => '',
        ]);

        //Atualiza o itemMenu com os dados validados
        $itemMenu->update($validatedData);

        //redireciona para itemMenu/index
        return redirect('/itemMenu/index')->with(['MensagensToast' => ['ItemMenu atualizado com sucesso!']]);
    }

    /**
     * Deleta o itemMenu recebido como parametro
     *
     * @param {itemMenu} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para itemMenu/index
    */
    public function delete(ItemMenu $itemMenu)
    {
        //deleta o itemMenu
        $itemMenu->delete();

        //redireciona para itemMenu/index
        return redirect('/itemMenu/index')->with(["MensagensToast" => ["ItemMenu Removido Com Sucesso!"]]);
    }
}
