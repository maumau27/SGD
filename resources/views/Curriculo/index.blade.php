@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/curriculo/add') ?>')">Novo Curriculo</button>
        <h1>Curriculos</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Nome" <?php if($tipoFiltro == "Nome") echo "selected"; ?>>Nome</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/curriculo/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Nome')</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($curriculos as $curriculo):?>
                <tr>
                    <th scope="row">{{$curriculo->id}}</th>
                    <td class="w-75">{{$curriculo->Nome}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-primary" onclick="redirecionar('<?= url('/curriculo/view/'.$curriculo->id) ?>')">Visualizar</button>
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/curriculo/edit/'.$curriculo->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $curriculo->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $curriculos->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/curriculo/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar a Curriculo?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }
    </script>
@endsection