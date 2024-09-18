@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Schedule</h1>
            <div class="card-calendar shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-12 col-md-12">
                            <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addModal" tabindex="0">+ Schedule mesin</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <th>NO.</th>
                                <th>NAMA SCHEDULE</th>
                                <th>JUMLAH MESIN</th>
                                <th>TANGGAL PEMBUATAN</th>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
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
        <div class="modal-dialog modal-fullscreen">
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

    <!-- View Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_schedule">
                </div>
                <div class="modal-body" id="modal_data_schedule">
                </div>
                <div class="modal-footer" id="modal_button_schedule">
                </div>
            </div>
        </div>
    </div>
    <!-- End View Modal-->

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
@endsection

@push('style')
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
@endpush

@push('script')
    {{-- <script src="{{ asset('assets/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script> --}}
    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
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

        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refreshschedule") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            no: index + 1,
                            name_schedule: refreshschedule.name_schedule,
                            id_machine: JSON.parse(refreshschedule.id_machine.split(',').length),
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                <div class="dynamic-button-group">
                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item-custom-detail" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#scheduleModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Edit Machine Schedule</a>
                                        <a class="dropdown-item-custom-edit" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                        <a class="dropdown-item-custom-delete" data-id="${refreshschedule.id}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                    </div>
                                </div>
                            `
                        };
                    });
                }
            },
            columns: [
                { data: 'no', orderable: false, searchable: false},
                { data: 'name_schedule' },
                { data: 'id_machine' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#scheduleModal').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const machineId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("readmachineschedule", ':id') }}'.replace(':id', machineId),
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Edit Jadwal Preventive Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <form id="editform" method="post">
                            <table class="table table-bordered" id="machineTablesSchedule" width="100%">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NO. INVENT</th>
                                        <th>NAMA MESIN</th>
                                        <th>BRAND/MERK</th>
                                        <th>SPEC/TYPE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.getmachineid.map((machine, index) => `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${machine.invent_number}</td>
                                            <td>${machine.machine_name}</td>
                                            <td>${machine.machine_brand}</td>
                                            <td>${machine.machine_spec}</td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="bi bi-calendar3"></i>
                                                        </div>
                                                    </div>
                                                    <input name="schedule_time[${index}]" type="date" class="form-control ui-datepicker" placeholder="DD/MM/YYYY">
                                                    <input type="hidden" name="id_machine[${index}]" value="${machine.id}">
                                                </div>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </form>
                    `;

                    const button_modal = `
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="scheduleButton">Save changes</button>
                    `;

                    $('#modal_title_schedule').html(header_modal);
                    $('#modal_data_schedule').html(data_modal);
                    $('#modal_button_schedule').html(button_modal);
                    $('#machineTablesSchedule').DataTable();

                    $('#scheduleButton').on('click', function(event) {
                        event.preventDefault(); // Prevent default form submission
                        let scheduleTimes = $('input[name^="schedule_time"]').map(function() {
                            return $(this).val();
                        }).get(); // Collect all values in an array
                        let idMachines = $('input[name^="id_machine"]').map(function() {
                            return $(this).val();
                        }).get(); // Collect all values in an array
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("addmachineschedule") }}',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'schedule_time': scheduleTimes,
                                'id_machine': idMachines,
                            },
                            success: function(response) {
                                if (response.success) {
                                    const successMessage = response.success;
                                    $('#successText').text(successMessage);
                                    $('#successModal').modal('show');
                                }
                                setTimeout(function() {
                                    $('#successModal').modal('hide');
                                    $('#scheduleModal').modal('hide');
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
                                    $('#scheduleModal').modal('hide');
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

        $('#addModal').on('shown.bs.modal', function(event) {
            $.ajax({
                type: 'GET',
                url: '{{ route("fetchmachine") }}',
                success: function(data) {
                    let combinedValue = [];
                    function combineMachineValues() {
                        const checkboxes = document.getElementsByName("machineinput");
                        combinedValue = [];
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                combinedValue.push(checkbox.value);
                            }
                        });
                    }

                    let tableRows = '';
                    data.refreshmachine.forEach((value, key) => {
                        tableRows += `
                            <tr>
                                <td>${key + 1}</td>
                                <td>${value.invent_number}</td>
                                <td>${value.machine_number}</td>
                                <td>${value.machine_name}</td>
                                <td>${value.machine_type}</td>
                                <td>${value.machine_brand}</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="machineinput" value="${value.id}">
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    const header_modal = `
                        <h5 class="modal-title">Tambah Jadwal Preventive Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <form id="addForm" method="post">
                            <div class="row" align-items="center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" name="name_schedule" type="text" placeholder="Nama Jadwal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="machineTables" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO. INVENT</th>
                                            <th>NO MESIN</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                            ${tableRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    `;

                    const button_modal = `
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addButton">Save changes</button>
                    `;

                    $('#modal_title_add').html(header_modal);
                    $('#modal_data_add').html(data_modal);
                    $('#modal_button_add').html(button_modal);
                    $('#machineTables').DataTable();

                    // Add event listeners for checkboxes
                    const checkboxes = document.getElementsByName("machineinput");
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', combineMachineValues);
                    });

                    $('#addButton').on('click', function(event) {
                        event.preventDefault();
                        let formData = {
                            nameSchedule: $('input[name="name_schedule"]').val(),
                            machineInput: combinedValue,
                        };
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("addschedule") }}',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'name_schedule': formData.nameSchedule,
                                'id_machine': formData.machineInput,
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
                },
                error: function(xhr, status, error) {
                    console.error('error:', error);
                    $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        });

        $('#editModal').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const machineId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("readschedule", ':id') }}'.replace(':id', machineId),
                success: function(data) {
                    let combinedValue = [];
                    function combineMachineValues() {
                        const checkboxes = document.getElementsByName("machineinput");
                        combinedValue = [];
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                combinedValue.push(checkbox.value);
                            }
                        });
                        combinedValue = combinedValue.join(',');
                    }

                    let tableRows = '';
                    if (Array.isArray(data.machinearray)) {
                        data.refreshmachine.forEach((value, key) => {
                            const machineArray = data.machinearray.map(id => parseInt(id)); // convert json string array into legular integer array
                            const isChecked = machineArray.includes(value.id) ? 'checked' : ''; // compare each legular integer array value into id each machine and check it if have same value
                            tableRows += `
                                <tr>
                                    <td>${key + 1}</td>
                                    <td>${value.invent_number}</td>
                                    <td>${value.machine_number}</td>
                                    <td>${value.machine_name}</td>
                                    <td>${value.machine_type}</td>
                                    <td>${value.machine_brand}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="machineinput" value="${value.id}" ${isChecked}>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    const header_modal = `
                        <h5 class="modal-title">Edit Jadwal Preventive Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <form id="editForm" method="put">
                            <div class="row" align-items="center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" name="schedule_name" value="${data.getschedule.name_schedule}" type="text" placeholder="Nama Jadwal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="machineTablesEdit" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO. INVENT</th>
                                            <th>NO MESIN</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                            ${tableRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    `;

                    const button_modal = `
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="editButton">Save changes</button>
                    `;

                    $('#modal_title_edit').html(header_modal);
                    $('#modal_data_edit').html(data_modal);
                    $('#modal_button_edit').html(button_modal);
                    $('#machineTablesEdit').DataTable();

                    // Add event listeners for checkboxes
                    const checkboxes = document.getElementsByName("machineinput");
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', combineMachineValues);
                    });

                    $('#editButton').on('click', function(event) {
                        event.preventDefault();
                        let formData = {
                            scheduleName: $('input[name="schedule_name"]').val(),
                            machineInput: combinedValue,
                        };
                        $.ajax({
                            type: 'PUT',
                            url: '{{ route("updateschedule", ':id') }}'.replace(':id', machineId),
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'schedule_name': formData.scheduleName,
                                'id_machine': formData.machineInput,
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
                                    const warningMessage = JSON.parse(xhr.responseText).error;
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

        // fungsi delete button untuk hapus mesin
        $('#scheduleTables').on('click', '.dropdown-item-custom-delete', function(e) {
            e.preventDefault();
            const button = $(this);
            const machineId = button.data('id');
            if (confirm("Apakah yakin menghapus mesin ini?")) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("removeschedule", ':id') }}'.replace(':id', machineId),
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
    });
</script>
@endpush
