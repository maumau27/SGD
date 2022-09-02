@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Editar Usuario - {{$usuario->Login}}</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Login" id="Login" placeholder="Login" value="{{$usuario->Login}}" required>
            <label for="Login">Login</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="Email" placeholder="Email" value="{{$usuario->Email}}" required>
            <label for="Email" class="form-label">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Nome" placeholder="Login" value="{{$usuario->Nome}}" required>
            <label for="Nome" class="form-label">Nome</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="Senha" placeholder="Senha">
            <label for="Senha" class="form-label">Senha</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="SenhaConfirma"  placeholder="SenhaConfirma">
            <label for="SenhaConfirma" class="form-label">Confirmar Senha</label>
        </div>

        <div class="mb-3" style="border-bottom:1px solid black;">
        <h3 class="mb-3">Perfils</h3>
        <div class="container-fluid mb-2">
            <?php $cols = 4; $i = $cols - 1; foreach($Perfils as $perfil): ?>
                <?php $i++; if ($i == $cols) { echo '<div class="row">'; $i = 0; } ?>
                <div class="col form-check mb-2">
                    <div class="flex">
                        <input class="btn-check" type="checkbox" value="{{$perfil->id}}" name="Perfil[{{$perfil->id}}]" id="{{$perfil->Codigo}}" autocomplete="off" <?= $PerfilsUsuario[$perfil->Codigo] ?? "" ?>>
                        <label class="btn btn-outline-primary" for="{{$perfil->Codigo}}"> {{ $perfil->Nome }} </label>
                    </div>
                </div>
                <?php if ($i == $cols - 1) { echo '</div>'; } ?>
            <?php endforeach; ?>
            <?php if ($i != $cols - 1) { echo '</div>'; } ?>
        </div>
        </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')
    
    <script>
        $('form').submit(function(e) {
            e.preventDefault();
            if( $("[name='Senha']").val() == $("[name='SenhaConfirma']").val() )
            {
                this.submit();
            }
            else
            {
                newToast('Senhas não são iguais!');
            }
        });
    </script>

@endsection