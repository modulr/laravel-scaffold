@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <profile-password></profile-password>
        </div>
    </div>
</div>
@endsection
