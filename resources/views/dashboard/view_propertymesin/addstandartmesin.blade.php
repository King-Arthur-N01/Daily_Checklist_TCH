@extends('layouts.master')
@section('title', 'Tambah Property Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Checklist</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-header" width="100%">
                            <tbody>
                                <tr>
                                    <th>No. Invent Mesin :</th>
                                    <th>{{ $machines->invent_number }}</th>
                                    <th>Spec/Tonage :</th>
                                    <th>{{ $machines->machine_spec }}</th>
                                </tr>
                                <tr>
                                    <th>Nama Mesin :</th>
                                    <th>{{ $machines->machine_name }}</th>
                                    <th>Buatan :</th>
                                    <th>{{ $machines->machine_made }}</th>
                                </tr>
                                <tr>
                                    <th>Brand/Merk :</th>
                                    <th>{{ $machines->machine_brand }}</th>
                                    <th>Mfg.NO :</th>
                                    <th>{{ $machines->mfg_number }}</th>
                                </tr>
                                <tr>
                                    <th>Model/Type :</th>
                                    <th>{{ $machines->machine_type }}</th>
                                    <th>Install Date :</th>
                                    <th>{{ $machines->install_date }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <form>
                            <table class="table table-bordered" id="dataTables" width="100%">
                                <thead>
                                    <tr>
                                        <th>Bagian Yang Dicheck</th>
                                        <th>Standart/Parameter</th>
                                        <th>Metode Pengecekan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div id="inputContainer1">
                                                <div class="dynamic-input-group">
                                                    <input class="col-12" type="text" placeholder="Example : Push Button">
                                                    <button class="btn btn-success btn-circle btn-sm" id="addInputBtn1"><i class="fas fa-plus"></i></button>
                                                    <button class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this)"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="inputContainer2">
                                                <div class="dynamic-input-group">
                                                    <input class="col-12" type="text" placeholder="Example : Berfungsi dengan baik">
                                                    <button class="btn btn-success btn-circle btn-sm" id="addInputBtn2"><i class="fas fa-plus"></i></button>
                                                    <button class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this)"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="inputContainer3">
                                                <div class="dynamic-input-group">
                                                    <input class="col-12" type="text" placeholder="Example : Dioperasikan">
                                                    <button class="btn btn-success btn-circle btn-sm" id="addInputBtn3"><i class="fas fa-plus"></i></button>
                                                    <button class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this)"><i class="fas fa-trash-alt"></i></button>
                                                </div>
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
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/dynamicinput.js') }}"></script>

@endpush