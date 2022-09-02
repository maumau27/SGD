<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Turma;
use App\Models\Professor;
use App\Models\Disciplina;
use App\Models\ProfessorTurmaCache;
use App\Models\DisciplinaTurmaCache;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class TurmaController extends Controller
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
        $turmas = Turma::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('turma.index', ['turmas' => $turmas])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de turmas.
     *
     * @return {view} retorna a view add, contendo as disciplinas e professores
    */
    public function add(Request $request, Professor $professor)
    {
        //se não está especificado um professor
        if($professor->id == null)
            //Retorna a view com os parametros necessarios (todos os professores)
            return view('turma.add')->with("Professores", Professor::all())->with("Disciplinas", Disciplina::all());
        else
            //Retorna a view com os parametros necessarios (apenas o especificado)
            return view('turma.add')->with("Professor", $professor)->with("Disciplinas", Disciplina::all());
    }

    /**
     * Efetua a inserção de uma nova turma no banco. 
     *
     * @param {request} contem o request do formulario, com as informações da turma a ser adicionada
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL, para criar uma turma a partir de um professor.
     * @return {redirect} retorna um redirecionamento para turma/index ou /professor/turmas/
    */
    public function add_post(Request $request, Professor $professor)
    {
        //valida os dados do request
        $validatedData = $request->validate([
            'Codigo' => 'required',
            'MaximoAlunos' => '',
            'Ano' => '',
            'Semestre' => '',
            'idProfessor' => '',
            'idDisciplina' => '',
        ]);

        //Seta o codigo da Disciplina nos dados validados
        $validatedData['codigoDisciplina'] = Disciplina::find($request->input('idDisciplina'))->Codigo;

        //Cria a turma com os dados validados
        $turma = Turma::create($validatedData);

        //pega os atributos do professor vinculado a turma, para a criação do cache
        $professorCacheData = $turma->professor->getAttributes();
        //pega os atributos da disciplina vinculada a turma, para a criação do cache
        $disciplinaCacheData = $turma->disciplina->getAttributes();
        //seta o idTurma do professorCache para o id da turma criada
        $professorCacheData["idTurma"] = $turma->id;
        //seta o idTurma da disciplinaCache para o id da turma criada
        $disciplinaCacheData["idTurma"] = $turma->id;

        //Cria o cache do professor
        $professorCache = ProfessorTurmaCache::create($professorCacheData);
        //Cria o cache da disciplina
        $disciplinaCache = DisciplinaTurmaCache::create($disciplinaCacheData);

        //Seta o idProfessorCache da turma criada para o cache criado acima.
        $turma->idProfessorCache = $professorCache->id;
        //Seta o idDisciplinaCache da turma criada para o cache criado acima.
        $turma->idDisciplinaCache = $disciplinaCache->id;

        //Salva os id's setados acima
        $turma->save();

        //se o url não contem um id de professor 
        if($professor->id == null)
            //redireciona para /turma/index
            return redirect('/turma/index')->with("MensagensToast", ["Turma registrada com sucesso!"]);
        //caso a turma seja criada a partir de um professor
        else
            //redireciona para //professor/turmas/. lista das turmas do professor.
            return redirect('/professor/turmas/'.$professor->id)->with(['MensagensToast' => ['Turma atualizada com sucesso!']]);
    }
    
    /**
     * Display a pagina de edit de turma.
     *
     * @param {turma} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL, para editar uma turma a partir de um professor.
     * @return {view} retorna a view edit com a permissão a ser editada
    */
    public function edit(Turma $turma, Professor $professor)
    {
        //se o url não contem um id de professor 
        if($professor->id == null)
            //Retorna a view com os parametros necessarios (todos os professores)
            return view('turma.edit', ['turma' => $turma])->with("Professores", Professor::all())->with("Disciplinas", Disciplina::all())
                                                          ->with("ProfessorCache", $turma->professorCache)->with("DisciplinaCache", $turma->disciplinaCache);
        //caso a turma seja editada a partir de um professor                                                  
        else
            //Retorna a view com os parametros necessarios (apenas o especificado)
            return view('turma.edit', ['turma' => $turma])->with("Professor", $professor)->with("Disciplinas", Disciplina::all())
                                                          ->with("ProfessorCache", $turma->professorCache)->with("DisciplinaCache", $turma->disciplinaCache);
    }

     /**
     * Efetua a atualização de uma turma no banco.
     *
     * @param {turma} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {professor} contem o modelo Eloquente adquirido a partir do id na URL, para editar uma turma a partir de um professor.
     * @param {request} contem o request do formulario, com as informações da permissão a ser atualizada
     * @return {view} retorna um redirecionamento para permissoes/index
    */
    public function edit_post(Request $request, Turma $turma, Professor $professor)
    {
        //valida os dados do request
        $validatedData = $request->validate([
            'Codigo' => 'required',
            'MaximoAlunos' => '',
            'Ano' => '',
            'Semestre' => '',
            'idProfessor' => '',
            'idDisciplina' => '',
        ]);

        //Se mudar o idProfessor, criar novo Cache
        if($validatedData['idProfessor'] != $turma->idProfessor)
        {
            //verifica que o idProfessor não é 0.
            if($validatedData['idProfessor'] != 0)
            {
                //Pega os atributos do novo professor
                $professorCacheData = Professor::find($validatedData['idProfessor'])->getAttributes();
                //Seta o idTurma do professorCache para o id da turma sendo editada
                $professorCacheData["idTurma"] = $turma->id;
                //Cria o novo cache de professor
                $professorCache = ProfessorTurmaCache::create($professorCacheData);
                //Seta o idProfessorCache da turma para o id cache criado acima
                $turma->idProfessorCache = $professorCache->id;

                //Salva o id setado acima
                $turma->save();    
            }
        }
        //Caso contrario, atualizar o cache
        else{
            //valida os dados do request
            $credenciais_professor_cache = $request->validate([
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

            //Atualiza o cache do professor
            $turma->professorCache->update($credenciais_professor_cache);
        }

        //Se mudar o idDisciplina, criar novo Cache
        if($validatedData['idDisciplina'] != $turma->idDisciplina)
        {
            //Pega os atributos da nova disciplina
            $disciplinaCacheData = Disciplina::find($credenciais['idDisciplina'])->getAttributes();
            //Seta o idTurma da disciplinaCache para o id da turma sendo editada
            $disciplinaCacheData["idTurma"] = $turma->id;
            //Cira a nova cache de disciplina
            $disciplinaCache = ProfessorTurmaCache::create($disciplinaCacheData);
            //Seta o idDisciplinaCache da turma para o id cache criado acima
            $turma->idDisciplinaCache = $disciplinaCache->id;

            //Salva o id setado acima
            $turma->save();    
        }
        //Caso contrario, atualizar o cache
        else{
            //valida os dados do request
            $credenciais_disciplina_cache = $request->validate([
                'CodigoDisciplina' => '',
                'Titulo' => '', 
                'Creditos' => '',
                'Ementa' => '', 
            ]);

            //Atualiza o cache da disciplina
            $turma->disciplinaCache->update($credenciais_disciplina_cache);
        }

        //Atualiza a turma com os dados validados
        $turma->update($validatedData);

        //se o url não contem um id de professor 
        if($professor->id == null)
            //Redireciona para /turma/index
            return redirect('/turma/index')->with(['MensagensToast' => ['Turma atualizada com sucesso!']]);
        //caso a turma seja editada a partir de um professor        
        else
            //Redireciona para /professor/turmas/. lista das turmas de um professor
            return redirect('/professor/turmas/'.$professor->id)->with(['MensagensToast' => ['Turma atualizada com sucesso!']]);
    }

    /**
     * Deleta a turma recebida como parametro. Remove os vinculos com professorCache e disciplinaCache
     *
     * @param {permissao} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para permissoes/index
    */
    public function delete(Turma $turma)
    {
        //Disvincula as relações com professorCache
        $turma->professorCache->delete();
        //Disvincula as relações com disciplinaCache
        $turma->disciplinaCache->delete();
        //Deleta a turma
        $turma->delete();

        //Redireciona para /turma/index
        return redirect('/turma/index')->with(["MensagensToast" => ["Turma Removida Com Sucesso!"]]);
    }
}
