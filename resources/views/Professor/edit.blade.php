@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Editar Professor</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Nome" id="Nome" placeholder="Nome" value="{{$professor->Nome}}" require>
            <label for="Nome">Nome</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Bio" id="Bio" placeholder="Bio" value="{{$professor->Bio}}">
            <label for="Bio">Bio</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="MiniBio" id="MiniBio" placeholder="MiniBio" value="{{$professor->MiniBio}}" >
            <label for="MiniBio">MiniBio</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Cargo" id="Cargo" placeholder="Cargo" value="{{$professor->Cargo}}" >
            <label for="Cargo">Cargo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="BolsaProdutividade" id="BolsaProdutividade" placeholder="BolsaProdutividade" value="{{$professor->BolsaProdutividade}}" >
            <label for="BolsaProdutividade">BolsaProdutividade</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Telefone" id="Telefone" placeholder="Telefone" value="{{$professor->Telefone}}" >
            <label for="Telefone">Telefone</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Sala" id="Sala" placeholder="Sala" value="{{$professor->Sala}}" >
            <label for="Sala">Sala</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Site" id="Site" placeholder="Site" value="{{$professor->Site}}" >
            <label for="Site">Site</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Lattes" id="Lattes" placeholder="Lattes" value="{{$professor->Lattes}}" >
            <label for="Lattes">Lattes</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Linkedin" id="Linkedin" placeholder="Linkedin" value="{{$professor->Linkedin}}" >
            <label for="Linkedin">Linkedin</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Scholar" id="Scholar" placeholder="Scholar" value="{{$professor->Scholar}}" >
            <label for="Scholar">Scholar</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="DBPL" id="DBPL" placeholder="DBPL" value="{{$professor->DBPL}}" >
            <label for="DBPL">DBPL</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="ORCID" id="ORCID" placeholder="ORCID" value="{{$professor->ORCID}}" >
            <label for="ORCID">ORCID</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Publons" id="Publons" placeholder="Publons" value="{{$professor->Publons}}" >
            <label for="Publons">Publons</label>
        </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')

@endsection