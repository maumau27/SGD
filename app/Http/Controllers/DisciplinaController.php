<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Disciplina;
use App\Models\Bibliografia;
use App\Models\PreReq;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class DisciplinaController extends Controller
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
        $disciplinas = Disciplina::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('disciplina.index', ['disciplinas' => $disciplinas])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a view de disciplina. Verifica se é optativa ou não para retorna a view correspondente
     *
     * @param {disciplina} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view do view, contendo os valores da disciplina, pre-requisitos e bibliografias para serem renderizados
    */
    public function view(Disciplina $disciplina)
    {
        //testa se a disciplina é optativa
        if($disciplina->Optativa)
            //Retorna a view com os parametros necessarios
            return view('disciplina.viewOptativa', ['disciplina' => $disciplina, 'grupoOptativa' => $disciplina->optativa]);

        //Retorna a view com os parametros necessarios
        return view('disciplina.view', ['disciplina' => $disciplina, 'prereqs' => $disciplina->requisitos(), 
                                        'bibliografias' => $disciplina->bibliografia,
                                        'bibliografiasComplementar' => $disciplina->bibliografiaComplementar]);
    }

    /**
     * Display a pagina de add de disciplinas.
     *
     * @return {view} retorna a view add, contendo todas as bibliografias e disciplinas
    */
    public function add()
    {
        //Retorna a view com os parametros necessarios
        return view('disciplina.add', ["Bibliografias" => Bibliografia::all()])->with("Disciplinas", Disciplina::all());
    }

    /**
     * Efetua a inserção de uma nova disciplina no banco. 
     *
     * @param {request} contem o request do formulario, com as informações da disciplina a ser adicionada
     * @return {redirect} retorna um redirecionamento para disciplinas/index
    */
    public function add_post(Request $request)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Codigo' => 'required', 
            'Titulo' => 'required',
            'Creditos' => 'required',
            'Ementa' => 'required',
        ]);

        //Cria a disciplina com os dados validados
        $disciplina = Disciplina::create($validatedData);

        //caso exista Bibliografias no request
        if($request->exists('Bibliografias'))
            //Vincula as bibliografias a disciplina, com complementar = 0
            $disciplina->bibliografia()->attach($request->input('Bibliografias'), ['Complementar' => 0]);
        //caso exista BibliografiasComp no request
        if($request->exists('BibliografiasComp'))
            //Vincula as bibliografias a disciplina, com complementar = 1
            $disciplina->bibliografiaComplementar()->attach($request->input('BibliografiasComp'), ['Complementar' => 1]);

        //caso exista PreReqs no request
        if($request->exists('PreReqs'))
        {
            //para cada grupo de pre-requisito
            foreach($request->input('PreReqs') as $prereqs)
            {
                //Cria o PreReq
                $prereq = PreReq::create(["idDisciplina" => $disciplina->id, "ListaCodigos" => "", "NumeroCreditos" => 0]);
                //para cada requisito do grupo
                foreach($prereqs as $requisito)
                {
                    //encontra o codigo da disciplina
                    $codigo = Disciplina::find($requisito)->Codigo;
                    //Vincula o requisito ao PreReq criado
                    $prereq->requisitos()->attach($requisito, ["codigoDisciplina" => $codigo]);
                }
            }
        }

        //redireciona para disciplina/index
        return redirect('/disciplina/index')->with("MensagensToast", ["Disciplina registrada com sucesso!"]);
    }

    /**
     * Display a pagina de edit de disciplinas.
     *
     * @param {disciplina} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit, contendo todas as bibliografias e disciplinas, e a disciplina a ser editada
    */
    public function edit(Disciplina $disciplina)
    {
        //Retorna a view com os parametros necessarios
        return view('disciplina.edit', ["Bibliografias" => Bibliografia::all()])->with("Disciplinas", Disciplina::all())->with("disciplina", $disciplina);
    }

    /**
     * Efetua a atualização de uma disciplina no banco.
     *
     * @param {disciplina} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações da disciplina a ser atualizada
     * @return {view} retorna um redirecionamento para disciplinas/index
    */
    public function edit_post(Request $request, Disciplina $disciplina)
    {
        //Valida os dados do request
        $validatedData = $request->validate([
            'Codigo' => 'required', 
            'Titulo' => 'required',
            'Creditos' => 'required',
            'Ementa' => 'required',
        ]);

        //Atualiza a disciplina com os dados validados
        $disciplina->update($validatedData);

        //Desvincula todas as bibliografias da disciplina. para revincular a abaixo
        $disciplina->bibliografia()->detach();
        //caso exista Bibliografias no request
        if($request->exists('Bibliografias'))
            //Vincula as bibliografias a disciplina, com complementar = 0
            $disciplina->bibliografia()->attach($request->input('Bibliografias'), ['Complementar' => 0]);
        //caso exista BibliografiasComp no request
        if($request->exists('BibliografiasComp'))
            //Vincula as bibliografias a disciplina, com complementar = 1
            $disciplina->bibliografiaComplementar()->attach($request->input('BibliografiasComp'), ['Complementar' => 1]);


        //delete todos os preReqs, para adicionar os novos
        $this->delete_prereq($disciplina->preReq);

        //caso exista PreReqs no request
        if($request->exists('PreReqs'))
        {
            //para cada grupo de pre-requisito
            foreach($request->input('PreReqs') as $prereqs)
            {
                //Cria o PreReq
                $prereq = PreReq::create(["idDisciplina" => $disciplina->id, "ListaCodigos" => "", "NumeroCreditos" => 0]);
                //para cada requisito do grupo
                foreach($prereqs as $requisito)
                {
                    //encontra o codigo da disciplina
                    $codigo = Disciplina::find($requisito)->Codigo;
                    //Vincula o requisito ao PreReq criado
                    $prereq->requisitos()->attach($requisito, ["codigoDisciplina" => $codigo]);
                }
            }
        }

        //redireciona para disciplina/index
        return redirect('/disciplina/index')->with("MensagensToast", ["Disciplina atualizada com sucesso!"]);
    }

    /**
     * Deleta a disciplina recebida como parametro. Remove tambem a disciplina das tabelas de relacionamento.
     *
     * @param {disciplina} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para disciplinas/index
    */
    public function delete(Disciplina $disciplina)
    {
        //disvincula as bibliografias de disciplina
        $disciplina->bibliografia()->detach();
        //disvincula os preReq da disciplina
        $this->delete_prereq($disciplina->preReq);
        //deleta a disciplina 
        $disciplina->delete();

        //redireciona para disciplina/index
        return redirect('/disciplina/index')->with(["MensagensToast" => ["Disciplina Removida Com Sucesso!"]]);
    }
    
    /**
     * Deleta todos o preReq recebido como parametro. Remove tambem o preReq das tabelas de relacionamento.
     *
     * @param {prereqs} contem o modelo Eloquente adquirido a partir da função preReq do Modelo disciplina
     * @return {void}
    */
    public function delete_prereq($prereqs)
    {
        //para cada preReq
        foreach($prereqs as $prereq)
        {
            //desvincula os requisitos
            $prereq->requisitos()->detach();
            //deleta o preReq
            $prereq->delete();
        }
    }
}
