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
                        <button type="button" class="btn btn-primary btn-pill showBtn">Add Remark</button> 
                    </div>
                </div>
                <div class="card">
                    <div style="margin-left: 15px;margin-top:20px;margin-bottom:50px">
                        <h5><b>Follow up Remarks</b></h5>
                        @if($remarks->isNotEmpty())
                            <table class="table" style="margin: 30px">
                                <tbody>
                                @foreach ($remarks as $remark)                              
                                    <tr>
                                    <th>remark:</th>
                                    <td id="remarks_description_{{$remark->id}}">{{$remark->description}}</td>
                                    <th>date</th>
                                    <td>{{$remark->created_at->format('d M Y')}}</td>
                                    <td><button class="btn btn-sm btn-primary btn-pill editBtn" data-remark-id={{$remark->id}}> <i class="fa fa-edit"></i> </button></td>
                                    <td><button class="btn btn-sm btn-danger btn-pill delete-btn" data-url="{{route('backend.remark.destroy',$remark->id)}}"><i class="fa fa-trash"></i></button>
                                    </tr>           
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No remarks available.</p>
                        @endif                                             
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

        $('.editBtn').on('click', function(){
            var remark_id = $(this).attr('data-remark-id');
            $('#edit_remark_id').val(remark_id);
            $('#description').text($('#remarks_description_'+remark_id).text());
            $('#show-inquiry').modal('show');
        });

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
        });

    </script>
@endsection
