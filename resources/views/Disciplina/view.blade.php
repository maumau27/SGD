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
                    <h3 class="mb-3"><b>Creditos:</b> {{$disciplina->Creditos}}</h3>
                <hr/>
                    <h3 class="mb-3"><b>Ementa</b></h3>
                    <span>{{$disciplina->Ementa}}</span>
                <hr/>
                @if($bibliografias->isNotEmpty())
                    <h3 class="mb-3"><b>Bibliografias</b></h3>
                    <?php foreach($bibliografias as $bibliografia): ?>
                        <span>{{$bibliografia->Titulo}}</span>
                        </br>
                    <?php endforeach; ?>
                <hr/>
                @endif
                @if($bibliografiasComplementar->isNotEmpty())
                    <h3 class="mb-3"><b>Bibliografia Complementar</b></h3>
                    <?php foreach($bibliografiasComplementar as $bibliografia): ?>
                        <span>{{$bibliografia->Titulo}}</span>
                        </br>
                    <?php endforeach; ?>
                <hr/>
                @endif
                @if(!empty($prereqs))
                    <h3 class="mb-3"><b>Pre-Requisitos</b></h3>
                    <?php $last_key = array_key_last($prereqs); foreach($prereqs as $key => $requisitos): ?>
                        <div class="row">
                            <?php foreach($requisitos as $requisito): ?>
                                @if(array_key_exists("Codigo", $requisito))
                                <div class="flex col mb-2">
                                    <button type="button" class="btn btn-warning" onclick="redirecionar('<?= url('disciplina/view/'.$requisito['id']) ?>')">{{$requisito['Codigo']}}</button>
                                </div>
                                @endif
                                @if(array_key_exists("NumeroCreditos", $requisito))
                                <div class="flex col mb-2">
                                    <span>{{$requisito['NumeroCreditos']}} Créditos</span>
                                </div>
                                @endif
                            <?php endforeach; ?>
                            <?php if ($key != $last_key): ?>
                                <span class="flex mb-1"> OU </span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                @endif
            </div>
        </div>
        
        <button type="button" class="btn btn-lg btn-danger float-end" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
    </div> 

</form>
@endsection

@section('script')


@endsection