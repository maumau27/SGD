@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Nova Turma {{isset($Professor) ? "de " . $Professor->Nome : ""}}</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Codigo" id="Codigo" placeholder="Codigo" required>
            <label for="Codigo">Codigo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="MaximoAlunos" id="MaximoAlunos" placeholder="Maximo de Alunos">
            <label for="MaximoAlunos">Maximo de Alunos</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Ano" id="Ano" placeholder="Ano">
            <label for="Ano">Ano</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Semestre" id="Semestre" placeholder="Semestre">
            <label for="Semestre">Semestre</label>
        </div>

        @if(isset($Professores))
        <select class="form-control selectpicker mb-3" aria-label="Default select" name="idProfessor" data-live-search="true">
            <label for="Semestre">Professor</label>
            <option data-tokens="{ $professor->Nome }}" value="0">A Definir</option>
            <?php foreach($Professores as $professor): ?>
                <option data-tokens="{ $professor->Nome }}" value="{{$professor->id}}">{{ $professor->Nome }}</option>
            <?php endforeach; ?>
        </select>
        @elseif(isset($Professor))
        <input type="hidden" class="form-control" name="idProfessor" id="idProfessor" placeholder="idProfessor" value="{{$Professor->id}}">
        @endif

        <select class="form-control selectpicker mb-3" aria-label="Default select" name="idDisciplina" data-live-search="true">
            <label for="Semestre">Disciplina</label>
            <?php foreach($Disciplinas as $disciplina): ?>
                <option data-tokens="{ $disciplina->Nome }}" value="{{$disciplina->id}}">{{ $disciplina->Codigo }}</option>
            <?php endforeach; ?>
        </select>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')
    
@endsection