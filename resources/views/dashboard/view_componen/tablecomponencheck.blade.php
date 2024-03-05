@extends('layouts.master')
@section('title', 'Table Tambah Checkpoint Komponen Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="custom-card-table col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
            <div class="table-top">
                <div class="az-content-label mg-b-5">Bordered Table</div>
                <p class="mg-b-20">Add borders on all sides of the table and cells.</p>
                <div class="col-sm-10 col-md-10">
                    <div class="dt-buttons">
                        <a type="button" class="btn btn-block btn-primary" href="{{ route('addcomponencheck') }}" tabindex="0" aria-controls="example">+ Tambah Bagian Checkpoint Mesin</a>
                    </div>
                </div>
                <div class="card-body col-10">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama Mesin</th>
                                    <th>Brand/Merk Mesin</th>
                                    <th>Nama Check Componen</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($machines as $machineget)
                                    <tr>
                                        <td>{{ $machineget->machine_name }}</td>
                                        <td>{{ $machineget->machine_brand }}</td>
                                        <td>{{ $machineget->name_componencheck }}</td>
                                        <td>
                                            <a class="button-table-custom-action dropdown" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu" aria-labelled by="navbarDropdownMenuLink2">
                                                <a class="button-table-custom-view" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                                <a class="button-table-custom-edit" href="{{ route('editcomponencheck', $machineget->id) }}"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></a>
                                                <a class="button-table-custom-delete" href="{{ route('deletecomponencheck', $machineget->id) }}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}"></a>
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
@endpush

@push('script')
@endpush
