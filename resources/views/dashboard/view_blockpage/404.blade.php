@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <h3 class="text-gray-800 mb-5">Error!!!! Standarisasi Checksheet Mesin Tidak Ada</h3>
        <p class="text-gray-500 mb-0">Periksa lagi apakah mesin sudah memiliki standarisasi checksheet</p>
        <a href="{{ route('home')}}">&larr; Back to Dashboard</a>
    </div>
@endsection

@push('script')
@endpush

@push('style')
@endpush
