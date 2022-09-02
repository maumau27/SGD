@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Novo Curriculo</h1>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Nome" id="Nome" placeholder="Nome" required>
            <label for="Nome">Nome</label>
        </div>
        <hr/>

        <h3 class="mb-3">Grade</h3>

        <div id="BoxPeriodos">

        </div>

        <div class="flex"> <i class="fa fa-plus-circle add" onclick="adicionar_periodo()" aria-hidden="true"></i> </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')
    <script>
        var idPeriodo = 1;
        var idDisciplina = 1;

        function adicionar_periodo() {
            $("#BoxPeriodos").append(`
            <div class="row" id="Periodo_`+idPeriodo+`">
                <div class="col-2 BoxNomePeriodo">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" name="NomePeriodo[`+idPeriodo+`]" placeholder="Nome Periodo" required>
                        <label for="NomePeriodo[`+idPeriodo+`]">Nome Periodo</label>
                    </div>
                </div>
                <div class="col-9">
                    <div id="BoxDisciplinas_`+idPeriodo+`" class="row">
                        
                    </div>
                </div>
                <div class="col-1 BoxAdd">
                    <div class="flex pt-2"> <i class="fa fa-plus-circle add" onclick="adicionar_disciplina(`+idPeriodo+`)" aria-hidden="true"></i> </div>
                    <div class="flex pt-1"> <i class="fa fa-minus-circle remove" onclick="remover_periodo(`+idPeriodo+`)" aria-hidden="true"></i> </div>
                </div>
            <hr/>
            </div>
            `);
            idPeriodo++;
        }

        function remover_periodo(id) {
            $("#Periodo_"+id).remove();
        }

        function adicionar_disciplina(periodo) {
            $("#BoxDisciplinas_"+periodo).append(`
            <div class="col-2" id="Disciplina_div_`+idDisciplina+`">
                <select id="Disciplina_Select_`+idDisciplina+`" class="form-control selectpicker mb-3" style="width: 100px;" aria-label="Default select" name="Disciplina[`+periodo+`][`+idDisciplina+`]" data-live-search="true">
                    <?php foreach($Disciplinas as $disciplina): ?>
                        <option style="width:inherit" data-tokens="<?= $disciplina->Codigo ?>" value="<?=$disciplina->id?>"><?= $disciplina->Codigo ?></option>
                    <?php endforeach; ?>
                </select>
                <i class="fa fa-minus-circle remove flex" onclick="remover_disciplina(`+idDisciplina+`)" aria-hidden="true"></i>
            </div>
            `);
            $('#Disciplina_Select_' + idDisciplina).selectpicker('refresh');
            idDisciplina++;
        }

        function remover_disciplina(id) {
            $("#Disciplina_div_"+id).remove();
        }

    </script>
    
@endsection