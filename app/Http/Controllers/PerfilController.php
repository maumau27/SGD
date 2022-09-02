<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use App\Models\Perfil;
use App\Models\Permissoes;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class PerfilController extends Controller
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
        $perfils = Perfil::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('perfil.index', ['perfils' => $perfils])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de perfil.
     *
     * @return {view} retorna a view add, contendo todas as permissões
    */
    public function add(Request $request)
    {
        //Retorna a view com os parametros necessarios
        return view('perfil.add', ['Permissoes' => Permissoes::all()]);
    }

    /**
     * Efetua a inserção de um novo perfil no banco. 
     *
     * @param {request} contem o request do formulario, com as informações do perfil a ser adicionado
     * @return {redirect} retorna um redirecionamento para perfil/index
    */
    public function add_post(Request $request)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Nome' => '',
            'Codigo' => '',
        ]);

        //Cria o perfil com os dados validados
        $perfil = Perfil::create($validatedData);

        //Vincula as permissões ao perfil
        $perfil->permissoes()->attach(array_keys($request->input('Permissoes')));

        //redireciona para perfil/index
        return redirect('/perfil/index')->with("MensagensToast", ["Perfil registrado com sucesso!"]);
    }
    
    /**
     * Display a pagina de edit de perfil.
     *
     * @param {disciplina} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit, contendo todas as bibliografias e disciplinas, e a disciplina a ser editada
    */
    public function edit(Perfil $perfil)
    {
        //cria uma array permissoes
        $permissoes = array();
        //para cada permissão no perfil
        foreach($perfil->permissoes as $permissao)
            //adiciona a array permissão com checked, para a view
            $permissoes[$permissao->Nome] = 'checked';

        //Retorna a view com os parametros necessarios
        return view('perfil.edit', ['perfil' => $perfil, 'PerfilPermissoes' => $permissoes, 'Permissoes' => Permissoes::all()]);
    }

    /**
     * Efetua a atualização de um perfil no banco.
     *
     * @param {perfil} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações do perfil a ser atualizada
     * @return {view} retorna um redirecionamento para disciplinas/index
    */
    public function edit_post(Request $request, Perfil $perfil)
    {
        //Valida od dados do request
        $validatedData = $request->validate([
            'Nome' => '',
            'Codigo' => '',
        ]);

        //Atualiza o pefril com os dados validados
        $perfil->update($validatedData);

        //vincula as permissões do perfil. Sync remove e depois adiciona as permissões 
        $perfil->permissoes()->sync(array_keys($request->input('Permissoes')));

        //redireciona para perfil/index
        return redirect('/perfil/index')->with(['MensagensToast' => ['Perfil atualizado com sucesso!']]);
    }

    /**
     * Deleta o perfil recebido como parametro. Remove tambem as permissões vinculadas no perfil
     *
     * @param {perfil} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para perfil/index
    */
    public function delete(Perfil $perfil)
    {
        //disvincula as permissões do perfil
        $perfil->permissoes()->detach();
        //deleta o perfil
        $perfil->delete();

        //redireciona para perfil/index
        return redirect('/perfil/index')->with(["MensagensToast" => ["Perfil Removido Com Sucesso!"]]);
    }
}
