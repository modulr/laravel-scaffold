<!doctype html>
<html lang="{{ app()->getLocale() }}">
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
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/icon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/icon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script>
          window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user()
          ]) !!};
        </script>

        <script>
        if ('serviceWorker' in navigator ) {
          window.addEventListener('load', function() {
            navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
              // Registration was successful
              console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
              // registration failed :(
              console.log('ServiceWorker registration failed: ', err);
            });
          });
        }
        </script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            body {
                background-color: #E42C54;
            }
            p, h1, a{
                color: #fff;
                font-weight: lighter;
            }
            a:hover {
                text-decoration: none;
                color: inherit;
            }
            .logo {
                max-width: 200px;
                margin-top: 100px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="img-fluid logo" src="/svg/traeme.svg" alt="">
                    <br><br><br>
                    <br><br><br>
                </div>

                <div class="col-sm-12 text-center">
                    <a href="tel:813-089-8642"><h1><i class="fas fa-phone"></i> 813 089 8642</h1></a>
                    <br>
                </div>

                <div class="col-sm-12 text-center">
                    <a href="https://api.whatsapp.com/send?phone=528130898642&text=Me%20puedes%20traer%20&source=&data="><h3><i class="fab fa-whatsapp wp-color"></i> WhatsApp</h3></a>
                    <br><br><br>
                </div>

                <div class="col-sm-12 text-center">
                    <p><a href="mailto:megusta@traeme.app">megusta@traeme.app</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
