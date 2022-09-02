@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1 class="mb-3">Nova Disciplina</h1>

        <h3 class="mb-2">Dados</h3>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Titulo" placeholder="Titulo" required>
            <label for="Titulo" class="form-label">Titulo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Codigo" id="Codigo" placeholder="Codigo">
            <label for="Codigo">Codigo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="Creditos" placeholder="Creditos" required>
            <label for="Creditos" class="form-label">Creditos</label>
        </div>
        <div class="form-floating mb-3">
            <textarea type="text" class="form-control" name="Ementa" placeholder="Ementa" style="height:200px" required></textarea>
            <label for="Ementa" class="form-label">Ementa</label>
        </div>

        <hr/>

        <h3 class="mb-2">Bibliografias</h3>
        <div id="bibliografiaBox">

        </div>
        <div class="flex"> <i class="fa fa-plus-circle add" onclick="adicionar_bibliografia()" aria-hidden="true"></i> </div>

        <hr/>

        <h3 class="mb-2">Bibliografias Complementares</h3>
        <div id="bibliografiaCompBox">

        </div>
        <div class="flex"> <i class="fa fa-plus-circle add" onclick="adicionar_bibliografiaComp()" aria-hidden="true"></i> </div>

        <hr/>

        <h3 class="mb-2">Pre-Requisitos</h3>
        <div id="PreReqBox">

        </div>
        <div class="flex"> <i class="fa fa-plus-circle add" title="Adicionar Grupo de Pre-Requisitos" onclick="adicionar_grupo_prereq()" aria-hidden="true"></i> </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')
    <script>
        var idBibliografia = 1;
        var idBibliografiaComp = 1;

        var idGrupoPreReq = 1;
        var idPreReq = 1;

        function adicionar_bibliografia() {
            $("#bibliografiaBox").append(` 
            <div class="row" id="bibliografiaDiv_`+ idBibliografia +`">
                <div class="col-11">
                    <select id="bibliografiaSelect_`+ idBibliografia +`" class="form-control selectpicker mb-3 " aria-label="Default select" name="Bibliografias[`+ idBibliografia +`]" data-live-search="true">
                        <?php foreach($Bibliografias as $bibliografia): ?>
                            <option style="width:inherit" data-tokens="<?= $bibliografia->Titulo ?>" value="<?=$bibliografia->id?>"><?= $bibliografia->Titulo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-1 ">
                    <i class="fa fa-minus-circle remove" onclick="remover_bibliografia(`+ idBibliografia +`)" aria-hidden="true"></i>
                </div>
            </div>
            `);
            $('#bibliografiaSelect_' + idBibliografia).selectpicker('refresh');
            idBibliografia++;
        }

        function remover_bibliografia(id) {
            $("#bibliografiaDiv_" + id).remove();
        }

        function adicionar_bibliografiaComp() {
            $("#bibliografiaCompBox").append(` 
            <div class="row" id="bibliografiaCompDiv_`+ idBibliografiaComp +`">
                <div class="col-11">
                    <select id="bibliografiaCompSelect_`+ idBibliografiaComp +`" class="form-control selectpicker mb-3 " aria-label="Default select" name="BibliografiasComp[`+ idBibliografiaComp +`]" data-live-search="true">
                        <?php foreach($Bibliografias as $bibliografia): ?>
                            <option style="width:inherit" data-tokens="<?= $bibliografia->Titulo ?>" value="<?=$bibliografia->id?>"><?= $bibliografia->Titulo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-1 ">
                    <i class="fa fa-minus-circle remove" onclick="remover_bibliografiaComp(`+ idBibliografiaComp +`)" aria-hidden="true"></i>
                </div>
            </div>
            `);
            $('#bibliografiaCompSelect_' + idBibliografiaComp).selectpicker('refresh');
            idBibliografiaComp++;
        }

        function remover_bibliografiaComp(id) {
            $("#bibliografiaCompDiv_" + id).remove();
        }

        function adicionar_grupo_prereq()
        {
            $("#PreReqBox").append(`
            <div id="PreReqGrupo_`+idGrupoPreReq+`" class="row">

                <h5 class="flex">
                    Grupo de Pre-Requisitos
                    <i class="fa fa-plus-circle add" onclick="adicionar_prereq(`+idGrupoPreReq+`)" aria-hidden="true"></i>
                    <i class="fa fa-minus-circle remove" onclick="remover_grupo_prereq(`+idGrupoPreReq+`)" aria-hidden="true"></i>
                </h5>

            </div>
            <div class="flex" id="OU_Grupo_`+ idGrupoPreReq +`">OU</div> 
            `);
            idGrupoPreReq++;
        }

        function adicionar_prereq(grupo)
        {
            $("#PreReqGrupo_"+grupo).append(`
            <div class="col-2" id="PreReq_div_`+ idPreReq +`">
                <select id="PreReq_Select_`+ idPreReq +`" class="form-control selectpicker mb-3" style="width: 100px;" aria-label="Default select" name="PreReqs[`+ grupo +`][`+ idPreReq +`]" data-live-search="true">
                    <?php foreach($Disciplinas as $disciplina): ?>
                        <option style="width:inherit" data-tokens="<?= $disciplina->Codigo ?>" value="<?=$disciplina->id?>"><?= $disciplina->Codigo ?></option>
                    <?php endforeach; ?>
                </select>
                <i class="fa fa-minus-circle remove flex" onclick="remover_prereq(`+ idPreReq +`)" aria-hidden="true"></i>
            </div>
            `);
            $('#PreReq_Select_' + idPreReq).selectpicker('refresh');
            idPreReq++;
        }

        function remover_grupo_prereq(grupo)
        {
            $("#PreReqGrupo_"+grupo).remove();
            $("#OU_Grupo_"+grupo).remove();
        }

        function remover_prereq(id)
        {
            $("#PreReq_div_"+id).remove();
        }

    </script>
@endsection