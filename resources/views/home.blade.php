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
            <a class="btn btn-link btn-lg btn-phone mb-4" href="tel:813-089-8642">
                <small class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                </small>
                813 089 8642
            </a>
            @endauth
            <p class="mb-0"><small>Tarifa del dia desde <rates-day></rates-day> pesos</small></p>
            <p><small>Horario: 9:00am a 9:00pm</small></p>
            <p class="mb-0"><small>Parral Chih.</small></p>
        </div>
        <div class="col-sm-12">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 1400 253.176" enable-background="new 0 0 1400 253.176" xml:space="preserve">
            <path fill="#FFFFFF" d="M0,21.479v231.688l1400,0.01V6.756C639.719,296.66,228.03-92.227,0,21.479z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col text-center">
            @auth
            @else
            <p class="mb-4">Recibe tu primer mandado ¡<strong>Gratis</strong>!</p>
            <a class="btn btn-brand btn-facebook mb-2" href="/auth/facebook">
              <span>Registrate con Facebook</span>
            </a>
            <div>
                <a class="btn btn-info mb-2" href="/register">
                  <span>Registrate con tu correo</span>
                </a>
            </div>
            <div class="mb-5">
                <a class="btn btn-outline-secondary" href="/login">
                  Ya tengo una cuenta
                </a>
            </div>
            @endauth
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <img src="/img/pasos.png" class="img-fluid" alt="pasos">
            <img src="/img/repartidor_bici.png" class="img-fluid" alt="Repartidor">
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
            <!-- <img class="img-fluid logo mt-5 mb-5" src="/svg/traeme.svg" alt=""> -->
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
