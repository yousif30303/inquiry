@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{$breadcrumb->title}} @can('assessor.create') <a href="{{route('backend.assessor.edit',0)}}" class="btn btn-primary pull-right btn-pill"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a> @endcan</h5>
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

        @canany(['assessor.edit','assessor.delete']) action =  true @endcanany;
        @can('assessor.edit') edit_action =  true @endcan;
        @canany('assessor.delete') delete_action =  true @endcan;

        $(document).ready(function (){
            initDatatable(
                app_url+'/assessor/datatable',
                'get',
                {},
                [
                    {
                        "title": "#",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: "SB ID", data:'sb_id'},
                    { title: "Name", data:'name'},
                    {
                        title: "Status",
                        data:'status',
                        visible: edit_action,
                        render: function (data, type, row){
                            return '<div class="media-body text-center icon-state"> <label class="switch"> <input data-id="'+ row.id +'" type="checkbox" class="status" '+ (data ? 'checked' : '') +'><span class="switch-state"></span> </label> </div>';
                        }
                    },
                    {
                        title: "Action",
                        data:'name',
                        class:'d-flex',
                        visible: action,
                        render:function (data,type, row){
                            let col_data ='';
                            if(edit_action){
                                col_data +='<a class="btn btn-sm btn-primary process btn-pill" href="'+app_url+'/assessor/'+row.id+'/edit'+'" > Edit</a>';
                            }
                            if(delete_action){
                                col_data +='<span class="btn btn-sm btn-danger m-l-10 delete-btn btn-pill" data-url="'+app_url+'/assessor/'+row.id+'">Delete</span>';
                            }
                            return col_data;
                        }
                    },
                ]
            );
        });

        $(document).on('change','.status',function (){
            let url =app_url+'/assessor/status/'+$(this).data('id');
            ajaxRequest(url,'post',{},true,function(status,data){
                if(status){
                    notification('success','Success!',data.message);
                }
                else{
                    notification('danger','Error!',data);
                }
            });
        });
    </script>
@endsection
