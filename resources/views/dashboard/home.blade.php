@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Input Checklist</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/clipboard_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('indexmachinerecord')}}">Input Preventive Harian Mesin &nbsp; <i class="fas fa-tasks"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Checklist</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_clipboard_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('managemachineresults')}}">Tambah Preventive Harian Mesin &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Machine</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_task_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('managemachine')}}">Tambah Kategori Mesin &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body-custom">
                    <div class="col-7">
                        <h5 class="card-title-head">Tambah Componen Check Mesin</h5>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/inspection_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title" href="{{route('managecomponencheck')}}">Tambah Componen Check &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
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
        <div class="col-xl-4 col-md-6 mb-4">
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
    </div>
@endsection

@push('script')
@endpush

@push('style')
@endpush
