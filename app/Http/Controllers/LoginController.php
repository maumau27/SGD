<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\RecuperarSenha;
use App\Models\Usuarios;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class LoginController extends Controller
{
    /**
     * Função de initialização. Chama o __contruct pai e inicializa os middleware a serem ultilizados.
     *
    */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Função para display de login.
     *
    */
    public function home()
    {
        //Retorna a view da login
        return view('login');
    }

    /**
     * Efetua a recuperação de senha do usuario
     *
     * @param {request} contem o request do formulario, enviado por POST
     * @return {view} retorna um redirecionamento para login, com a devida mensagem
    */
    public function recuperarSenha(Request $request)
    {
        //Pega o email do request
        $input = $request->input('Email');

        //Busca o usuario dono do email do request
        $usuario = Usuarios::where("Email", $input)->first();
        //Se não encontrar o usuario
        if($usuario == null)
            //Retorna um redirecionamento para login com uma mensagem de erro
            return redirect()->route('login')->withErrors([
                'Erro' => 'Email não consta na lista de usuarios',
            ]);

        //Cria uma nova senha aleatoria
        $novaSenha = Str::random(8);
        //Seta a nova senha para o usuario
        $usuario->Senha = $novaSenha;
        //Salva o usuario com a nova senha
        $usuario->save();

        //Envia um email para o usuario com a nova senha
        Mail::to($input)->send(new RecuperarSenha($usuario, $novaSenha));

        //Retorna um redirecionamento para login com a mensagem de sucesso
        return redirect()->route('login')->with(["MensagensToast" => ["Nova senha enviada por email."]]);
    }

    /**
     * Efetua o login de um usuario, validando as credencias
     *
     * @param {request} contem o request do formulario, enviado por POST
     * @return {redirect, view} retorna ou a view do login, em caso de falta. Ou redireciona para a home de um usuario logado
    */
    public function login(Request $request)
    {
        //Variavel auxilar para mensagens
        $data = array();
        //Pega os dados para validar do request
        $credentials = $request->only('Login', "Senha");
 
        //Testa se a credencial está valida.
        if (Auth::attempt($credentials)) {
            //Cria a sessão do usuario
            $request->session()->regenerate();

            //Configura a mensagem de sucesso
            $data["MensagensToast"] = ["Login efetuado com sucesso"];
 
            //Redireciona para a home do usuario
            return redirect()->route('home')->with($data);
        }
 
        return view('login', $data)->withErrors([
            'email' => 'Email ou senha incorretos',
        ]);
    }

    /**
     * Efetua o logout do usuario do sistema
     *
     * @return {redirect} retorna um redirecionamento para a rota de login
    */
    public function logout()
    {
        //verifica que o usuario está logado
        if(Auth::check())
        {
            //Efetua o logout
            Auth::logout();
            //Redireciona para a tela de login
            return redirect()->route('login');
        }
    }
}