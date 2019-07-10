@extends('layouts.auth')

@section('auth')
<div class="col-md-8">
    <div class="card-group">
        <div class="card">
            <div class="card-body p-5">
                <div class="text-center d-lg-none">
                    <a href="/">
                    <img src="svg/traeme.svg" class="mb-5" width="150" alt="Traeme">
                    </a>
                </div>
                <h1>Iniciar sesión</h1>
                <p class="text-muted">Inicia sesion con tu cuenta</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}" required autofocus>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                Recordar mis datos
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                Entrar
                            </button>
                        </div>
                        <div class="col-12">
                          <a class="btn btn-brand btn-facebook btn-block" href="/auth/facebook">Entrar con Facebook</a>
                        </div>
                        <!-- <div class="col-12 text-right">
                            <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div> -->
                    </div>
                </form>
            </div>
            <div class="card-footer p-4 d-lg-none">
                <div class="col-12">
                    <a class="btn btn-outline-primary btn-block mt-3" href="{{ route('register') }}">Registrate con tu correo</a>
                    <a class="btn btn-brand btn-facebook btn-block" href="/auth/facebook">Registrate con Facebook</a>
                </div>
            </div>
        </div>
        <div class="card text-white bg-primary py-5 d-md-down-none">
            <div class="card-body text-center">
                <div>
                    <a href="/">
                        <img src="img/traeme.png" class="mb-5" width="150" alt="Traeme">
                    </a>
                    <h2>Registrate</h2>
                    <p>Si no tienes una cuenta crea una.</p>
                    <a class="btn btn-primary active mt-2" href="{{ route('register') }}">¡Registrate con tu correo!</a>
                    <p class="mt-2 mb-2">ó</p>
                    <a class="btn btn-brand btn-facebook" href="/auth/facebook">Registrate con Facebook</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
