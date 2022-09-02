@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/turma/add') ?>')">Nova Turma</button>
        <h1>Turmas</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Codigo" <?php if($tipoFiltro == "Codigo") echo "selected"; ?>>Codigo</option>
                <option value="MaximoAlunos" <?php if($tipoFiltro == "MaximoAlunos") echo "selected"; ?>>Maximo de Alunos</option>
                <option value="Ano" <?php if($tipoFiltro == "Ano") echo "selected"; ?>>Ano</option>
                <option value="codigoDisciplina" <?php if($tipoFiltro == "codigoDisciplina") echo "selected"; ?>>Disciplina</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/turma/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Codigo')</th>
                <th scope="col">@sortablelink('MaximoAlunos', 'Maximo de Alunos')</th>
                <th scope="col">@sortablelink('Ano', 'Semestre')</th>
                <th scope="col">Professor</th>
                <th scope="col">@sortablelink('codigoDisciplina', 'Disciplina')</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($turmas as $turma):?>
                <tr>
                    <th scope="row">{{$turma->id}}</th>
                    <td>{{$turma->Codigo}}</td>
                    <td>{{$turma->MaximoAlunos}}</td>
                    <td>{{$turma->Ano}}.{{$turma->Semestre}}</td>
                    <td>{{$turma->professor ? $turma->professor->Nome : "A Definir"}}</td>
                    <td>{{$turma->disciplina->Codigo}}</td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/turma/edit/'.$turma->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $turma->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $turmas->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/turma/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar a Turma?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }
    </script>
@endsection