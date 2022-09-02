@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <div class="center" style="width:70%">
            <div class="card p-3">
                    <h1 class="flex mb-3">{{$disciplina->Titulo}}</h1>
                <hr/>
                    <h3 class="mb-3"><b>Codigo:</b> {{$disciplina->Codigo}}</h3>
                <hr/>
                    <h3 class="mb-3"><b>Grupo de Disciplinas</b></h3>
                    <?php foreach($grupoOptativa as $optativa): ?>
                        <div class="row">
                            <div class="flex col mb-2">
                            <button type="button" class="btn btn-warning" onclick="redirecionar('<?= url('disciplina/view/'.$optativa['id']) ?>')">{{$optativa['Codigo']}}</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
        </div>
        
        <button type="button" class="btn btn-lg btn-danger float-end" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
    </div> 

</form>
@endsection

@section('script')


@endsection