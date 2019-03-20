@extends('layouts.auth')

@section('auth')
    <div class="col-sm-12 text-center">
        <a href="tel:813-089-8642" class="btn-white btn-phone">
            <img class="img-fluid logo" src="/img/traeme_b.png" alt="">
        </a>
        <br><br>
        <p class="lead">Mandados a domicilio</p>
        <br><br>
    </div>

    <div class="col-sm-12 text-center">
        <a class="btn-white btn-phone" href="tel:813-089-8642">
            <p>Llámanos</p>
            <h3>
                <!-- <i class="fas fa-phone"></i> -->
                <small class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                </small>
                813 089 8642
            </h3>
        </a>
    </div>

    <div class="col-sm-12 text-center">
        <p>o haz tu pedido por</p>
        <a class="btn btn-lg btn-light" href="https://api.whatsapp.com/send?phone=528130898642&text=Me%20puedes%20traer%20&source=&data=">
            <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <!-- <a class="btn btn-lg btn-light" href="https://m.me/sisiapp">
            <i class="fab fa-lg fa-facebook-messenger"></i> Messenger
        </a> -->
        <br><br><br>
        <p class="lead"><i>Ahorra tiempo y dinero</i></p>
    </div>

    <!-- <div class="col-sm-12">
        <h5>Ultimos Pedidos</h5>
        <ul>
            <li>Pagar el Gas</li>
            <li>Pagar el Cable</li>
            <li>Despensa</li>
            <li>Medicamento</li>
        </ul>
        <h5>Lo más Pedido</h5>
        <ul>
            <li>Pagar Servicios</li>
            <li>Super</li>
            <li>Farmacia</li>
        </ul>
        <h5>Categorias</h5>
        <ul>
            <li>Mandados</li>
            <li>Super</li>
            <li>Tiendita</li>
            <li>Farmacia</li>
            <li>Restaurant</li>
        </ul>
    </div> -->

    <div class="col-sm-12 text-center">
        <p>
            <!-- <a class="btn-white d-inline d-sm-none" href="fb://page/296760280983048">
                Síguenos en
                <i class="fab fa-lg fa-facebook-square"></i>
                Facebook
            </a>
            <a class="btn-white d-none d-sm-inline" href="https://www.facebook.com/traeme" target="_blank">
                Síguenos en
                <i class="fab fa-lg fa-facebook-square"></i>
                Facebook
            </a>
            <br> -->
            <small class="hover-color">© 2019 Traeme, all rights reserved.</small>
        </p>
    </div>

    <!-- <div class="col-sm-12 text-center">
        <p>
            <a class="btn-white" href="mailto:megusta@sisiapp.mx">
                megusta@sisiapp.mx
            </a>
        </p>
    </div> -->
@endsection
