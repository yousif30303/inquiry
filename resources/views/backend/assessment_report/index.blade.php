@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{$breadcrumb->title}}</h5>
                        <form action="" id="filter_form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <lable>Registration ID</lable>
                                    <input type="number" name="registration_id" class="form-control"
                                           id="registration_id_filter">
                                </div>
                                <div class="col-sm-4">
                                    <lable>Assessor</lable>
                                    <select name="assessor_id" id="assessor_id_filter" class="form-control">
                                        <option value="">All</option>
                                        @foreach($assessors as $assessor)
                                            <option
                                                value="{{$assessor->id}}">{{$assessor->sb_id.' - '.$assessor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <lable>Result</lable>
                                    <select name="result" id="result_filter" class="form-control">
                                        <option value="">All</option>
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                        <option value="Absent">Absent</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <lable for="from_date_filter">From Date</lable>
                                    <input type="text" name="from_date" id="from_date_filter" readonly
                                           class="form-control datepicker-here digits" data-language="en"
                                           data-bs-original-title title>
                                </div>
                                <div class="col-sm-4">
                                    <lable for="to_date_filter">To Date</lable>
                                    <input type="text" name="to_date" id="to_date_filter" readonly
                                           class="form-control datepicker-here digits" data-language="en"
                                           data-bs-original-title title>
                                </div>
                                <div class="col-sm-4 pt-4">
                                    <button class="btn btn-success btn-pill" id="filter" type="submit"><i
                                            class="fa fa-filter"></i> Filter
                                    </button>
                                    <button class="btn btn-danger btn-pill" id="reset" type="reset"><i
                                            class="fa fa-refresh"></i> Reset
                                    </button>
                                    <button class="btn btn-warning btn-pill" id="download" type="button"><i
                                            class="fa fa-file-excel-o"></i> Download
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr class="mb-0 pb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="datatable">

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

        $('#filter_form').submit(function (e) {
            e.preventDefault();
            datatable.destroy();
            let data = $(this).serializeArray();
            let indexed_array = {};
            $.map(data, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });
            iniTable(indexed_array);
            console.log(indexed_array);
        });

        // initTable();

        // $('#filter').click(function () {
        //     datatable.destroy();
        //     let registration_id = $('#registration_id_filter').val();
        //     let assessor_id = $('#assessor_id_filter').val();
        //     let result = $('#result_filter').val();
        //     let from_date = $('#from_date_filter').val();
        //     let to_date = $('#to_date_filter').val();
        //     let filter = {
        //         'result': null,
        //         'registration_id': null,
        //         'assessor_id': null,
        //         'from_date': null,
        //         'to_date': null
        //     };
        //     if (result != '') {
        //         filter.result = result;
        //     }
        //     if (registration_id != '') {
        //         filter.registration_id = registration_id;
        //     }
        //     if (assessor_id != '') {
        //         filter.assessor_id = assessor_id;
        //     }
        //     if (from_date != '') {
        //         filter.registration_id = from_date;
        //     }
        //     if (to_date != '') {
        //         filter.assessor_id = to_date;
        //     }
        //     iniTable(filter);
        // });

        $('#reset').click(function () {
            datatable.destroy();
            iniTable({});
        });

        function iniTable(data) {
            initDatatable(
                app_url + '/assessment/datatable',
                'get',
                data,
                [
                    {
                        "title": "#",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {title: "Reg. ID", data: 'student_id'},
                    {title: "Assessor ID", data: 'assessor.sb_id'},
                    {title: "Assessor Name", data: 'assessor.name'},
                    {title: "Start Time", data: 'start_time'},
                    {title: "End Time", data: 'end_time'},
                    {
                        title: "Assessment Time",
                        data: 'assessment_time',
                        render: function (data, type, row, meta) {
                            let hours = Math.floor(data / 3600);
                            data = data - hours * 3600;
                            let minutes = Math.floor(data / 60);
                            let seconds = data - minutes * 60;
                            let ret = "";
                            if (hours > 0) {
                                ret += (hours < 10 ? "0" : "") + hours + ":";
                            }
                            return ret + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                        }
                    },
                    {
                        title: "Result",
                        data: 'result',
                        'class': "text-center",
                        render: function (data, type, row, meta) {
                            if (data == 'Pass') {
                                return '<div class="span badge rounded-pill pill-badge-success">' + data + '</div>';
                            } else if (data == 'Fail') {
                                return '<div class="span badge rounded-pill pill-badge-danger">' + data + '</div>';
                            }
                            return '<div class="span badge rounded-pill pill-badge-dark">' + data + '</div>';

                        }
                    },
                ]
            );
        }

        $(document).ready(function () {
            iniTable({});
        });

        $(document).on('change', '.status', function () {
            let url = app_url + '/assessor/status/' + $(this).data('id');
            ajaxRequest(url, 'post', {}, true, function (status, data) {
                if (status) {
                    notification('success', 'Success!', data.message);
                } else {
                    notification('danger', 'Error!', data);
                }
            });
        });
    </script>
@endsection
