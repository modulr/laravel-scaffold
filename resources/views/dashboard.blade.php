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
      <div class="row">
        <div class="col-md-6">
          <users-count></users-count>
        </div>
        <div class="col-md-6">
          <roles-count></roles-count>
        </div>
      </div>
  </div>
</div>
@endsection
