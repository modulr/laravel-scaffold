@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-3">
        <div class="col-12 text-center px-5">
            <img src="/img/stores/tienda.svg" class="img-fluid w-75" alt="Traeme Tienda">
        </div>
        <stores-stores></stores-stores>
    </div>
</div>
@endsection
