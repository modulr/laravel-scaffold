@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center bg-gradient">
        <div class="col-sm-12 text-center">
            <img class="img-fluid logo mt-5 mb-3" src="/img/traeme.png" alt="Tráeme">
            <p class="lead mt-2 mb-1">Mandados a domicilio</p>
        </div>
        <div class="col-9 col-sm-6 col-md-4 mb-4">
            <!-- <p>¿Que te llevamos?</p> -->
            @auth
            <orders-create-auth></orders-create-auth>
            @else
            <orders-create></orders-create>
            @endauth
        </div>
        <div class="col-12 px-0">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-10 pb-3 text-center">
            <h1 class="font-weight-bold mt-3 mb-4">Lo que quieras cuando quieras</h1>
        </div>
        <stores-sales></stores-sales>
        <stores-level1 class="mb-2"></stores-level1>
        <stores-categories></stores-categories>
        <!-- <stores-random></stores-random> -->
        <h4 class="mt-5"><a href="/tiendas">Ver más <i class="ml-2 fas fa-chevron-right"></i></a></h4>
    </div>

    <div class="row justify-content-center bg-gradient mt-5">
        <div class="col text-center px-0">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M1400,94.676V0.009L0,0v107.141C760.281-138.29,1171.969,190.938,1400,94.676z"/>
            </svg>
            <div class="row justify-content-center px-5">
              <div class="col-lg-6 col-md-12">
                <img src="/svg/pasos.svg" class="img-fluid" alt="Pasos para pedir">
              </div>
            </div>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 230.219" enable-background="new 0 0 1400 230.219" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,16.607v207.391c315.782-256.167,1050.855,52.862,1400,0.007V5.225
                C639.719,229.38,228.031-71.309,0,16.607z"/>
            </svg>
            <div class="row justify-content-center px-5">
              <div class="col-lg-6 col-md-12">
                <img src="/svg/tarifa.svg" class="img-fluid" alt="Tarifa Dinámica">
              </div>
            </div>
            <!-- <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 230.219" enable-background="new 0 0 1400 230.219" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,16.607v207.391c315.782-256.167,1050.855,52.862,1400,0.007V5.225
                C639.719,229.38,228.031-71.309,0,16.607z"/>
            </svg> -->
            <!-- <div class="row justify-content-center px-5">
              <div class="col-lg-4 col-md-12">
                <img src="/svg/repartidor.svg" class="img-fluid" alt="Repartidor">
              </div>
            </div> -->
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <config></config>
    <div class="row justify-content-center">
        <div class="col-12 text-center border-top">
            <p class="my-4">© 2020 Tráeme</p>
        </div>
    </div>
</div>
@endsection
