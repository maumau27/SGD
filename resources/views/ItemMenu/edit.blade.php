@extends('layouts.default')
@section('title', 'Dashboard')


@section('content')
<form method="POST">
@csrf

    <div class="container mt-5">
        <h1>Editar Item Menu - {{$itemMenu->Menu ?? "###" .' > '. $itemMenu->Item}}</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Menu" id="Menu" placeholder="Menu" value="{{$itemMenu->Menu}}">
            <label for="Menu">Menu</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Item" placeholder="Item" value="{{$itemMenu->Item}}" required>
            <label for="Item" class="form-label">Item</label>
        </div>

        <select class="form-control selectpicker mb-3" aria-label="Default select" name="idPermissoes" data-live-search="true">
            <?php foreach($Permissoes as $permissao): ?>
                <option data-tokens="{ $permissao->Nome }}" <?php if($itemMenu->permissoes && $permissao->id == $itemMenu->permissoes->id) echo 'selected'; ?> value="{{$permissao->id}}">{{ $permissao->Nome }}</option>
            <?php endforeach; ?>
        </select>

        <button type="button" class="btn btn-outline-lg btn-outline-danger" onclick="redirecionar('<?= url()->previous() ?>')">Voltar</button>
        <button type="submit" class="btn btn-outline-lg btn-outline-primary float-end">Salvar</button>
    </div> 

</form>

@endsection

@section('script')

@endsection