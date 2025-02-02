@extends('layouts.master')
@section('title', 'Table Preventive Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Info Preventive Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal PM Mesin</h6>
                </div>
                <div class="card-body">
                    {{-- <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#addMachinePreventive" tabindex="0"><i class="bi bi-calendar2-plus-fill"></i>&nbsp; Input PM Diluar Schedule</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered" id="preventiveTables" width="100%">
                            <thead>
                                <tr>
                                    <th>ACTION</th>
                                    <th>NO.</th>
                                    <th>NAMA SCHEDULE (TAHUN)</th>
                                    <th>JUMLAH SCHEDULE PREVENTIVE</th>
                                    <th>TANGGAL PEMBUATAN</th>
                                    <th>SCHEDULE STATUS</th>
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

    <!-- Modal Add Base on Preventive -->
    <div class="modal fade" id="baseOnSchedule" tabindex="-1" role="dialog" aria-labelledby="baseOnScheduleLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_onschedule"></div>
                <div class="modal-body" id="modal_data_onschedule"></div>
                <div class="modal-body" id="modal_data_pendingschedule"></div>
                <div class="modal-header" id="modal_title_offschedule" style="background-color: #f6c23e;"></div>
                <div class="modal-body" id="modal_data_offschedule"></div>
                <div class="modal-footer" id="modal_button_onschedule"></div>
            </div>
        </div>
    </div>

    <!-- Modal Add Off Preventive -->
    {{-- <div class="modal fade" id="offSchedule" tabindex="-1" role="dialog" aria-labelledby="offScheduleLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_offschedule"></div>
                <div class="modal-body" id="modal_data_offschedule"></div>
                <div class="modal-footer" id="modal_button_offschedule"></div>
            </div>
        </div>
    </div> --}}
    <!-- End Modal Add Off Preventive -->

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/formatdate.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                $('#successText').text("{{ session('success') }}");
                $('#successModal').modal('show');
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 2000);
            @elseif (session('error'))
                $('#warningText').text("{{ session('error') }}");
                $('#warningModal').modal('show');
                setTimeout(function() {
                    $('#warningModal').modal('hide');
                }, 2000);
            @endif
        });
    </script>
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
            const table = $('#preventiveTables').DataTable({
                ajax: {
                    url: '{{ route("refreshpreventive") }}',
                    dataSrc: function(data) {
                        return data.refreshpreventive.map(function(infopreventive, index) {
                            return {
                                id: infopreventive.id,
                                number: index + 1,
                                schedule_name: infopreventive.name_schedule_year,
                                machine_count: infopreventive.machine_schedules_count,
                                created_date: formatDate(infopreventive.created_at),
                                schedule_status: infopreventive.schedule_agreed,
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
                    { data: 'number' },
                    { data: 'schedule_name' },
                    { data: 'machine_count' },
                    { data: 'created_date' },
                    {
                        data: 'schedule_status',
                        render: function(data, type, row) {
                            return data === null ? '<span class="badge badge-danger">Belum Disetujui</span>' : '<span class="badge badge-success">Sudah Disetujui</span>';
                        }
                    },
                ]
            });

            $('#preventiveTables tbody').on('click', 'td.table-accordion', function () {
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
                        url: '{{route("refreshdetailpreventive", ":id")}}'.replace(':id', rowId),
                        success: function(data) {

                            let tableRows = '';

                            if (!data.refreshdetailpreventive || data.refreshdetailpreventive.length === 0) {
                                tableRows = `
                                    <tr>
                                        <td colspan="5">
                                            <h5 style="text-align: center;">ERROR DATA PERBULAN TIDAK DITEMUKAN!</h5>
                                        </td>
                                    </tr>
                                `;
                            } else {
                                data.refreshdetailpreventive.forEach((infodetailpreventive, key) => {
                                    tableRows += `
                                        <tr>
                                            <td>${key + 1}</td>
                                            <td>${infodetailpreventive.name_schedule_month}</td>
                                            <td>${infodetailpreventive.machine_count}</td>
                                            <td>${formatDate(infodetailpreventive.created_at)}</td>
                                            <td>
                                                ${infodetailpreventive.schedule_status  === 0 ? '<span class="badge badge-danger">Unfinished</span>' : infodetailpreventive.schedule_status  === 1 ? '<span class="badge badge-success">Finished</span>' : ''}
                                            </td>
                                            <td>
                                                <div class="dynamic-button-group">
                                                    <button type="button" class="btn btn-primary btn-sm" style="color:white" data-toggle="modal" data-id="${infodetailpreventive.getmonthid}" data-target="#baseOnSchedule"><i class="bi bi-pencil-square"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    `;
                                });
                            }

                            let detailTable = `
                                <table class="table-child" id="scheduleTablesChild">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>NAMA SCHEDULE (BULAN)</th>
                                            <th>JUMLAH SCHEDULE PREVENTIVE</th>
                                            <th>TANGGAL PEMBUATAN</th>
                                            <th>SCHEDULE STATUS</th>
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
                            }, 2000);
                        }
                    });
                }
            });

            function mergeCells() {
                let db = document.getElementById("offScheduleTables");
                let dbRows = db.rows;
                let lastValue1 = "";
                let lastCounter = 1;
                let lastRow = 0;
                for (let i = 0; i < dbRows.length; i++) {
                    let thisValue1 = dbRows[i].cells[0].innerHTML;
                    if (thisValue1 == lastValue1) {
                        lastCounter++;
                        dbRows[lastRow].cells[0].rowSpan = lastCounter;
                        dbRows[i].cells[0].style.display = "none";
                    } else {
                        dbRows[i].cells[0].style.display = "table-cell";
                        lastValue1 = thisValue1;
                        lastCounter = 1;
                        lastRow = i;
                    }
                }
            }

            $('#baseOnSchedule').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const scheduleId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readpreventive", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal_onschedule = `
                            <h5 class="modal-title">Base On Schedule PM Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        const data_modal_onschedule = `
                            <div class="col-xl-12">
                                <h4>${data.baseonscheduledata[0].name_schedule_month}</h4>
                            </div>
                            <table class="table table-bordered" id="onScheduleTables">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>NAMA MESIN</th>
                                        <th>NO INVENTARIS</th>
                                        <th>KAPASITAS</th>
                                        <th>NOMOR MESIN</th>
                                        <th>DURASI</th>
                                        <th>JAM PREVENTIVE</th>
                                        <th>TANGGAL PREVENTIVE</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.baseonscheduledata.map((schedule, index) => {
                                        let reschedulePM = null;
                                        let scheduleStatus = null;
                                        let actionButton = null;
                                        let machineHourData = data.workinghourdata.find(workinghour => workinghour.id === schedule.standart_id);
                                        let machineHour = machineHourData ? machineHourData.preventive_hour : '0'; // Ambil preventive_hour atau 'N/A' jika tidak ditemukan
                                        let scheduleHour = schedule.schedule_hour;

                                        if (schedule.reschedule_date_3) {
                                            reschedulePM = formatDate(schedule.reschedule_date_3) + ' ***)';
                                        } else if (schedule.reschedule_date_2) {
                                            reschedulePM = formatDate(schedule.reschedule_date_2) + ' **';
                                        } else if (schedule.reschedule_date_1) {
                                            reschedulePM = formatDate(schedule.reschedule_date_1) + ' *';
                                        } else {
                                            reschedulePM = formatDate(schedule.schedule_date);
                                        }

                                        if (schedule.machine_schedule_status === 0) {
                                            scheduleStatus = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                            actionButton = `<a class="btn btn-primary btn-sm preventiveButton" style="color:white" data-id="${schedule.schedule_id}"><i class="bi bi-play-fill"></i>Start Preventive</a>`;
                                        } else if (schedule.machine_schedule_status === 2) {
                                            scheduleStatus = '<span class="badge badge-warning">Terjadi Abnormal</span>';
                                            actionButton = `<a class="btn btn-secondary btn-sm" style="color:white"><i class="bi bi-ban-fill"></i> None</a>`;
                                        } else {
                                            scheduleStatus = '<span class="badge badge-success">Sudah Dikerjakan</span>';
                                            actionButton = `<a class="btn btn-secondary btn-sm" style="color:white"><i class="bi bi-ban-fill"></i> None</a>`;
                                        }
                                        return `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${schedule.machine_name}</td>
                                                <td>${schedule.invent_number}</td>
                                                <td>${schedule.machine_type || '-'}</td>
                                                <td>${schedule.machine_number || '-'}</td>
                                                <td>${machineHour} /Jam</td>
                                                <td>${scheduleHour.split(':').slice(0, 2).join(':') || 'Belum ada'}</td>
                                                <td>${reschedulePM}</td>
                                                <td>${scheduleStatus}</td>
                                                <td>
                                                    ${actionButton}
                                                </td>
                                            </tr>
                                        `;
                                    }).join('')}
                                </tbody>
                            </table>
                        `;

                        const data_modal_pending_schedule =
                            (!data.pendingscheduledata || data.pendingscheduledata.length === 0) ? `
                                <table class="table table-bordered" id="pendingScheduleTables">
                                    <thead>
                                        <tr>
                                            <td colspan="9">
                                                <h5 style="text-align: center;">Tidak ada PENDING SCHEDULE saat ini</h5>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            ` : `
                                <div class="col-xl-12">
                                    <h4>PENDING SCHEDULE</h4>
                                </div>
                                <table class="table table-bordered" id="pendingScheduleTables">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>NAMA MESIN</th>
                                            <th>NO INVENTARIS</th>
                                            <th>KAPASITAS</th>
                                            <th>NOMOR MESIN</th>
                                            <th>DURASI</th>
                                            <th>JAM PREVENTIVE</th>
                                            <th>TANGGAL PREVENTIVE</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.pendingscheduledata.map((pendingschedule, index) => {
                                            let pendingReschedulePM = null;
                                            let pendingScheduleStatus = null;
                                            let pendingActionButton = null;
                                            let machineHourData = data.workinghourdata.find(workinghour => workinghour.id === pendingschedule.standart_id);
                                            let machineHour = machineHourData ? machineHourData.preventive_hour : '0'; // Ambil preventive_hour atau 'N/A' jika tidak ditemukan
                                            let scheduleHour = pendingschedule.schedule_hour;

                                            if (pendingschedule.reschedule_date_3) {
                                                pendingReschedulePM = formatDate(pendingschedule.reschedule_date_3) + ' ***';
                                            } else if (pendingschedule.reschedule_date_2) {
                                                pendingReschedulePM = formatDate(pendingschedule.reschedule_date_2) + ' **';
                                            } else if (pendingschedule.reschedule_date_1) {
                                                pendingReschedulePM = formatDate(pendingschedule.reschedule_date_1) + ' *';
                                            } else {
                                                pendingReschedulePM = formatDate(pendingschedule.schedule_date);
                                            }

                                            if (pendingschedule.machine_schedule_status === 0) {
                                                pendingScheduleStatus = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                                pendingActionButton = `<a class="btn btn-primary btn-sm preventiveButton" style="color:white" data-id="${pendingschedule.schedule_id}"><i class="bi bi-play-fill"></i>Start Preventive</a>`;
                                            } else if (pendingschedule.machine_schedule_status === 2) {
                                                pendingScheduleStatus = '<span class="badge badge-warning">Terjadi Abnormal</span>';
                                                pendingActionButton = `<a class="btn btn-secondary btn-sm" style="color:white"><i class="bi bi-ban-fill"></i> None</a>`;
                                            } else {
                                                pendingScheduleStatus = '<span class="badge badge-success">Sudah Dikerjakan</span>';
                                                pendingActionButton = `<a class="btn btn-secondary btn-sm" style="color:white"><i class="bi bi-ban-fill"></i> None</a>`;
                                            }
                                            return `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${pendingschedule.machine_name}</td>
                                                    <td>${pendingschedule.invent_number}</td>
                                                    <td>${pendingschedule.machine_type || '-'}</td>
                                                    <td>${pendingschedule.machine_number || '-'}</td>
                                                    <td>${machineHour} /Jam</td>
                                                    <td>${scheduleHour.split(':').slice(0, 2).join(':') || 'Belum ada'}</td>
                                                    <td>${pendingReschedulePM}</td>
                                                    <td>${pendingScheduleStatus}</td>
                                                    <td>
                                                        ${pendingActionButton}
                                                    </td>
                                                </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
                            `;

                        const header_modal_offschedule = `
                            <h5 class="modal-title">Special Schedule PM Mesin</h5>
                        `;

                        const data_modal_offschedule =
                            (!data.offscheduledata || data.offscheduledata.length === 0) ? `
                                <table class="table table-bordered" id="offScheduleTables">
                                    <thead>
                                        <tr>
                                            <td colspan="9">
                                                <h5 style="text-align: center;">Tidak ada special schedule saat ini</h5>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            ` : `
                                <table class="table table-bordered" id="offScheduleTables">
                                    <thead>
                                        <tr>
                                            <th>SPECIAL SCHEDULE</th>
                                            <th>NO.</th>
                                            <th>NAMA MESIN</th>
                                            <th>NO INVENTARIS</th>
                                            <th>KAPASITAS</th>
                                            <th>NOMOR MESIN</th>
                                            <th>DURASI</th>
                                            <th>JAM PREVENTIVE</th>
                                            <th>TANGGAL PREVENTIVE</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.offscheduledata.map((offschedule, index) => {
                                            let offReschedulePM = null;
                                            let offScheduleStatus = null;
                                            let offActionButton = null;
                                            let machineHourData = data.workinghourdata.find(workinghour => workinghour.id === offschedule.standart_id);
                                            let machineHour = machineHourData ? machineHourData.preventive_hour : '0'; // Ambil preventive_hour atau 'N/A' jika tidak ditemukan
                                            let scheduleHour = offschedule.schedule_hour;

                                            if (offschedule.reschedule_date_3) {
                                                offReschedulePM = formatDate(offschedule.reschedule_date_3) + ' ***';
                                            } else if (offschedule.reschedule_date_2) {
                                                offReschedulePM = formatDate(offschedule.reschedule_date_2) + ' **';
                                            } else if (offschedule.reschedule_date_1) {
                                                offReschedulePM = formatDate(offschedule.reschedule_date_1) + ' *';
                                            } else {
                                                offReschedulePM = formatDate(offschedule.schedule_date);
                                            }

                                            if (offschedule.machine_schedule_status === 0) {
                                                offScheduleStatus = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                                offActionButton = `<a class="btn btn-primary btn-sm preventiveButton" style="color:white" data-id="${offschedule.schedule_id}"><i class="bi bi-play-fill"></i>Start Preventive</a>`;
                                            } else if (offschedule.machine_schedule_status === 2) {
                                                offScheduleStatus = '<span class="badge badge-warning">Terjadi Abnormal</span>';
                                                offActionButton = `<a class="btn btn-primary btn-sm continueButton" style="color:white" data-id="${offschedule.schedule_id}"><i class="bi bi-play-fill"></i>Continue Preventive</a>`;
                                            } else {
                                                offScheduleStatus = '<span class="badge badge-success">Sudah Dikerjakan</span>';
                                                offActionButton = `<a class="btn btn-secondary btn-sm" style="color:white"><i class="bi bi-ban-fill"></i> None</a>`;
                                            }
                                            return `
                                                <tr>
                                                    <td><h5>${offschedule.name_schedule_month}</h5></td>
                                                    <td>${index + 1}</td>
                                                    <td>${offschedule.machine_name}</td>
                                                    <td>${offschedule.invent_number}</td>
                                                    <td>${offschedule.machine_type || '-'}</td>
                                                    <td>${offschedule.machine_number || '-'}</td>
                                                    <td>${machineHour} /Jam</td>
                                                    <td>${scheduleHour.split(':').slice(0, 2).join(':') || 'Belum ada'}</td>
                                                    <td>${offReschedulePM}</td>
                                                    <td>${offScheduleStatus}</td>
                                                    <td>
                                                        ${offActionButton}
                                                    </td>
                                                </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
                            `;

                        const button_modal =`
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        `;
                        $('#modal_title_onschedule').html(header_modal_onschedule);
                        $('#modal_data_onschedule').html(data_modal_onschedule);
                        $('#modal_data_pendingschedule').html(data_modal_pending_schedule);
                        $('#modal_title_offschedule').html(header_modal_offschedule);
                        $('#modal_data_offschedule').html(data_modal_offschedule);
                        $('#modal_button_onschedule').html(button_modal);
                        mergeCells();

                        $(document).on('click', '.preventiveButton', function(event) {
                            const button = $(this); // Menggunakan 'this' untuk merujuk ke elemen yang diklik
                            const preventiveId = button.data('id');
                            open_url = '{{ route("formpreventive", ':id') }}'.replace(':id', preventiveId);
                            window.location.href = open_url;
                            return;
                        });

                        $(document).on('click', '.continueButton', function(event) {
                            const button = $(this); // Menggunakan 'this' untuk merujuk ke elemen yang diklik
                            const preventiveId = button.data('id');
                            open_url = '{{ route("formeditpreventive", ':id') }}'.replace(':id', preventiveId);
                            window.location.href = open_url;
                            return;
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        });
    </script>
@endpush
