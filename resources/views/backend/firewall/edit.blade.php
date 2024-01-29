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
                    <form action="{{route('backend.firewall.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="location">Location</label>
                                    <select name="location" id="location" required class="form-control select2" data-placeholder="Choose location" >
                                        <option value="">Choose location</option>
                                        @foreach($locations as $location)
                                            <option value="{{$location->id}}"  @if(old('location',$firewall->location_id)==$location->id) selected @endif >{{$location->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-6">
                                    <label for="brand">Brand</label>
                                    <select name="brand" id="brand" required class="form-control select2" data-placeholder="Choose brand" >
                                        <option value="">Choose brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" @if(old('brand',$firewall->brand_id)==$brand->id) selected @endif >{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="ip_address">IP Address</label>
                                    <input type="text" name="ip_address" required value="{{old('ip_address',$firewall->ip_address)}}" id="ip_address" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="model">Model</label>
                                    <input type="text" name="model"  value="{{old('model',$firewall->model)}}" id="model" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="port">Part No.</label>
                                    <input type="text" name="port" value="{{old('port',$firewall->port)}}" id="port" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <label for="serial_no">Serial No.</label>
                                    <input type="text" name="serial_no"  value="{{old('serial_no',$firewall->serial_no)}}" id="serial_no" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="warranty">Warranty</label>
                                    <input type="text" name="warranty"  value="{{old('warranty',$firewall->warranty)}}" id="warranty" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="warranty_expiry_date">Warranty Expiry Date</label>
                                    <input type="text" readonly  name="warranty_expiry_date" class="form-control datepicker-here" data-language="en" value="{{old('warranty_expiry_date',$firewall->warranty_expiry_date?->format('d-m-Y') )}}" id="warranty_expiry_date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="firmware">Firmware</label>
                                    <input type="text" name="firmware"  value="{{old('firmware',$firewall->firmware)}}" id="firmware" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="5">{{old('remarks',$firewall->remarks)}}</textarea>

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
