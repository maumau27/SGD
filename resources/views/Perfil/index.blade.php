@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/perfil/add') ?>')">Novo Perfil</button>
        <h1>Perfil</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Nome" <?php if($tipoFiltro == "Nome") echo "selected"; ?>>Nome</option>
                <option value="Codigo" <?php if($tipoFiltro == "Codigo") echo "selected"; ?>>Codigo</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/perfil/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Nome')</th>
                <th scope="col">@sortablelink('Codigo')</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($perfils as $perfil):?>
                <tr>
                    <th scope="row">{{$perfil->id}}</th>
                    <td>{{$perfil->Nome}}</td>
                    <td>{{ $perfil->Codigo }} <td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/perfil/edit/'.$perfil->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $perfil->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $perfils->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/perfil/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar o Perfil?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }

    </script>
@endsection