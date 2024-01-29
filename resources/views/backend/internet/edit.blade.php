@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{$breadcrumb->title}}</h5>
                    </div>
                    <hr class="mb-0 pb-0">
                    <form action="{{route('backend.internet.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="location">Location</label>
                                    <select name="location" required id="location" class="form-control select2" data-placeholder="Choose location" >
                                        <option value="">Choose location</option>
                                        @foreach($locations as $location)
                                            <option value="{{$location->id}}" @if(old('brand',$internet->location_id)==$location->id) selected @endif >{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="type">Type</label>
                                    <select name="type" required id="type" class="form-control select2" data-placeholder="Select Type" >
                                        <option value="">Select Type</option>
                                        <option value="Leased Line" @if(old('type',$internet->type)=='Leased Line') selected @endif >Leased Line</option>
                                        <option value="Normal Internet" @if(old('type',$internet->type)=='Normal Internet') selected @endif >Normal Internet</option>
                                        <option value="IPVPN" @if(old('type',$internet->type)=='IPVPN') selected @endif >IPVPN</option>
                                        <option value="MPLS" @if(old('type',$internet->type)=='MPLS') selected @endif >MPLS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="provider">Provider</label>
                                    <select name="provider" required id="provider" class="form-control select2" data-placeholder="Select Provider" >
                                        <option value="">Select Provider</option>
                                        <option value="Etisalat" @if(old('provider',$internet->provider)=='Etisalat') selected @endif >Etisalat</option>
                                        <option value="Du" @if(old('provider',$internet->provider)=='Du') selected @endif >Du</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="account">Account No.</label>
                                    <input type="text" required name="account" value="{{old('account',$internet->account)}}" id="account" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="username">Username</label>
                                    <input type="text" required name="username" value="{{old('username',$internet->username)}}" id="username" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="password">Password</label>
                                    <input type="text" required name="password" value="{{old('password',$internet->password)}}" id="password" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="speed">Speed</label>
                                    <select name="speed" id="speed" required class="form-control select2" data-placeholder="Select Speed" >
                                        <option value="">Select Speed</option>
                                        <option value="10 Mb/s" @if(old('speed',$internet->speed)=='10 Mb/s') selected @endif >10 Mb/s</option>
                                        <option value="20 Mb/s" @if(old('speed',$internet->speed)=='20 Mb/s') selected @endif >20 Mb/s</option>
                                        <option value="30 Mb/s" @if(old('speed',$internet->speed)=='30 Mb/s') selected @endif >30 Mb/s</option>
                                        <option value="40 Mb/s" @if(old('speed',$internet->speed)=='40 Mb/s') selected @endif >40 Mb/s</option>
                                        <option value="50 Mb/s" @if(old('speed',$internet->speed)=='50 Mb/s') selected @endif >50 Mb/s</option>
                                        <option value="60 Mb/s" @if(old('speed',$internet->speed)=='60 Mb/s') selected @endif >60 Mb/s</option>
                                        <option value="70 Mb/s" @if(old('speed',$internet->speed)=='70 Mb/s') selected @endif >70 Mb/s</option>
                                        <option value="80 Mb/s" @if(old('speed',$internet->speed)=='80 Mb/s') selected @endif >80 Mb/s</option>
                                        <option value="100 Mb/s" @if(old('speed',$internet->speed)=='100 Mb/s') selected @endif >100 Mb/s</option>
                                        <option value="250 Mb/s" @if(old('speed',$internet->speed)=='250 Mb/s') selected @endif >250 Mb/s</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="router">Router</label>
                                    <input type="text" name="router" required value="{{old('router',$internet->router)}}" id="router" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="monthly_rental">Monthly Rental</label>
                                    <input type="text" name="monthly_rental" required value="{{old('monthly_rental',$internet->monthly_rental)}}" id="monthly_rental" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="ip_address">IP Address</label>
                                    <input type="text" name="ip_address" required value="{{old('ip_address',$internet->ip_address)}}" id="ip_address" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="5">{{old('remarks',$internet->remarks)}}</textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col text-center"><button type="submit" class="btn btn-primary btn-pill">{{$button_title}}</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $('.check-all').change(function (){
            $('.'+$(this).data('class')).prop("checked", $(this).is(':checked'));
        });
    </script>

@endsection
