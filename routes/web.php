<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissoesController;
use App\Http\Controllers\ItemMenuController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\BibliografiaController;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\TurmaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Login
Route::get('/', [LoginController::class, 'home'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/recuperarSenha', [LoginController::class, 'recuperarSenha']);
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

//Dashboard
Route::redirect('/dashboard/index', url('/home'));
Route::get('/home', [DashboardController::class, 'home'])->name('home');

//Usuarios
Route::match(['get', 'post'], '/usuarios/index', [UsuariosController::class, 'index']);
Route::get('/usuarios/add', [UsuariosController::class, 'add']);
Route::post('/usuarios/add', [UsuariosController::class, 'add_post']);
Route::get('/usuarios/edit/{usuario}', [UsuariosController::class, 'edit']);
Route::post('/usuarios/edit/{usuario}', [UsuariosController::class, 'edit_post']);
Route::get('/usuarios/delete/{usuario}', [UsuariosController::class, 'delete']);

//Permissoes
Route::match(['get', 'post'], '/permissoes/index', [PermissoesController::class, 'index']);
Route::get('/permissoes/add', [PermissoesController::class, 'add']);
Route::post('/permissoes/add', [PermissoesController::class, 'add_post']);
Route::get('/permissoes/edit/{permissao}', [PermissoesController::class, 'edit']);
Route::post('/permissoes/edit/{permissao}', [PermissoesController::class, 'edit_post']);
Route::get('/permissoes/delete/{permissao}', [PermissoesController::class, 'delete']);

//ItemMenu
Route::match(['get', 'post'], '/itemMenu/index', [ItemMenuController::class, 'index']);
Route::get('/itemMenu/add', [ItemMenuController::class, 'add']);
Route::post('/itemMenu/add', [ItemMenuController::class, 'add_post']);
Route::get('/itemMenu/edit/{itemMenu}', [ItemMenuController::class, 'edit']);
Route::post('/itemMenu/edit/{itemMenu}', [ItemMenuController::class, 'edit_post']);
Route::get('/itemMenu/delete/{itemMenu}', [ItemMenuController::class, 'delete']);

//Perfil
Route::match(['get', 'post'], '/perfil/index', [PerfilController::class, 'index']);
Route::get('/perfil/add', [PerfilController::class, 'add']);
Route::post('/perfil/add', [PerfilController::class, 'add_post']);
Route::get('/perfil/edit/{perfil}', [PerfilController::class, 'edit']);
Route::post('/perfil/edit/{perfil}', [PerfilController::class, 'edit_post']);
Route::get('/perfil/delete/{perfil}', [PerfilController::class, 'delete']);

//Bibliografia
Route::match(['get', 'post'], '/bibliografia/index', [BibliografiaController::class, 'index']);
Route::get('/bibliografia/add', [BibliografiaController::class, 'add']);
Route::post('/bibliografia/add', [BibliografiaController::class, 'add_post']);
Route::get('/bibliografia/edit/{bibliografia}', [BibliografiaController::class, 'edit']);
Route::post('/bibliografia/edit/{bibliografia}', [BibliografiaController::class, 'edit_post']);
Route::get('/bibliografia/delete/{bibliografia}', [BibliografiaController::class, 'delete']);

//Disciplina
Route::match(['get', 'post'], '/disciplina/index', [DisciplinaController::class, 'index']);
Route::get('/disciplina/view/{disciplina}', [DisciplinaController::class, 'view']);
Route::get('/disciplina/add', [DisciplinaController::class, 'add']);
Route::post('/disciplina/add', [DisciplinaController::class, 'add_post']);
Route::get('/disciplina/edit/{disciplina}', [DisciplinaController::class, 'edit']);
Route::post('/disciplina/edit/{disciplina}', [DisciplinaController::class, 'edit_post']);
Route::get('/disciplina/delete/{disciplina}', [DisciplinaController::class, 'delete']);

//Professor
Route::match(['get', 'post'], '/professor/index', [ProfessorController::class, 'index']);
Route::get('/professor/add', [ProfessorController::class, 'add']);
Route::post('/professor/add', [ProfessorController::class, 'add_post']);
Route::get('/professor/edit/{professor}', [ProfessorController::class, 'edit']);
Route::post('/professor/edit/{professor}', [ProfessorController::class, 'edit_post']);
Route::get('/professor/delete/{professor}', [ProfessorController::class, 'delete']);
//Professor Disciplinas
Route::match(['get', 'post'], '/professor/turmas/{professor}', [ProfessorController::class, 'turmas']);
Route::get('/professor/addDisciplina/{professor}', [ProfessorController::class, 'addDisciplina']);
Route::post('/professor/addDisciplina/{professor}', [ProfessorController::class, 'addDisciplina_post']);
Route::get('/professor/editDisciplina/{professor}/{disciplina}', [ProfessorController::class, 'editDisciplina']);
Route::post('/professor/editDisciplina/{professor}/{disciplina}', [ProfessorController::class, 'editDisciplina_post']);
Route::get('/professor/deleteDisciplina/{professor}/{disciplina}', [ProfessorController::class, 'deleteDisciplina']);

//Curriculo
Route::match(['get', 'post'], '/curriculo/index', [CurriculoController::class, 'index']);
Route::get('/curriculo/add', [CurriculoController::class, 'add']);
Route::post('/curriculo/add', [CurriculoController::class, 'add_post']);
Route::get('/curriculo/edit/{curriculo}', [CurriculoController::class, 'edit']);
Route::post('/curriculo/edit/{curriculo}', [CurriculoController::class, 'edit_post']);
Route::get('/curriculo/delete/{curriculo}', [CurriculoController::class, 'delete']);
Route::get('/curriculo/view/{curriculo}', [CurriculoController::class, 'view']);

//Turma
Route::match(['get', 'post'], '/turma/index', [TurmaController::class, 'index']);
Route::get('/turma/add', [TurmaController::class, 'add']);
Route::get('/turma/add/{professor}', [TurmaController::class, 'add']);
Route::post('/turma/add', [TurmaController::class, 'add_post']);
Route::post('/turma/add/{professor}', [TurmaController::class, 'add_post']);
Route::get('/turma/edit/{turma}', [TurmaController::class, 'edit']);
Route::get('/turma/edit/{turma}/{professor}', [TurmaController::class, 'edit']);
Route::post('/turma/edit/{turma}', [TurmaController::class, 'edit_post']);
Route::post('/turma/edit/{turma}/{professor}', [TurmaController::class, 'edit_post']);
Route::get('/turma/delete/{turma}', [TurmaController::class, 'delete']);