@extends('layouts.master')
@section('title', 'Tambah Property Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Standarisasi Checksheet Mesin</h1>
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#uploadModal" tabindex="0"><i class="bi bi-bookmark-plus-fill"></i>&nbsp; Standarisasi mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="propertyTables" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Standarisasi Mesin</th>
                                    <th>Jumlah Componencheck</th>
                                    <th>Jumlah Standart/Parameter</th>
                                    <th>Jumlah Metode Pengecekan</th>
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

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addPropertyModal">Tambahkan Secara Manual</button>
                </div>
                <div class="modal-body">
                    <form id="uploadData">
                        @csrf
                        <p>Format excel harus <mark>.xlsx</mark> selain itu tidak akan terbaca dan aturan urutan Kolom pada excel</p>
                        <p class="text-upload-header">No.<mark>|</mark>No.Invent Mesin<mark>|</mark>Nama Mesin<mark>|</mark>Brand/Merk<mark>|</mark>Model/Type<mark>|</mark>Spec/Output<mark>|</mark>No.MFG<mark>|</mark>Tahun Pembuatan<mark>|</mark>Input Daya<mark>|</mark>Buatan<mark>|</mark>Install Date<mark>|</mark>No.MFG<mark>|</mark>Keterangan<mark>|</mark>No.Mesin</p>
                        <label for="importExcel" class="table-buttons" id="customButton"><i class="fas fa-file-medical"></i>&nbsp; Select a file</label>
                        <input type="file" name="fileupload" id="importExcel" hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="uploadButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Upload Modal-->

    <!-- Register Modal -->
    <div class="modal fade" id="addPropertyModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
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
                                            <button type="button" class="btn btn-success btn-sm" id="addRowBtn">Add Rows</button>
                                            <button type="button" class="btn btn-danger btn-sm" id="removeRowBtn">Delete Rows</button>
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

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <form id="updateform" method="put">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Standarisasi</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Standarisasi</label>
                            <div>
                                <input class="form-control form-control-user" type="text" name="name_property_edit" placeholder="Nama Standarisasi">
                                <input type="hidden" name="id_property" id="property_id">
                            </div>
                        </div>
                        <table class="table table-bordered" id="dynamicEditTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Bagian Yang Dicheck</th>
                                    <th>Standart/Parameter</th>
                                    <th>Metode Pengecekan</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="editTableBody">
                                <tr>
                                    <td id="columnContainerA_1_Edit">
                                        <div class="dynamic-input-group" id="inputContainerA_1_1_Edit">
                                            <textarea type="text" class="form-control" style="height: 90px;" name="bagian_yang_dicheck[]" id="componencheck_1_1_Edit" placeholder="Example : Push Button"></textarea>
                                            <input type="hidden" name="total_user_input[]" id="userInputCount_1_Edit" value="1">
                                        </div>
                                    </td>
                                    <td id="columnContainerB_1_Edit">
                                        <div class="dynamic-input-group" id="inputContainerB_1_1_Edit">
                                            <input type="text" class="form-control form-control-user" name="standart_parameter[]" id="parameter_1_1_Edit" placeholder="Example : Berfungsi dengan baik">
                                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_1_1_Edit"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnB_1_1_Edit"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    <td id="columnContainerC_1_Edit">
                                        <div class="dynamic-input-group" id="inputContainerC_1_1_Edit">
                                            <input type="text" class="form-control form-control-user" name="metode_pengecekan[]" id="metodecheck_1_1_Edit" placeholder="Example : Dioperasikan">
                                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_1_1_Edit"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnC_1_1_Edit"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dynamic-button-group">
                                            <button type="button" class="btn btn-success btn-sm" id="addRowBtnEdit">Add Rows</button>
                                            <button type="button" class="btn btn-danger btn-sm" id="removeRowBtnEdit">Delete Rows</button>
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
    <!-- End Update Modal-->

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
    <script src="{{ asset('assets/vendor/custom-js/upload.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set automatic soft refresh table
            setInterval(function() {
                overlay.addClass('is-active');
                table.ajax.reload(null, false);
                table.on('draw.dt', function() {
                    overlay.removeClass('is-active');
                });
            }, 60000); // 60000 milidetik = 60 second

            // Ambil nilai data-id dari tombol updatemodal
            $(document).on('click', '.btn-edit[data-toggle="modal"]', function() {
                const propertyId = $(this).data('id');
                $('#property_id').val(propertyId);
            });

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#propertyTables').DataTable({
                ajax: {
                    url: '{{ route("refreshproperty") }}',
                    dataSrc: function(data) {
                        return data.getproperty.map((getproperty, index) => {
                            return {
                                no: index + 1,
                                standart_name: getproperty.name_property,
                                componencheck: getproperty.componencheck_count,
                                parameter: getproperty.parameter_count,
                                metodecheck: getproperty.metodecheck_count,
                                actions: `
                                    <a class="btn btn-primary btn-sm btn-edit" style="color:white" data-id="${getproperty.id}" data-toggle="modal" data-target="#updateModal">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="${getproperty.id}" id="deleteButton" style="color:white">Delete</a>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'standart_name' },
                    { data: 'componencheck' },
                    { data: 'parameter' },
                    { data: 'metodecheck' },
                    { data: 'actions', orderable: false, searchable: false}
                ]
            });

            $('#uploadButton').on('click', function(e) {
                e.preventDefault();
                let file = $('#importExcel')[0].files[0];
                let uploadData = new FormData();
                uploadData.append('file', file);
                $.ajax({
                    type: "POST",
                    url: "{{ route('importproperty') }}",
                    data: uploadData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                            overlay.toggleClass('is-active');
                        }
                        setTimeout(function() {
                                $('#successModal').modal('hide');
                                $('#uploadModal').modal('hide');
                                overlay.removeClass('is-active');
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
                            $('#uploadModal').modal('hide');
                        }, 2000);
                    }
                }).always(function() {
                    table.ajax.reload(null, false);
                });
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
                                    $('#addPropertyModal').modal('hide');
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
                                $('#addPropertyModal').modal('hide');
                            }, 2000);
                        }
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                } else {
                    // User cancelled the registration, do nothing
                }
            });

            $('#updateform').on('submit', function(event) {
                event.preventDefault();
                let formData = {
                    '_token': '{{ csrf_token() }}',
                    name_property: $('input[name="name_property_edit"]').val(),
                    id_property: $('input[name="id_property"]').val(),
                };

                $('#editTableBody tr').each(function(index) {
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
                        const textareaValue = $(this).val();

                        if (textareaId.startsWith(`componencheck_${rowIdSuffix}_`)) {
                            formData[dynamicArrayName].componencheck.push(textareaValue);
                        }
                    });

                    $(this).find('input').each(function() {
                        const inputId = $(this).attr('id');
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
                console.log(formData);

                if (confirm('Apakah sudah yakin mengisi data dengan benar?')) {
                    $.ajax({
                        url: '{{ route("editproperty", ":id") }}'.replace(':id', formData.id_property),
                        type: 'PUT',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                const successMessage = response.success;
                                $('#successText').text(successMessage);
                                $('#successModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#successModal').modal('hide');
                                $('#updateModal').modal('hide');
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
                                $('#updateModal').modal('hide');
                            }, 2000);
                        }
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                } else {
                    // User cancelled the update, do nothing
                }
            });

            $('#propertyTables').on('click', '.btn-delete', function(e) {
                event.preventDefault();
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addRowBtn = document.getElementById("addRowBtnEdit");
            const removeRowBtn = document.getElementById("removeRowBtnEdit");

            if (addRowBtn) {
                addRowBtn.addEventListener("click", function (event) {
                    event.preventDefault();
                    addRow();
                });
            }

            if (removeRowBtn) {
                removeRowBtn.addEventListener("click", function (event) {
                    event.preventDefault();
                    removeRow();
                });
            }

            let rowCount = 1;
            const inputCounts = {1: {A: 1, B: 1, C: 1}};

            function addRow() {
                const tableBody = document.getElementById("editTableBody");
                const newRow = tableBody.insertRow(-1);
                rowCount++;
                const rowIdSuffix = rowCount;
                inputCounts[rowIdSuffix] = {A: 1, B: 1, C: 1};

                newRow.innerHTML =`
                    <td id="columnContainerA_${rowIdSuffix}_Edit">
                        <div class="dynamic-input-group" id="inputContainerA_${rowIdSuffix}_1_Edit">
                            <textarea type="text" class="form-control" style="height: 100px;" name="bagian_yang_dicheck[]" id="componencheck_${rowIdSuffix}_1_Edit" placeholder="Example : Push Button"></textarea>
                            <input type="hidden" name="total_user_input" id="userInputCount_${rowIdSuffix}_Edit" value="1">
                        </div>
                    </td>
                    <td id="columnContainerB_${rowIdSuffix}_Edit">
                        <div class="dynamic-input-group" id="inputContainerB_${rowIdSuffix}_1_Edit">
                            <input type="text" class="form-control form-control-user" name="standart_parameter[]" id="parameter_${rowIdSuffix}_1_Edit" placeholder="Example : Berfungsi dengan baik">
                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_${rowIdSuffix}_1_Edit"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnB_${rowIdSuffix}_1_Edit"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                    <td id="columnContainerC_${rowIdSuffix}_Edit">
                        <div class="dynamic-input-group" id="inputContainerC_${rowIdSuffix}_1_Edit">
                            <input type="text" class="form-control form-control-user" name="metode_pengecekan[]" id="metodecheck_${rowIdSuffix}_1_Edit" placeholder="Example : Dioperasikan">
                            <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_${rowIdSuffix}_1_Edit"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnC_${rowIdSuffix}_1_Edit"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                    <td>
                        <div class="dynamic-button-group">
                            <button type="button" class="btn btn-success btn-sm addRowBtnEdit">Add Rows</button>
                            <button type="button" class="btn btn-danger btn-sm removeRowBtnEdit">Delete Rows</button>
                        </div>
                    </td>
                `;

                attachEventListeners(newRow, rowIdSuffix);
            }

            function attachEventListeners(row, rowIdSuffix) {
                row.querySelector(`#addColumnBtnB_${rowIdSuffix}_1_Edit`).addEventListener("click", function (event) {
                    event.preventDefault();
                    addInput(`columnContainerB_${rowIdSuffix}_Edit`, "standart_parameter[]", `parameter_${rowIdSuffix}_Edit`, "Example: Berfungsi dengan baik", rowIdSuffix, 'B');
                });

                row.querySelector(`#addColumnBtnC_${rowIdSuffix}_1_Edit`).addEventListener("click", function (event) {
                    event.preventDefault();
                    addInput(`columnContainerC_${rowIdSuffix}_Edit`, "metode_pengecekan[]", `metodecheck_${rowIdSuffix}_Edit`, "Example: Dioperasikan", rowIdSuffix, 'C');
                });

                row.querySelector(`#removeColumnBtnB_${rowIdSuffix}_1_Edit`).addEventListener("click", function (event) {
                    event.preventDefault();
                    removeInput(this, `columnContainerB_${rowIdSuffix}_Edit`);
                });

                row.querySelector(`#removeColumnBtnC_${rowIdSuffix}_1_Edit`).addEventListener("click", function (event) {
                    event.preventDefault();
                    removeInput(this, `columnContainerC_${rowIdSuffix}_Edit`);
                });

                row.querySelector(".addRowBtnEdit").addEventListener("click", function (event) {
                    event.preventDefault();
                    addRow();
                });

                row.querySelector(".removeRowBtnEdit").addEventListener("click", function (event) {
                    event.preventDefault();
                    removeRow();
                });
            }

            function removeRow() {
                const tableBody = document.getElementById("editTableBody");
                const rows = tableBody.rows;
                if (rows.length > 1) {
                    tableBody.deleteRow(-1);
                } else {
                    alert("At least one row must remain.");
                }
            }

            document.getElementById("addColumnBtnB_1_1_Edit").addEventListener("click", function (event) {
                event.preventDefault();
                addInput("columnContainerB_1_Edit", "standart_parameter[]", "parameter_1_Edit", "Example: Berfungsi dengan baik", 1, 'B');
            });

            document.getElementById("addColumnBtnC_1_1_Edit").addEventListener("click", function (event) {
                event.preventDefault();
                addInput("columnContainerC_1_Edit", "metode_pengecekan[]", "metodecheck_1_Edit", "Example: Dioperasikan", 1, 'C');
            });

            document.getElementById("removeColumnBtnB_1_1_Edit").addEventListener("click", function (event) {
                event.preventDefault();
                removeInput(this, `inputContainerB_1_1_Edit`);
            });

            document.getElementById("removeColumnBtnC_1_1_Edit").addEventListener("click", function (event) {
                event.preventDefault();
                removeInput(this, `inputContainerC_1_1_Edit`);
            });

            function addInput(containerId, inputName, inputIdPrefix, placeholder, rowIdSuffix, columnId) {
                const inputContainer = document.getElementById(containerId);
                if (!inputCounts[rowIdSuffix]) {
                    inputCounts[rowIdSuffix] = {A: 1, B: 1, C: 1};
                }
                const inputGroupCount = ++inputCounts[rowIdSuffix][columnId];
                const newInputGroup = document.createElement("div");
                newInputGroup.className = "dynamic-input-group";

                const newInput = document.createElement("input");
                newInput.type = "text";
                newInput.className = "form-control form-control-user";
                newInput.name = inputName;
                newInput.id = `${inputIdPrefix}_${inputGroupCount}`;
                newInput.placeholder = placeholder;

                const addButton = document.createElement("button");
                addButton.type = "button";
                addButton.className = "btn btn-success btn-circle btn-sm";
                addButton.innerHTML = '<i class="fas fa-plus"></i>';
                addButton.addEventListener("click", function (event) {
                    event.preventDefault();
                    addInput(containerId, inputName, inputIdPrefix, placeholder, rowIdSuffix, columnId);
                });

                const removeButton = document.createElement("button");
                removeButton.type = "button";
                removeButton.className = "btn btn-danger btn-circle btn-sm";
                removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
                removeButton.onclick = function () {
                    removeInput(this, containerId);
                };

                newInputGroup.appendChild(newInput);
                newInputGroup.appendChild(addButton);
                newInputGroup.appendChild(removeButton);
                inputContainer.appendChild(newInputGroup);

                // Increment the hidden input value
                document.getElementById(`userInputCount_${rowIdSuffix}_Edit`).value = inputGroupCount;
            }

            function removeInput(button, containerId) {
                const inputContainer = document.getElementById(containerId);
                if (inputContainer) {
                    const inputGroups = inputContainer.querySelectorAll(".dynamic-input-group");
                    if (inputGroups.length > 1) {
                        const inputGroup = button.parentNode;
                        inputGroup.parentNode.removeChild(inputGroup);

                        // Decrement the hidden input value
                        const rowIdSuffix = containerId.split('_').pop();
                        const currentCount = parseInt(document.getElementById(`userInputCount_${rowIdSuffix}_Edit`).value, 10);
                        document.getElementById(`userInputCount_${rowIdSuffix}_Edit`).value = currentCount - 1;
                    } else {
                        alert("At least one input must remain.");
                    }
                } else {
                    console.error(`Element with id "${containerId}" not found`);
                }
            }
        });
    </script>
@endpush
