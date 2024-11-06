@extends('layouts.master')
@section('title', 'Table persetujuan preventive')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Persetujuan Checklist Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-filter">
                            <div class="col-4">
                                <p class="mg-b-10">Nama Mesin</p>
                                <select class="form-control select2" name="" id="category-input-machinename">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <select class="form-control select2" name="" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Status Mesin</p>
                                <select class="form-control" name="sample" id="statusMachine">
                                    <option selected="selected">Select :</option>
                                    <option>Sudah Dipreventive</option>
                                    <option>Belum Dipreventive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="preventiveTables2" width="100%">
                            <thead>
                                <th>NO.</th>
                                <th>NAMA MESIN</th>
                                <th>TYPE MESIN</th>
                                <th>NOMOR MESIN</th>
                                <th>STATUS</th>
                                <th>STATUS PREVENTIVE</th>
                                <th>SHIFT</th>
                                <th>WAKTU PREVENTIVE</th>
                                <th>ACTION</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
    </div>

    <!-- Approval Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_approve">
                </div>
                <div class="modal-body" id="modal_data_approve">
                </div>
                <div class="modal-footer" id="modal_button_approve">
                </div>
            </div>
        </div>
    </div>
    <!-- End Approval Modal-->

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

    <!-- Alert Danger Modal -->
    <div class="modal fade" id="failedModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <i class="modal-alert">Data Preventive FAILED to be updated !!!!</i>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Danger Modal -->

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/custom-js/filtertable1.js') }}"></script> --}}
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
            const table = $('#preventiveTables2').DataTable({
                ajax: {
                    url: '{{ route("refreshapproval") }}',
                    dataSrc: function(data) {
                        return data.refreshrecord.map((refreshrecord, index) => {
                            return {
                                number: index + 1,
                                machine_name: refreshrecord.machine_name,
                                machine_type: refreshrecord.machine_type,
                                machine_number: refreshrecord.machine_number,
                                status: refreshrecord.approve_by ? (refreshrecord.approve_by > 0 ? 'Sudah Sudah Disetujui' : 'Belum Disetujui') : 'Belum Disetujui',
                                record_status: refreshrecord.machinerecord_status,
                                shift: refreshrecord.shift,
                                getcreatedate: refreshrecord.created_date,
                                actions: `
                                    <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="${refreshrecord.records_id}" data-target="#approveModal"><i class="bi bi-pencil-square"></i></button>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_number' },
                    { data: 'status' },
                    { data: 'record_status', render: function(data, type, row) {
                        if (data === 0) {
                            return '<span class="badge badge-danger">ABNORMAL</span>';
                        } else if (data === 1) {
                            return '<span class="badge badge-success">NORMAL</span>';
                        }
                    }},
                    { data: 'shift' },
                    { data: 'getcreatedate' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#approveModal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let approveId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readapproval", ':id') }}'.replace(':id', approveId),
                    success: function(data) {
                        let table_modal = '';
                        data.machinedata.forEach((rowdata, index) => {
                            const actions = JSON.parse(data.combineresult[0].operator_action)[index].join(' & ');
                            const result = JSON.parse(data.combineresult[0].result)[index];

                            table_modal += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${rowdata.name_componencheck}</td>
                                    <td>${rowdata.name_parameter}</td>
                                    <td>${rowdata.name_metodecheck}</td>
                                    <td>${actions}</td>
                                    <td>${result}</td>
                                </tr>
                            `;
                        });

                        const header_modal = `
                            <h5 class="modal-title">Extra Large Modal</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        const data_modal = `
                            <div class="table-responsive">
                                <table class="table table-header" width="100%">
                                    <tbody>
                                        <tr>
                                            <th>No. Invent Mesin :</th>
                                            <th>${data.machinedata[0].invent_number}</th>
                                            <th>Spec/Tonage :</th>
                                            <th>${data.machinedata[0].machine_spec}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Mesin :</th>
                                            <th>${data.machinedata[0].machine_name}</th>
                                            <th>Buatan :</th>
                                            <th>${data.machinedata[0].machine_made}</th>
                                        </tr>
                                        <tr>
                                            <th>Brand/Merk :</th>
                                            <th>${data.machinedata[0].machine_brand}</th>
                                            <th>Mfg.NO :</th>
                                            <th>${data.machinedata[0].mfg_number}</th>
                                        </tr>
                                        <tr>
                                            <th>Model/Type :</th>
                                            <th>${data.machinedata[0].machine_type}</th>
                                            <th>Install Date :</th>
                                            <th>${data.machinedata[0].install_date}</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="header-input">
                                    <div class="col-6">
                                        <a>NO.MESIN :</a>
                                        <input class="form-control" type="int" name="machine_number" id="machine_number" value="${data.usersdata[0].machine_number2}" readonly>
                                    </div>
                                    <div class="col-6">
                                        <a>WAKTU PREVENTIVE :</a>
                                        <input class="form-control" value="${new Date(data.usersdata[0].created_at).toLocaleDateString()}" readonly>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="dataTables" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Bagian Yang Dicheck</th>
                                            <th>Standart/Parameter</th>
                                            <th>Metode Pengecekan</th>
                                            <th>Action</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${table_modal}
                                    </tbody>
                                </table>
                                <div class="form-custom">
                                    <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                                    <textarea class="form-control" id="input_note" type="text" rows="6" cols="50">${data.usersdata[0].note}</textarea>
                                </div>
                                <div class="form-custom">
                                    <table class="table table-bordered table-custom" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>Shift :</th>
                                                <th>Disetujui oleh :</th>
                                                <th>Dikoreksi oleh :</th>
                                                <th colspan="4">Dibuat oleh :</th>
                                            </tr>
                                            <tr>
                                                <td>${data.usersdata[0].shift}</td>
                                                <td>${data.usersdata.approve_by_name ? data.usersdata.approve_by_name : 'Belum disetujui'}</td>
                                                <td>${data.usersdata.correct_by_name ? data.usersdata.correct_by_name : 'Belum dikoreksi'}</td>
                                                ${data.usernames.map((get_user_id) => `
                                                    <td>${get_user_id}</td>
                                                `).join('')}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        `;
                        const button_modal =`
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            @can('delete_records', Permission::class)
                            <button type="submit" class="btn btn-danger" id="deleteButton" data-toggle="modal">Delete</button>
                            @endcan
                            <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                        `;
                        $('#modal_title_approve').html(header_modal);
                        $('#modal_data_approve').html(data_modal);
                        $('#modal_button_approve').html(button_modal);
                        mergeCells();

                        // Save button
                        $('#saveButton').on('click', function() {
                            let note = $('#input_note').val();
                            let approvedBy = '{{ Auth::user()->id }}';
                            if (confirm("Apakah yakin mengapprove preventive ini?")) {
                                $.ajax({
                                    type: 'PUT',
                                    url: '{{ route("insertapproval", ':id') }}'.replace(':id', approveId),
                                    data: {
                                        '_token': '{{ csrf_token() }}', // Include the CSRF token
                                        'approve_by': approvedBy,
                                        'note': note
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#approveModal').modal('hide');
                                        }, 2000);
                                    },
                                    error: function(xhr, status, error) {
                                        if (xhr.responseText) {
                                            const warningMessage = JSON.parse(xhr.responseText).error;
                                            $('#warningText').text(warningMessage);
                                            $('#warningModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#warningModal').modal('hide');
                                            $('#approveModal').modal('hide');
                                        }, 2000);
                                    }
                                }).always(function() {
                                    table.ajax.reload(null, false);
                                });
                            } else {
                                // User cancelled the deletion, do nothing
                            }
                        });

                        // Delete button
                        $('#deleteButton').on('click', function() {
                            if (confirm("Are you sure you want to delete this record?")) {
                                $.ajax({
                                    type: 'DELETE',
                                    url: '{{ route("removeapproval", ':id') }}'.replace(':id', approveId),
                                    data: {
                                        '_token': '{{ csrf_token() }}', // Include the CSRF token
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#approveModal').modal('hide');
                                        }, 2000);
                                    },
                                    error: function(xhr, status, error) {
                                        if (xhr.responseText) {
                                            const warningMessage = JSON.parse(xhr.responseText).error;
                                            $('#warningText').text(warningMessage);
                                            $('#warningModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#warningModal').modal('hide');
                                            $('#approveModal').modal('hide');
                                        }, 2000);
                                    }
                                }).always(function() {
                                    table.ajax.reload(null, false);
                                });
                            } else {
                                // User cancelled the deletion, do nothing
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
