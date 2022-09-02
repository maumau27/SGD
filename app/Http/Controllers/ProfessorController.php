<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Professor;
use App\Models\Disciplina;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class ProfessorController extends Controller
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
        $professores = Professor::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('professor.index', ['professores' => $professores])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de professor.
     *
     * @return {view} retorna a view add
    */
    public function add(Request $request)
    {
        //Retorna a view 
        return view('professor.add');
    }

    /**
     * Efetua a inserção de um novo professor no banco. 
     *
     * @param {request} contem o request do formulario, com as informações do professor a ser adicionado
     * @return {redirect} retorna um redirecionamento para professor/index
    */
    public function add_post(Request $request)
    {
        //valida os dados do request
        $validatedData = $request->validate([
            'Nome' => 'required',
            'Bio' => '', 
            'MiniBio' => '',
            'Cargo' => '', 
            'BolsaProdutividade' => '',
            'Telefone' => '', 
            'Sala' => '',
            'Site' => '', 
            'Email' => '',
            'Lattes' => '', 
            'Linkedin' => '',
            'DBPL' => '', 
            'ORCID' => '',
            'Publons' => '',
        ]);

        //cria o professor com os dados validados
        $professor = Professor::create($validatedData);

        //redireciona para professor/index
        return redirect('/professor/index')->with("MensagensToast", ["Professor registrado com sucesso!"]);
    }
    
    /**
     * Display a pagina de edit de professor.
     *
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit com o professor a ser editado
    */
    public function edit(Professor $professor)
    {
        //Retorna a view com os parametros necessarios
        return view('professor.edit', ['professor' => $professor]);
    }

    /**
     * Efetua a atualização de um professor no banco.
     *
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações do professor a ser atualizado
     * @return {view} retorna um redirecionamento para professor/index
    */
    public function edit_post(Request $request, Professor $professor)
    {
        //valida os dados do request
        $validatedData = $request->validate([
            'Nome' => 'required',
            'Bio' => '', 
            'MiniBio' => '',
            'Cargo' => '', 
            'BolsaProdutividade' => '',
            'Telefone' => '', 
            'Sala' => '',
            'Site' => '', 
            'Email' => '',
            'Lattes' => '', 
            'Linkedin' => '',
            'DBPL' => '', 
            'ORCID' => '',
            'Publons' => '',
        ]);

        //Atualiza o professor com os dados validados
        $professor->update($validatedData);

        //Redireciona para /professor/index
        return redirect('/professor/index')->with(['MensagensToast' => ['Professor atualizado com sucesso!']]);
    }

    /**
     * Deleta o professor recebido como parametro. Remove os vinculos disciplina
     *
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para professor/index
    */
    public function delete(Professor $professor)
    {
        //Disvincula as disciplinas associadas ao professor
        $professor->disciplina()->detach();
        //Deleta o professor
        $professor->delete();

        //Redireciona para /professor/index
        return redirect('/professor/index')->with(["MensagensToast" => ["Professor removido Com Sucesso!"]]);
    }

    /**
     * Exibi a lista de turmas vinculadas ao professor
     *
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL
    */
    public function turmas(Professor $professor)
    {
        //Pega as turmas associadas ao professor, e pagina a lista
        $turmas = $professor->turma()->paginate(10);
        
        //Retorna a view com os parametros necessarios
        return view('professor.turmas', ['turmas' => $turmas, 'professor' => $professor]);
    }
}
