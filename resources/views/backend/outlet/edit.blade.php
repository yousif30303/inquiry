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
                    <form action="{{route('backend.outlet.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="location">Location</label>
                                    <select name="location" required id="location" class="form-control select2" data-placeholder="Choose location" >
                                        <option value="">Choose location</option>
                                        @foreach($locations as $location)
                                            <option value="{{$location->id}}" @if(old('location',$outlet->location_id)==$location->id) selected @endif >{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="name">Outlet Name</label>
                                    <input type="text" required name="name" value="{{old('name',$outlet->name)}}" id="name" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="brand">Router Brand</label>
                                    <select name="brand" required id="brand" class="form-control select2" data-placeholder="Choose brand" >
                                        <option value="">Choose brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" @if(old('brand',$outlet->brand_id)==$brand->id) selected @endif >{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="internet_type">Internet Type</label>
                                    <input type="text" required name="internet_type" value="{{old('internet_type',$outlet->internet_type)}}" id="internet_type" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="provider">Provider</label>
                                    <input type="text" required name="provider" value="{{old('provider',$outlet->provider)}}" id="provider" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <label for="account_no">Account No.</label>
                                    <input type="text" required name="account_no" value="{{old('account_no',$outlet->account_no)}}" id="account_no" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="username">Username</label>
                                    <input type="text" required name="username" value="{{old('username',$outlet->username)}}" id="username" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="password">Password</label>
                                    <input type="text" name="password" value="{{old('password',$outlet->password)}}" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="speed">speed</label>
                                    <input type="text" name="speed" value="{{old('speed',$outlet->speed)}}" id="speed" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="monthly_rental">Monthly Rental</label>
                                    <input type="text" name="monthly_rental" value="{{old('monthly_rental',$outlet->monthly_rental)}}" id="monthly_rental" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" name="telephone" value="{{old('telephone',$outlet->telephone)}}" id="telephone" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" name="mobile" value="{{old('mobile',$outlet->mobile)}}" id="mobile" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="ip_address">IP Address</label>
                                    <input type="text" name="ip_address" value="{{old('ip_address',$outlet->ip_address)}}" id="ip_address" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks" value="{{old('remarks',$outlet->remarks)}}" id="remarks" class="form-control">
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
