@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <table class="table" style="margin: 30px">
                        <tbody>
                             <tr>
                                 <th>Date</th>
                                 <td>{{$inquiry->date}}</td>
                                 <th>Category</th>
                                 <td>{{$inquiry->Category->name}}</td>
                             </tr>
                             <tr>
                                 <th>Name</th>
                                 <td>{{$inquiry->name}}</td>
                                 <th>Mobile No.</th>
                                 <td>{{$inquiry->mobile}}</td>
                             </tr>
                             <tr>
                                <th>Visit Time</th>
                                <td>{{$inquiry->visit_time}}</td>
                                <th>Information given by</th>
                                <td>{{$inquiry->entered_by}}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>{{$inquiry->remarks}}</td>
                            </tr>  
                        </tbody>
                     </table>
                     <div class="card-header pb-4 text-center">
                        @if ($inquiry->status == 0)
                            <button type="button" class="btn btn-primary btn-pill showBtn">Add Remark</button>
                            <button class="btn btn-sm pull-right btn-danger btn-pill closeRequest-btn" data-url="{{route('backend.inquiry.updateRequest',['id'=>$inquiry->id,'status'=>1])}}">Close</button>
                        @else
                            <button class="btn btn-sm pull-right btn-success btn-pill openRequest-btn" data-url="{{route('backend.inquiry.updateRequest',['id'=>$inquiry->id,'status'=>0])}}">Open</button> 
                        @endif 
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row starter-main">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5><b>Follow up Remarks</b></h5>
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
                    <form method="POST" action="{{route('backend.remark.update')}}">
                    @csrf
                    <input type="hidden" id="inquiry" name="inquiry" value="{{$inquiry->id}}" />
                    <input type="hidden" id="edit_remark_id" name="remark_id" value="" />
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="branch">Remarks:</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5" value='fo'></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary pull-right" id="btn-change-status">Submit</button>
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
        let action = true;
        let edit_action = false;
        let delete_action =false;

        @canany(['inquiry.edit','inquiry.delete']) action =  true @endcanany;
        @can('inquiry.manage') edit_action =  true @endcan;
        @canany('inquiry.delete') delete_action =  true @endcan;

        
        $('.showBtn').on('click', function(){
            $('#show-inquiry').modal('show');
            $('#edit_remark_id').val(0);
        });

        function editBtn(id,description){
            $('#edit_remark_id').val(id);
            //console.log($('#datatable tbody tr:nth-child(1) td:nth-child(2) ').text());
            $('#description').text(description);
            $('#show-inquiry').modal('show');
        };

        let id = $('#inquiry').val();
        let datatableLink = app_url+'/remark/datatable/'+id;

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
                    { title: "Description", data:'description'},
                    { 
                      title: "Date", 
                      data:'created_at',
                        render:function (data,type, row){
                            const dateTimeParts = data.split('T');
                            const datePart = dateTimeParts[0];
                            const timePart = dateTimeParts[1].split('.')[0]; // Remove milliseconds and 'Z'

                            return `${datePart} ${timePart}`;
                        }
                    },
                    {
                        title: "Action",
                        data:'name',
                        class:'text-center',
                        visible : action,
                        render:function (data,type, row){
                            let col_data ='<div class="d-flex">';

                            col_data +=`<button class="btn btn-sm btn-info m-l-10 btn-pill" onclick="editBtn('${row.id}','${row.description}')"> <i class="fa fa-eye"></i> </button>`;
                            
                            if(delete_action){
                                col_data +='<button class="btn btn-sm btn-danger btn-pill m-l-10 delete-btn" data-url="'+app_url+'/remark/'+row.id+'"><i class="fa fa-trash"></i></button>';
                            }
                            return col_data + '</div>';
                        }
                    },
                ],
            );         
        });

    </script>
@endsection
