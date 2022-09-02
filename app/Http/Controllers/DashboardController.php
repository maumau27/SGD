<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Disciplina;

/**
 * SGD - Sistema de gerencia de disciplinas
 *
 * @author   Mauricio Lana <mauriciolana@hotmail.com>
 */
class DashboardController extends Controller
{
    /**
     * Função de initialização. Chama o __contruct pai e inicializa os middleware a serem ultilizados.
     *
    */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Função para display da home.
     *
    */
    public function home()
    {
        //Retorna a view da home
        return view('home');
    }

    /*public function alunos()
	{
		$this->autoRender = false;
		$this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');

		$this->loadModel('VwAluno'); //or you can load it in beforeFilter()
        $data=$this->VwAlunoDisciplina->query('SELECT * FROM VwAluno');


  	    $this->response->body($data);

		$this->set(compact('data'));
	    $this->set('_serialize', ['data']);
	}

    public function disciplinas()
	{
        $this->autoRender = false;
        $this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');

        $this->loadModel('VwAlunoDisciplina'); //or you can load it in beforeFilter()
        $data=$this->VwAlunoDisciplina->query('SELECT * FROM VwAlunoDisciplina');


        $this->response->body($data);

        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
	}*/
}
