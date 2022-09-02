<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Curriculo;
use App\Models\Disciplina;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class CurriculoController extends Controller
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
        $curriculos = Curriculo::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('curriculo.index', ['curriculos' => $curriculos])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a view de curriculo.
     *
     * @param {curriculo} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view do view, contendo os valores do curriculo
    */
    public function view(Curriculo $curriculo)
    {
        //Retorna a view com os parametros necessarios
        return view('curriculo.view')->with('curriculo', $curriculo)->with('periodos', $curriculo->periodos());
    }

    /**
     * Display a pagina de add de curriculo.
     *
     * @return {view} retorna a view add
    */
    public function add(Request $request)
    {
        //Retorna a view com os parametros necessarios
        return view('curriculo.add')->with("Disciplinas", Disciplina::all());
    }

    /**
     * Efetua a inserção de um novo curriculo no banco. 
     *
     * @param {request} contem o request do formulario, com as informações do curriculo a ser adicionado
     * @return {redirect} retorna um redirecionamento para curriculo/index
    */
    public function add_post(Request $request)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Nome' => 'required',
        ]);

        //Cria o curriculo com os dados validados
        $curriculo = Curriculo::create($validatedData);

        //Caso o request contenha Disciplinas
        if($request->exists('Disciplina'))
        {
            //variavel auxiliar para contabilizar os periodos
            $numeroPeriodo = 1;
            //Para cada conjunto de disciplina (periodo)
            foreach($request->input('Disciplina') as $key => $periodos)
            {
                //Para cada periodo, pega cada id de disciplina dentro da array.
                foreach($periodos as $disciplinaId)
                {
                    //Encontra o disciplina no banco de id = disciplinaId
                    $disciplina = Disciplina::find($disciplinaId);
                    //Vincula a disciplina ao curriculo, com os dados auxiliares necessarios.
                    $curriculo->disciplina()->attach($disciplinaId, ["codigoDisciplina" => $disciplina->Codigo, "PeriodoNumero" => $numeroPeriodo, "PeriodoNome" => $request->input("NomePeriodo")[$key]]);
                }
                //Incrementa o numero de periodos.
                $numeroPeriodo++;
            }
        }

        //redireciona para /curriculo/index
        return redirect('/curriculo/index')->with("MensagensToast", ["Curriculo registrada com sucesso!"]);
    }
    
    /**
     * Display a pagina de edit de curriculo.
     *
     * @param {curriculo} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit com o curriculo a ser editado
    */
    public function edit(Curriculo $curriculo)
    {
        //Retorna a view com os parametros necessarios
        return view('curriculo.edit', ['curriculo' => $curriculo])->with('periodos', $curriculo->periodos())->with("Disciplinas", Disciplina::all());
    }

    /**
     * Efetua a atualização de um curriculo no banco.
     *
     * @param {curriculo} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações da curriculo a ser atualizada
     * @return {view} retorna um redirecionamento para curriculo/index
    */
    public function edit_post(Request $request, Curriculo $curriculo)
    {
        //Valida os dados do request
        $validation = $request->validate([
            'Nome' => 'required',
        ]);
            
        //Atualiza o curriculo com os dados validados
        $curriculo->update($validation);

        //Disvincula todas as disciplinas do curriculo, para adicionar novamente
        $curriculo->disciplina()->detach();
        //Caso o request contenha Disciplinas
        if($request->exists('Disciplina'))
        {
            //variavel auxiliar para contabilizar os periodos
            $numeroPeriodo = 1;
            //Para cada conjunto de disciplina (periodo)
            foreach($request->input('Disciplina') as $key => $periodos)
            {
                //Para cada periodo, pega cada id de disciplina dentro da array.
                foreach($periodos as $disciplinaId)
                {
                    //Encontra o disciplina no banco de id = disciplinaId
                    $disciplina = Disciplina::find($disciplinaId);
                    //Vincula a disciplina ao curriculo, com os dados auxiliares necessarios.
                    $curriculo->disciplina()->attach($disciplinaId, ["codigoDisciplina" => $disciplina->Codigo, "PeriodoNumero" => $numeroPeriodo, "PeriodoNome" => $request->input("NomePeriodo")[$key]]);
                }
                //Incrementa o numero de periodos.
                $numeroPeriodo++;
            }
        }

        //redireciona para /curriculo/index
        return redirect('/curriculo/index')->with(['MensagensToast' => ['Curriculo atualizado com sucesso!']]);
    }

    /**
     * Deleta o curriculo recebido como parametro. Remove os vinculos com disciplina
     *
     * @param {curriculo} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para curriculo/index
    */
    public function delete(Curriculo $curriculo)
    {
        //Disvincula as discplinas associadas ao curriculo
        $curriculo->disciplina()->detach();
        //Deleta o curriculo
        $curriculo->delete();

        //redireciona para /curriculo/index
        return redirect('/curriculo/index')->with(["MensagensToast" => ["Curriculo Removido Com Sucesso!"]]);
    }
}
