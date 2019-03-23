@extends('layouts.home')

@section('home')
    <div class="col-sm-12 text-center">
        <a href="https://api.whatsapp.com/send?phone=528130898642&text=Me%20puedes%20traer%20&source=&data=" class="btn-white btn-phone">
            <img class="img-fluid logo" src="/img/traeme_b.png" alt="">
        </a>
        <!-- <a class="btn btn-lg btn-light" href="https://m.me/sisiapp">
            <i class="fab fa-lg fa-facebook-messenger"></i> Messenger
        </a> -->
        <p class="lead mt-4 mb-4">Mandados a domicilio</p>
    </div>

    <div class="col-sm-6 text-center">
        <p class="mb-0">¿Que te llevamos?</p>
        <p><small>La tarifa del dia de hoy es <b>$15.00</b> pesos por vuelta</small></p>
        <div class="form-group">
            <textarea class="form-control" rows="3" placeholder="¡Traeme unos tacos!, a la Calle #numero, colonia en Parral"></textarea>
        </div>
        <a class="btn btn-lg btn-light mb-4" href="https://api.whatsapp.com/send?phone=528130898642&text=Me%20puedes%20traer%20&source=&data=">
            <i class="fab fa-whatsapp"></i> Ordenar
        </a>
    </div>

    <div class="col-sm-12 bg-white curve-content">
        <svg version="1.1" id="curve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1400 281.582" enable-background="new 0 0 1400 281.582" xml:space="preserve">
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
    <div class="col-sm-12 bg-white text-center">
        <ul class="list-unstyled mb-5">
            <li class="mb-2 lead">¿Necesitas algo de la tienda?</li>
            <li class="mb-2 lead">¿Se te olvido pagar la lúz?</li>
            <li class="mb-2 lead">¿Se te antojaron unos tacos?</li>
            <li class="mb-2 lead">¿Necesitas enviar un paquete?</li>
        </ul>
        <p><small>Pidelo por teléfono</small></p>
        <a class="btn-phone" href="tel:813-089-8642">
            <h5>
                <!-- <i class="fas fa-phone"></i> -->
                <small class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                </small>
                813 089 8642
            </h5>
        </a>
    </div>
    <div class="col-sm-12 text-center bg-white">
        <div class="col-sm-12">
            <h5 class="mt-5">Ultimos Pedidos</h5>
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
            </ul>
        </div>
        <a href="https://api.whatsapp.com/send?phone=528130898642&text=Me%20puedes%20traer%20&source=&data=" class="btn-white btn-phone">
            <img class="img-fluid logo" src="/svg/traeme.svg" alt="">
        </a>
        <p class="mt-5"><i>Ahorra tiempo y dinero</i></p>
        <a href="mailto:megusta@traeme.app">
            megusta@traeme.app
        </a>
        <p>
            <small class="mb-2">© 2019 Traeme, all rights reserved.</small>
        </p>
    </div>
@endsection
