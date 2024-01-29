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
                    <form action="{{route('backend.role.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 "><h6 for="name" class="pull-right mt-2 p-0">Name</h6></div>
                                <div class="col-6">
                                    <input type="text" name="name" required value="{{old('name',$role->name)}}" id="name" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col"><h5>Permissions</h5></div>
                            </div>
                            <div class="row">
                                @foreach($all_permissions as $key => $permissions)
                                    <div class="col-md-6">
                                        <div class="card box-shadow b-1 border">
                                            <div class="card-header p-3 pb-0">
                                                <div class="row">
                                                    <div class="col"><h6>{{$key}}</h6></div>
                                                    <div class="col pull-right">
                                                        <label class="d-block pull-right" for="{{$key}}">
                                                            <input class="checkbox_animated check-all" data-class="{{$key}}" id="{{$key}}" type="checkbox"> Select All
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-0 mt-0 pb-0">
                                            <div class="card-body d-flex">
                                                @foreach($permissions as $permission)
                                                    <label class="d-block m-r-20" for="{{$permission->get('name')}}">
                                                        <input class="checkbox_animated {{$key}}" @checked($role->hasPermissionTo($permission->get('id'))) value="{{$permission->get('id')}}" name="permissions[]" id="{{$permission->get('name')}}" type="checkbox"> {{$permission->get('title')}}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
