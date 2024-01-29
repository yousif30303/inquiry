<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.header')
<script>
    var api_url='{{env('API_URL')}}';
    var app_url='{{url('/')}}';
</script>


<body>
<script>
    /**
     * THIS SCRIPT REQUIRED FOR PREVENT FLICKERING IN SOME BROWSERS
     */
    localStorage.getItem("body") === "dark-only" &&
    document.querySelector("body").classList.add("dark-only");
</script>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    @include('layouts.partials.navbar')
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper horizontal-menu">
        <!-- Page Sidebar Start-->
        @include('layouts.partials.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            @include('layouts.partials.breadcrum')
            @include('layouts.partials.errors')
            <!-- Container-fluid starts-->
            @yield('content')
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        @include('layouts.partials.footer')
    </div>
</div>
    @include('layouts.partials.scripts')

    <script>
        function notification(type, title, message){
            $.notify(
                {
                    title:title,
                    message:message
                },
                {
                    type:type,
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:false,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'right'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated bounce',
                        exit:'animated bounce'
                    }
                }
            );
        }
        @if(session('success'))
            notification('success','Success!',"{{session('success')}}");
        @endif
        @if(session('error'))
            notification('danger','Error!',"{{session('error')}}");
        @endif
        function ajaxRequest(url, method, data, csrf_required, callback){
            if(csrf_required){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            $.ajax({
                url: url,
                type: method, //send it through get method
                data: data,
                dataType: "json",
                success: function(data) {
                    callback(true, data);
                },
                error: function(xhr) {
                    callback(false,xhr);
                }
            });
        }

        var datatable;
        function initDatatable(url, method, data, columns){
            datatable = $('#datatable').DataTable({
                "processing": true,
                "serverSide": false,
                "ordering": false,
                "pageLength": 25,
                // lengthChange:false,
                // "bPaginate": false,
                // info: false,
                "sScrollX": "100%",
                "searching": true,
                "ajax": {
                    url: url,
                    type: method,
                    data:data,
                },
                columns: columns
            });
        }
        function deletebtn(url){
            ajaxRequest(url,'post',{'_method':'delete'},true,function(status,data){
                if(status){
                    notification('success','Success!',data.message);
                }
                else{
                    notification('danger','Error!',data);
                }
            });
        }

        function ajaxPromise(url, method, data, csrf_token) {
            return new Promise((resolve, reject) => {
                ajaxRequest(url,method,data,csrf_token,function(status,data){
                    if(status){
                        resolve(data)
                    }
                    else{
                        reject(data)
                    }
                });
            });
        }

        function deleteConfirm(url){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success btn-pill',
                    cancelButton: 'btn btn-danger m-r-20 btn-pill'
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: (data) => {
                    return ajaxPromise(url,'post',{'_method':'delete'},true)
                    .then(function (data) {
                        return data;
                        }).catch(function (error){
                            console.log(error);
                            swalWithBootstrapButtons.fire(
                                'Error!',
                                'Something went wrong',
                                'error'
                            );
                        });
                },
                // allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed){
                    if(result.value.data){
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            result.value.message,
                            'success'
                        );
                        datatable.ajax.reload();
                    }
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary data is safe :)',
                        'error'
                    )
                }
            })
        }

        $(document).on('click','.delete-btn',function () {
            deleteConfirm($(this).data('url'));
        })

        function closeRequestConfirm(url){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success btn-pill',
                    cancelButton: 'btn btn-danger m-r-20 btn-pill'
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to close the request?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes, close it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: (data) => {
                    return ajaxPromise(url,'post',{'_method':'post'},true)
                    .then(function (data) {
                        Swal.fire(
                        'closed!',
                        'Your Request has been closed.',
                        'success'
                        )
                            window.location.href = app_url +'/inquiry';
                        }).catch(function (error){
                            console.log(error);
                            swalWithBootstrapButtons.fire(
                                'Error!',
                                'Something went wrong',
                                'error'
                            );
                        });
                },
                // allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed){
                    if(result.value.data){
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            result.value.message,
                            'success'
                        );
                        datatable.ajax.reload();
                    }
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary data is safe :)',
                        'error'
                    )
                }
            })
        }

        $(document).on('click','.closeRequest-btn',function () {
            closeRequestConfirm($(this).data('url'));
        })


        function openRequestConfirm(url){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success btn-pill',
                    cancelButton: 'btn btn-danger m-r-20 btn-pill'
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to open the request?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes, open it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: (data) => {
                    return ajaxPromise(url,'post',{'_method':'post'},true)
                    .then(function (data) {
                        Swal.fire(
                        'opened!',
                        'Your Request has been opened.',
                        'success'
                        )
                        location.reload();
                        }).catch(function (error){
                            console.log(error);
                            swalWithBootstrapButtons.fire(
                                'Error!',
                                'Something went wrong',
                                'error'
                            );
                        });
                },
                // allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed){
                    if(result.value.data){
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            result.value.message,
                            'success'
                        );
                        datatable.ajax.reload();
                    }
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary data is safe :)',
                        'error'
                    )
                }
            })
        }

        $(document).on('click','.openRequest-btn',function () {
            openRequestConfirm($(this).data('url'));
        })

        $('.select2').select2();

        function isEmpty(val){
            return (val === undefined || val == null || val.length <= 0) ? true : false;
        }

        $(document).ready(function (){
            $("#from-validate").validate({
                errorClass:"text-danger",
                errorElement:'span'
            });
        });

        // $('.datepicker').datepicker();

    </script>

    @yield('script')
</body>
</html>
