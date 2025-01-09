@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        @can('create_records', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Input Preventive Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/clipboard_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexmachinerecord') }}">Input Preventive Checksheet &nbsp; <i class="fas fa-tasks"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('manage_machine', Permission::class)
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
        @can('manage_machine', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Tambah Kategori Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/add_task_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexproperty') }}">Tambah Kategori Checksheet &nbsp; <i class="fas fa-indent"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('manage_machine', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Standarisasi Jam PM Mesin</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/working_hour_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexworkinghour') }}">Tambah Jam Preventive Mesin &nbsp; <i class="fas fa-indent"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
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
        @can('view_records', Permission::class)
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
        @can('create_schedule', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Input Schedule Preventive</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/add_schedule_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexyear') }}">Tambah atau Lihat Jadwal Preventive &nbsp; <i class="fas fa-calendar-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('recognize_schedule', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Cek Schedule Preventive (TAHUN)</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/check_year_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexyear-recognize') }}">Lihat Pending Jadwal Preventive &nbsp; <i class="fas fa-calendar-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('agreed_schedule', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Setujui Schedule Preventive (TAHUN)</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/approve_year_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexyear-agreed') }}">Lihat Pending Jadwal Preventive &nbsp; <i class="fas fa-calendar-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('recognize_schedule', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Cek Schedule Preventive (BULAN)</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/check_year_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexmonth-recognize') }}">Lihat Pending Jadwal Preventive &nbsp; <i class="fas fa-calendar-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('agreed_schedule', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Setujui Schedule Preventive (BULAN)</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/approve_year_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexmonth-agreed') }}">Lihat Pending Jadwal Preventive &nbsp; <i class="fas fa-calendar-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('reschedule_schedule', Permission::class)
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body-custom">
                        <div class="col-7">
                            <h5 class="card-title-head">Cek Schedule Preventive (PLANNER)</h5>
                        </div>
                        <div class="col-5" style="text-align: right">
                            <img class="image-card-home" src="{{ asset('assets/icons/check_month_home.png') }}">
                        </div>
                        <div class="card-footer-item-custom col-12">
                            <a class="card-title" href="{{ route('indexmonth-planner') }}">Lihat Jadwal Preventive Maintenance &nbsp; <i class="fas fa-calendar-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@push('script')
    {{-- <script src="{{ asset('assets/vendor/echarts/echarts.common.min.js') }}"></script> --}}
@endpush

@push('style')
@endpush
