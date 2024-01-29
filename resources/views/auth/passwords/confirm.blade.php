@extends('layouts.auth.app')

@section('title',__('Confirm Password')." | ".env("APP_NAME"))
@section('content')
    <div class="row">
        <div class="col-xl-7">
            <img class="bg-img-cover bg-center" src="{{asset('assets/images/login/bdc-rak.jpg')}}" alt="looginpage">
        </div>
        <div class="col-xl-5" style="margin-left: -0.8rem;">
            <div class="login-card">
                <form class="theme-form login-form" method="post" action="{{ route('password.email') }}">
                    @csrf
                    <img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt="Logo">
                    <h4 class="text-center mt-4 mb-4">{{ __('Confirm Password') }}</h4>
                    <h6 class="text-center">{{ __('Please confirm your password before continuing.') }}</h6>

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <button class="btn btn-primary w-100 btn-air-primary mt-4" type="submit">{{ __('Send Password Reset Link') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
