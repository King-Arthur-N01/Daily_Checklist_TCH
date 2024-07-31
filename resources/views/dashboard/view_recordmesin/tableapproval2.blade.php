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
                                <th>PIC</th>
                                <th>SHIFT</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>NO. MESIN</th>
                                <th>WAKTU PREVENTIVE</th>
                                <th>STATUS</th>
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
        <div class="modal-dialog modal-xxl">
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
    <script src="{{ asset('assets/vendor/custom-js/filtertable1.js') }}"></script>
    <script>
        $(document).ready(function() {
            // sett automatic soft refresh table
            setInterval(function() {
                table.ajax.reload(null, false);
            }, 60000); // 60000 milidetik = 60 second

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#preventiveTables2').DataTable({
                ajax: {
                    url: '{{ route("refreshapproval") }}',
                    dataSrc: function(data) {
                        if (data && data.refreshrecord) {
                            // Process the data to match the table columns
                            return data.refreshrecord.map(function(refreshrecord) {
                                console.log(refreshrecord);
                                return {
                                    no: refreshrecord.records_id,
                                    pic: refreshrecord.getuser,
                                    shift: refreshrecord.shift,
                                    nama_mesin: refreshrecord.machine_name,
                                    model_type: refreshrecord.machine_type,
                                    no_mesin: refreshrecord.machine_number2,
                                    waktu_preventive: refreshrecord.record_time,
                                    status: refreshrecord.approve_by ? refreshrecord.approve_by : 'Belum Disetujui',
                                    action: `
                                        <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="${refreshrecord.records_id}" data-target="#approveModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></button>
                                    `
                                };
                            });
                        } else {
                            console.error('Invalid data received from server:', data);
                            return [];
                        }
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'pic' },
                    { data: 'shift' },
                    { data: 'nama_mesin' },
                    { data: 'model_type' },
                    { data: 'no_mesin' },
                    { data: 'waktu_preventive' },
                    { data: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#approveModal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let approveId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('fetchapproval', ':id') }}'.replace(':id', approveId),
                    success: function(data) {
                        const header_modal = `
                            <h5 class="modal-title">Extra Large Modal</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <table class="table table-bordered">
                                <tr><th>No. Invent Mesin :</th><td>${data.machinedata[0].invent_number}</td><th>Spec/Tonage :</th><td>${data.machinedata[0].machine_spec}</td></tr>
                                <tr><th>Nama Mesin :</th><td>${data.machinedata[0].machine_name}</td><th>Buatan :</th><td>${data.machinedata[0].machine_made}</td></tr>
                                <tr><th>Brand/Merk :</th><td>${data.machinedata[0].machine_brand}</td><th>Mfg.NO :</th><td>${data.machinedata[0].mfg_number}</td></tr>
                                <tr><th>Model/Type :</th><td>${data.machinedata[0].machine_type}</td><th>Install Date :</th><td>${data.machinedata[0].install_date}</td></tr>
                            </table>
                            <h4>History Records</h4>
                            <table class="table table-bordered" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Bagian Yang Dicheck</th>
                                        <th>Standart/Parameter</th>
                                        <th>Metode Pengecekan</th>
                                        <th>Action</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.combinedata.map((row, index) => `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${row.name_componencheck}</td>
                                            <td>${row.name_parameter}</td>
                                            <td>${row.name_metodecheck}</td>
                                            <td>${row.operator_action}</td>
                                            <td>${row.result}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                            <div class="form-custom">
                                <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                                <textarea id="input_note" type="text" rows="6" cols="50">${data.machinedata[0].note}</textarea>
                                </div>
                                <table class="table table-bordered" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>Disetujui oleh :</th>
                                            <th>Dikoreksi oleh :</th>
                                            <th>Dibuat oleh :</th>
                                        </tr>
                                        <tr>
                                            <td>${data.recordsdata[0].approve_by_name}</td>
                                            <td>${data.recordsdata[0].correct_by_name}</td>
                                            <td>${data.usernames.join(' & ')}</td>
                                        </tr>
                                    </thead>
                                </table>
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
                                    url: '{{ route('pushapproval', ':id') }}'.replace(':id', approveId),
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
                                    url: '{{ route('removeapprove', ':id') }}'.replace(':id', approveId),
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
