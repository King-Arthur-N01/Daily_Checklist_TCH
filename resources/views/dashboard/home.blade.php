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
                        <img class="image-card-home" src="{{asset('assets/icons/clipboard.png')}}">
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
                        <h4 class="card-title-custom-1">Add Checklist</h4>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_clipboard.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <h6 class="card-title-custom">Tambah Preventive Harian Mesin &nbsp; <i class="fas fa-indent"></i></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard-1 col-md-3">
            <div class="az-list-item">
                <div class="row-card-custom">
                    <div class="col-7">
                        <h4 class="card-title-custom-1">Add Machine</h4>
                    </div>
                    <div class="col-5" style="text-align: right">
                        <img class="image-card-home" src="{{asset('assets/icons/add_task.png')}}">
                    </div>
                    <div class="card-footer-item-custom col-12">
                        <h6 class="card-title-custom">Tambah Kategori Mesin &nbsp; <i class="fas fa-indent"></i></h6>
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
