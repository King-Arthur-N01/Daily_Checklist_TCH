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
                            <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addScheduleModal" tabindex="0">+ Schedule Tahunan Mesin</a>
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
    <div class="modal fade" id="addScheduleModal" tabindex="-1">
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
    <div class="modal fade" id="editScheduleModal" tabindex="-1">
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

    <!-- Edit Modal -->
    <div class="modal fade" id="addScheduleMonth" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_month_add">
                </div>
                <div class="modal-body" id="modal_data_month_add">
                </div>
                <div class="modal-footer" id="modal_button_month_add">
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal-->

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

        $(function() {
            $('#date_picker').daterangepicker();
        });

        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refreshschedule") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map(function(refreshschedule) {
                        return {
                            no: refreshschedule.id,
                            name_schedule: refreshschedule.name_schedule,
                            id_machine: JSON.parse(refreshschedule.machine_collection.split(',').length),
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                <div class="dynamic-button-group">
                                    <button class="btn btn-success btn-sm" style="color:white" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#addScheduleMonth"><i class="bi bi-plus-circle-fill"></i>&nbsp;Schedule Bulanan</button>
                                    <button class="btn btn-danger btn-sm deleteButton" style="color:white" data-id="${refreshschedule.id}"><i class="bi bi-trash3-fill"></i>&nbsp;Delete Schedule</button>
                                </div>
                            `
                        };
                    });
                }
            },
            columns: [
                {
                    "data": 'id',
                    "render": function(data, type, row) {
                        return `<button value="${data}"><i class="fas fa-angle-right toggle-icon"></i></button>`;
                    },
                    "className": 'table-accordion',
                    "orderable": false,
                },
                { data: 'name_schedule' },
                { data: 'id_machine' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#scheduleTables tbody').on('click', 'td.table-accordion', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let rowId = row.data().id;

            const toggleIcon = this.querySelector('.toggle-icon');

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                toggleIcon.classList.remove('active');
            } else {
                $.ajax({
                    type: 'GET',
                    url: '{{route("refreshdetailschedule", ":id")}}'.replace(':id', rowId),
                    success: function(data) {

                        let tableRows = '';
                        data.machinedata.forEach((machines, key) => {
                            tableRows += `
                                <tr>
                                    <td>${key + 1}</td>
                                    <td>${machines.invent_number}</td>
                                    <td>${machines.machine_name}</td>
                                    <td>${machines.machine_brand}</td>
                                    <td>${machines.machine_spec}</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="bi bi-hourglass-split"></i>
                                                </div>
                                            </div>
                                            <input name="schedule_duration[]" type="number" class="form-control" placeholder="Dihitung Perjam">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="bi bi-calendar3"></i>
                                                </div>
                                            </div>
                                            <input name="schedule_time[]" type="date" class="form-control ui-datepicker" placeholder="DD/MM/YYYY">
                                            <input type="hidden" name="id_machine[]" value="${machines.id}">
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });

                        let detailTable = `
                            <table class="table-child" id="scheduleTablesChild">
                                <thead>
                                    <tr>
                                        <th>INVENT NUMBER</th>
                                        <th>NOMOR MESIN</th>
                                        <th>NAMA MESIN</th>
                                        <th>BRAND MESIN</th>
                                        <th>TYPE MESIN</th>
                                        <th>BATAS WAKTU PREVENTIVE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableRows}
                                </tbody>
                            </table>
                        `
                        row.child(detailTable).show();
                        tr.addClass('shown');
                        toggleIcon.classList.add('active');
                    },
                    error: function(xhr, error) {
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
                });
            }
        });

        $('#addScheduleModal').on('shown.bs.modal', function(event) {
            $.ajax({
                type: 'GET',
                url: '{{ route("fetchmachine") }}',
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Tambah Jadwal Preventive Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    let combinedMachineId = [];
                    let nameSchedule = '';

                    // Check if previous selections exist in sessionStorage
                    let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                    function updateSelectedMachines() {
                        combinedMachineId = [];
                        let checkboxes = document.getElementsByName("machineinput");
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                combinedMachineId.push(checkbox.value);
                            }
                        });
                        sessionStorage.setItem('tempData', JSON.stringify(combinedMachineId));
                    }

                    // Display machines in the first modal (selection menu)
                    function renderFirstMenu() {
                        let tableRows1 = `
                            <div class="row" align-items="center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" id="name_schedule" type="text" placeholder="Nama Jadwal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="machineTables1" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO INVENT</th>
                                            <th>NO MESIN</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                    `;
                                        data.refreshmachine.forEach((machine, index) => {
                                            tableRows1 += `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${machine.invent_number}</td>
                                                    <td>${machine.machine_number}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type}</td>
                                                    <td>${machine.machine_brand}</td>
                                                    <td><input type="checkbox" name="machineinput" value="${machine.id}"></td>
                                                </tr>
                                            `;
                                        });
                        tableRows1 += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;

                        document.getElementById("modal_data_add").innerHTML = tableRows1;

                        // Re-add event listeners for new checkboxes
                        let checkboxes = document.getElementsByName("machineinput");
                        checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));
                    }

                    // Display the selected machines in the second modal (confirmation menu)
                    function renderSecondMenu() {
                        const selectedMachines = data.refreshmachine.filter(machine =>
                            combinedMachineId.includes(machine.id.toString())
                        );

                        let tableRows2 = `
                            <h5>SAAT PEMBUATAN JADWAL PREVENTIVE DIUSAHAKAN AMBIL DITANGGAL YANG BERTEPATAN DENGAN HARI SENIN!!!!</h5>
                            <form id="addSchedule" method="post">
                                <input type="hidden" name="name_schedule" value="${nameSchedule}">
                                <table class="table table-bordered" id="machineTables2" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>NO INVENT</th>
                                            <th>NO MESIN</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>RENCANA PREVENTIVE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                `;
                                    selectedMachines.forEach((machine, index) => {
                                        tableRows2 += `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${machine.invent_number}</td>
                                                <td>${machine.machine_number}</td>
                                                <td>${machine.machine_name}</td>
                                                <td>${machine.machine_type}</td>
                                                <td>${machine.machine_brand}</td>
                                                <td>
                                                    <input class="form-control" type="text" id="date_picker" name="schedule_time">
                                                    <input type="hidden" name="id_machine" value="${machine.id}">
                                                </td>
                                            </tr>
                                        `;
                                    });
                        tableRows2 += `
                                    </tbody>
                                </table>
                            </form>
                        `;
                        document.getElementById("modal_data_add").innerHTML = tableRows2;
                    }

                    // Modal button functionality to switch between menus
                    function changeMenu(step) {
                        const button_modal1 = `
                            <button class="btn dynamic-button btn-secondary" id="previousButton"><i class="bi bi-arrow-left"></i>Previous</button>
                            <button class="btn dynamic-button btn-primary" id="nextButton">Next<i class="bi bi-arrow-right"></i></button>
                        `;
                        const button_modal2 = `
                            <button class="btn dynamic-button btn-secondary" id="previousButton"><i class="bi bi-arrow-left"></i>Previous</button>
                            <button class="btn dynamic-button btn-primary" id="confirmButton">Confirm<i class="bi bi-check2-circle"></i></button>
                        `;
                        if (step === 1) {
                            renderFirstMenu();
                            document.getElementById("modal_button_add").innerHTML = button_modal1;
                            document.getElementById("previousButton").disabled = true;
                        } else if (step === 2) {
                            renderSecondMenu();
                            document.getElementById("modal_button_add").innerHTML = button_modal2;
                            document.getElementById("confirmButton").addEventListener('click', function() {
                                confirmButton();
                            });
                        }
                    }

                    $('#modal_title_add').html(header_modal);
                    changeMenu(1);

                    document.getElementById("modal_button_add").addEventListener('click', function(event) {
                        if (event.target.id === "previousButton") {
                            changeMenu(1);
                        }
                    });

                    document.getElementById("modal_button_add").addEventListener('click', function(event) {
                        if (event.target.id === "nextButton") {
                            nameSchedule = $('#name_schedule').val();
                            if (nameSchedule === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2);
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        function confirmButton() {
            event.preventDefault();
            let scheduleName = $('input[name="name_schedule"]').val();
            let scheduleTimes = [];
            let idMachines = [];

            $('input[name="schedule_time"]').each(function() {
                scheduleTimes.push($(this).val());
            });
            $('input[name="id_machine"]').each(function() {
                idMachines.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '{{ route("addschedule") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name_schedule' : scheduleName,
                    'schedule_time[]': scheduleTimes,
                    'id_machine[]': idMachines,
                },
                success: function(response) {
                    if (response.success) {
                        const successMessage = response.success;
                        $('#successText').text(successMessage);
                        $('#successModal').modal('show');
                    }
                    setTimeout(function() {
                        $('#successModal').modal('hide');
                        $('#addScheduleModal').modal('hide');
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    if (xhr.responseText) {
                        console.error(xhr.responseText);
                        const warningMessage = JSON.parse(xhr.responseText).error;
                        $('#failedText').text(warningMessage);
                        $('#failedModal').modal('show');
                    }
                    setTimeout(function() {
                        $('#failedModal').modal('hide');
                        $('#addScheduleModal').modal('hide');
                    }, 2000);
                }
            }).always(function() {
                table.ajax.reload(null, false);
            });
        }

        $('#addScheduleMonth').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const machineId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("readscheduledata", ':id') }}'.replace(':id', machineId),
                success: function(data) {

                    let tableRows = '';
                    data.getmachines.forEach((machines, key) => {
                        const machine = machines[0];
                        tableRows += `
                            <tr>
                                <td>${key + 1}</td>
                                <td>${machine.invent_number}</td>
                                <td>${machine.machine_number}</td>
                                <td>${machine.machine_name}</td>
                                <td>${machine.machine_type}</td>
                                <td>${machine.machine_brand}</td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="bi bi-hourglass-split"></i>
                                            </div>
                                        </div>
                                        <input name="schedule_time[]" type="number" class="form-control" placeholder="Dihitung Perjam">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="bi bi-calendar3"></i>
                                            </div>
                                        </div>
                                        <input name="schedule_date[]" type="date" class="form-control ui-datepicker" placeholder="DD/MM/YYYY">
                                        <input type="hidden" name="id_machine[]" value="${machine.id}">
                                        <input type="hidden" name="id_schedule" value="${data.getschedule}">
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    const header_modal = `
                        <h5 class="modal-title">Edit Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;
                    const data_modal = `
                        <form id=" addForm" method="post">
                            <table class="table table-bordered" id="machineTables" width="100%">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>NO INVENT</th>
                                        <th>NO MESIN</th>
                                        <th>NAMA MESIN</th>
                                        <th>MODEL/TYPE</th>
                                        <th>BRAND/MERK</th>
                                        <th>DURASI</th>
                                        <th>RENCANA TGL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableRows}
                                </tbody>
                            </table>
                        </form>
                    `;
                    const button_modal = `
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
                    `;
                    $('#modal_title_month_add').html(header_modal);
                    $('#modal_data_month_add').html(data_modal);
                    $('#modal_button_month_add').html(button_modal);

                    // Save button
                    $('#saveButton').on('click', function() {
                        event.preventDefault();
                        let scheduleId = $('input[name="id_schedule"]').val();
                        let scheduleDuration = [];
                        let scheduleDate = [];
                        let machinesId = [];

                        $('input[name="schedule_duration"]').each(function() {
                            scheduleDuration.push($(this).val());
                        });
                        $('input[name="schedule_date"]').each(function() {
                            scheduleDate.push($(this).val());
                        });
                        $('input[name="id_machine"]').each(function() {
                            machinesId.push($(this).val());
                        });
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("addschedulemonth") }}',
                            data: {
                                '_token': '{{ csrf_token() }}', // Include the CSRF token
                                'id_schedule' : scheduleName,
                                'schedule_duration[]': formData.scheduleDuration,
                                'schedule_date[]': formData.scheduleDate,
                                'id_machine[]': formData.machinesId
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
            if (confirm("Apakah yakin menghapus schedule ini?")) {
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
