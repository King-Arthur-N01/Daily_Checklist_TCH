@extends('layouts.master')
@section('title', 'Table Tambah Metode Pengecekan Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Metode</h1>
            <div class="col-sm-12 col-md-12">
                <div class="dt-buttons">
                    <a type="button" class="btn btn-block btn-primary" href="{{route('addmethod')}}" tabindex="0" aria-controls="example">+ Tambah Metode Pengecekan Mesin</a>
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
                                <tr>
                                    <th>Nama Standarisasi Mesin</th>
                                    <th>Nama Componen Yang Dicheck</th>
                                    <th>Nama Parameter Pengecekan</th>
                                    <th>Nama Metode Pengecekan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($metodechecks as $getmetode)
                                <tr>
                                    <td>{{ $getmetode->name_property}}</td>
                                    <td>{{ $getmetode->name_componencheck}}</td>
                                    <td>{{ $getmetode->name_parameter}}</td>
                                    <td>{{ $getmetode->name_metodecheck }}</td>
                                    <td>
                                        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                {{-- <a class="dropdown-item" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a> --}}
                                                <a class="dropdown-item-custom-edit" style="text-align: center" href="{{ route('editmethod', $getmetode->id) }}"><img style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}">Edit</a>
                                                <a class="dropdown-item-custom-delete" style="text-align: center" href="{{ route('deletemethod', $getmetode->id) }}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">Delete</a>
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
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
