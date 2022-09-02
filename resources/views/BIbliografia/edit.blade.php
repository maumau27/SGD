@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Editar Bibliografia</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Titulo" id="Titulo" placeholder="Titulo" value="{{$bibliografia->Titulo}}">
            <label for="Titulo">Titulo</label>
        </div>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')

@endsection