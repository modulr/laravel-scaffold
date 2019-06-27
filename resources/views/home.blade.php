@extends('layouts.app')

@section('content')
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
            <!-- <p class="mb-0">Registrate y recibe tu primer mandado ¡<strong>Gratis</strong>!</p> -->
            <p class="mb-0">Tarifa del dia desde <rates-day></rates-day> pesos</p>
            <p><small>Horario: 8:00am a 10:00pm</small></p>
        </div>
        <div class="col-sm-12">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <!-- @auth
        @else
        <div class="col-8 text-center mb-5">
            <a class="btn btn-brand btn-facebook mb-2" href="/auth/facebook">
              <span>Registrate con Facebook</span>
            </a>
            <div>
                <a class="btn btn-info mb-2" href="/register">
                  <span>Registrate con tu correo</span>
                </a>
            </div>
            <div>
                <a class="btn btn-outline-secondary" href="/login">
                  Ya tengo una cuenta
                </a>
            </div>
            <p class="small mt-4 mb-5">Revisa el historial de tus mandados y guarda tus direcciones.</p>
        </div>
        <div class="col-12 text-center">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 281.582" enable-background="new 0 0 1400 281.582" xml:space="preserve">
                <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="17.0752" y1="25.6475" x2="1428.4752" y2="292.9289">
                    <stop  offset="0" style="stop-color:#EF374B"/>
                    <stop  offset="0.3814" style="stop-color:#EC374C"/>
                    <stop  offset="0.5188" style="stop-color:#E6364E"/>
                    <stop  offset="0.6168" style="stop-color:#DD3552"/>
                    <stop  offset="0.696" style="stop-color:#D03457"/>
                    <stop  offset="0.7638" style="stop-color:#BF335C"/>
                    <stop  offset="0.8239" style="stop-color:#AC3163"/>
                    <stop  offset="0.8783" style="stop-color:#952F6B"/>
                    <stop  offset="0.9283" style="stop-color:#7C2E74"/>
                    <stop  offset="0.9727" style="stop-color:#5E2D7D"/>
                    <stop  offset="1" style="stop-color:#472C83"/>
                </linearGradient>
                <path fill="url(#SVGID_1_)" d="M1400.07,28.394c-257.404,122.357-706.822-104.342-1400,0v253.188
                c659.208-251.47,1308.758-125.986,1400-18.135V28.394z"/>
            </svg>
        </div>
        @endauth -->
        <div class="col-12 pb-3 text-center px-5">
            <img src="/img/stores/tienda.svg" class="img-fluid w-75" alt="Traeme Tienda">
        </div>

        <div class="col-12 col-md-4 px-5 pt-1 text-center">
            <a href="#pollo-feliz-menu" data-toggle="modal" data-target="#pollo-feliz-menu">
                <img src="/img/stores/banner_pollo_feliz.png" class="img-fluid" alt="Pollo Feliz">
            </a>
        </div>
        <div class="modal fade" id="pollo-feliz-menu" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close text-body mr-3 mt-3" data-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="carouselPolloFeliz" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/img/stores/menu/pollo_feliz/pollo_feliz_1.jpg" class="d-block w-100" alt="Pollo Feliz menu 1">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/stores/menu/pollo_feliz/pollo_feliz_2.jpg" class="d-block w-100" alt="Pollo Feliz menu 2">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/stores/menu/pollo_feliz/pollo_feliz_3.jpg" class="d-block w-100" alt="Pollo Feliz menu 3">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/stores/menu/pollo_feliz/pollo_feliz_4.jpg" class="d-block w-100" alt="Pollo Feliz menu 4">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/stores/menu/pollo_feliz/pollo_feliz_5.jpg" class="d-block w-100" alt="Pollo Feliz menu 5">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselPolloFeliz" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselPolloFeliz" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!-- <img src="/img/stores/menu/pollo_feliz/pollo_feliz_1.jpg" class="img-fluid" alt="Pollo Feliz menu 1">
                    <img src="/img/stores/menu/pollo_feliz/pollo_feliz_2.jpg" class="img-fluid" alt="Pollo Feliz menu 2"> -->
                </div>
            </div>
          </div>
        </div>
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
        <div class="col-12 col-md-4 px-5 pt-3 text-center">
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
                    <div id="carouselElForastero" class="carousel slide" data-ride="carousel">
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
        </div>
        <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/banner_anita.png" class="img-fluid" alt="La Cocina de Anita">
        </div>
        <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/banner_blvd_chino.png" class="img-fluid" alt="Blvd Chino">
        </div>
        <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/banner_dogos_co_2.png" class="img-fluid" alt="Dogos & Co">
        </div>
        <!-- <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/sakura.png" class="img-fluid" alt="Sakura">
        </div>
        <div class="col-12 col-md-4 px-5 pt-2 text-center">
            <img src="/img/stores/banner_paraiso_pay.png" class="img-fluid" alt="Paraiso del Pay">
        </div> -->
        <!-- <div class="col-12 col-md-4 px-5 pt-3 text-center">
            <img src="/img/stores/banner_wings.png" class="img-fluid" alt="Wings Co">
        </div>
        <div class="col-12 col-md-4 px-5 text-center">
            <img src="/img/stores/banner_vape.png" class="img-fluid" alt="Vape City">
        </div>
        <div class="col-12 col-md-4 px-5 pt-2 text-center">
            <img src="/img/stores/banner_express.png" class="img-fluid" alt="Bolas de Arroz Express">
        </div> -->
    </div>

    <stores-level1></stores-level1>

    <div class="row justify-content-center bg-gradient mt-5">
        <div class="col text-center">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M1400,94.676V0.009L0,0v107.141C760.281-138.29,1171.969,190.938,1400,94.676z"/>
            </svg>
            <div class="px-5">
                <img src="/svg/pasos.svg" class="img-fluid" alt="pasos">
            </div>
            <!-- <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M1400,94.676V0.009L0,0v107.141C760.281-138.29,1171.969,190.938,1400,94.676z"/>
            </svg> -->
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
            <!-- <h5 class="mt-5">Ultimos Pedidos</h5>
            <ul class="list-unstyled">
                <li>Pagar el Gas</li>
                <li>Pagar el Cable</li>
                <li>Despensa</li>
                <li>Medicamento</li>
            </ul>
            <h5>Lo más Pedido</h5>
            <ul class="list-unstyled">
                <li>Pagar Servicios</li>
                <li>Super</li>
                <li>Farmacia</li>
            </ul>
            <h5>Categorias</h5>
            <ul class="list-unstyled">
                <li>Mandados</li>
                <li>Super</li>
                <li>Tiendita</li>
                <li>Farmacia</li>
                <li>Restaurant</li>
            </ul> -->

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
            <!-- <a href="mailto:megusta@traeme.app">megusta@traeme.app</a> -->
            <p class="mb-0"><small>© 2019 Traeme, Todos los derechos reservados.</small></p>
            <p class="mb-5"><small>Creado por <a href="https://modulr.io" target="_blank">Modulr</a></small></p>
        </div>
    </div>
@endsection
