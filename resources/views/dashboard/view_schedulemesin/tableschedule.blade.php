@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Schedule</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    {{-- <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="col-4">
                                <p class="mg-b-10">Nama Mesin</p>
                                <input class="form-control" name="" id="filterByName">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Nomor Mesin </p>
                                <input class="form-control" name="" id="filterById">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Standarisasi Mesin</p>
                                <select class="form-control select2" name="sample" id="filterByProperty">
                                    <option selected="selected">Select :</option>
                                    <option><i class="fas fa-check-circle"></i>Sudah Dipreventive</option>
                                    <option>Belum Dipreventive</option>
                                </select>
                            </div>
                        </div>
                    </form> --}}
                    <div class="table-responsive">
                        <table class="table" id="scheduleTables" width="100%">
                            <thead>
                                <th>NO MESIN</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                {{-- <th>INVENT NUMBER</th> --}}
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                        </table>
                    </div>
                    <div class="calendar">
                        <div id="calendar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
    </div>
@endsection

@push('style')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/laravel-calendar/fullcalendar.min.css') }}"> --}}
@endpush

@push('script')
{{-- <script src="{{ asset('assets/vendor/fullcalendar/index.global.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/fullcalendar/packages/core/index.global.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/fullcalendar/packages/core/index.global.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/fullcalendar/packages/interaction/index.global.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/fullcalendar/packages/multimonth/index.global.min.js') }}"></script> --}}
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<script src="{{ mix('js/app.js') }}" defer></script>
@endpush
