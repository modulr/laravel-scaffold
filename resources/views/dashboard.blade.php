@extends('layouts.app')

@section('content')
<div>
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="card-body">
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif

      You are logged in!
  </div>
</div>
@endsection
