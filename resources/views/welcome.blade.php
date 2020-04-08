<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="57x57" href="/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
    <body>
        <div class="container">
            <div class="row justify-content-around pb-3">
                <div class="col-12">
                    <img src="/img/medeex-blanco.png" alt="Medeex" class="logo mt-4">
                </div>
                <div class="col-12 text-center">
                    <h2 class="title mt-3 mb-5">TEST DE DIAGNÓSTICO</h2>
                </div>
                <div class="col-md-7">
                    <div class="row justify-content-center">
                        <div class="col-12 back-video text-center py-3">
                            <video autoplay controls class="mt-2">
                                <source src="/videos/test_real_inicio.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="col-11">
                            <img src="/img/video-footer.png" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="/img/register-text.png" class="img-fluid">
                    <!-- <p>A continuación en este <br> Test de Diagnóstico vas a encontrar más de 80 reactivos con el objetivo de identificar con claridad cuales son los problemas críticos los cuales impiden que crezcas dentro de tu empresa.</p>
                    <p>Para iniciar con el test es necesariocrear una cuenta.</p>
                    <p><strong>"REGISTRATE PARA INICIAR"</strong></p> -->
                    <div class="text-center mb-5">
                    @if (Route::has('login'))
                        @auth
                            <a href="/test" class="btn btn-primary rounded-0 btn-cut title px-4 py-2">Iniciar Diagnostico</a>
                        @else
                            <!-- <a href="{{ route('login') }}">Entrar</a> -->
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-0 btn-cut title px-4 py-2">REGISTRARTÉ</a>
                        @endauth
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
