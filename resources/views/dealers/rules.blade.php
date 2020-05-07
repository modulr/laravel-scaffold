@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <div class="col-12 col-md-8">
            <h2 class="mb-4">Reglas</h2>
            {!! $data->rules !!}
        </div>
    </div>
</div>
@endsection
