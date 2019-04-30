@extends('layouts.app')

@section('content')
    <div class="row justify-content-center bg-gradient">
        <div class="col-sm-12 text-center">
            <img class="img-fluid logo mt-5" src="/img/traeme.png" alt="">
            <p class="lead mt-4 mb-2">Mandados a domicilio</p>
        </div>
        <div class="col-9 col-sm-6 col-md-4 text-center">
            <p>¿Que te llevamos?</p>
            @auth
            <orders-create-auth class="mb-4"></orders-create-auth>
            @else
            <orders-create class="mb-4"></orders-create>
            <p class="mt-0 mb-0"><small>ó por teléfono</small></p>
            <a class="btn btn-link btn-lg btn-phone mb-4" href="tel:627-110-1145">
                <small class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                </small>
                627 110 1145
            </a>
            @endauth
            <p class="mb-0">Registrate y recibe tu primer mandado ¡<strong>Gratis</strong>!</p>
            <p class="mb-0"><small>Tarifa del dia desde <rates-day></rates-day> pesos</small></p>
            <p><small>Horario: 8:00am a 9:00pm</small></p>
        </div>
        <div class="col-sm-12">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center mt-5 mb-5">
        @auth
        @else
        <div class="col-8 text-center">
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
        @endauth
        <div class="col-12 pb-3 text-center px-5">
            <img src="/img/stores/tienda.svg" class="img-fluid w-75" alt="Traeme Tienda">
        </div>
        <div class="col-12 col-md-3 px-5 pt-3 text-center">
            <img src="/img/stores/wings_co.png" class="img-fluid" alt="Wings Co">
        </div>
        <div class="col-12 col-md-3 px-5 text-center">
            <img src="/img/stores/banner_vape.png" class="img-fluid" alt="Vape City">
        </div>
        <div class="col-12 col-md-3 px-5 pt-2 text-center">
            <img src="/img/stores/banner_paraiso_pay.png" class="img-fluid" alt="Paraiso del Pay">
        </div>
        <div class="col-12 col-md-3 px-5 pt-2 text-center">
            <img src="/img/stores/banner_express.png" class="img-fluid" alt="Bolas de Arroz Express">
        </div>
    </div>

    <div class="row justify-content-center bg-gradient">
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
            <p class="mt-5 mb-5"><i>Ahorra tiempo y dinero</i></p>
            <div class="text-center">
                <a href="https://www.facebook.com/traeme.parral" target="_blank" class="text-success mr-3"><i class="fab fa-facebook-square fa-2x"></i></a>
                <a href="https://www.instagram.com/traeme_parral" target="_blank" class="text-success"><i class="fab fa-instagram fa-2x"></i></a>
            </div>
            <!-- <a href="mailto:megusta@traeme.app">megusta@traeme.app</a> -->
            <p class="mb-0"><small>© 2019 Traeme, Todos los derechos reservados.</small></p>
            <p class="mb-5"><small>Creado por <a href="https://modulr.io" target="_blank">Modulr</a></small></p>
        </div>
    </div>
@endsection
