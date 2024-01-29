@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row starter-main">
            @can('assessor.list')
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="file"></i></div>
                                <div class="media-body"><span class="m-0">Total Assessors</span>
                                    <h4 class="mb-0 counter" id="count-total-assessor">{{$assessors}}</h4><i
                                        class="icon-bg"
                                        data-feather="file"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="row">
            @can('assessment.list')
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="database"></i></div>
                                <div class="media-body"><span class="m-0">Total Assessments</span>
                                    <h4 class="mb-0 counter" id="count-total">0</h4><i class="icon-bg"
                                                                                       data-feather="database"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-success b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="check-circle"></i></div>
                                <div class="media-body"><span class="m-0">Pass</span>
                                    <h4 class="mb-0 counter" id="count-pass">0</h4><i class="icon-bg"
                                                                                      data-feather="check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-danger b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="x-circle"></i></div>
                                <div class="media-body"><span class="m-0">Fail</span>
                                    <h4 class="mb-0 counter" id="count-fail">0</h4><i class="icon-bg"
                                                                                      data-feather="x-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-info b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="alert-circle"></i></div>
                                <div class="media-body"><span class="m-0">Absent</span>
                                    <h4 class="mb-0 counter" id="count-absent">0</h4><i class="icon-bg"
                                                                                        data-feather="alert-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Recent Assessments</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="assessment">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Assessments</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="column-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
    </div>
@endsection

@section('script')
    @can('assessment.list')
        <script>
            function setChartData(heading, pass, fail, absent) {
                return {
                    chart: {
                        height: 560,
                        type: 'bar',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            endingShape: 'rounded',
                            columnWidth: '90%',
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    series: [{
                        name: 'Pass',
                        data: pass
                    }, {
                        name: 'Fail',
                        data: fail
                    }, {
                        name: 'Absent',
                        data: absent
                    }],
                    xaxis: {
                        categories: heading,
                    },
                    fill: {
                        opacity: 1

                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return  val
                            }
                        }
                    },
                    colors: [vihoAdminConfig.primary, '#d9534f', '#222222']
                }
            }

            $('#assessment').DataTable({
                "processing": true,
                // "serverSide": true,
                "ordering": false,
                "bPaginate": false,
                info: false,
                "sScrollX": "100%",
                "searching": false,
                "ajax": {
                    url: app_url + "/dashboard/data",
                    dataSrc: function (d) {
                        $('#count-total').text(d.total_count);
                        $('#count-absent').text(d.absent_count);
                        $('#count-fail').text(d.fail_count);
                        $('#count-pass').text(d.pass_count);

                        var options3 = setChartData(
                            d.assesors,
                            d.assessment_pass,
                            d.assessment_fail,
                            d.assessment_absent
                        );
                        var chart3 = new ApexCharts(
                            document.querySelector("#column-chart"),
                            options3
                        );
                        chart3.render();

                        return d.assessments;
                    },

                },
                columns: [
                    {
                        "title": "#",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {title: "Reg. ID", data: 'student_id'},
                    {title: "Assessor ID", data: 'assessor.sb_id'},
                    {title: "Assessor Name", data: 'assessor.name'},
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
            });



        </script>
    @endcan
@endsection
