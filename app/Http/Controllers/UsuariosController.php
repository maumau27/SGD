<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use App\Models\Usuarios;
use App\Models\Perfil;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class UsuariosController extends Controller
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
        $usuarios = Usuarios::where($request['tipoFiltro'] ?? "id", 'like', '%'.$request['Filtro'].'%' ?? '%')->sortable()->paginate(10);

        //Retorna a view com os parametros necessarios
        return view('usuarios.index', ['usuarios' => $usuarios])->with('filtro', $request['Filtro'] ?? "")->with('tipoFiltro', $request["tipoFiltro"] ?? "");
    }

    /**
     * Display a pagina de add de usuario.
     *
     * @return {view} retorna a view add, contendo todas os perfils
    */
    public function add(Request $request)
    {
        //Retorna a view com os parametros necessarios
        return view('usuarios.add', ['Perfils' => Perfil::all()]);
    }

    /**
     * Efetua a inserção de um novo usuario no banco. 
     *
     * @param {request} contem o request do formulario, com as informações do usuario a ser adicionado
     * @return {redirect} retorna um redirecionamento para usuarios/index
    */
    public function add_post(Request $request)
    {
        //valida os dados do request
        $validatedData = $request->validate([
            'Login' => 'required|unique:Usuarios,Login',
            'Nome' => '',
            'Email' => 'required|email|unique:Usuarios,Email', 
            'Senha' => 'required', 
        ]);

        //Cria o usuario com os dados validados
        $usuario = Usuarios::create($validatedData);

        //Vincula os perfils do usuario com os valores do request
        $usuario->perfil()->attach(array_keys($request->input('Perfil')));

        //redireciona para usuarios/index
        return redirect('/usuarios/index')->with("MensagensToast", ["Usuario registrado com sucesso!"]);
    }
    
    /**
     * Display a pagina de edit de usuario.
     *
     * @param {usuario} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {view} retorna a view edit com o usuario a ser editado
    */
    public function edit(Usuarios $usuario)
    {
        //cira uma array com os perfils do usuario
        $perfils = array();
        //Preenche a array. 
        foreach($usuario->perfil as $perfil)
            $perfils[$perfil->Codigo] = 'checked';

        //Retorna a view com os parametros necessarios
        return view('usuarios.edit', ['usuario' => $usuario, 'PerfilsUsuario' => $perfils, 'Perfils' => Perfil::all()]);
    }

    /**
     * Efetua a atualização de um usuario no banco.
     *
     * @param {usuario} contem o modelo Eloquente adquirido a partir do id na URL
     * @param {request} contem o request do formulario, com as informações do usuario a ser atualizado
     * @return {view} retorna um redirecionamento para usuarios/index
    */
    public function edit_post(Request $request, Usuarios $usuario)
    {
        //Array de validação
        $validation = [
            'Login' => 'required|unique:Usuarios,Login,'.$usuario->id,
            'Nome' => '',
            'Email' => 'required|email|unique:Usuarios,Email,'.$usuario->id, 
        ];

        //Se a senha foi preenchida no request
        if($request->input('Senha') != null)
            //Adiciona senha ao array de validação
            $validation['Senha'] = 'required';
        
        //valida os dados do request, usando a array de validação
        $credenciais = $request->validate($validation);

        //Se a senha foi preenchida no request
        if($request->input('Senha') != null)
            //Seta DT_ultima_senha para agora
            $credenciais['DT_ultima_senha'] = now();

        //Atualiza o usuario com os dados validados
        $usuario->update($credenciais);

        //atualizar os perfils vinculados ao usuario
        $usuario->perfil()->sync(array_keys($request->input('Perfil')));

        //Redireciona para /usuarios/index
        return redirect('/usuarios/index')->with(['MensagensToast' => ['Usuario atualizado com sucesso!']]);
    }

    /**
     * Deleta o usuario recebido como parametro. Remove os vinculos com perfil
     *
     * @param {usuario} contem o modelo Eloquente adquirido a partir do id na URL
     * @return {redirect} retorna um redirecionamento para usuarios/index
    */
    public function delete(Usuarios $usuario)
    {
        //Disvincula os perfils do usuario
        $usuario->perfil()->detach();
        //Deleta o usuario
        $usuario->delete();

        //Redireciona para /usuarios/index
        return redirect('/usuarios/index')->with(["MensagensToast" => ["Usuario Removido Com Sucesso!"]]);
    }
}