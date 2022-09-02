<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bibliografia;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class BibliografiaController extends Controller
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
        $bibliografias = Bibliografia::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('bibliografia.index', ['bibliografias' => $bibliografias])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de bibliografia.
     *
     * @return {view} retorna a view add
    */
    public function add(Request $request)
    {
        //Retorna a view
        return view('bibliografia.add');
    }

    /**
     * Efetua a inserção de uma nova bibliografia no banco. 
     *
     * @param {request} contem o request do formulario, com as informações da bibliografia a ser adicionada
     * @return {redirect} retorna um redirecionamento para bibliografia/index
    */
    public function add_post(Request $request)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Titulo' => '',
        ]);

        //Cria a bibliografia com os dados validados
        $bibliografia = Bibliografia::create($validatedData);

        //redireciona para bibliografia/index
        return redirect('/bibliografia/index')->with("MensagensToast", ["Bibliografia registrada com sucesso!"]);
    }
    
    /**
     * Display a pagina de edit de bibliografia.
     *
     * @param {bibliografia} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit com a bibliografia a ser editada
    */
    public function edit(Bibliografia $bibliografia)
    {
        //Retorna a view com os parametros necessarios
        return view('bibliografia.edit', ['bibliografia' => $bibliografia]);
    }

    /**
     * Efetua a atualização de uma bibliografia no banco.
     *
     * @param {bibliografia} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações da bibliografia a ser atualizada
     * @return {view} retorna um redirecionamento para bibliografia/index
    */
    public function edit_post(Request $request, Bibliografia $bibliografia)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Titulo' => '',
        ]);

        //Atualiza a bibliografia com os dados validados
        $bibliografia->update($validatedData);

        //Redireciona para /bibliografia/index
        return redirect('/bibliografia/index')->with(['MensagensToast' => ['Bibliografia atualizado com sucesso!']]);
    }

    /**
     * Deleta a bibliografia recebida como parametro.
     *
     * @param {bibliografia} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para bibliografia/index
    */
    public function delete(Bibliografia $bibliografia)
    {
        //Deleta a bibliografia
        $bibliografia->delete();

        //Redireciona para /bibliografia/index
        return redirect('/bibliografia/index')->with(["MensagensToast" => ["Bibliografia Removido Com Sucesso!"]]);
    }
}
