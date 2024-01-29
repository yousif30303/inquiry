@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{$breadcrumb->title}} @can('outlet.manage') <a href="{{route('backend.outlet.edit',0)}}" class="btn btn-primary pull-right btn-pill"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a> @endcan</h5>
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

        @canany(['outlet.edit','outlet.delete']) action =  true @endcanany;
        @can('outlet.manage') edit_action =  true @endcan;
        @canany('outlet.delete') delete_action =  true @endcan;

        $(document).ready(function (){
            initDatatable(
                app_url+'/outlet/datatable',
                'get',
                {},
                [
                    {
                        "title": "#",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: "Outlet Name", data:'name'},
                    { title: "Location", data:'location.name'},
                    { title: "Router Brand", data:'brand.name'},
                    { title: "Internet Type", data:'internet_type'},
                    { title: "Provider", data:'provider'},
                    { title: "Account No", data:'account_no'},
                    { title: "Username", data:'username'},
                    { title: "Password", data:'password'},
                    { title: "Speed", data:'speed'},
                    { title: "Monthly Rental", data:'monthly_rental'},
                    { title: "Telephone", data:'telephone'},
                    { title: "Mobile", data:'mobile'},
                    { title: "IP", data:'ip_address'},
                    { title: "Remarks", data:'remarks'},
                    {
                        title: "Action",
                        data:'name',
                        visible : action,
                        render:function (data,type, row){
                            let col_data ='<div class="d-flex">';
                            if(edit_action){
                                col_data +='<a class="btn btn-sm btn-primary btn-pill process" href="'+app_url+'/outlet/'+row.id+'/edit'+'" > <i class="fa fa-edit"></i></a>';
                            }
                            if(delete_action){
                                col_data +='<span class="btn btn-sm btn-danger btn-pill m-l-10 delete-btn" data-url="'+app_url+'/outlet/'+row.id+'"><i class="fa fa-trash"></i></span>';
                            }
                            return col_data + '</div>';
                        }
                    },
                ]
            );
        });
    </script>
@endsection
