@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1 class="mb-3">Editar Disciplina - {{$disciplina->Codigo}}</h1>

        <h3 class="mb-2">Dados</h3>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Titulo" placeholder="Titulo" value="{{$disciplina->Titulo}}" required>
            <label for="Titulo" class="form-label">Titulo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Codigo" id="Codigo" placeholder="Codigo" value="{{$disciplina->Codigo}}" required>
            <label for="Codigo">Codigo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="Creditos" placeholder="Creditos" value="{{$disciplina->Creditos}}" required>
            <label for="Creditos" class="form-label">Creditos</label>
        </div>
        <div class="form-floating mb-3">
            <textarea type="text" class="form-control" name="Ementa" placeholder="Ementa" style="height:200px" required>{{$disciplina->Ementa}}</textarea>
            <label for="Ementa" class="form-label">Ementa</label>
        </div>

        <hr/>

        <h3 class="mb-2">Bibliografias</h3>
        <div id="bibliografiaBox">
            <?php $idBibliografia = 0; foreach($disciplina->bibliografia as $bibliografia_Disciplina):?>
            <div class="row" id="bibliografiaDiv_{{$idBibliografia}}">
                <div class="col-11">
                    <select id="bibliografiaSelect_{{$idBibliografia}}" class="form-control selectpicker mb-3 " aria-label="Default select" name="Bibliografias[{{$idBibliografia}}]" data-live-search="true">
                        <?php foreach($Bibliografias as $bibliografia): ?>
                            <option style="width:inherit" data-tokens="<?= $bibliografia->Titulo ?>" <?php if($bibliografia_Disciplina->id == $bibliografia->id) echo 'selected'; ?> value="<?=$bibliografia->id?>"><?= $bibliografia->Titulo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-1 ">
                    <i class="fa fa-minus-circle remove" onclick="remover_bibliografia({{$bibliografia->id}})" aria-hidden="true"></i>
                </div>
            </div>
            <?php $idBibliografia++; endforeach; ?>
        </div>
        <div class="flex"> <i class="fa fa-plus-circle add" onclick="adicionar_bibliografia()" aria-hidden="true"></i> </div>

        <hr/>

        <h3 class="mb-2">Bibliografias Complementares</h3>
        <div id="bibliografiaCompBox">
            <?php $idBibliografiaComp = 0; foreach($disciplina->bibliografiaComplementar as $bibliografia_Disciplina):?>
            <div class="row" id="bibliografiaDiv_{{$idBibliografiaComp}}">
                <div class="col-11">
                    <select id="bibliografiaSelect_{{$idBibliografiaComp}}" class="form-control selectpicker mb-3 " aria-label="Default select" name="BibliografiasComp[{{$idBibliografiaComp}}]" data-live-search="true">
                        <?php foreach($Bibliografias as $bibliografia): ?>
                            <option style="width:inherit" data-tokens="<?= $bibliografia->Titulo ?>" <?php if($bibliografia_Disciplina->id == $bibliografia->id) echo 'selected'; ?> value="<?=$bibliografia->id?>"><?= $bibliografia->Titulo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-1 ">
                    <i class="fa fa-minus-circle remove" onclick="remover_bibliografia({{$bibliografia->id}})" aria-hidden="true"></i>
                </div>
            </div>
            <?php $idBibliografiaComp++; endforeach; ?>

        </div>
        <div class="flex"> <i class="fa fa-plus-circle add" onclick="adicionar_bibliografiaComp()" aria-hidden="true"></i> </div>

        <hr/>

        <h3 class="mb-2">Pre-Requisitos</h3>
        <div id="PreReqBox">
            <?php $idPreReq = 0; $idGrupoPreReq = 0; foreach($disciplina->prereq as $preReqs): ?>
                <div id="PreReqGrupo_{{$idGrupoPreReq}}" class="row">

                <h5 class="flex">
                    Grupo de Pre-Requisitos
                    <i class="fa fa-plus-circle add" onclick="adicionar_prereq({{$idGrupoPreReq}})" aria-hidden="true"></i>
                    <i class="fa fa-minus-circle remove" onclick="remover_grupo_prereq({{$idGrupoPreReq}})" aria-hidden="true"></i>
                </h5>

                <?php foreach($preReqs->requisitos as $requisito): ?>
                    <div class="col-2" id="PreReq_div_{{$idPreReq}}">
                        <select id="PreReq_Select_{{$idPreReq}}" class="form-control selectpicker mb-3" style="width: 100px;" aria-label="Default select" name="PreReqs[{{$idGrupoPreReq}}][{{$idPreReq}}]" data-live-search="true">
                            <?php foreach($Disciplinas as $disciplina): ?>
                                <option style="width:inherit" data-tokens="<?= $disciplina->Codigo ?>" <?php if($requisito->id == $disciplina->id) echo 'selected'; ?> value="<?=$disciplina->id?>"><?= $disciplina->Codigo ?></option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa fa-minus-circle remove flex" onclick="remover_prereq({{$idPreReq}})" aria-hidden="true"></i>
                    </div>
                <?php $idPreReq++; endforeach; ?>

                </div>
                <div class="flex" id="OU_Grupo_{{$idGrupoPreReq}}">OU</div>
            <?php $idGrupoPreReq++; endforeach; ?>
        </div>
        <div class="flex"> <i class="fa fa-plus-circle add" title="Adicionar Grupo de Pre-Requisitos" onclick="adicionar_grupo_prereq()" aria-hidden="true"></i> </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')
    <script>
        var idBibliografia = {{$idBibliografia}};
        var idBibliografiaComp = {{$idBibliografiaComp}};

        var idGrupoPreReq = {{$idGrupoPreReq}};
        var idPreReq = {{$idPreReq}};

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