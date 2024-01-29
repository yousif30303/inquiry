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
                    <form action="{{route('backend.nvr.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="location">Location</label>
                                    <select name="location" required id="location" class="form-control select2" data-placeholder="Choose location" >
                                        <option value="">Choose location</option>
                                        @foreach($locations as $location)
                                            <option value="{{$location->id}}" @if(old('location',$nvr->location_id)==$location->id) selected @endif >{{$location->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-6">
                                    <label for="brand">Brand</label>
                                    <select name="brand" id="brand" required class="form-control select2" data-placeholder="Choose brand" >
                                        <option value="">Choose brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" @if(old('brand',$nvr->brand_id)==$brand->id) selected @endif >{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="ip_address">IP Address</label>
                                    <input type="text" required name="ip_address" value="{{old('ip_address',$nvr->ip_address)}}" id="ip_address" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="model">Model</label>
                                    <input type="text" required name="model" value="{{old('model',$nvr->model)}}" id="model" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="port">Port No.</label>
                                    <input type="text" required name="port" value="{{old('port',$nvr->port)}}" id="port" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <label for="serial_no">Serial No.</label>
                                    <input type="text" required name="serial_no" value="{{old('serial_no',$nvr->serial_no)}}" id="serial_no" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="dyn_dns">DYN DNS</label>
                                    <input type="text" required name="dyn_dns" value="{{old('dyn_dns',$nvr->dyn_dns)}}" id="dyn_dns" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="username">Username</label>
                                    <input type="text" required name="username" value="{{old('username',$nvr->username)}}" id="username" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="channel">Channel</label>
                                    <input type="text" required name="channel" value="{{old('channel',$nvr->channel)}}" id="channel" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="storage">Storage</label>
                                    <input type="text" required name="storage" value="{{old('storage',$nvr->storage)}}" id="storage" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="server_port">Server Port</label>
                                    <input type="text" required name="server_port" value="{{old('server_port',$nvr->server_port)}}" id="server_port" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="http_port">HTTP Port</label>
                                    <input type="text" required name="http_port" value="{{old('http_port',$nvr->http_port)}}" id="http_port" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="remark">Remark</label>
                                    <input type="text" required name="remark" value="{{old('remark',$nvr->remark)}}" id="remark" class="form-control">
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
