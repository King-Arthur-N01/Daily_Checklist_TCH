@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tambah Data Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-filter" id="filterCard" style="display: none;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="dataTables_filter col-4" id="dataTable_filter">
                                <p class="mg-b-10">Input Nama Mesin</p>
                                <input class="form-control" id="searchInput" type="search" aria-controls="dataTable" placeholder="Search here"></input>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <select class="form-control select2" name="" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Hari/Bulan/Tahun </p>
                                <div class="wd-250 mg-b-20">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="datetimepicker" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header py-3">
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
                                                <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item-custom-detail" data-toggle="modal" data-id="{{ $machineget->id }}" data-target="#ExtralargeModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                                    <a class="dropdown-item-custom-edit" data-toggle="modal" data-id="{{ $machineget->id }}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                                    <a class="dropdown-item-custom-delete" id="deleteButton" data-id="{{ $machineget->id }}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
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
    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_view">
                </div>
                <div class="modal-body" id="modal_data_view">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
@endpush

@push('script')
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
                        $('#ExtralargeModal').modal('hide');
                    }
                }).always(function() {
                    setTimeout(function() {
                        location.reload(); // Refresh the page after a 2-second delay
                    }, 2000); // 2000 milliseconds = 2 seconds
                });
            });
            $('#editModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("fetchdataproperty", ':id') }}'
                        .replace(':id', id),
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
                                    <th>Standarisasi</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${data.fetchmachine.invent_number}</td>
                                        <td>${data.fetchmachine.machine_name}</td>
                                        <td>${data.fetchmachine.machine_brand}</td>
                                        <td>${data.fetchmachine.machine_type}</td>
                                        <td>
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
                            <button type="submit" class="btn btn-primary" id="propertyButton">Save changes</button>
                        `;
                        $('#modal_title_edit').html(header_modal);
                        $('#modal_data_edit').html(data_modal);
                        $('#modal_button_edit').html(button_modal);
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });
            // fungsi delete button untuk hapus mesin
            $('#deleteButton').on('click', function(e) {
                e.preventDefault();
                var machineId = $(this).attr("data-id");
                if (confirm("Apakah yakin menghapus mesin ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('removemachine', ':id') }}".replace(':id', machineId),
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
            //fungsi button get detail mesin
            $('#ExtralargeModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("fetchviewproperty", ':id') }}'.replace(':id', id),
                    success: function(data) {
                        if (!data || !data.fetchmachines || data.fetchmachines.length === 0) {
                            $('#modal-data').html(
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
                        $('#modal_title_view').html(header_modal);
                        $('#modal_data_view').html(data_modal);
                        mergeCells();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
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
                        url: '{{ route("fetchtableproperty", ':id') }}'.replace(':id', id),
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
            //fungsi fillter button
            $('#filterButton').on('click', function() {
                const filterCard = document.getElementById("filterCard");
                if ($(filterCard).css('display') === 'none') {
                    $(filterCard).fadeIn(1000);
                    $(filterCard).css('display', 'block');
                } else {
                    $(filterCard).fadeOut(1000);
                    $(filterCard).css('display', 'none');
                }
            });
        });
    </script>
@endpush
