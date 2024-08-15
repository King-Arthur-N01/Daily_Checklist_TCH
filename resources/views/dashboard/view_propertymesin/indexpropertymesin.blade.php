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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="propertyTables" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Standarisasi Mesin</th>
                                    <th>Nama Mesin</th>
                                    <th>Nomor Mesin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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

    <!-- Alert Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <span id="successText" class="modal-alert"></span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Success Modal -->

    <!-- Alert Danger Modal -->
    <div class="modal fade" id="failedModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <span id="failedText" class="modal-alert"></span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Danger Modal -->

    <!-- Alert Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <span id="warningText" class="modal-alert"></span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Warning Modal -->
@endsection

@push('style')
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/dynamicinput.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set automatic soft refresh table
            setInterval(function() {
                overlay.addClass('is-active');
                table.ajax.reload(null, false);
                table.on('draw.dt', function() {
                    overlay.removeClass('is-active');
                });
            }, 30000); // 30000 milidetik = 30 second

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#propertyTables').DataTable({
                ajax: {
                    url: '{{ route("refreshproperty") }}',
                    dataSrc: function(data) {
                        return data.joinproperty.map((joinproperty, index) => {
                            return {
                                no: index + 1,
                                standart_name: joinproperty.name_property,
                                machine_name: joinproperty.machine_name,
                                machine_number: joinproperty.machine_number,
                                actions: `
                                    <a class="btn btn-primary btn-sm" style="color:white" data-id="${joinproperty.id}" data-toggle="modal" data-target="#EditModal">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="${joinproperty.id}" id="deleteButton" style="color:white">Delete</a>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'standart_name' },
                    { data: 'machine_name' },
                    { data: 'machine_number' },
                    { data: 'actions', orderable: false, searchable: false}
                ]
            });

            $('#registerform').on('submit', function(event) {
                event.preventDefault();
                let formData = {
                    '_token': '{{ csrf_token() }}',
                    name_property: $('input[name="name_property"]').val(),
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
                        url: '{{ route("addproperty") }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                const successMessage = response.success;
                                $('#successText').text(successMessage);
                                $('#successModal').modal('show');
                            }
                            setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    $('#registerModal').modal('hide');
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseText) {
                                const warningMessage = JSON.parse(xhr.responseText).error;
                                $('#failedText').text(warningMessage);
                                $('#failedModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#failedModal').modal('hide');
                                $('#registerModal').modal('hide');
                            }, 20000);
                        }
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                } else {
                    // User cancelled the deletion, do nothing
                }
            });

            $('#propertyTables').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const button = $(this);
                const propertyId = button.data('id');
                if (confirm("Apakah yakin menghapus standarisasi ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route("removeproperty", ':id') }}'.replace(':id', propertyId),
                        data: {
                            '_token': '{{ csrf_token() }}',
                        }
                    }).done(function(response) {
                        if (response.success.trim()) {
                            const successMessage = response.success.trim();
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        setTimeout(function() {
                                $('#successModal').modal('hide'); // Hide success modal
                        }, 2000);
                    }).fail(function(xhr, status, error) {
                        console.error(xhr.responseText);
                        const warningMessage = JSON.parse(xhr.responseText).error;
                        $('#failedText').text(warningMessage);
                        $('#failedModal').modal('show');
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                } else {
                    // User cancelled the deletion, do nothing
                }
            });
        });
    </script>
@endpush
