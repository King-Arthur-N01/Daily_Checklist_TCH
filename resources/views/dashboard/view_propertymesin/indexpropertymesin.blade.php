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
                                                <input class="col-12" type="text" name="bagian_yang_dicheck[]" placeholder="Example : Push Button">
                                                <a class="btn btn-success btn-circle btn-sm" id="addInputBtn1"><i class="fas fa-plus"></i></a>
                                                <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainer1')"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div id="inputContainer2">
                                            <div class="dynamic-input-group">
                                                <input class="col-12" type="text" name="standart_parameter[]" placeholder="Example : Berfungsi dengan baik">
                                                <a class="btn btn-success btn-circle btn-sm" id="addInputBtn2"><i class="fas fa-plus"></i></a>
                                                <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainer2')"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div id="inputContainer3">
                                            <div class="dynamic-input-group">
                                                <input class="col-12" type="text" name="metode_pengecekan[]" placeholder="Example : Dioperasikan">
                                                <a class="btn btn-success btn-circle btn-sm" id="addInputBtn3"><i class="fas fa-plus"></i></a>
                                                <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainer3')"><i class="fas fa-trash-alt"></i></a>
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
    $(document).ready(function() {
        $('#registerform').on('submit', function(event) {
            event.preventDefault();
            // Serialize each group of dynamic inputs separately
            var bagianYangDicheck = $("input[name='bagian_yang_dicheck[]']").map(function() {return $(this).val();}).get();
            var standartParameter = $("input[name='standart_parameter[]']").map(function() {return $(this).val();}).get();
            var metodePengecekan = $("input[name='metode_pengecekan[]']").map(function() {return $(this).val();}).get();
            // Prepare the data to be sent
            var formData = {
                '_token': '{{ csrf_token() }}',
                name_property : $('input[name="name_property"]').val(),
                bagian_yang_dicheck : bagianYangDicheck,
                standart_parameter : standartParameter,
                metode_pengecekan : metodePengecekan
            };
            $.ajax({
                url: '{{ route("registerproperty") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success
                    console.log(response);
                    alert('Data submitted successfully');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                    alert('Failed to submit data');
                }
            });
        });
    });
</script>
@endpush
