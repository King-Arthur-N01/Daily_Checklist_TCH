@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Schedule Preventive Mesin</h1>
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <tr>
                                    <th>ACTION</th>
                                    <th>NO.</th>
                                    <th>SCHEDULE PERTAHUN</th>
                                    <th>JUMLAH SCHEDULE MESIN</th>
                                    <th>STATUS</th>
                                    <th>STATUS</th>
                                    <th>TANGGAL PEMBUATAN</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/formatdate.js') }}"></script>
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
                    url: '{{ route("refreshyear") }}',
                    dataSrc: function(data) {
                        return data.refreshschedule.map((refreshschedule, index) => {
                            return {
                                number: index + 1,
                                id: refreshschedule.id,
                                name_schedule: refreshschedule.name_schedule_year,
                                id_machine: refreshschedule.machine_schedules_count,
                                status_1: refreshschedule.schedule_recognize,
                                status_2: refreshschedule.schedule_agreed,
                                created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: '2-digit'
                                }),
                                actions: `
                                    <div class="dynamic-button-group">
                                        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item-custom-primary-more print_quarter2" data-id="${refreshschedule.id}"><i class="bi bi-printer-fill"></i>&nbsp;print Quarter 2</button>
                                            <button class="dropdown-item-custom-primary-more print_quarter1" data-id="${refreshschedule.id}"><i class="bi bi-printer-fill"></i>&nbsp;print Quarter 1</button>
                                            <button class="dropdown-item-custom-primary-more print_year" data-id="${refreshschedule.id}"><i class="bi bi-printer-fill"></i>&nbsp;Print Annual</button>
                                        </div>
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
                    { data: 'number' },
                    { data: 'name_schedule' },
                    { data: 'id_machine' },
                    { data: 'status_1', render: function(data, type, row) {
                        return data === null ? '<span class="badge badge-danger">Belum Diketahui</span>' : '<span class="badge badge-success">Sudah Diketahui</span>';
                    }},
                    { data: 'status_2', render: function(data, type, row) {
                        return data === null ? '<span class="badge badge-danger">Belum Disetujui</span>' : '<span class="badge badge-success">Sudah Disetujui</span>';
                    }},
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
                        url: '{{route("refreshdetailyear", ":id")}}'.replace(':id', rowId),
                        success: function(data) {
                            let tableRows = '';

                            if (!data.refreshscheduledetail || data.refreshscheduledetail.length === 0) {
                                tableRows = `
                                    <tr>
                                        <td colspan="5">
                                            <h5 style="text-align: center;">Data perbulan tidak ditemukan !!!!</h5>
                                        </td>
                                    </tr>
                                `;
                            } else {
                                data.refreshscheduledetail.forEach((schedulemonth, key) => {
                                    tableRows += `
                                        <tr>
                                            <td>${key + 1}</td>
                                            <td>${schedulemonth.name_schedule_month}</td>
                                            <td>${schedulemonth.machine_count}</td>
                                            <td>
                                                ${schedulemonth.schedule_planner == null ? '<span class="badge badge-danger">Belum Disetujui Planner</span>' : '<span class="badge badge-success">Sudah Disetujui Planner</span>'}
                                            </td>
                                            <td>
                                                ${schedulemonth.schedule_status == 0 ? '<span class="badge badge-danger">Unfinished</span>' : '<span class="badge badge-success">Finished</span>'}
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#viewScheduleMonth"><i class="bi bi-eye-fill"></i></button>
                                            </td>
                                        </tr>
                                    `;
                                });
                            }

                            let detailTable = `
                                <table class="table-child" id="scheduleTablesChild_1">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>SCHEDULE PERBULAN</th>
                                            <th>JUMLAH MESIN</th>
                                            <th>STATUS</th>
                                            <th>STATUS SCHEDULE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${tableRows}
                                    </tbody>
                                </table>
                            `;

                            let tableSpecial = '';

                            if (!data.refreshschedulespecial || data.refreshschedulespecial.length === 0) {
                                tableSpecial = `
                                    <tr>
                                        <td colspan="5">
                                            <h5 style="text-align: center;">Tidak ada special schedule !!!!</h5>
                                        </td>
                                    </tr>
                                `;
                            } else {
                                data.refreshschedulespecial.forEach((schedulespecial, key) => {
                                    tableSpecial += `
                                        <tr>
                                            <td>${key + 1}</td>
                                            <td>${schedulespecial.name_schedule_month}</td>
                                            <td>${schedulespecial.special_count}</td>
                                            <td>
                                                ${schedulespecial.schedule_planner == null ? '<span class="badge badge-danger">Belum Disetujui Planner</span>' : '<span class="badge badge-success">Sudah Disetujui Planner</span>'}
                                            </td>
                                            <td>
                                                ${schedulespecial.schedule_status == 0 ? '<span class="badge badge-danger">Unfinished</span>' : '<span class="badge badge-success">Finished</span>'}
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-id="${schedulespecial.getspecialid}" data-target="#viewScheduleMonth"><i class="bi bi-eye-fill"></i></button>
                                            </td>
                                        </tr>
                                    `;
                                });
                            }

                            let specialTable = `
                                <table class="table-child" id="scheduleTablesChild_2">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>SPECIAL SCHEDULE</th>
                                            <th>JUMLAH MESIN</th>
                                            <th>STATUS</th>
                                            <th>STATUS SCHEDULE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${tableSpecial}
                                    </tbody>
                                </table>
                            `;

                            // Gabungkan detailTable dan specialTable
                            let combinedTable = `
                                ${detailTable}
                                ${specialTable}
                            `;

                            // Tampilkan gabungan tabel
                            row.child(combinedTable).show();
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

            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<VIEW YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
            $(document).on('click', '.view_schedule_year', function(event) {
                let button = $(this); // Use 'this' to refer to the clicked button
                let scheduleId = button.data('id');
                let new_view = '{{ route("viewyear", ":id") }}'.replace(':id', scheduleId);
                window.open(new_view, '_blank');
            });
            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END VIEW YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>



            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<PRINT YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
            $(document).on('click', '.print_quarter2', function(event) {
                let button = $(this); // Use 'this' to refer to the clicked button
                let scheduleId = button.data('id');
                let new_view_print = '{{ route("print_quarter2", ":id") }}'.replace(':id', scheduleId);
                window.open(new_view_print, '_blank');
            });
            $(document).on('click', '.print_quarter1', function(event) {
                let button = $(this); // Use 'this' to refer to the clicked button
                let scheduleId = button.data('id');
                let new_view_print = '{{ route("print_quarter1", ":id") }}'.replace(':id', scheduleId);
                window.open(new_view_print, '_blank');
            });
            $(document).on('click', '.print_year', function(event) {
                let button = $(this); // Use 'this' to refer to the clicked button
                let scheduleId = button.data('id');
                let new_view_print = '{{ route("printyear", ":id") }}'.replace(':id', scheduleId);
                window.open(new_view_print, '_blank');
            });
            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END PRINT YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>



            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<VIEW MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
            $('#viewScheduleMonth').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let scheduleId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("viewmonth", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {
                        const header_modal = `
                            <div class="custom-header">
                                <h5 class="modal-title">Detail Preventive Mesin</h5>
                                ${data.monthlyscheduledata[0].schedule_planner === null ?
                                    '<span class="badge-custom badge-danger">Belum Disetujui Planner</span>' :
                                    '<span class="badge-custom badge-success">Sudah DIsetujui Planner</span>'
                                }
                            </div>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                    <div>
                                        <input class="form-control" type="text" value="${data.monthlyscheduledata[0].name_schedule_month}" readonly>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>NAMA MESIN</th>
                                        <th>NO INVENTARIS</th>
                                        <th>KAPASITAS</th>
                                        <th>NOMOR MESIN</th>
                                        <th>RENCANA TANGGAL</th>
                                        <th>KETERSEDIAAN</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.monthlyscheduledata.map((schedule, index) => {
                                        let reschedulePM = null;
                                        let scheduleHour = JSON.parse(schedule.schedule_hour);
                                        let startTime = null;
                                        let endTime = null;

                                        if (scheduleHour == null) {
                                            startTime = 'Belum ada';
                                            endTime = 'Belum ada'
                                        } else {
                                            startTime = scheduleHour.length > 0 ? scheduleHour[0] : 'Belum ada';
                                            endTime = scheduleHour.length > 1 ? scheduleHour[1] : 'Belum ada';
                                        }
                                        let scheduleStatus = null;

                                        if (schedule.reschedule_date_3) {
                                            reschedulePM = formatDate(schedule.reschedule_date_3) + ' ***';
                                        } else if (schedule.reschedule_date_2) {
                                            reschedulePM = formatDate(schedule.reschedule_date_2) + ' **';
                                        } else if (schedule.reschedule_date_1) {
                                            reschedulePM = formatDate(schedule.reschedule_date_1) + ' *';
                                        } else {
                                            reschedulePM = formatDate(schedule.schedule_date);
                                        }

                                        if (schedule.machine_schedule_status === 0) {
                                            scheduleStatus = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                        } else if (schedule.machine_schedule_status === 1) {
                                            scheduleStatus = '<span class="badge badge-success">Sudah Dikerjakan</span>';
                                        } else if (schedule.machine_schedule_status === 2){
                                            scheduleStatus = '<span class="badge badge-warning">Terjadi Abnormal</span>';
                                        }
                                        return `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${schedule.machine_name}</td>
                                                <td>${schedule.invent_number}</td>
                                                <td>${schedule.machine_type || '-'}</td>
                                                <td>${schedule.machine_number || '-'}</td>
                                                <td>${reschedulePM}</td>
                                                <td>${startTime} - ${endTime}</td>
                                                <td>${scheduleStatus}</td>
                                            </tr>
                                        `;
                                    }).join('')}
                                </tbody>
                            </table>
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="printButton">Print Mesin</button>
                        `;
                        $('#modal_title_month_view').html(header_modal);
                        $('#modal_data_month_view').html(data_modal);
                        $('#modal_button_month_view').html(button_modal);

                        // Add event listener to print button
                        $('#printButton').on('click', function() {
                            new_url_pdf = '{{ route("printmonth", ':id') }}'.replace(':id', scheduleId);
                            window.open(new_url_pdf, '_blank');
                            return;
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });
            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END VIEW MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
        });

        //fungsi filter button
            $('#filterButton').on('click', function() {
            const filterCard = $('#filterCard');
            filterCard.collapse('toggle');
        });
    </script>

@endpush
