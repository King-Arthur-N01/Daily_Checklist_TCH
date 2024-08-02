@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tambah Data Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card card-filter collapse" id="filterCard">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="col-4">
                                <p class="mg-b-10">Nama Mesin</p>
                                <input class="form-control" name="" id="filterByName">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Nomor Mesin </p>
                                <input class="form-control" name="" id="filterById">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Standarisasi Mesin</p>
                                <select class="form-control select2" name="sample" id="filterByProperty">
                                    <option selected="selected">Select :</option>
                                    <option><i class="fas fa-check-circle"></i>Sudah Dipreventive</option>
                                    <option>Belum Dipreventive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#uploadModal"><i class="fas fa-clipboard-check"></i>&nbsp; Tambah Checksheet Mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    <div class="spinner-border" id="loading_screen" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="importTables" width="100%">
                            <thead>
                                <th>NO. INVENT</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND/MERK</th>
                                <th>STANDARISASI</th>
                                <th>ACTION</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal" id="addButtton">Tambahkan Secara Manual</button>
                </div>
                <div class="modal-body">
                    <form id="formData">
                        @csrf
                        <p>Format excel harus <mark>.xlsx</mark> selain itu tidak akan terbaca dan aturan urutan Kolom pada excel</p>
                        <p class="text-upload-header">No.<mark>|</mark>No.Invent Mesin<mark>|</mark>No.Mesin<mark>|</mark>Nama Mesin<mark>|</mark>Brand/Merk<mark>|</mark>Model/Type<mark>|</mark>Spec/Tonnage<mark>|</mark>Buatan<mark>|</mark>MFG No.<mark>|</mark>Install Date</p>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_add">
                </div>
                <div class="modal-body" id="modal_data_add">
                </div>
                <div class="modal-footer" id="modal_button_add">
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Modal-->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_edit">
                </div>
                <div class="modal-body" id="modal_data_edit">
                </div>
                <div class="modal-footer" id="modal_button_edit">
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal-->

    <!-- View Machine Property Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_view">
                </div>
                <div class="modal-body" id="modal_data_view">
                </div>
                <div class="modal-footer" id="modal_button_view">
                </div>
            </div>
        </div>
    </div>
    <!-- End View Machine Property Modal-->

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/upload.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function showLoading() {
                $('#loading_screen').show();
            }

            // Hide the loading overlay after the data is loaded
            function hideLoading() {
                $('#loading_screen').hide();
            }

            // sett automatic soft refresh table
            setInterval(function() {
                table.ajax.reload(null, false);
            }, 60000); // 60000 milidetik = 60 second/ 1 menit

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#importTables').DataTable({
                ajax: {
                    url: '{{ route("refreshimport") }}',
                    dataSrc: function(data) {
                        // Sesuaikan data yang akan digunakan oleh DataTables
                        return data.refreshmachine.map(function(refreshmachine) {
                            let refreshproperty = data.refreshproperty.find(function(property) {
                                return property.id === refreshmachine.id_property;
                            });
                            return {
                                invent_number: refreshmachine.invent_number,
                                machine_name: refreshmachine.machine_name,
                                machine_type: refreshmachine.machine_type,
                                machine_brand: refreshmachine.machine_brand,
                                name_property: refreshproperty ? refreshproperty.name_property : 'Belum ada standarisasi',
                                actions: `
                                    <div class="dynamic-button-group">
                                        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item-custom-detail" id="viewButton" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#viewModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                            <a class="dropdown-item-custom-edit" id="editButton" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                            <a class="dropdown-item-custom-delete" id="deleteButton" data-id="${refreshmachine.id}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                        </div>
                                    </div>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'invent_number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_brand' },
                    { data: 'name_property' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            //fungsi upload button untuk upload mesin
            $('#uploadButton').on('click', function(e) {
                e.preventDefault();
                let file = $('#importExcel')[0].files[0];
                let formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    type: "POST",
                    url: "{{ route('uploadfile') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        setTimeout(function() {
                                $('#successModal').modal('hide');
                                $('#addModal').modal('hide');
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseText) {
                            const warningMessage = xhr.responseText;
                            $('#failedText').text(warningMessage);
                            $('#failedModal').modal('show');
                        }
                        setTimeout(function() {
                            $('#failedModal').modal('hide');
                            $('#addModal').modal('hide');
                        }, 20000);
                    }
                }).always(function() {
                    table.ajax.reload(null, false);
                });
            });

            $('#addModal').on('shown.bs.modal', function(event) {
                const header_modal = `
                    <h5 class="modal-title">Standarisasi Mesin</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                `;
                const data_modal = `
                    <form id="addForm" method="post">
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Invent</label>
                                    <div>
                                        <input style="text-transform: uppercase;" class="form-control" id="inventNumber" type="text" name="invent_number" placeholder="_-__-__-____">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_name" placeholder="Nama Mesin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_brand" placeholder="Brand/Merk Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Model/Type Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_type" placeholder="Model/Type Mesin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_spec" placeholder="Spec/Tonnage">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_made" placeholder="Buatan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                    <div>
                                        <input class="form-control" type="text" name="mfg_number" placeholder="MFG Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                    <div>
                                        <input class="form-control" type="text" name="install_date" placeholder="Install Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">No Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_number" placeholder="Nomor Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
                const button_modal = `
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
                `;
                $('#modal_title_add').html(header_modal);
                $('#modal_data_add').html(data_modal);
                $('#modal_button_add').html(button_modal);
                $('#inventNumber').mask('a-aa-99-9999');
                // definisi deklarasi mask =
                //     '9': "[0-9]",
                //     'a': "[A-Za-z]",
                //     '*': "[A-Za-z0-9]"

                // Add event listener to save button
                $('#saveButton').on('click', function() {
                    let formData = {
                        inventNumber: $('input[name="invent_number"]').val(),
                        machineSpec: $('input[name="machine_spec"]').val(),
                        machineName: $('input[name="machine_name"]').val(),
                        machineMade: $('input[name="machine_made"]').val(),
                        machineBrand: $('input[name="machine_brand"]').val(),
                        mfgNumber: $('input[name="mfg_number"]').val(),
                        machineType: $('input[name="machine_type"]').val(),
                        installDate: $('input[name="install_date"]').val(),
                        machineNumber: $('input[name="machine_number"]').val()
                    };
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("addmachine") }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'invent_number': formData.inventNumber,
                            'machine_spec': formData.machineSpec,
                            'machine_name': formData.machineName,
                            'machine_made': formData.machineMade,
                            'machine_brand': formData.machineBrand,
                            'mfg_number': formData.mfgNumber,
                            'machine_type': formData.machineType,
                            'install_date': formData.installDate,
                            'machine_number': formData.machineNumber,
                        },
                        success: function(response) {
                            if (response.success) {
                                const successMessage = response.success;
                                $('#successText').text(successMessage);
                                $('#successModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#successModal').modal('hide');
                                $('#addModal').modal('hide');
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseText) {
                                const warningMessage = xhr.responseText;
                                $('#failedText').text(warningMessage);
                                $('#failedModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#failedModal').modal('hide');
                                $('#addModal').modal('hide');
                            }, 20000);
                        }
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                });
            });

            // fungsi untuk mengedit atau menambahkan standarisasi ke mesin
            $('#editModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const machineId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readmachineproperty", ':id') }}'.replace(':id', machineId),
                    success: function(data) {
                        let options = '';
                        if (Array.isArray(data.fetchproperty)) {
                            $.each(data.fetchproperty, function(index, fetchtable) {
                                const isSelected = fetchtable.id == data.fetchmachine.id_property ? 'selected' : '';
                                options += `<option value="${fetchtable.id}" ${isSelected}>${fetchtable.name_property}</option>`;
                            });
                        } else {
                            console.error('fetchproperty is not an array:', data.fetchproperty);
                        }

                        const header_modal = `
                            <h5 class="modal-title">Edit Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Invent</label>
                                        <div>
                                            <input style="text-transform: uppercase;" class="form-control" id="inventNumber" type="text" name="invent_number" value="${data.fetchmachine.invent_number}" placeholder="_-__-__-____">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_name" value="${data.fetchmachine.machine_name}" placeholder="Nama Mesin">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_brand" value="${data.fetchmachine.machine_brand}" placeholder="Brand/Merk Mesin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Model/Type Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_type" value="${data.fetchmachine.machine_type}" placeholder="Model/Type Mesin">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_spec" value="${data.fetchmachine.machine_spec}" placeholder="Spec/Tonnage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_made" value="${data.fetchmachine.machine_made}" placeholder="Buatan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                        <div>
                                            <input class="form-control" type="text" name="mfg_number" value="${data.fetchmachine.mfg_number}" placeholder="MFG Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                        <div>
                                            <input class="form-control" type="text" name="install_date" value="${data.fetchmachine.install_date}" placeholder="Install Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">No Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_number" value="${data.fetchmachine.machine_number}" placeholder="Nomor Mesin">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <table class="table table-bordered" id="editTables" width="100%">
                                <thead>
                                    <th>Standarisasi Mesin</th>
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <select class="form-control select2" id="getproperty">
                                                <option value="">Tidak ada</option>
                                                ${options}
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
                        `;
                        $('#modal_title_edit').html(header_modal);
                        $('#modal_data_edit').html(data_modal);
                        $('#modal_button_edit').html(button_modal);

                        // Save button
                        $('#saveButton').on('click', function() {
                            // let idProperty = $('#getproperty').val();
                            let formData = {
                                inventNumber: $('input[name="invent_number"]').val(),
                                machineSpec: $('input[name="machine_spec"]').val(),
                                machineName: $('input[name="machine_name"]').val(),
                                machineMade: $('input[name="machine_made"]').val(),
                                machineBrand: $('input[name="machine_brand"]').val(),
                                mfgNumber: $('input[name="mfg_number"]').val(),
                                machineType: $('input[name="machine_type"]').val(),
                                installDate: $('input[name="install_date"]').val(),
                                machineNumber: $('input[name="machine_number"]').val(),
                                idProperty : $('#getproperty').val()
                            };
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("updatemachine", ':id') }}'.replace(':id', machineId),
                                data: {
                                    '_token': '{{ csrf_token() }}', // Include the CSRF token
                                    'invent_number': formData.inventNumber,
                                    'machine_spec': formData.machineSpec,
                                    'machine_name': formData.machineName,
                                    'machine_made': formData.machineMade,
                                    'machine_brand': formData.machineBrand,
                                    'mfg_number': formData.mfgNumber,
                                    'machine_type': formData.machineType,
                                    'install_date': formData.installDate,
                                    'machine_number': formData.machineNumber,
                                    'id_property': formData.idProperty
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#editModal').modal('hide');
                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                        const warningMessage = xhr.responseText;
                                        $('#failedText').text(warningMessage);
                                        $('#failedModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#failedModal').modal('hide');
                                        $('#editModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });

            //fungsi button get detail mesin
            $('#viewModal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let machineId = button.data('id');
                // var no_mesin = $("#viewButton")$(this).attr("data-id");
                $.ajax({
                    type: 'GET',
                    url: '{{ route("detailproperty", ':id') }}'.replace(':id', machineId),
                    success: function(data) {
                        if (!data || !data.fetchmachines || data.fetchmachines.length === 0) {
                            $('#modal_data_view').html(
                                '<h4 style="text-align: center;">Error data property mesin belum tersedia!</h4>'
                            );
                        } else {
                            const machine = data.fetchmachines[0];
                            const header_modal = `
                                <h5 class="modal-title">Detail Preventive Mesin</h5>
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                            `;
                            const data_modal = `
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No. Invent Mesin :</th>
                                        <td>${machine.invent_number}</td>
                                        <th>Spec/Tonage :</th>
                                        <td>${machine.machine_spec}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Mesin :</th>
                                        <td>${machine.machine_name}</td>
                                        <th>Buatan :</th>
                                        <td>${machine.machine_made}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand/Merk :</th>
                                        <td>${machine.machine_brand}</td>
                                        <th>Mfg.NO :</th>
                                        <td>${machine.mfg_number}</td>
                                    </tr>
                                    <tr>
                                        <th>Model/Type :</th>
                                        <td>${machine.machine_type}</td>
                                        <th>Install Date :</th>
                                        <td>${machine.install_date}</td>
                                    </tr>
                                </table>
                                <h5>Standart Mesin</h5>
                                <table class="table table-bordered" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Nama Mesin</th>
                                            <th>Bagian Yang Dicheck</th>
                                            <th>Standart/Parameter</th>
                                            <th>Metode Pengecekan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    ${data.fetchmachines.map(machine => `
                                            <tr>
                                                <td>${machine.machine_name}</td>
                                                <td>${machine.name_componencheck}</td>
                                                <td>${machine.name_parameter}</td>
                                                <td>${machine.name_metodecheck}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            `;
                            const button_modal = `
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-id="${machineId}" id="printButton">Print Mesin</button>
                            `;
                            $('#modal_title_view').html(header_modal);
                            $('#modal_data_view').html(data_modal);
                            $('#modal_button_view').html(button_modal);
                            mergeCells();

                            // Add event listener to print button
                            $('#printButton').on('click', function() {
                                new_url_pdf = '{{ route("exportfile", ':id') }}'.replace(':id', machineId);
                                window.open(new_url_pdf, '_blank');
                                return;
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });

            // fungsi delete button untuk hapus mesin
            $('#importTables').on('click', '.dropdown-item-custom-delete', function(e) {
                e.preventDefault();
                const button = $(this);
                const machineId = button.data('id');
                if (confirm("Apakah yakin menghapus mesin ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route("removemachine", ':id') }}'.replace(':id', machineId),
                        data: {
                            '_token': '{{ csrf_token() }}'
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

            //fungsi filter button
            $('#filterButton').on('click', function() {
                const filterCard = $('#filterCard');
                filterCard.collapse('toggle');
            });
        });
    </script>
@endpush
