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
        <stores-categories></stores-categories>
        <stores-sales></stores-sales>
        <stores-random></stores-random>
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
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 230.219" enable-background="new 0 0 1400 230.219" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,16.607v207.391c315.782-256.167,1050.855,52.862,1400,0.007V5.225
                C639.719,229.38,228.031-71.309,0,16.607z"/>
            </svg>
            <div class="row justify-content-center px-5">
              <div class="col-lg-4 col-md-12">
                <img src="/svg/repartidor.svg" class="img-fluid" alt="Repartidor">
              </div>
            </div>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1400 112.859" enable-background="new 0 0 1400 112.859" xml:space="preserve">
                <path fill="#FFFFFF" d="M0,18.184v94.667l1400,0.009V5.719C639.719,251.149,228.03-78.078,0,18.184z"/>
            </svg>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 text-center pt-5">
            <img class="img-fluid logo" src="/svg/traeme.svg" alt="">
            <p class="lead mt-5 mb-1">Mandados a domicilio</p>
            <p class="mb-5"><i>Ahorra tiempo y dinero</i></p>
            <div class="text-center mb-2">
                <!-- <a href="https://play.google.com/store/apps/details?id=com.traeme.traemeapp" target="_blank">
                  <img src="/img/google-play-badge.png" class="img-fluid" alt="...">
                </a> -->
                <a target="_blank" href='https://play.google.com/store/apps/details?id=com.traeme.traemeapp&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                  <img alt='Disponible en Google Play' class="img-fluid logo" src='https://play.google.com/intl/en_us/badges/static/images/badges/es-419_badge_web_generic.png'/>
                </a>
            </div>
            <div class="text-center mb-2">
                <a href="https://www.facebook.com/traeme.parral" target="_blank" class="text-success mr-3">
                  <i class="fab fa-facebook-square fa-3x"></i>
                  <!-- <img src="/img/facebook.png" class="img-fluid" alt="Facebook"> -->
                </a>
                <a href="https://www.instagram.com/traeme_parral" target="_blank" class="text-success">
                  <i class="fab fa-instagram fa-3x"></i>
                  <!-- <img src="/img/instagram.png" class="img-fluid" alt="Instagram"> -->
                </a>
            </div>
            <div class="mt-5 mb-4">
                <a class="btn btn-link btn-lg btn-phone" href="tel:627-110-1145">
                    <small class="fa-stack mr-1">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                    </small>
                    (627) 110 1145
                </a>
            </div>
            <p class="mb-0"><small>© 2020 Tráeme, Todos los derechos reservados.</small></p>
            <p class="mb-5"><small>Creado por <a href="https://alfredobarron.com" target="_blank">Alfredo Barrón</a></small></p>
        </div>
    </div>
</div>
@endsection
