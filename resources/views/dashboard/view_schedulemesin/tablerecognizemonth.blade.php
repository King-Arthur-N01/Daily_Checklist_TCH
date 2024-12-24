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

    <!-- Recognize Schedule Month -->
    <div class="modal fade show" id="recognizeModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_recognize">
                </div>
                <div class="modal-body" id="modal_data_recognize">
                </div>
                <div class="modal-footer" id="modal_button_recognize">
                </div>
            </div>
        </div>
    </div>
    <!-- End Recognize Schedule Month -->

    <!-- View Schedule Month -->
    <div class="modal fade" id="viewScheduleMonth" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_month_view">
                </div>
                <div class="modal-body" id="modal_data_month_view">
                </div>
                <div class="modal-footer" id="modal_button_month_view">
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
                url: '{{ route("refreshmonth") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            number: index + 1,
                            name_schedule: refreshschedule.name_schedule_month,
                            total_schedule: JSON.parse(refreshschedule.schedule_collection.split(',').length),
                            schedule_status: refreshschedule.schedule_recognize ? (refreshschedule.schedule_recognize > 0 ? 'Sudah Disetujui Planner' : 'Belum Disetujui Planner') : 'Belum Disetujui Planner',
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                    <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#recognizeModal"><i class="bi bi-pencil-square"></i></button>
                            `
                        };
                    });
                }
            },
            columns: [
                { data: 'number' },
                { data: 'name_schedule' },
                { data: 'total_schedule' },
                { data: 'schedule_status' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });


        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<KOREKSI SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI TAMBAH MESIN PERBULAN & PERKIRAAN WAKTU PREVENTIVE
        $('#recognizeModal').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("viewmonth", ':id') }}'.replace(':id', scheduleId),
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
                        <h5 class="modal-title">Koreksi Schedule Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                <div>
                                    <input class="form-control" type="text" value="${data.getschedulemonth[0].name_schedule_month}" readonly>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered" id="dataTables">
                            <thead>
                                <tr>
                                    <th>NO.INVENT</th>
                                    <th>NAMA MESIN</th>
                                    <th>MODEL/TYPE</th>
                                    <th>BRAND/MERK</th>
                                    <th>NO.MESIN/AREA</th>
                                    <th>KETERANGAN</th>
                                    <th>DURASI</th>
                                    <th>RENCANA PM</th>
                                    <th colspan="2">ACTION</th>
                                    <th>KETERSEDIAAN</th>
                                    <th>ALASAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.getschedulemonth.map((schedule, index) => {
                                    let scheduleStart = new Date(schedule.schedule_start);
                                    let scheduleEnd = new Date(schedule.schedule_end);
                                    let scheduleDate = new Date(schedule.schedule_date);
                                    let isNotCorrect = !(scheduleDate >= scheduleStart && scheduleDate <= scheduleEnd);
                                    let displayDate = isNotCorrect ? 'Data Perlu Diperbaiki' : formatDate(schedule.schedule_date);
                                    return `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${schedule.invent_number}</td>
                                            <td>${schedule.machine_name}</td>
                                            <td>${schedule.machine_type || '-'}</td>
                                            <td>${schedule.machine_brand || '-'}</td>
                                            <td>${schedule.machine_number || '-'}</td>
                                            <td>${schedule.schedule_duration}</td>
                                            <td>${displayDate}</td>
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
                                                <input type="text" class="form-control" name="reschedule_note" placeholder="(OPSIONAL)" readonly>
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
                    $('#modal_title_recognize').html(header_modal);
                    $('#modal_data_recognize').html(data_modal);
                    $('#modal_button_recognize').html(button_modal);
                    selectCheckbox()

                    $('.datepicker').each(function() {
                        const scheduleDate = $(this).data('schedule-date'); // Ambil tanggal dari data attribute
                        $(this).daterangepicker({
                            parentEl: '#modal_data_recognize',
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
                        let recognizeBy = '{{ Auth::user()->id }}';
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
                                url: '{{ route("editmonth-recognize", ':id') }}'.replace(':id', scheduleId),
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'recognize_by': recognizeBy,
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
                                        $('#recognizeModal').modal('hide');
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
                                        $('#recognizeModal').modal('hide');
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
