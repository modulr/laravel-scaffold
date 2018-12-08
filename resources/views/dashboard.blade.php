@extends('layouts.app')

@section('content')
<div>
    <div class="container">
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="row justify-content-md-center">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="fa fa-file bg-primary p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-primary">Cotizaciones</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="far fa-file bg-info p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-info">Cotizaciones Empresa</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="fa fa-calendar bg-warning p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-warning">Calendario</div>
                            </div>
                        </div>
                    </div>
                </div>
                @can('read-users')
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="fa fa-users bg-success p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-success">Usuarios</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
