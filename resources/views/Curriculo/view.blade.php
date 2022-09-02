@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')

    <h1> {{ $curriculo->Nome }} </h1>

    <?php $total_creditos = 0; foreach($periodos as $nome => $periodo): ?>

        <div class="row mt-5">
            <div class="col-2">
                <h4> {{ $nome }} </h4>
            </div>
            <?php $total_creditos_periodo = 0; foreach($periodo as $disciplina): ?> 
                <div class="col">
                    <div class="card flex card-disciplina" listaPreReq="{{$disciplina->requisitosLista()}}" codigo="{{ $disciplina->Codigo }}" creditos="{{ $disciplina->Creditos }}" 
                        onclick="marcarPreReqs(this)">
                        <a href="http://localhost/dashboard/public/disciplina/view/{{$disciplina->id}}" target="_blanc">{{$disciplina->Codigo}}</a>
                    </div>
                </div>
            <?php $total_creditos_periodo += $disciplina->Creditos; endforeach; $total_creditos += $total_creditos_periodo; ?>
            <div class="col-2">
                <div class="card flex" >Total de Creditos: {{$total_creditos_periodo}}</div>
            </div>
        </div>
        <hr/>

    <?php endforeach; ?>
    <div class="row mt-5">
        <div class="col">
            <div class="card flex" >Total de Creditos: {{ $total_creditos }} </div>
        </div>
    </div>

@endsection

@section('script')

<script>
    const colors = [];
    while (colors.length < 100) {
        do {
            var color = Math.floor((Math.random()*1000000)+1);
        } while (colors.indexOf(color) >= 0);
        colors.push("#" + ("000000" + color.toString(16)).slice(-6));
    }

    function marcarPreReqs(disciplina)
    {
        desmarcarPreReqs(disciplina);
        if(!disciplina.getAttribute("listaPreReq"))
            return;
        array_requisitos = disciplina.getAttribute("listaPreReq").split(';');
        i = 0;
        array_requisitos.forEach(function (item) {
            requisitos = item.split(',');
            color = colors[i];
            i += 1;
            requisitos.forEach(function (item) {
                $("[codigo="+item+"]").css("backgroundColor", color);
            })
        });
    }

    function desmarcarPreReqs(disciplina)
    {
        $(".card-disciplina").css("backgroundColor", "black");
    }

    window.onload = (event) => {
        $(".card-disciplina").each(function(){
            //console.log($(this).width($(this).attr("creditos") * 25))
        });
        
        
        console.log(colors);
    };

    function generateRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

</script>

@endsection