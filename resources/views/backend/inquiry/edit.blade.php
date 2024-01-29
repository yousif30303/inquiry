@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Add Inquiry</h5>
                    </div>
                    <hr class="mb-0 pb-0">
                    <form action="{{route('backend.inquiry.update',$id)}}" id="from-validate" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="date">Date</label>
                                    <input type="text" name="date" required value="{{$date}}" id="date" class="form-control" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" required class="form-control select2" data-placeholder="Choose Category" >
                                        <option value="">Choose Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" required value="" id="name" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="mobile">Mobile No.</label>
                                    <input type="text" name="mobile"  value="" id="mobile" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="visit_time">Visit Time</label>
                                    <input type="time" name="visit_time"  value="" id="visit_time" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="entered_by">Entered by</label>
                                    <input type="text" name="entered_by"  value="{{auth()->user()->name}}" id="entered_by" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control" id="remarks" cols="30" rows="5"></textarea>

                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col text-center"><button type="submit" class="btn btn-primary btn-pill">Add Inquiry</button></div>
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
