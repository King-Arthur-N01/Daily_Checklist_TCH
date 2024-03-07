@extends('layouts.master')
@section('title', 'Preventive mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="custom-card-table col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-top">
                <div class="az-content-label mg-b-5">Bordered Table</div>
                <p class="mg-b-20">Add borders on all sides of the table and cells.</p>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success')}}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Invent Number</th>
                                    <th>Name Machine</th>
                                    <th>Type Machine</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($machinerecords as $recordget)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a class="button-table-custom-action dropdown" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2"><a class="button-table-custom-view" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                                <a class="button-table-custom-edit" href="#"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></a>
                                                <a class="button-table-custom-delete" href="#" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}"></a>
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
    </div>
    <!-- ============================================================== -->
    <!-- end data table  -->
    <!-- ============================================================== -->
    </div>
@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/datatables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/datatables/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/datatables/css/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/datatables/css/select.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/datatables/css/fixedHeader.bootstrap4.css')}}">
@endpush

@push('script')
    <script src="{{asset('assets/lib/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/ajax/jszip.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/ajax/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/data-table.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
@endpush
