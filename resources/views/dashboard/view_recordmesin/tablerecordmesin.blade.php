@extends('layouts.master')
@section('title', 'Preventive mesin')

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
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%">
                            <thead>
                                <th>CHECKPOINT NO</th>
                                <th>MACHINE NAME</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                <th>MFG NUMBER</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($machines as $machineget)
                                <tr>
                                    <td>{{$machineget->invent_number}}</td>
                                    <td>{{$machineget->machine_name}}</td>
                                    <td>{{$machineget->machine_type}}</td>
                                    <td>{{$machineget->machine_brand}}</td>
                                    <td>{{$machineget->mfg_number}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" style="color:white" href="{{route('indexuserinput',$machineget->id)}}"><img style="height: 20px" src="{{asset('assets/icons/edit_white_table.png')}}"></a>
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
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/select.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css')}}"> --}}
@endpush

@push('script')
    {{-- <script src="{{asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/ajax/jszip.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/ajax/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/data-table.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script> --}}
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    </script>
@endpush
