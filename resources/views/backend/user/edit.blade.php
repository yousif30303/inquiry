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
                    <form action="{{route('backend.user.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name"  required value="{{old('name',$user->name)}}" id="name" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" required value="{{old('email',$user->email)}}" class="form-control" id="email">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="roles">Role</label>
                                    <select name="roles[]" multiple id="roles" data-placeholder="Select Role" class="form-control select2">

                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" @selected(in_array($role->id,old('roles',$user->roles->pluck('id')->toArray())))>{{$role->name}}</option>
                                        @endforeach
                                    </select>
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


@endsection
