@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="card card-dashboard-pageviews col-md-3">
            <div class="card-body">
                <div class="az-list-item">
                    <div class="col-8">
                        <h4 class="card-title-custom-1">Input Checklist</h4>
                        <h5 class="card-title-custom-2">Tidak ada masalah hari ini</h5>
                    </div>
                    <div class="col-4">
                        <img style="height: 55px" src="assets/icons/arrow_down_green.png">
                    </div>
                    <div class="card-footer-custom-1">
                        <a class="card-link">View Details &nbsp;<i class="mdi mdi-settings"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-dashboard col-md-3">
            <div class="card card-custom-2">
                <div class="card-body-custom">
                    <div class="row-card-custom">
                        <div class="col-8">
                            <h4 class="card-title">BARANG MASUK</h4>
                            <h5 class="card-title-custom">10 Items In Today</h5>
                        </div>
                        <div class="col-4">
                            <img style="height: 55px" src="assets/icons/arrow_down_green.png">
                        </div>
                        <div class="card-footer-item-custom-2">
                            <a class="card-link">View Details &nbsp;<i class="mdi mdi-settings"></i></a>
                        </div>
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
