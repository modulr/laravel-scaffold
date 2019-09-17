@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center bg-gradient">
        <div class="col-sm-12 text-center">
            <img class="img-fluid logo mt-5 mb-3" src="/img/traeme.png" alt="">
        </div>
        <div class="col-9 col-sm-6 col-md-4 text-center">
            <p>¿Que te llevamos?</p>
            @auth
            <orders-create-auth class="mb-4"></orders-create-auth>
            @else
            <orders-create class="mb-3"></orders-create>
            @endauth
            <p class="mb-0">Tarifa del dia desde <rates-day></rates-day> pesos</p>
            <p><small>Horario: 8:00am a 10:00pm</small></p>
        </div>
        <div class="col-12 px-0">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-12 pb-3 text-center px-5">
            <img src="/img/stores/tienda.svg" class="img-fluid w-75" alt="Traeme Tienda">
        </div>
        <stores-pollo-feliz></stores-pollo-feliz>
        <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <a href="#texas-menu" data-toggle="modal" data-target="#texas-menu">
                <img src="/img/stores/banner_texas_pizza.png" class="img-fluid" alt="Texas Pizza">
            </a>
            <!-- <a href="#texas-menu" class="btn btn-pill btn-primary btn-sm btn-menu" data-toggle="modal" data-target="#texas-menu">
                menu
            </a> -->
        </div>
        <div class="modal fade" id="texas-menu" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close text-body mr-3 mt-3" data-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/img/stores/menu/texas_pizza/1.jpeg" class="img-fluid" alt="Texas Pizza Menu">
                    <img src="/img/stores/menu/texas_pizza/2.jpeg" class="img-fluid" alt="Texas Pizza Menu">
                </div>
            </div>
          </div>
        </div>
        <!-- <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <a href="#el-forastero-menu" data-toggle="modal" data-target="#el-forastero-menu">
                <img src="/img/stores/banner_el_forastero.png" class="img-fluid" alt="El Forastero">
            </a>
        </div>
        <div class="modal fade" id="el-forastero-menu" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close text-body mr-3 mt-3" data-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="carouselElForastero" class="carousel slide" data-ride="carousel" data-touch="true" data-keyboard="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/img/stores/menu/el_forastero/el_forastero_1.jpg" class="d-block w-100" alt="El Forastero menu 1">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/stores/menu/el_forastero/el_forastero_2.jpg" class="d-block w-100" alt="El Forastero menu 2">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/stores/menu/el_forastero/el_forastero_3.jpg" class="d-block w-100" alt="El Forastero menu 3">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselElForastero" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselElForastero" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
          </div>
        </div> -->
        <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <a href="#blvd-chino-menu" data-toggle="modal" data-target="#blvd-chino-menu">
                <img src="/img/stores/banner_blvd_chino.png" class="img-fluid" alt="Blvd Chino">
            </a>
        </div>
        <div class="modal fade" id="blvd-chino-menu" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close text-body mr-3 mt-3" data-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/img/stores/menu/blvd_chino/blvd_chino_promocion_jueves.jpeg" class="img-fluid" alt="Blvd Chino Promocion">
                </div>
            </div>
          </div>
        </div>
        <!-- <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/banner_dogos_co_2.png" class="img-fluid" alt="Dogos & Co">
        </div> -->
        <!-- <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/sabor_de_casa.png" class="img-fluid" alt="La Cocina de Anita">
        </div> -->
    </div>

    <stores-level1></stores-level1>

    <div class="row justify-content-center bg-gradient mt-5">
        <div class="col text-center px-0">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M1400,94.676V0.009L0,0v107.141C760.281-138.29,1171.969,190.938,1400,94.676z"/>
            </svg>
            <div class="px-5">
                <img src="/svg/pasos.svg" class="img-fluid" alt="Pasos para pedir">
            </div>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 230.219" enable-background="new 0 0 1400 230.219" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,16.607v207.391c315.782-256.167,1050.855,52.862,1400,0.007V5.225
                C639.719,229.38,228.031-71.309,0,16.607z"/>
            </svg>
            <div class="px-5">
                <img src="/svg/tarifa.svg" class="img-fluid" alt="Tarifa Dinámica">
            </div>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 230.219" enable-background="new 0 0 1400 230.219" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,16.607v207.391c315.782-256.167,1050.855,52.862,1400,0.007V5.225
                C639.719,229.38,228.031-71.309,0,16.607z"/>
            </svg>
            <div class="px-5 py-5">
                <img src="/svg/repartidor.svg" class="img-fluid" alt="Repartidor">
            </div>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 text-center pt-5">
            <img class="img-fluid logo" src="/svg/traeme.svg" alt="">
            <p class="lead mt-5 mb-1">Mandados a domicilio</p>
            <p class="mb-5"><i>Ahorra tiempo y dinero</i></p>
            <div class="mt-5 mb-4">
                <a class="btn btn-link btn-lg btn-phone" href="tel:627-110-1145">
                    <small class="fa-stack mr-1">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                    </small>
                    (627) 110 1145
                </a>
            </div>
            <div class="text-center mb-2">
                <a href="https://www.facebook.com/traeme.parral" target="_blank" class="text-success mr-3"><i class="fab fa-facebook-square fa-2x"></i></a>
                <a href="https://www.instagram.com/traeme_parral" target="_blank" class="text-success"><i class="fab fa-instagram fa-2x"></i></a>
            </div>
            <p class="mb-0"><small>© 2019 Traeme, Todos los derechos reservados.</small></p>
            <p class="mb-5"><small>Creado por <a href="https://modulr.io" target="_blank">Modulr</a></small></p>
        </div>
    </div>
</div>
@endsection
