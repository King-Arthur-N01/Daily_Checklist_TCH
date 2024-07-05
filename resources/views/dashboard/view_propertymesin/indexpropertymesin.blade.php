@extends('layouts.master')
@section('title', 'Tambah Property Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Bordered Table</h1>
            <div class="col-sm-12 col-md-12">
                <div class="dt-buttons">
                    <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#registerModal" tabindex="0">+ Standarisasi mesin</a>
                </div>
            </div>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="propertyTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Standart Mesin</th>
                                    <th>Jumlah Componencheck</th>
                                    <th>Jumlah Standart/Parameter</th>
                                    <th>Jumlah Metode Pengecekan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($joinproperty as $propertyget)
                                    <tr>
                                        <td>{{ $propertyget->id }}</td>
                                        <td>{{ $propertyget->name_property }}</td>
                                        <td>{{ $propertyget->componencheck_count }}</td>
                                        <td>{{ $propertyget->parameter_count }}</td>
                                        <td>{{ $propertyget->metodecheck_count }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="{{ $propertyget->id }}" data-target="#EditModal">Edit</a>
                                            <a class="btn btn-danger btn-sm" style="color:white" href="#" onclick="return confirm('Yakin Hapus?')">Delete</a>
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
        <!-- end basic table  -->
        <!-- ============================================================== -->
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Standarisasi</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="registerform" method="post">
                        <div class="form-group">
                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Standarisasi</label>
                            <div>
                                <input class="form-control form-control-user" type="text" name="name_property" placeholder="Nama Standarisasi">
                            </div>
                        </div>
                        <table class="table table-bordered" id="dynamicTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Bagian Yang Dicheck</th>
                                    <th>Standart/Parameter</th>
                                    <th>Metode Pengecekan</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr>
                                    <td id="columnContainerA_1">
                                        <div class="dynamic-input-group" id="inputContainerA_1_1">
                                            <input type="text" name="bagian_yang_dicheck[]" id="componencheck_1_1" placeholder="Example : Push Button">
                                        </div>
                                    </td>
                                    <td id="columnContainerB_1">
                                        <div class="dynamic-input-group" id="inputContainerB_1_1">
                                            <input type="text" name="standart_parameter[]" id="parameter_1_1" placeholder="Example : Berfungsi dengan baik">
                                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_1_1"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnB_1_1"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    <td id="columnContainerC_1">
                                        <div class="dynamic-input-group" id="inputContainerC_1_1">
                                            <input type="text" name="metode_pengecekan[]" id="metodecheck_1_1" placeholder="Example : Dioperasikan">
                                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_1_1"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnC_1_1"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dynamic-input-group action-buttons">
                                            <button type="button" class="btn btn-success btn-sm" id="addRowBtn">Add rows</i></button>
                                            <button type="button" class="btn btn-danger btn-sm" id="removeRowBtn">Remove Rows</i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="column-button">
                            <button type="submit" class="form-buttons">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-space btn-primary" data-toggle="modal" id="registerButton">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Register Modal-->
@endsection

@push('style')
@endpush

@push('script')
<script src="{{ asset('assets/vendor/custom-js/dynamicinput.js') }}"></script>
<script>

</script>
@endpush
