@extends('layouts.auth')

@section('auth')
<div class="col-md-8">
    <div class="card-group">
        <div class="card">
            <div class="card-body p-5">
                <div class="text-center d-lg-none">
                    <img src="svg/modulr.svg" class="mb-5" width="150" alt="Modulr Logo">
                </div>
                <h1>{{ __('Login') }}</h1>
                <p class="text-muted">Sign In to your account</p>

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
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary px4">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <!-- <div class="col-8 text-right">
                            <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div> -->
                    </div>
                </form>
            </div>
            <!-- <div class="card-footer p-4 d-lg-none">
                <div class="col-12 text-right">
                    <a class="btn btn-outline-primary btn-block mt-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
            </div> -->
        </div>
        <!-- <div class="card text-white bg-primary py-5 d-md-down-none">
            <div class="card-body text-center">
                <div>
                    <img src="svg/modulr.svg" class="mb-5" width="150" alt="Modulr Logo">
                    <h2>{{ __('Sign up') }}</h2>
                    <p>If you don't have account create one.</p>
                    <a class="btn btn-primary active mt-2" href="{{ route('register') }}">{{ __('Register Now!') }}</a>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
