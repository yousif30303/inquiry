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
                    <form action="{{route('backend.domain.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="name">Domain Name</label>
                                    <input type="text" name="name" value="{{old('name',$domain->name)}}" required id="name" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="service_provider">Service Provider</label>
                                    <input type="text" name="service_provider" required value="{{old('service_provider',$domain->service_provider)}}" id="internet_type" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="ser_pro_email">Serv Pro Email</label>
                                    <input type="text" name="ser_pro_email" required value="{{old('ser_pro_email',$domain->ser_pro_email)}}" id="ser_pro_email" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <label for="ser_pro_no">Serv Pro NO.</label>
                                    <input type="text" name="ser_pro_no" required value="{{old('ser_pro_no',$domain->ser_pro_no)}}" id="ser_pro_no" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="registeration_date">Registeration Date</label>
                                    <input type="text" readonly required name="registeration_date" class="form-control datepicker-here" data-language="en" value="{{old('registeration_date',$domain->registeration_date?->format('d-m-Y') )}}" id="registeration_date">
                                </div>
                                <div class="col-6">
                                    <label for="expire_date">Expire Date</label>
                                    <input type="text" readonly required name="expire_date" class="form-control datepicker-here" data-language="en" value="{{old('expire_date',$domain->expire_date?->format('d-m-Y') )}}" id="expire_date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="domain_link">Domain Link</label>
                                    <input type="text" name="domain_link" required value="{{old('domain_link',$domain->domain_link)}}" id="domain_link" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" required value="{{old('username',$domain->username)}}" id="username" class="form-control" />
                                </div>
                            </div>

                            <div class="row">  
                                <div class="col-6">
                                    <label for="password">Password.</label>
                                    <input type="text" name="password" required value="{{old('password',$domain->password)}}" id="password" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks" required value="{{old('remarks',$domain->remarks)}}" id="remarks" class="form-control">
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
