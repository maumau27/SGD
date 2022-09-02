@extends('layouts.login')
@section('title', 'Dashboard')


@section('content')

    <div class="fixed-center">
        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">@yield('title')</div>
            <div class="card-body flex">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Entrar no Sistema</button>
            </div>
            <div class="card-footer">
                <a class="card-link" data-bs-toggle="modal" data-bs-target="#recuperarSenha">Esqueci minha senha</a>
            </div>
        </div>
    </div>

    <!-- Modal login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLable" aria-hidden="true">
        <form method="POST">   
        @csrf
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="loginModalLabel">@yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <div class="mb-3">
                <label for="Login" class="form-label">Nome</label>
                <input name="Login" type="text" class="form-control" id="Login" required>
            </div>
            <div class="mb-3">
                <label for="Senha" class="form-label">Senha</label required>
                <input name="Senha" type="password" class="form-control" id="Senha">
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="lembrar">
                <label class="form-check-label" for="lembrar">Manter Logado</label>
            </div> -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            </div>
        </div>
        </form>
    </div>

     <!-- Modal recuperar senha -->
     <div class="modal fade" id="recuperarSenha" tabindex="-1" aria-labelledby="recuperarSenhaLable" aria-hidden="true">
        <form method="POST" action="recuperarSenha">
        @csrf
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="recuperarSenhaLable">@yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <div class="mb-3">
                <label for="Email" class="form-label">Email</label>
                <input name="Email" type="email" class="form-control" id="Email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">Preencha o campo acima com o seu email registrado no sistema para que possamos reenviar sua senha.</div>
            </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Recuperar Senha</button>
            </div>
            </div>
        </div>
        </form>
    </div>

@endsection

@section('script')

@endsection