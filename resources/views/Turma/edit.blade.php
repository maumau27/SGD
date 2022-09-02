@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
    <h1>Editar Turma {{isset($Professor) ? "de " . $Professor->Nome : ""}}</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Codigo" id="Codigo" placeholder="Codigo" value="{{$turma->Codigo}}" require>
            <label for="Codigo">Codigo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="MaximoAlunos" id="MaximoAlunos" placeholder="Maximo de Alunos" value="{{$turma->MaximoAlunos}}">
            <label for="MaximoAlunos">Maximo de Alunos</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Ano" id="Ano" placeholder="Ano" value="{{$turma->Ano}}">
            <label for="Ano">Ano</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Semestre" id="Semestre" placeholder="Semestre" value="{{$turma->Semestre}}">
            <label for="Semestre">Semestre</label>
        </div>

        @if(isset($Professores))
        <select class="form-control selectpicker mb-3" aria-label="Default select" name="idProfessor" data-live-search="true">
            <option data-tokens="{ $professor->Nome }}" <?php if(!$turma->professor) echo 'selected'; ?> value="0">A Definir</option>
            <?php foreach($Professores as $professor): ?>
                <option data-tokens="{ $professor->Nome }}" <?php if($turma->professor && $professor->id == $turma->professor->id) echo 'selected'; ?> value="{{$professor->id}}">{{ $professor->Nome }}</option>
            <?php endforeach; ?>
        </select>
        @elseif(isset($Professor))
        <input type="hidden" class="form-control" name="idProfessor" id="idProfessor" placeholder="idProfessor" value="{{$Professor->id}}">
        @endif

        <select class="form-control selectpicker mb-3" aria-label="Default select" name="idDisciplina" data-live-search="true">
            <?php foreach($Disciplinas as $disciplina): ?>
                <option data-tokens="{ $disciplina->Nome }}" <?php if($turma->disciplina && $disciplina->id == $turma->disciplina->id) echo 'selected'; ?> value="{{$disciplina->id}}">{{ $disciplina->Codigo }}</option>
            <?php endforeach; ?>
        </select>


        <div class="mb-3">
            <a class="mt-3 btn btn-outline-primary" data-bs-toggle="collapse" href="#collapseProfessor" role="button">
                Informações Espelhadas do Professor
            </a>
        </div>
        <div class="collapse mb-3" id="collapseProfessor">
            <div class="card card-body">
                <h2> Dados do Professor </h2>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Nome" id="Nome" placeholder="Nome" value="{{$ProfessorCache->Nome}}" require>
                    <label for="Nome">Nome</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Bio" id="Bio" placeholder="Bio" value="{{$ProfessorCache->Bio}}">
                    <label for="Bio">Bio</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="MiniBio" id="MiniBio" placeholder="MiniBio" value="{{$ProfessorCache->MiniBio}}" >
                    <label for="MiniBio">MiniBio</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Cargo" id="Cargo" placeholder="Cargo" value="{{$ProfessorCache->Cargo}}" >
                    <label for="Cargo">Cargo</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="BolsaProdutividade" id="BolsaProdutividade" placeholder="BolsaProdutividade" value="{{$ProfessorCache->BolsaProdutividade}}" >
                    <label for="BolsaProdutividade">BolsaProdutividade</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Telefone" id="Telefone" placeholder="Telefone" value="{{$ProfessorCache->Telefone}}" >
                    <label for="Telefone">Telefone</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Sala" id="Sala" placeholder="Sala" value="{{$ProfessorCache->Sala}}" >
                    <label for="Sala">Sala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Site" id="Site" placeholder="Site" value="{{$ProfessorCache->Site}}" >
                    <label for="Site">Site</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Lattes" id="Lattes" placeholder="Lattes" value="{{$ProfessorCache->Lattes}}" >
                    <label for="Lattes">Lattes</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Linkedin" id="Linkedin" placeholder="Linkedin" value="{{$ProfessorCache->Linkedin}}" >
                    <label for="Linkedin">Linkedin</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Scholar" id="Scholar" placeholder="Scholar" value="{{$ProfessorCache->Scholar}}" >
                    <label for="Scholar">Scholar</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="DBPL" id="DBPL" placeholder="DBPL" value="{{$ProfessorCache->DBPL}}" >
                    <label for="DBPL">DBPL</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="ORCID" id="ORCID" placeholder="ORCID" value="{{$ProfessorCache->ORCID}}" >
                    <label for="ORCID">ORCID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Publons" id="Publons" placeholder="Publons" value="{{$ProfessorCache->Publons}}" >
                    <label for="Publons">Publons</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <a class="mt-3 btn btn-outline-primary" data-bs-toggle="collapse" href="#collapseDisciplina" role="button">
                Informações Espelhadas da Disciplina
            </a>
        </div>
        <div class="collapse mb-3" id="collapseDisciplina">
            <div class="card card-body">
                <h2> Dados da Disciplina </h2>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="CodigoDisciplina" id="CodigoDisciplina" placeholder="CodigoDisciplina" value="{{$DisciplinaCache->Codigo}}" require>
                    <label for="CodigoDisciplina">Codigo</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Titulo" id="Titulo" placeholder="Titulo" value="{{$DisciplinaCache->Titulo}}">
                    <label for="Titulo">Titulo</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Creditos" id="Creditos" placeholder="Creditos" value="{{$DisciplinaCache->Creditos}}" >
                    <label for="Creditos">Creditos</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Ementa" id="Ementa" placeholder="Ementa" value="{{$DisciplinaCache->Ementa}}" >
                    <label for="Ementa">Ementa</label>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')

@endsection