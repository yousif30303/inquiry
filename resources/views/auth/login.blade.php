@extends('layouts.auth.app')
@section('title',"Login | ".env("APP_NAME"))
@section('content')
    <div class="row">
        <div class="col-xl-7">
            <img class="bg-img-cover bg-center" src="{{asset('assets/images/login/banner.jpg')}}" alt="looginpage">
        </div>
        <div class="col-xl-5" style="margin-left: -0.8rem;">
            <div class="login-card">
                <form class="theme-form login-form" method="post" action="{{route('login')}}">
                    @csrf
                    <img class="img-fluid" id="logo" src="{{asset('assets/images/logo/logo.png')}}" alt="Logo">
                    <img class="img-fluid" style="display: none" id="dark-logo" src="{{asset('assets/images/logo/logo-white.png')}}" alt="Logo">
                    <h4 class="text-center mt-4">{{config('app.name')}}</h4>
                    <h6 class="text-center">Welcome back! Log in to your account.</h6>
                    @error('email')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$message}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @enderror
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                            <input class="form-control" type="email" name="email" value="{{old('email')}}"
                                   required="required" placeholder="Test@gmail.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                            <input class="form-control" type="password" name="password" required="required"
                                   placeholder="*********">
                            <div class="show-hide"><span class="show">                         </span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <input id="checkbox1" type="checkbox">
                            <label for="checkbox1">Remember password</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w-100 btn-air-primary btn-lg mt-4" type="submit">Sign in
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        if(localStorage.getItem("body") === "dark-only"){
            $('#dark-logo').show();
            $('#logo').hide();
        }
    </script>

@endpush
