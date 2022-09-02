@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Editar Disciplina do Professor - {{ $professor->Nome }}</h1>

        <label for="idDisciplina">Disciplina</label>
        <select class="form-control selectpicker mb-3" aria-label="Default select" name="idDisciplina" data-live-search="true">
            <?php foreach($disciplinas as $disciplina): ?>
                <option data-tokens="{ $disciplina->Codigo }}" <?php if($disciplina->id == $disciplinaProf->id) echo 'selected'; ?> value="{{$disciplina->id}}">{{ $disciplina->Codigo }}</option>
            <?php endforeach; ?>
        </select>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Ano" id="Ano" placeholder="Ano" value="{{$relacao->pivot->Ano}}">
            <label for="Ano">Ano</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Semestre" placeholder="Semestre" value="{{$relacao->pivot->Semestre}}">
            <label for="Semestre" class="form-label">Semestre</label>
        </div>

        <input type="hidden" id="disciplinaAntiga" name="disciplinaAntiga" value="{{ $disciplinaProf->id }}">

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')


@endsection