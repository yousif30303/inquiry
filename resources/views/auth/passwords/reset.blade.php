@extends('layouts.auth.app')
@section('title',"Reset Password | ".env("APP_NAME"))

@section('content')
    <div class="row">
        <div class="col-xl-7">
            <img class="bg-img-cover bg-center" src="{{asset('assets/images/login/bdc-rak.jpg')}}" alt="looginpage">
        </div>
        <div class="col-xl-5" style="margin-left: -0.8rem;">
            <div class="login-card">
                <form class="theme-form login-form" method="post" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt="Logo">
                    <h4 class="text-center mt-4 mb-4">{{ __('Reset Password') }}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', request()->email) }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <button class="btn btn-primary w-100 btn-air-primary mt-4" type="submit">{{ __('Reset Password') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
