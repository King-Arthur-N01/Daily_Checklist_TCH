@extends('layouts.master')
@section('title', 'Table Machine')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Machine</h1>
            <div class="col-sm-12 col-md-12">
                <div class="dt-buttons">
                    <a type="button" class="btn btn-block btn-primary" href="{{route('addmachine')}}" tabindex="0" aria-controls="example">+ Tambah Mesin</a>
                </div>
            </div>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th>Invent Number</th>
                                <th>Nama Mesin</th>
                                <th>Brand Mesin</th>
                                <th>Type Mesin</th>
                                <th>Tonage Mesin</th>
                                <th>Install Date</th>
                                <th>MFG Number</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($machines as $machineget)
                                    <tr>
                                        <td>{{ $machineget->invent_number }}</td>
                                        <td>{{ $machineget->machine_name }}</td>
                                        <td>{{ $machineget->machine_brand }}</td>
                                        <td>{{ $machineget->machine_type }}</td>
                                        <td>{{ $machineget->machine_spec }}</td>
                                        <td>{{ $machineget->install_date }}</td>
                                        <td>{{ $machineget->mfg_number }}</td>
                                        <td>
                                            <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                {{-- <a class="dropdown-item" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a> --}}
                                                <a class="dropdown-item-custom-edit" style="text-align: center" href="{{ route('editmachine', $machineget->id) }}"><img style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}">Edit</a>
                                                <a class="dropdown-item-custom-delete" style="text-align: center" href="{{ route('deletemachine', $machineget->id) }}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">Delete</a>
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
    @endsection

    @push('style')
    @endpush

    @push('script')
        {{-- <script href="{{asset('assets/vendor/custom-js/mergecell.js')}}"></script> --}}
    @endpush
