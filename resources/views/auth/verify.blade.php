@extends('layouts.auth.app')
@section('title',"Reset Password | ".env("APP_NAME"))
@section('content')
    <div class="row">
        <div class="col-xl-7">
            <img class="bg-img-cover bg-center" src="{{asset('assets/images/login/bdc-rak.jpg')}}" alt="looginpage">
        </div>
        <div class="col-xl-5" style="margin-left: -0.8rem;">
            <div class="login-card">
                <form class="theme-form login-form" method="post" action="{{ route('verification.resend') }}">
                    @csrf
                    <img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt="Logo">
                    <h4 class="text-center mt-4 mb-4">{{ __('Verify Your Email Address') }}</h4>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <h6>
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                    </h6>
                    <div class="form-group">
                        <div class="form-group">
                            <button class="btn btn-primary w-100 btn-air-primary mt-4" type="submit">{{ __('click here to request another') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

