@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tambah Checklist Machine</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
            <div class="card-body">
                <form>
                    <div class="col-sm-6 col-md-6">
                        <input type="file" id="myFile" hidden accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <label for="myFile" class="table-buttons" id="customButton"><i class="fas fa-file-medical"></i>&nbsp; Select a file</label>
                        {{-- <input type="file" class="table-buttons" id="fileupload" name="fileupload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" /> --}}
                    </div>
                </form>
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                            <thead>
                                <th>Nama Mesin</th>
                                <th>Bagian Yang Dicheck</th>
                                <th>Standart/Parameter</th>
                                <th>Metode Pengecekan</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                {{-- @foreach ($machines as $machineget)
                                    <tr>
                                        <td>{{$machineget->machine_name}}</td>
                                        <td>{{$machineget->name_componencheck}}</td>
                                        <td>{{$machineget->name_parameter}}</td>
                                        <td>{{$machineget->name_metodecheck}}</td>
                                        <td>
                                            <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                                    <a class="dropdown-item-custom-edit" style="text-align: center" href="{{ route('editmachine', $machineget->id) }}"><img style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}">Edit</a>
                                                    <a class="dropdown-item-custom-delete" style="text-align: center" href="{{ route('deletemachineresults', $machineget->id) }}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">Delete</a>
                                                </div>
                                            </td>
                                    </tr>
                                @endforeach --}}
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
@endpush

@push('script')
    <script src="{{asset('assets/vendor/custom-js/upload.js')}}"></script>
    {{-- <script src="{{asset('assets/vendor/custom-js/mergecell.js')}}"></script> --}}
@endpush
