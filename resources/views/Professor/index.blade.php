@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/professor/add') ?>')">Novo Professor</button>
        <h1>Professores</h1>

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
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/professor/index/') ?>')" >Resetar</button>
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
            <?php foreach($professores as $professor):?>
                <tr>
                    <th scope="row">{{$professor->id}}</th>
                    <td class="w-75">{{$professor->Nome}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-primary" onclick="redirecionar('<?= url('/professor/turmas/'.$professor->id) ?>')">Turmas</button>
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/professor/edit/'.$professor->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $professor->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $professores->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/professor/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar a Professor?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }
    </script>
@endsection