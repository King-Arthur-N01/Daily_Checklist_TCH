@extends('layouts.master')
@section('title', 'Table koreksi preventive')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Koreksi Checklist Mesin</h1>
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
                        <table class="table table-bordered" id="preventiveTables1" width="100%">
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

    <!-- Correct Modal -->
    <div class="modal fade" id="correctModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_correct">
                </div>
                <div class="modal-body" id="modal_data_correct">
                </div>
                <div class="modal-footer" id="modal_button_correct">
                </div>
            </div>
        </div>
    </div>
    <!-- End Correct Modal-->

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
    <script src="{{ asset('assets/vendor/custom-js/formatdate.js') }}"></script>
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
            const table = $('#preventiveTables1').DataTable({
                ajax: {
                    url: '{{ route("refreshcorrect") }}',
                    dataSrc: function(data) {
                        return data.refreshrecord.map((refreshrecord, index) => {
                            return {
                                number: index + 1,
                                machine_name: refreshrecord.machine_name,
                                machine_type: refreshrecord.machine_type,
                                machine_number: refreshrecord.machine_number,
                                status: refreshrecord.correct_by ? (refreshrecord.correct_by > 0 ? 'Sudah Dikoreksi' : 'Belum Dikoreksi') : 'Belum Dikoreksi',
                                record_status: refreshrecord.machinerecord_status,
                                shift: refreshrecord.shift,
                                getcreatedate: refreshrecord.created_date,
                                actions: `
                                    <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="${refreshrecord.records_id}" data-target="#correctModal"><i class="bi bi-pencil-square"></i></button>
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
                    {
                        data: 'getcreatedate',
                        render: function(data) {
                            return formatDate(data);
                        }
                    },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#correctModal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let correctId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readcorrection", ':id') }}'.replace(':id', correctId),
                    success: function(data) {
                        let table_modal = '';
                        const operatorActionArray = JSON.parse(data.combineresult[0].operator_action || '[]');
                        const resultArray = JSON.parse(data.combineresult[0].result || '[]');
                        const maxLength = Math.min(
                            data.machinedata.length,
                            operatorActionArray.length,
                            resultArray.length
                        );

                        for (let index = 0; index < maxLength; index++) {
                            const actions = operatorActionArray[index]?.join(' & ') || 'No actions';
                            const result = resultArray[index] || 'No result';

                            table_modal += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${data.machinedata[index].name_componencheck}</td>
                                    <td>${data.machinedata[index].name_parameter}</td>
                                    <td>${data.machinedata[index].name_metodecheck}</td>
                                    <td>${actions}</td>
                                    <td>${result}</td>
                                </tr>
                            `;
                        }

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
                                        <input class="form-control" type="int" name="machine_number" id="machine_number" value="${data.machinedata[0].machine_number}" readonly>
                                    </div>
                                    <div class="col-6">
                                        <a>WAKTU PREVENTIVE :</a>
                                        <input class="form-control" value="${new Date(data.usersdata[0].record_date).toLocaleDateString()}" readonly>
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
                                    <label>Opsi clear abnormal terhadap preventive</label>
                                    <div class="switch-container">
                                        <label>Clear Abnormals</label>
                                        <label class="switch">
                                            <input type="checkbox" id="clear_abnormals" value="0">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <a>Abnormality terhadap preventive</a>
                                    <input class="form-control" id="abnormals_value" value="${data.abnormals}" readonly>
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
                                                <td>${data.usersdata[0].approve_by_name ? data.usersdata[0].approve_by_name : 'Belum disetujui'}</td>
                                                <td>${data.usersdata[0].correct_by_name ? data.usersdata[0].correct_by_name : 'Belum dikoreksi'}</td>
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
                        $('#modal_title_correct').html(header_modal);
                        $('#modal_data_correct').html(data_modal);
                        $('#modal_button_correct').html(button_modal);
                        mergeCells();

                        document.getElementById('clear_abnormals').addEventListener('change', function() {
                            const abnormalsInput = document.getElementById('abnormals_value');
                            const clearAbnormals = document.getElementById('clear_abnormals');
                            if (this.checked) {
                                abnormalsInput.removeAttribute('readonly');
                                abnormalsInput.style.textDecoration = 'line-through';
                                clearAbnormals.value = '1';
                                abnormalsInput.setAttribute('readonly', true);
                            } else {
                                abnormalsInput.removeAttribute('readonly');
                                abnormalsInput.style.textDecoration = 'none';
                                clearAbnormals.value = '0';
                                abnormalsInput.setAttribute('readonly', true);
                            }
                        });

                        // Save button
                        $('#saveButton').on('click', function() {
                            let clearAbnormals = $('#clear_abnormals').val();
                            let note = $('#input_note').val();
                            let correctedBy = '{{ Auth::user()->id }}';
                            if (confirm("Apakah yakin mengkoreksi preventive ini?")) {
                                $.ajax({
                                    type: 'PUT',
                                    url: '{{ route("insertcorrection", ':id') }}'.replace(':id', correctId),
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'clear_abnormals': clearAbnormals,
                                        'correct_by': correctedBy,
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
                                            $('#correctModal').modal('hide');
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
                                            $('#correctModal').modal('hide');
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
                                    url: '{{ route("removecorrection", ':id') }}'.replace(':id', correctId),
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
                                            $('#correctModal').modal('hide');
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
                                            $('#correctModal').modal('hide');
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
