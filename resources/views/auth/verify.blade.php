@extends('layouts.auth')

@section('auth')
<div class="col-md-6">
    <div class="card mx-4">
        <div class="card-body p-4">
            <h1>{{ __('Verify Your Email Address') }}</h1>
            <p class="text-muted">{{ __('Before proceeding, please check your email for a verification link.') }}</p>

            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.

            @if (session('resent'))
                <div class="alert alert-success mt-4" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
