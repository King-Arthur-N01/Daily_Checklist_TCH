@extends('layouts.master')
@section('title', 'Table Preventive Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Input Checklist Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="col-sm-12 col-md-12">
                        <div>
                            <form  method="post">
                                @csrf
                                <div class="table-filter">
                                    <div class="col-4">
                                        <p class="mg-b-10">Nama Mesin</p>
                                        <select class="form-control select2" name="" id="filterByName">
                                            <option selected="selected" value="">Select :</option>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <p class="mg-b-10">Input Nomor Mesin </p>
                                        <select class="form-control select2" name="" id="filterByNumber">
                                            <option selected="selected" value="">Select :</option>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <p class="mg-b-10">Status Mesin</p>
                                        <select class="form-control" name="sample" id="filterByStatus">
                                            <option selected="selected">Select :</option>
                                            <option><i class="fas fa-check-circle"></i>Sudah Dipreventive</option>
                                            <option>Belum Dipreventive</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="successMessages">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div id="errorMessages">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="recordTables" width="100%">
                            <thead>
                                <th>NO MESIN</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                {{-- <th>INVENT NUMBER</th> --}}
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($machines as $getmachine)
                                    <tr>
                                        <td>{{ $getmachine->machine_number }}</td>
                                        <td>{{ $getmachine->machine_name }}</td>
                                        <td>{{ $getmachine->machine_type }}</td>
                                        <td>{{ $getmachine->machine_brand }}</td>
                                        @if (empty($getmachine->id_property))
                                            <td>Belum ada standarisasi mesin</td>
                                        @else
                                            <td data-id="{{ $getmachine->id_property }}">{{ $getmachine->id_property }}</td>
                                        @endif
                                        <td>
                                            <div class="dynamic-button-group">
                                                <a class="btn btn-primary btn-sm" style="color:white" href="{{ route('indexuserinput', $getmachine->id) }}"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#recordTables').DataTable({ // Disable sorting for columns
                columnDefs: [{
                    "orderable": false,
                    "targets": [5]
                }]
            });
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'
            });
            // fungsi get status waktu terakhir preventive mesin melalui ajax
            var table = $('#recordTables').DataTable();
            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var row = this.node();
                var idCell = $(row).find('td').eq(4);
                var id = idCell.data('id');
                if (id) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('fetchtablerecord', ':id') }}'.replace(':id', id),
                        success: function(data) {
                            if (data.gettotalhours && data.gettotaldays) {
                                idCell.text('Terakhir preventive ' + data.gettotaldays + ' hari ' + data.gettotalhours + ' jam yang lalu');
                            } else {
                                idCell.text('Error fetching data');
                            }
                        },
                        error: function() {
                            idCell.text('Belum pernah dilakukan preventive');
                        }
                    });
                }
            });
        });
    </script>
@endpush
