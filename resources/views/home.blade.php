@extends('layouts.app')

@section('content')
    <div class="row justify-content-center bg-gradient">
        <div class="col-sm-12 text-center">
            <img class="img-fluid logo mt-5" src="/img/traeme.png" alt="">
            <!-- <a class="btn btn-lg btn-light" href="https://m.me/sisiapp">
                <i class="fab fa-lg fa-facebook-messenger"></i> Messenger
            </a> -->
            <p class="lead mt-4 mb-0">Mandados a domicilio</p>
            <p><small>Tarifa del dia <b>$15.00</b> pesos</small></p>
        </div>

        <div class="col-9 col-sm-6 col-md-4 text-center mb-5">
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
                <p>ó</p>
                <a class="btn btn-brand btn-facebook" href="/auth/facebook">
                  <i class="fab fa-facebook-f"></i>
                  <span>Registrate con Facebook</span>
                </a>
                <p class="mb-4">y recibe tu primer mandado ¡<strong>Gratis</strong>!</p>
                <a class="btn btn-light" href="/register">
                  <span>Registrate</span>
                </a>
                <a class="btn btn-link btn-phone btn-block" href="/login">
                  Ya tengo una cuenta
                </a>
            @endauth
        </div>

        <div class="col-sm-12">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 1400 253.176" enable-background="new 0 0 1400 253.176" xml:space="preserve">
            <path fill="#FFFFFF" d="M0,21.479v231.688l1400,0.01V6.756C639.719,296.66,228.03-92.227,0,21.479z"/>
        </svg>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 text-center">
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
