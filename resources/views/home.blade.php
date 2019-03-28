@extends('layouts.app')

@section('content')
    <div class="row justify-content-center bg-gradient">
        <div class="col-sm-12 text-center">
            <img class="img-fluid logo mt-5" src="/img/traeme_b.png" alt="">
            <!-- <a class="btn btn-lg btn-light" href="https://m.me/sisiapp">
                <i class="fab fa-lg fa-facebook-messenger"></i> Messenger
            </a> -->
            <p class="lead mt-4 mb-0">Mandados a domicilio</p>
            <p><small>Tarifa del dia <b>$15.00</b> pesos</small></p>
        </div>

        <div class="col-9 col-sm-6 text-center mb-5">
            <p>¿Que te llevamos?</p>
            @auth
                <orders-create-auth class="mb-4"></orders-create-auth>
            @else
                <orders-create class="mb-4"></orders-create>
                <p class="mb-0"><small>Pidelo por teléfono</small></p>
                <a class="btn btn-link btn-lg btn-phone" href="tel:811-897-7886">
                    <small class="fa-stack">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                    </small>
                    813 089 8642
                </a>
                <a class="btn btn-brand btn-facebook mt-3" href="/auth/facebook">
                  <i class="fab fa-facebook-f"></i>
                  <span>Registrate con Facebook</span>
                </a>
                <p class="mb-4">y recibe tu primer mandado ¡<strong>Gratis</strong>!</p>
                <a class="btn btn-primary btn-block" href="/register">
                  <span>Registrate</span>
                </a>
                <a class="btn btn-link btn-phone btn-block" href="/login">
                  Ya tengo una cuenta
                </a>
            @endauth
        </div>

        <div class="col-sm-12">
            <svg version="1.1" class="curve curve_white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1400 166.917" enable-background="new 0 0 1400 166.917" xml:space="preserve">
                <path fill="#FFFFFF" d="M0.07,21.479v108.105c693.173-104.33,1142.589,122.361,1400,0.01V6.756 C639.79,296.66,228.101-92.226,0.07,21.479z"/>
            </svg>
            <svg version="1.1" class="curve curve_gradient" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1400 281.582" enable-background="new 0 0 1400 281.582" xml:space="preserve">
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
                <path fill="url(#SVGID_1_)" d="M1400.07,28.394c-257.404,122.357-706.822-104.342-1400,0v253.188 c659.208-251.47,1308.758-125.986,1400-18.135V28.394z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 text-center mt-5">
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
            <img class="img-fluid logo mt-5 mb-5" src="/svg/traeme.svg" alt="">
            <p class="mt-5"><i>Ahorra tiempo y dinero</i></p>
            <a href="mailto:megusta@traeme.app">
                megusta@traeme.app
            </a>
            <p>
                <small class="mb-2">© 2019 Traeme, all rights reserved.</small>
            </p>
        </div>
    </div>
@endsection
