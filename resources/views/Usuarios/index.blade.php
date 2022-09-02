@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/usuarios/add') ?>')">Novo Usuario</button>
        <h1>Usuarios</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Login" <?php if($tipoFiltro == "Login") echo "selected"; ?>>Login</option>
                <option value="Nome" <?php if($tipoFiltro == "Nome") echo "selected"; ?>>Nome</option>
                <option value="Email" <?php if($tipoFiltro == "Email") echo "selected"; ?>>Email</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/usuarios/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Login')</th>
                <th scope="col">@sortablelink('Nome')</th>
                <th scope="col">@sortablelink('Email')</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($usuarios as $usuario):?>
                <tr>
                    <th scope="row">{{$usuario->id}}</th>
                    <td scope="row">{{$usuario->Login}}</td>
                    <td>{{$usuario->Nome ?? ""}}</td>
                    <td>{{$usuario->Email}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/usuarios/edit/'.$usuario->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $usuario->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $usuarios->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/usuarios/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar o Usuario?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }

    </script>
@endsection