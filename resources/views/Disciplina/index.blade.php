@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/disciplina/add') ?>')">Nova Disciplina</button>
        <h1>Disciplinas</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Codigo" <?php if($tipoFiltro == "Codigo") echo "selected"; ?>>Codigo</option>
                <option value="Titulo" <?php if($tipoFiltro == "Titulo") echo "selected"; ?>>Titulo</option>
                <option value="Creditos" <?php if($tipoFiltro == "Creditos") echo "selected"; ?>>Creditos</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/disciplina/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->

        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Codigo')</th>
                <th scope="col">@sortablelink('Titulo')</th>
                <th scope="col">@sortablelink('Creditos')</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($disciplinas as $disciplina):?>
                <tr>
                    <th scope="row">{{$disciplina->id}}</th>
                    <td scope="row">{{$disciplina->Codigo}}</td>
                    <td>{{$disciplina->Titulo}}</td>
                    <td>{{$disciplina->Creditos}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-primary" onclick="redirecionar('<?= url('/disciplina/view/'.$disciplina->id) ?>')">Visualizar</button>
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/disciplina/edit/'.$disciplina->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $disciplina->id ?>)">Apagar</button> 
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $disciplinas->appends(Request::except('page'))->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/disciplina/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar a Disciplina?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }

    </script>
@endsection