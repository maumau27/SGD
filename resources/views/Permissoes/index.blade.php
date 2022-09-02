@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/permissoes/add') ?>')">Nova Permissâo</button>
        <h1>Permissões</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Nome" <?php if($tipoFiltro == "Nome") echo "selected"; ?>>Nome</option>
                <option value="Controller" <?php if($tipoFiltro == "Controller") echo "selected"; ?>>Controller</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/permissoes/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Nome')</th>
                <th scope="col">@sortablelink('Controller')</th>
                <th scope="col">Action</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($permissoes as $permissao):?>
                <tr>
                    <th scope="row">{{$permissao->id}}</th>
                    <td>{{$permissao->Nome}}</td>
                    <td>{{$permissao->Controller}}</td>
                    <td>{{$permissao->Action}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/permissoes/edit/'.$permissao->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $permissao->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $permissoes->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/permissoes/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar a Permissao?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }

    </script>
@endsection