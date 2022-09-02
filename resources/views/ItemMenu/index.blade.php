@extends('layouts.default')
@section('title', 'Dashboard')

@section('content')

    <div class="container mt-5">
        <button type="button" class="btn btn-outline-success float-end" onclick="redirecionar('<?= url('/itemMenu/add') ?>')">Novo Item Menu</button>
        <h1>Itens do Menu</h1>

        <form method="POST">
        @csrf
        
        <!-- Filtro -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="Filtro">Filtro</label>

            <input type="text" class="form-control" name="Filtro" id="Filtro" placeholder="Filtro" value="{{$filtro ?? ''}}">

            <label class="input-group-text" for="tipoFiltro">Categoria</label>

            <select class="form-select form-control-sm" name="tipoFiltro" id="tipoFiltro">
                <option value="Menu" <?php if($tipoFiltro == "Menu") echo "selected"; ?>>Menu</option>
                <option value="Item" <?php if($tipoFiltro == "Item") echo "selected"; ?>>Item</option>
            </select>

            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <button class="btn btn-outline-danger" type="button" onclick="redirecionar('<?= url('/itemMenu/index/') ?>')" >Resetar</button>
        </div>
        <!-- Filtro -->
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">@sortablelink('Menu')</th>
                <th scope="col">@sortablelink('Item')</th>
                <th scope="col">Ação</th>
                <th class="float-end" scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($itemMenus as $itemMenu):?>
                <tr>
                    <th scope="row">{{$itemMenu->id}}</th>
                    <td>{{$itemMenu->Menu ?? '###'}}</td>
                    <td>{{$itemMenu->Item ?? ""}}</td>
                    <td><?php if($itemMenu->permissoes) {echo $itemMenu->permissoes->Controller . "/" . $itemMenu->permissoes->Action;} ?></td>
                    <td class="float-end">
                        <button type="button" class="btn btn-outline-warning" onclick="redirecionar('<?= url('/itemMenu/edit/'.$itemMenu->id) ?>')">Editar</button>
                        <button type="button" class="btn btn-outline-danger" onclick="apagar(<?= $itemMenu->id ?>)">Apagar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        {{ $itemMenus->onEachSide(1)->links() }}

        </form>
    </div> 

@endsection

@section('script')
    <script>
        var apagarURL = "<?= url("/itemMenu/delete"); ?>";
        function apagar(id) {
            var apagar = confirm("Deseja apagar o Item Menu?");
            if(apagar)
                window.location.replace(apagarURL + "/" + id);
        }

    </script>
@endsection