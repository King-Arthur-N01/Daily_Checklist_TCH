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
                        <img class="image-card-home" src="{{asset('assets/icons/clipboard_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('indexmachinerecord')}}">Input Preventive Harian &nbsp; <i class="fas fa-tasks"></i></a>
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
                        <img class="image-card-home" src="{{asset('assets/icons/add_clipboard_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('managemachinedata')}}">Tambah Form Preventive &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Standart Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_task_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('indexproperty')}}">Tambah Standarisasi Mesin &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @can('corrected_records', Permission::class)
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Checking Preventive Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/checking_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('viewcorrection')}}">Lihat Pending Check &nbsp; <i class="bi bi-clipboard2-check-fill"></i></a>
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
                        <h5 class="card-title-head">Approval Preventive Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/approval_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('viewapproval')}}">Lihat Pending Approval &nbsp; <i class="bi bi-clipboard2-check-fill"></i></a>
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
                        <img class="image-card-home" src="{{asset('assets/icons/history_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('historymachine')}}">Lihat History Preventive &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    {{-- <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Componen Check Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/inspection_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('managemachine')}}">Tambah Componen Check &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Parameter Pengecekan Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/parameter_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('manageparameter')}}">Tambah Parameter Pengecekan &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Metode Pengecekan Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/method_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('managemethod')}}">Tambah Metode Pengecekan &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('script')
@endpush

@push('style')
@endpush
