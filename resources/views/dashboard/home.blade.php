@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="card-dashboard-1 col-md-3">
            <div class="az-list-item">
                <div class="row-card-custom">
                    <div class="col-7">
                        <h4 class="card-title-custom-1">Input Checklist</h4>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/clipboard_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <h6 class="card-title-custom">Input Preventive Harian Mesin &nbsp; <i class="fas fa-tasks"></i></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-1 col-md-3">
            <div class="az-list-item">
                <div class="row-card-custom">
                    <div class="col-7">
                        <h4 class="card-title-custom-1">Tambah Checklist</h4>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_clipboard_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title-custom" href="">Tambah Preventive Harian Mesin &nbsp; <i class="fas fa-indent"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-1 col-md-3">
            <div class="az-list-item">
                <div class="row-card-custom">
                    <div class="col-7">
                        <h4 class="card-title-custom-1">Tambah Machine</h4>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_task_home.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <a class="card-title-custom" href="{{route('managemachine')}}">Tambah Kategori Mesin &nbsp; <i class="fas fa-indent"></i></a>
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
