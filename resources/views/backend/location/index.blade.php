@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{$breadcrumb->title}} @can('location.manage') <a href="{{route('backend.location.edit',0)}}" class="btn btn-primary pull-right btn-pill"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a> @endcan</h5>
                    </div>
                    <hr class="mb-0 pb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="datatable" >

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let action = false;
        let edit_action = false;
        let delete_action =false;

        @canany(['location.edit','location.delete']) action =  true @endcanany;
        @can('location.manage') edit_action =  true @endcan;
        @canany('location.delete') delete_action =  true @endcan;

        $(document).ready(function (){
            initDatatable(
                app_url+'/location/datatable',
                'get',
                {},
                [
                    {
                        "title": "#",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: "Name", data:'name'},
                    { title: "Address", data:'address'},
                    {
                        title: "Action",
                        data:'name',
                        visible : action,
                        render:function (data,type, row){
                            let col_data ='<div class="d-flex">';
                            if(edit_action){
                                col_data +='<a class="btn btn-sm btn-primary btn-pill process" href="'+app_url+'/location/'+row.id+'/edit'+'" > <i class="fa fa-edit"></i></a>';
                            }
                            if(delete_action){
                                col_data +='<span class="btn btn-sm btn-danger btn-pill m-l-10 delete-btn" data-url="'+app_url+'/location/'+row.id+'"><i class="fa fa-trash"></i></span>';
                            }
                            return col_data + '</div>';
                        }
                    },
                ]
            );
        });
    </script>
@endsection
