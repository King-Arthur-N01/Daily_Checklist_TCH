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
                                <select class="form-control select2" name="" id="filterByName">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <select class="form-control select2" name="" id="filterById">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="importTables" width="100%">
                            <thead>
                                <th>Nomor Invent</th>
                                <th>Nama Mesin</th>
                                <th>Brand/Merk</th>
                                <th>Model/Type</th>
                                <th>Standarisasi</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (isset($machines) && !empty($machines))
                                    @foreach ($machines as $machineget)
                                        <tr>
                                            <td>{{ $machineget->invent_number }}</td>
                                            <td>{{ $machineget->machine_name }}</td>
                                            <td>{{ $machineget->machine_brand }}</td>
                                            <td>{{ $machineget->machine_type }}</td>
                                            @if (empty($machineget->id_property))
                                                <td>Belum ada standarisasi</td>
                                            @else
                                                <td data-id="{{ $machineget->id_property }}">{{ $machineget->id_property }}</td>
                                            @endif
                                            <td>
                                                <div class="dynamic-button-group">
                                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item-custom-detail" id="viewButton" data-toggle="modal" data-id="{{ $machineget->id }}" data-target="#viewModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                                        <a class="dropdown-item-custom-edit" id="editButton" data-toggle="modal" data-id="{{ $machineget->id }}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                                        <a class="dropdown-item-custom-delete" id="deleteButton" data-id="{{ $machineget->id }}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No data found.</td>
                                    </tr>
                                @endif
                            </tbody>
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
        <div class="modal-dialog modal-lg">
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
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/upload.js') }}"></script>
    <script>
        $(document).ready(function() {
            //fungsi fillter header table
            $('#importTables').DataTable({ // Disable sorting for columns
                columnDefs: [{
                    "orderable": false,
                    "targets": [5]
                }]
            });
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //fungsi upload button untuk upload mesin
            $('#uploadButton').on('click', function(e) {
                e.preventDefault();
                var file = $('#importExcel')[0].files[0];
                var formData = new FormData();
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
                        $('#ExtralargeModal').modal('hide');
                    },
                    error: function(status, error, response) {
                        if (response.error) {
                            const warningMessage = response.error;
                            $('#failedText').text(warningMessage);
                            $('#failedModal').modal('show');
                        }
                        $('#uploadModal').modal('hide');
                    }
                }).always(function() {
                    setTimeout(function() {
                        location.reload(); // Refresh the page after a 2-second delay
                    }, 2000); // 2000 milliseconds = 2 seconds
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
                                        <input class="form-control" type="text" name="invent_number" placeholder="Invent Number">
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

                // Add event listener to save button
                $('#saveButton').on('click', function() {
                    var formData = {
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
                                $('#successModal').modal('show'); // Show success modal
                            }
                            $('#addModal').modal('hide'); // Hide modal on success
                        },
                        error: function(xhr, status, error) {
                            var warningMessage = xhr.responseText;
                            try {
                                warningMessage = JSON.parse(xhr.responseText).error;
                            } catch (e) {
                                console.error('Error parsing error message:',e);
                            }
                            $('#addModal').modal('hide'); // Hide modal on error
                        }
                    }).always(function() {
                        setTimeout(function() {
                            location.reload(); // Refresh the page after a 2-second delay
                        }, 2000); // 2000 milliseconds = 2 seconds
                    });
                });
            });

            // fungsi untuk mengedit atau menambahkan standarisasi ke mesin
            $('#editModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const machineId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("fetchviewproperty", ':id') }}'.replace(':id', machineId),
                    success: function(data) {
                        let options = '';
                        if (Array.isArray(data.fetchproperty)) {
                            $.each(data.fetchproperty, function(index, fetchtable) {
                                options += `<option value="${fetchtable.id}">${fetchtable.name_property}</option>`;
                            });
                        } else {
                            console.error('fetchproperty is not an array:', data.fetchproperty);
                        }

                        const header_modal = `
                            <h5 class="modal-title">Standarisasi Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <table class="table table-bordered" id="importTables" width="100%">
                                <thead>
                                    <th>Nomor Invent</th>
                                    <th>Nama Mesin</th>
                                    <th>Brand/Merk</th>
                                    <th>Model/Type</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${data.fetchmachine.invent_number}</td>
                                        <td>${data.fetchmachine.machine_name}</td>
                                        <td>${data.fetchmachine.machine_brand}</td>
                                        <td>${data.fetchmachine.machine_type}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Standarisasi</th>
                                    </tr>
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
                            var idProperty = $('#getproperty').val();
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("fetchdataproperty", ':id') }}'.replace(':id', machineId),
                                data: {
                                    '_token': '{{ csrf_token() }}', // Include the CSRF token
                                    'id_property': idProperty
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show'); // Show success modal
                                    }
                                    $('#ExtralargeModal').modal('hide'); // Hide modal on success
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
                                    location.reload();
                                }, 2000);
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
                var button = $(event.relatedTarget);
                var machineId = button.data('id');
                // var no_mesin = $("#viewButton")$(this).attr("data-id");
                $.ajax({
                    type: 'GET',
                    url: '{{ route("fetchdetailproperty", ':id') }}'.replace(':id', machineId),
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
            $('.dropdown-item-custom-delete').on('click', function(e) {
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
                        $('#successModal').modal('hide');
                    }).fail(function(xhr, status, error) {
                        console.error(xhr.responseText);
                        const warningMessage = xhr.statusText;
                        $('#failedText').text(warningMessage);
                        $('#failedModal').modal('show');
                    }).always(function() {
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    });
                } else {
                    // User cancelled the deletion, do nothing
                }
            });

            // fungsi get status standarisasi mesin melalui ajax
            var table = $('#importTables').DataTable();
            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var row = this.node();
                var idCell = $(row).find('td').eq(4);
                var id = idCell.data('id');
                if (id) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('fetchtableproperty', ':id') }}'.replace(':id', id),
                        success: function(data) {
                            if (data.name_property) {
                                idCell.text(data.name_property);
                            } else {
                                idCell.text('Belum ada standarisasi');
                            }
                        },
                        error: function() {
                            idCell.text('Error fetching name');
                        }
                    });
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
