@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Approval Schedule Planner</h1>
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>SCHEDULE PERBULAN</th>
                                    <th>JUMLAH SCHEDULE</th>
                                    <th>STATUS SCHEDULE</th>
                                    <th>TANGGAL PEMBUATAN</th>
                                    <th>ACTION</th>
                                </tr>
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

    <!-- planner Schedule Month -->
    <div class="modal fade show" id="plannerModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_planner">
                </div>
                <div class="modal-body" id="modal_data_planner">
                </div>
                <div class="modal-footer" id="modal_button_planner">
                </div>
            </div>
        </div>
    </div>
    <!-- End planner Schedule Month -->

    <!-- View Schedule Month -->
    <div class="modal fade" id="plannerModalEdit" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_planner_edit">
                </div>
                <div class="modal-body" id="modal_data_planner_edit">
                </div>
                <div class="modal-footer" id="modal_button_planner_edit">
                </div>
            </div>
        </div>
    </div>
    <!-- End View Schedule Month-->

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterange-picker/daterangepicker.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/formatdate.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/custom-js/select-checkbox.js') }}"></script> --}}
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

        let nameScheduleYear = "";
        let nameScheduleMonth = "";
        let combinedMachineId = [];

        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refresh-planner") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            number: index + 1,
                            name_schedule: refreshschedule.name_schedule_month,
                            total_schedule: JSON.parse(refreshschedule.schedule_collection.split(',').length),
                            schedule_status: refreshschedule.schedule_planner,
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                ${refreshschedule.schedule_planner === null ?
                                    `<button type="button" class="btn btn-primary btn-sm btn-Id" data-id="${refreshschedule.id}" data-toggle="modal" data-target="#plannerModal"><i class="bi bi-calendar-check-fill"></i></button>` :
                                    `<button type="button" class="btn btn-primary btn-sm btn-Id" data-id="${refreshschedule.id}" data-toggle="modal" data-target="#plannerModalEdit"><i class="bi bi-pencil-square"></i></button>`
                                }
                            `
                        };
                    });
                }
            },
            columns: [
                { data: 'number' },
                { data: 'name_schedule' },
                { data: 'total_schedule' },
                { data: 'schedule_status', render: function(data, type, row) {
                    return data === null ? '<span class="badge badge-danger">Belum Disetujui</span>' : '<span class="badge badge-success">Sudah Disetujui</span>';
                }},
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });


        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<KOREKSI SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI TAMBAH MESIN PERBULAN & PERKIRAAN WAKTU PREVENTIVE
        $('#plannerModal').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("readmonth-planner", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    function selectCheckbox() {
                        const table = document.getElementById("dataTables");
                        const rows = table.querySelectorAll("tbody tr");

                        rows.forEach((row) => {
                            const checkboxes = row.querySelectorAll('input[type="checkbox"]');
                            const machineRescheduleInput = row.querySelector('input[name="machine_reschedule"]');
                            const rescheduleNoteInput = row.querySelector('input[name="reschedule_note"]');

                            checkboxes.forEach((checkbox) => {
                                checkbox.addEventListener("change", () => {
                                    if (checkbox.checked) {
                                        checkboxes.forEach((otherCheckbox) => {
                                            if (otherCheckbox !== checkbox) {
                                                otherCheckbox.checked = false; // Hanya satu yang dapat dipilih
                                            }
                                        });

                                        if (checkbox.value === "tidak") {
                                            machineRescheduleInput.removeAttribute('readonly');
                                            rescheduleNoteInput.removeAttribute('readonly');
                                        } else if (checkbox.value === "iya") {
                                            machineRescheduleInput.setAttribute('readonly', true);
                                            rescheduleNoteInput.setAttribute('readonly', true);
                                        }

                                        // Update daterangepicker based on readonly state
                                        const datepickerId = machineRescheduleInput.getAttribute('id');
                                        if (machineRescheduleInput.hasAttribute('readonly')) {
                                            $(`#${datepickerId}`).data('daterangepicker').disable();
                                        } else {
                                            $(`#${datepickerId}`).data('daterangepicker').enable();
                                        }
                                    }
                                });
                            });

                        });
                    }


                    const header_modal = `
                        <h5 class="modal-title">Koreksi Schedule Perbaikan Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                <div>
                                    <input class="form-control" type="text" value="${data.scheduledata[0].name_schedule_month}" readonly>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered" id="dataTables">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>NO.INVENT</th>
                                    <th>NAMA MESIN</th>
                                    <th>MODEL/TYPE</th>
                                    <th>BRAND/MERK</th>
                                    <th>NO.MESIN/AREA</th>
                                    <th>DURASI</th>
                                    <th>SCHEDULE PM</th>
                                    <th colspan="2">ACTION</th>
                                    <th>KETERSEDIAAN</th>
                                    <th>ALASAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.scheduledata.map((schedule, index) => {
                                    let machineHourData = data.workinghourdata.find(workinghour => workinghour.id === schedule.standart_id);
                                    let machineHour = machineHourData ? machineHourData.preventive_hour : '0';
                                    return `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${schedule.invent_number}</td>
                                            <td>${schedule.machine_name}</td>
                                            <td>${schedule.machine_type || '-'}</td>
                                            <td>${schedule.machine_brand || '-'}</td>
                                            <td>${schedule.machine_number || '-'}</td>
                                            <td>${machineHour} /Jam</td>
                                            <td>${formatDate(schedule.schedule_date)}</td>
                                            <td>
                                                <div id="option_${schedule.schedule_id}">
                                                    <input type="checkbox" id="condition" value="iya" checked>SESUAI
                                                </div>
                                            </td>
                                            <td>
                                                <div id="option_${schedule.schedule_id}">
                                                    <input type="checkbox" id="condition" value="tidak">TIDAK SESUAI
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control datepicker" name="machine_reschedule" id="datepicker-${schedule.schedule_id}" data-schedule-date="${schedule.schedule_date}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="reschedule_note" placeholder="Opsional" readonly>
                                            </td>
                                        </tr>
                                    `;
                                }).join('')}
                            </tbody>
                        </table>
                    `;
                    const button_modal =`
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                    `;
                    $('#modal_title_planner').html(header_modal);
                    $('#modal_data_planner').html(data_modal);
                    $('#modal_button_planner').html(button_modal);
                    selectCheckbox()

                    $('.datepicker').each(function() {
                        const scheduleDate = $(this).data('schedule-date'); // Ambil tanggal dari data attribute
                        $(this).daterangepicker({
                            parentEl: '#modal_data_planner',
                            singleDatePicker: true,
                            showDropdowns: true,
                            startDate: moment(scheduleDate), // Gunakan scheduleDate yang diambil dari data attribute
                            locale: {
                                firstDay: 1,
                                format: 'DD-MM-YYYY'
                            }
                        });

                        // Tambahkan properti enable/disable manual
                        const daterangepickerInstance = $(this).data('daterangepicker');
                        daterangepickerInstance.enable = function() {
                            this.element.prop('disabled', false);
                        };
                        daterangepickerInstance.disable = function() {
                            this.element.prop('disabled', true);
                        };

                        // Set initial state based on readonly attribute
                        if ($(this).prop('readonly')) {
                            daterangepickerInstance.disable();
                        }
                    });


                    $('#saveButton').on('click', function() {
                        let machineReschedule = [];
                        let plannedBy = '{{ Auth::user()->id }}';
                        const selectedCheckboxes = $('input[type="checkbox"][value="tidak"]:checked');

                        selectedCheckboxes.each(function() {
                            const row = $(this).closest('tr');
                            const scheduleId = row.find('input[name="machine_reschedule"]').attr('id').replace('datepicker-', '');
                            const rescheduleValue = row.find('input[name="machine_reschedule"]').val();
                            const rescheduleNote = row.find('input[name="reschedule_note"]').val();
                            machineReschedule.push({ schedule_id: scheduleId, reschedule_value: rescheduleValue, reschedule_note: rescheduleNote });
                        });

                        if (confirm("Apakah yakin sudah mengetahui preventive ini?")) {
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("editmonth-planner", ':id') }}'.replace(':id', scheduleId),
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'planned_by': plannedBy,
                                    'machine_reschedule': machineReschedule
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#plannerModal').modal('hide');
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
                                        $('#plannerModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        } else {
                            // User cancelled the deletion, do nothing
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });


        $('#plannerModalEdit').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("findmonth-planner", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    function selectCheckbox() {
                        const table = document.getElementById("dataTables");
                        const rows = table.querySelectorAll("tbody tr");

                        rows.forEach((row) => {
                            const checkboxes = row.querySelectorAll('input[type="checkbox"]');
                            const machineRescheduleInput = row.querySelector('input[name="machine_reschedule"]');
                            const rescheduleNoteInput = row.querySelector('input[name="reschedule_note"]');

                            checkboxes.forEach((checkbox) => {
                                checkbox.addEventListener("change", () => {
                                    if (checkbox.checked) {
                                        checkboxes.forEach((otherCheckbox) => {
                                            if (otherCheckbox !== checkbox) {
                                                otherCheckbox.checked = false; // Hanya satu yang dapat dipilih
                                            }
                                        });

                                        if (checkbox.value === "tidak") {
                                            machineRescheduleInput.removeAttribute('readonly');
                                            rescheduleNoteInput.removeAttribute('readonly');
                                        } else if (checkbox.value === "iya") {
                                            machineRescheduleInput.setAttribute('readonly', true);
                                            rescheduleNoteInput.setAttribute('readonly', true);
                                        }

                                        // Update daterangepicker based on readonly state
                                        const datepickerId = machineRescheduleInput.getAttribute('id');
                                        if (machineRescheduleInput.hasAttribute('readonly')) {
                                            $(`#${datepickerId}`).data('daterangepicker').disable();
                                        } else {
                                            $(`#${datepickerId}`).data('daterangepicker').enable();
                                        }
                                    }
                                });
                            });

                        });
                    }

                    function updateReadonlyState() {
                        const rows = document.querySelectorAll("#dataTables tbody tr");
                        rows.forEach((row) => {
                            const checkboxTidak = row.querySelector('input[type="checkbox"][value="tidak"]');
                            const machineRescheduleInput = row.querySelector('input[name="machine_reschedule"]');
                            const rescheduleNoteInput = row.querySelector('input[name="reschedule_note"]');

                            if (checkboxTidak && checkboxTidak.checked) {
                                machineRescheduleInput.removeAttribute('readonly');
                                rescheduleNoteInput.removeAttribute('readonly');
                            } else {
                                machineRescheduleInput.setAttribute('readonly', true);
                                rescheduleNoteInput.setAttribute('readonly', true);
                            }
                        });
                    }

                    const header_modal = `
                        <h5 class="modal-title">Koreksi Reschedule Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                <div>
                                    <input class="form-control" type="text" value="${data.scheduledata[0].name_schedule_month}" readonly>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered" id="dataTables">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>NO.INVENT</th>
                                    <th>NAMA MESIN</th>
                                    <th>MODEL/TYPE</th>
                                    <th>BRAND/MERK</th>
                                    <th>NO.MESIN/AREA</th>
                                    <th>DURASI</th>
                                    <th>SCHEDULE PM</th>
                                    <th colspan="2">ACTION</th>
                                    <th>KETERSEDIAAN</th>
                                    <th>ALASAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.scheduledata.map((schedule, index) => {
                                    let reschedule_pm = null;
                                    let machineHour = 0; // Deklarasikan di sini
                                    const duration = schedule.standart_id == data.workinghourdata[0].id; // Pastikan untuk mengakses array dengan benar
                                    if (duration) {
                                        machineHour = data.workinghourdata[0].preventive_hour; // Ambil nilai preventive_hour
                                    }

                                    if (schedule.reschedule_date_3) {
                                        reschedule_pm = schedule.reschedule_date_3;
                                    } else if (schedule.reschedule_date_2) {
                                        reschedule_pm = schedule.reschedule_date_2;
                                    } else if (schedule.reschedule_date_1) {
                                        reschedule_pm = schedule.reschedule_date_1;
                                    } else {
                                        reschedule_pm = schedule.schedule_date;
                                    }

                                    // Tentukan apakah salah satu reschedule_date tidak null
                                    const isNotNull = schedule.reschedule_date_1 || schedule.reschedule_date_2 || schedule.reschedule_date_3;

                                    return `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${schedule.invent_number}</td>
                                            <td>${schedule.machine_name}</td>
                                            <td>${schedule.machine_type || '-'}</td>
                                            <td>${schedule.machine_brand || '-'}</td>
                                            <td>${schedule.machine_number || '-'}</td>
                                            <td>${machineHour} Jam</td>
                                            <td>${formatDate(schedule.schedule_date)}</td>
                                            <td>
                                                <div id="option_${schedule.schedule_id}">
                                                    <input type="checkbox" id="condition_${schedule.schedule_id}" value="iya" ${!isNotNull ? 'checked' : ''}>SESUAI
                                                </div>
                                            </td>
                                            <td>
                                                <div id="option_${schedule.schedule_id}">
                                                    <input type="checkbox" id="condition_${schedule.schedule_id}" value="tidak" ${isNotNull ? 'checked' : ''}>TIDAK SESUAI
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control datepicker" name="machine_reschedule" id="datepicker-${schedule.schedule_id}" data-schedule-date="${reschedule_pm}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="reschedule_note" placeholder="Opsional" readonly value="${schedule.reschedule_note || '-'}">
                                            </td>
                                        </tr>
                                    `;
                                }).join('')}
                            </tbody>
                        </table>
                    `;
                    const button_modal =`
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                    `;
                    $('#modal_title_planner_edit').html(header_modal);
                    $('#modal_data_planner_edit').html(data_modal);
                    $('#modal_button_planner_edit').html(button_modal);
                    updateReadonlyState();
                    selectCheckbox()

                    $('.datepicker').each(function() {
                        const scheduleDate = $(this).data('schedule-date'); // Ambil tanggal dari data attribute
                        $(this).daterangepicker({
                            parentEl: '#modal_data_planner_edit',
                            singleDatePicker: true,
                            showDropdowns: true,
                            startDate: moment(scheduleDate), // Gunakan scheduleDate yang diambil dari data attribute
                            locale: {
                                firstDay: 1,
                                format: 'DD-MM-YYYY'
                            }
                        });

                        // Tambahkan properti enable/disable manual
                        const daterangepickerInstance = $(this).data('daterangepicker');
                        daterangepickerInstance.enable = function() {
                            this.element.prop('disabled', false);
                        };
                        daterangepickerInstance.disable = function() {
                            this.element.prop('disabled', true);
                        };

                        // Set initial state based on readonly attribute
                        if ($(this).prop('readonly')) {
                            daterangepickerInstance.disable();
                        }
                    });


                    $('#saveButton').on('click', function() {
                        let machineReschedule = [];
                        let plannerBy = '{{ Auth::user()->id }}';
                        const selectedCheckboxes = $('input[type="checkbox"][value="tidak"]:checked');

                        selectedCheckboxes.each(function() {
                            const row = $(this).closest('tr');
                            const scheduleId = row.find('input[name="machine_reschedule"]').attr('id').replace('datepicker-', '');
                            const rescheduleValue = row.find('input[name="machine_reschedule"]').val();
                            const rescheduleNote = row.find('input[name="reschedule_note"]').val();
                            machineReschedule.push({ schedule_id: scheduleId, reschedule_value: rescheduleValue, reschedule_note: rescheduleNote });
                        });

                        if (confirm("Apakah yakin sudah mengetahui preventive ini?")) {
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("editmonth-planner", ':id') }}'.replace(':id', scheduleId),
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'planner_by': plannerBy,
                                    'machine_reschedule': machineReschedule
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#plannerModalEdit').modal('hide');
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
                                        $('#plannerModalEdit').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        } else {
                            // User cancelled the deletion, do nothing
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    });

    //fungsi filter button
        $('#filterButton').on('click', function() {
        const filterCard = $('#filterCard');
        filterCard.collapse('toggle');
    });
</script>

@endpush
