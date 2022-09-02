@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Editar Perfil - {{$perfil->Nome}}</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Nome" id="Nome" placeholder="Nome" value="{{$perfil->Nome}}" required>
            <label for="Nome">Nome</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Codigo" placeholder="Codigo" value="{{$perfil->Codigo}}" required>
            <label for="Codigo" class="form-label">Codigo</label>
        </div>
        
        <div class="mb-3" style="border-bottom:1px solid black;">
        <h3 class="mb-3">Permissoes</h3>
        <div class="container-fluid mb-2">
            <?php $cols = 4; $i = $cols - 1; foreach($Permissoes as $permissao): ?>
                <?php $i++; if ($i == $cols) { echo '<div class="row">'; $i = 0; } ?>
                <div class="col form-check mb-2">
                    <div class="flex">
                        <input class="btn-check" type="checkbox" value="{{$permissao->id}}" name="Permissoes[{{$permissao->id}}]" id="{{$permissao->Nome}}" autocomplete="off" <?= $PerfilPermissoes[$permissao->Nome] ?? "" ?>>
                        <label class="btn btn-outline-primary" for="{{$permissao->Nome}}"> {{ $permissao->Nome }} </label>
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