@extends('layouts.default')
@section('title', 'Dashboard')

<style>
    body{
        background:url("{{asset("img/logo_di.png")}}");
        background-color: black!important;
        background-repeat: no-repeat;
        background-position: center 48px;
        background-size:contain;
        background-repeat:no-repeat;
    }
</style>

@section('content')
    <h1 style="color:white;outline:1px;text-shadow:-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;"> Bem vindo ao Dashboard DI/PUC-Rio </h1>
@endsection

@section('script')

@endsection