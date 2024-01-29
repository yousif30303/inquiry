@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{$breadcrumb->title}} @can('inquiry.manage') <a href="{{route('backend.inquiry.edit',0)}}" class="btn btn-primary pull-right btn-pill"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a> @endcan</h5>
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
    <div class="modal fade" id="show-inquiry" tabindex="-1" role="dialog" aria-labelledby="show-inquiry" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inquiry Detail</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="d-flex justify-content-center" >
                        <div class="spinner-border" role="status" id="modal-preloading">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="row" id="modal-content">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Date</th>
                                    <td id="date"></td>
                                    <th>Category</th>
                                    <td id="category"></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td id="name"></td>
                                    <th>Mobile No.</th>
                                    <td id="mobile"></td>
                                </tr>
                                <tr>
                                    <th>Visit Time</th>
                                    <td id="visit_time">
                                    <th>Entered by</th>
                                    <td id="entered_by">
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <td colspan="3" id="remarks">
                                </tr>                           
                            </table>

                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button class="btn btn-secondary btn-pill" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let action = true;
        let edit_action = false;
        let delete_action =false;
        let datatableLink = app_url+'/inquiry/datatable';

        @canany(['inquiry.edit','inquiry.delete']) action =  true @endcanany;
        @can('inquiry.manage') edit_action =  true @endcan;
        @canany('inquiry.delete') delete_action =  true @endcan;
        @canany('inquiry.listAdmin') datatableLink =  app_url+'/inquiry/datatableAdmin' @endcan;


        $(document).ready(function (){
            initDatatable(
                datatableLink,
                'get',
                {},
                [
                    {
                        "title": "#",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { title: "Date", data:'date'},
                    { title: "Category", data:'category.name'},
                    { title: "Name", data:'name'},
                    { title: "Mobile No.", data:'mobile' , width: '60px'},
                    { title: "Visit Time", data:'visit_time'},
                    { title: "Information given by", data:'entered_by'},
                    { title: "Remarks", data:'remarks'},
                    { title: "Status", data:'status'},
                    
                    {
                        title: "Action",
                        data:'name',
                        class:'text-center',
                        visible : action,
                        render:function (data,type, row){
                            let col_data ='<div class="d-flex">';

                            col_data +='<a class="btn btn-sm btn-info m-l-10 btn-pill" href="'+app_url+'/inquiry/'+row.id+'/view'+'" > <i class="fa fa-eye"></i> </a>';
                            
                            if(delete_action){
                                col_data +='<span class="btn btn-sm btn-danger btn-pill m-l-10 delete-btn" data-url="'+app_url+'/inquiry/'+row.id+'"><i class="fa fa-trash"></i></span>';
                            }
                            return col_data + '</div>';
                        }
                    },
                ],
            );
            $('#datatable').on('draw.dt', function () {
        $('#datatable tbody td:nth-child(9)').each(function () {
            if ($(this).text().trim() !== '') { // Check if cell is not empty
                if($(this).text()==0){
                    $(this).css({"background-color":"red","font-weight":"bold","color":"white"});
                    $(this).text('OPEN');
                }else{
                    $(this).css({"background-color":"green","font-weight":"bold","color":"white"});
                    $(this).text('CLOSED');
                }
            }
        });
    });
        });

        $(document).on('click','.view-details',function (){
            $.ajax({
                url: $(this).data('url'),
                type: "get", //send it through get method
                dataType:'json',
                beforeSend: function() {
                    $('#modal-preloading').show();
                    $('#modal-content').hide();
                    $('#show-inquiry').modal('show');
                    $('#process-btn').hide();
                },
                success: function(response) {
                    let data=response.data;
                    $('#date').text(data.date);
                    $('#category').text(data.category.name);
                    $('#name').text(data.name);
                    $('#mobile').text(data.mobile);
                    $('#visit_time').text(data.visit_time);
                    $('#entered_by').text(data.entered_by);
                    $('#remarks').text(data.remarks);

                    // $('#request-body').html(JSON.stringify(data.transaction.request,null,4));
                    // $('#response-body').text(JSON.stringify(data.transaction.response,null,4));
                    $('#modal-preloading').hide();
                    $('#modal-content').show();
                },
                error: function(xhr) {
                    notification('danger',"Alert","Something went wrong!");
                    $('#modal-preloading').hide();
                    $('#modal-content').show();
                    $('#show-inquiry').modal('close');
                }
            });
        });

    </script>
@endsection
