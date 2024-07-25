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
                                            <a class="btn btn-danger btn-sm" id="deleteButton" data-id="{{ $propertyget->id }}" style="color:white">Delete</a>
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
        <div class="modal-dialog modal-xxl">
            <div class="modal-content">
                <form id="registerform" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Standarisasi</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    </div>
                    <div class="modal-body">
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
                                            <textarea type="text" class="form-control" style="height: 90px;" name="bagian_yang_dicheck[]" id="componencheck_1_1" placeholder="Example : Push Button"></textarea>
                                            <input type="hidden" name="total_user_input[]" id="userInputCount_1" value="1">
                                        </div>
                                    </td>
                                    <td id="columnContainerB_1">
                                        <div class="dynamic-input-group" id="inputContainerB_1_1">
                                            <input type="text" class="form-control form-control-user" name="standart_parameter[]" id="parameter_1_1" placeholder="Example : Berfungsi dengan baik">
                                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_1_1"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnB_1_1"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    <td id="columnContainerC_1">
                                        <div class="dynamic-input-group" id="inputContainerC_1_1">
                                            <input type="text" class="form-control form-control-user" name="metode_pengecekan[]" id="metodecheck_1_1" placeholder="Example : Dioperasikan">
                                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_1_1"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnC_1_1"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dynamic-button-group">
                                            <button type="button" class="btn btn-success btn-sm" id="addRowBtn">Add Rows</i></button>
                                            <button type="button" class="btn btn-danger btn-sm" id="removeRowBtn">Delete Rows</i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                    </div>
                </form>
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
        var formData = {
            '_token': '{{ csrf_token() }}',
            name_property : $('input[name="name_property"]').val(),
        };

        $('#tableBody tr').each(function(index) {
            const rowIdSuffix = $(this).find('td:first-child').attr('id').split('_')[1];
            const dynamicArrayName = `dataRows_${rowIdSuffix}`;
            if (!formData[dynamicArrayName]) {
                formData[dynamicArrayName] = {
                    componencheck: [],
                    parameter: [],
                    metodecheck: []
                };
            }

            $(this).find('textarea').each(function() {
                const textareaId = $(this).attr('id');
                const textareaName = $(this).attr('name');
                const textareaValue = $(this).val();

                if (textareaId.startsWith(`componencheck_${rowIdSuffix}_`)) {
                    formData[dynamicArrayName].componencheck.push(textareaValue);
                }
            });
            $(this).find('input').each(function() {
                const inputId = $(this).attr('id');
                const inputName = $(this).attr('name');
                const inputValue = $(this).val();

                if (inputId.startsWith(`parameter_${rowIdSuffix}_`)) {
                    formData[dynamicArrayName].parameter.push(inputValue);
                } else if (inputId.startsWith(`metodecheck_${rowIdSuffix}_`)) {
                    formData[dynamicArrayName].metodecheck.push(inputValue);
                } else if (inputId.startsWith(`userInputCount_${rowIdSuffix}`)) {
                    formData[dynamicArrayName].user_input_count = inputValue;
                }
            });
        });
        if (confirm('Apakah sudah yakin mengisi data dengan benar?')) {
            $.ajax({
                url: '{{ route("registerproperty") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        const successMessage = response.success;
                        $('#successText').text(successMessage);
                        $('#successModal').modal('show');

                    }
                    $('#registerModal').modal('hide'); // Hide modal on success
                },
                error: function(xhr, status, error) {
                    var warningMessage = xhr.responseText;
                    try {
                        warningMessage = JSON.parse(xhr.responseText).error;
                    } catch (e) {
                        console.error('Error parsing error message:',e);
                    }
                    $('#failedText').text(
                        warningMessage); // Set the error message in the modal
                    $('#failedModal').modal('show'); // Show error modal
                        console.error('Error saving machine record: ' + error);
                    $('#editModal').modal('hide'); // Hide modal on error
                }
            }).always(function() {
                setTimeout(function() {
                    location.reload(); // Refresh the page after a 2-second delay
                }, 2000); // 2000 milliseconds = 2 seconds
            });
        } else {
            // User cancelled the deletion, do nothing
        }
    });
    $(document).on('click', '#deleteButton', function(e) {
        e.preventDefault();
        var propertyId = $(this).data("id");
        if (confirm("Apakah yakin menghapus standarisasi ini?")) {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('removeproperty', ':id') }}".replace(':id', propertyId),
                data: {
                    '_token': '{{ csrf_token() }}'
                }
            }).done(function(response) {
                if (response.success) {
                    alert('Standarisasi berhasil dihapus.'); // Alert success message
                } else {
                    alert('Error: Standarisasi gagal dihapus!.'); // Alert failure message
                }
                $('#ExtralargeModal').modal('hide');
            }).fail(function(xhr, status, error) {
                alert('This PROPERTY has been deleted by someone!'); // Alert error message
            }).always(function() {
                setTimeout(function() {
                    location.reload();
                }, 2000);
            });
        } else {
            // User cancelled the deletion, do nothing
        }
    });
});
</script>
@endpush
