@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Nova Permissão</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Nome" placeholder="Nome" required>
            <label for="Nome" class="form-label">Nome</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Controller" id="Controller" placeholder="Controller" required>
            <label for="Controller">Controller</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Action" placeholder="Action" required>
            <label for="Action" class="form-label">Action</label>
        </div>
        
        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')


@endsection