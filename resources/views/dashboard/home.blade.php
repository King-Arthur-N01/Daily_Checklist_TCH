@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        @can('create_records', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Input Checksheet Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/clipboard_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexmachinerecord') }}">Input Preventive Harian &nbsp; <i class="fas fa-tasks"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('managemachine', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Tambah Checksheet Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/add_clipboard_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexmachinedata') }}">Tambah Form Preventive &nbsp; <i class="fas fa-folder-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('managemachine', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Tambah Standarisasi Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/add_task_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexproperty') }}">Tambah Standarisasi Form &nbsp; <i class="fas fa-indent"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="row">
        @can('corrected_records', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Koreksi Preventive Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/checking_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexcorrection') }}">Lihat Pending Check &nbsp; <i class="bi bi-clipboard2-check-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('approval_records', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Setujui Preventive Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/approval_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexapproval') }}">Lihat Pending Approval &nbsp; <i class="bi bi-clipboard2-check-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('viewtable_records', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Lihat Riwayat Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/history_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{route('indexhistoryrecord')}}">Lihat History Preventive &nbsp; <i class="fas fa-history"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Lihat Schedule</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{ asset('assets/icons/schedule_home.png') }}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{ route('indexschedule') }}">Tambah atau Lihat Jadwal Preventive &nbsp; <i class="fas fa-calendar-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-chart">
        <div class="col-6">
            <h5 class="card-title">Data Preventive Tahunan</h5>
            <!-- Vertical Bar Chart -->
            <div id="verticalBarChart" style="min-height: 400px;" class="echart"></div>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    echarts.init(document.querySelector("#verticalBarChart")).setOption({
                        title: {
                            text: 'TAHUN 2023'
                        },
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'shadow'
                            }
                        },
                        legend: {},
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: {
                            type: 'value',
                            boundaryGap: [0, 0.01]
                        },
                        yAxis: {
                            type: 'category',
                            data: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AGU', 'SEP', 'OCT', 'NOV','DEC']
                        },
                        series: [{
                                name: 'ACTUAL',
                                type: 'bar',
                                data: [45, 46, 47, 39, 46, 48, 43, 44, 47, 45, 48, 49]
                            },
                            {
                                name: 'TARGET',
                                type: 'bar',
                                data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50]
                            }
                        ]
                    });
                });
            </script>
            <!-- End Vertical Bar Chart -->
        </div>
        <div class="col-6">
            <!-- Donut Chart -->
            <div id="donutChart" style="min-height: 400px;" class="echart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    echarts.init(document.querySelector("#donutChart")).setOption({
                        tooltip: {
                            trigger: 'item'
                        },
                        legend: {
                            top: '5%',
                            left: 'center'
                        },
                        series: [{
                            name: 'Access From',
                            type: 'pie',
                            radius: ['40%', '70%'],
                            avoidLabelOverlap: false,
                            label: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: '18',
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: false
                            },
                            data: [{
                                    value: 240,
                                    name: 'WELDING SPOT'
                                },
                                {
                                    value: 124,
                                    name: 'WELDING ROBOT'
                                },
                                {
                                    value: 107,
                                    name: 'KNURLING'
                                },
                                {
                                    value: 78,
                                    name: 'PRESS BRAKE'
                                },
                                {
                                    value: 67,
                                    name: 'DRILLING'
                                },
                                {
                                    value: 30,
                                    name: 'COMPRESSOR'
                                }
                            ]
                        }]
                    });
                });
            </script>
            <!-- End Donut Chart -->
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/echarts/echarts.common.min.js') }}"></script>
@endpush

@push('style')
@endpush
