@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/bibliografia/add') ?>')">Nova Bibliografia</button>
        <h1>Bibliografias</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Titulo" <?php if($tipoFiltro == "Titulo") echo "selected"; ?>>Titulo</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/bibliografia/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Titulo')</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($bibliografias as $bibliografia):?>
                <tr>
                    <th scope="row">{{$bibliografia->id}}</th>
                    <td class="w-75">{{$bibliografia->Titulo}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/bibliografia/edit/'.$bibliografia->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $bibliografia->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $bibliografias->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/bibliografia/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar a Bibliografia?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }
    </script>
@endsection