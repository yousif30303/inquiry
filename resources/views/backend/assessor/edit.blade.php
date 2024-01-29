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
                    <form action="{{route('backend.assessor.update',$id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sb_id">SB ID</label>
                                    <input type="text" name="sb_id" required value="{{old('sb_id',$assessor->sb_id)}}" id="sb_id" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" readonly required value="{{old('name',$assessor->name)}}" class="form-control" id="name">

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
        $('#sb_id').focusout(function (){
            let sb_id = $('#sb_id').val();
            if(sb_id==''){
                return false;
            }
            ajaxRequest(app_url+'/assessor/profile/'+sb_id,'post',{},true, function (status, data){
                if(status){
                    $('#name').val(data.data.name);
                }
                else{
                    notification('danger','Error!',data.responseJSON.message);
                }
            });
        });
    </script>

@endsection
