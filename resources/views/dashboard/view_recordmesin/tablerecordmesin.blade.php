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
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
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
                                    <th>NAMA SCHEDULE</th>
                                    <th>JUMLAH SCHEDULE PREVENTIVE</th>
                                    <th>TANGGAL PEMBUATAN</th>
                                    <th>SCHEDULE STATUS</th>
                                    <th>LAIN NYA</th>
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
                <div class="modal-footer" id="modal_button_onschedule"></div>
            </div>
        </div>
    </div>

    {{-- <div class="dynamic-button-group">
        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item-custom-success base_on_schedule" data-toggle="modal" data-id="${infopreventive.id}" data-target="#baseOnSchedule"><i class="bi bi-pencil-square"></i>&nbsp;Base On Schedule</button>
            <button class="dropdown-item-custom-danger pending_schedule" data-toggle="modal" data-id="${infopreventive.id}" data-target="#pendingSchedule"><i class="bi bi-alarm-fill"></i>&nbsp;Pending Schedule</button>
            <button class="dropdown-item-custom-warning special_schedule" data-toggle="modal" data-id="${infopreventive.id}" data-target="#specialSchedule"><i class="bi bi-clipboard-plus-fill"></i>&nbsp;Special Schedule</button>
        </div>
    </div> --}}
    <!-- End Modal Add Base on Preventive -->

    <!-- Modal Add Off Preventive -->
    <div class="modal fade" id="offSchedule" tabindex="-1" role="dialog" aria-labelledby="offScheduleLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_offschedule"></div>
                <div class="modal-body" id="modal_data_offschedule"></div>
                <div class="modal-footer" id="modal_button_offschedule"></div>
            </div>
        </div>
    </div>
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
                        // let scheduleIds = JSON.parse(data.refreshprevenitve.schedule_collection);
                        return data.refreshpreventive.map(function(infopreventive, index) {
                            return {
                                id: infopreventive.id,
                                number: index + 1,
                                schedule_name: infopreventive.name_schedule_year,
                                machine_count: infopreventive.machine_schedules_count,
                                created_date: formatDate(infopreventive.created_at),
                                schedule_status: infopreventive.schedule_agreed,
                                other: `<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="${infopreventive.id}" data-target="#offSchedule" tabindex="0"><i class="bi bi-calendar2-plus-fill"></i>&nbsp; Input PM Diluar Schedule</button>`
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
                            if (data === 0) {
                                return '<span class="badge badge-danger" value="0">BELUM DISETUJUI</span>';
                            } else if (data === 1) {
                                return '<span class="badge badge-success" value="1">SUDAH DISETUJUI</span>';
                            }
                        }
                    },
                    { data: 'other' }
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
                                                ${infodetailpreventive.schedule_status  === 0 ? '<span class="badge badge-danger">UNFINISHED</span>' : infodetailpreventive.schedule_status  === 1 ? '<span class="badge badge-success">COMPLETED</span>' : ''}
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
                                            <th>NAMA SCHEDULE</th>
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

            $('#baseOnSchedule').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const scheduleId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readpreventive-onschedule", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Base On Schedule PM Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        const data_modal = `
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                    <div>
                                        <input class="form-control" type="text" value="${data.baseonscheduledata[0].name_schedule_month}" readonly>
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
                                        <th>DURASI</th>
                                        <th>TANGGAL PREVENTIVE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.baseonscheduledata.map((schedule, index) => {
                                        let reschedulePM = null;
                                        let machineHourData = data.workinghourdata.find(workinghour => workinghour.id === schedule.standart_id);
                                        let machineHour = machineHourData ? machineHourData.preventive_hour : '0'; // Ambil preventive_hour atau 'N/A' jika tidak ditemukan

                                        if (schedule.reschedule_date_3) {
                                            reschedulePM = formatDate(schedule.reschedule_date_3) + ' (Reschedule ke 3)';
                                        } else if (schedule.reschedule_date_2) {
                                            reschedulePM = formatDate(schedule.reschedule_date_2) + ' (Reschedule ke 2)';
                                        } else if (schedule.reschedule_date_1) {
                                            reschedulePM = formatDate(schedule.reschedule_date_1) + ' (Reschedule)';
                                        } else {
                                            reschedulePM = formatDate(schedule.schedule_date);
                                        }
                                        return `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${schedule.machine_name}</td>
                                                <td>${schedule.invent_number}</td>
                                                <td>${schedule.machine_type || '-'}</td>
                                                <td>${schedule.machine_number || '-'}</td>
                                                <td>${machineHour} /Jam</td>
                                                <td>${reschedulePM}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" style="color:white" data-id="${schedule.schedule_id}" data-toggle="modal" data-target="#updateModal"><i class="bi bi-play-fill"></i>Start Preventive</a>
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
                        $('#modal_title_onschedule').html(header_modal);
                        $('#modal_data_onschedule').html(data_modal);
                        $('#modal_button_onschedule').html(button_modal);

                        $('#saveButton').on('click', function() {
                            if (confirm("Apakah yakin sudah mengetahui preventive ini?")) {
                                $.ajax({
                                    type: 'PUT',
                                    url: '{{ route("edityear-accept", ':id') }}'.replace(':id', scheduleId),
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'accept_by': acceptBy,
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#acceptModal').modal('hide');
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
                                            $('#acceptModal').modal('hide');
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


            $('#offSchedule').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const scheduleId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readpreventive-offschedule", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Off Schedule PM Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        const data_modal = `
                            <div class="row" align-items="center">
                                <div class="col-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Filter Nomor Invent </p>
                                        <input class="form-control" id="get_by_number">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Filter Nama Mesin</p>
                                        <input class="form-control" id="get_by_name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"Filter >Waktu Preventive</p>
                                        <select class="form-control" id="get_by_month">
                                            <option value="">Pilih bulan...</option>
                                            <option value="January">Januari</option>
                                            <option value="February">Februari</option>
                                            <option value="March">Maret</option>
                                            <option value="April">April</option>
                                            <option value="May">Mei</option>
                                            <option value="June">Juni</option>
                                            <option value="July">Juli</option>
                                            <option value="August">Agustus</option>
                                            <option value="September">September</option>
                                            <option value="October">Oktober</option>
                                            <option value="November">November</option>
                                            <option value="December">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="addMonthlyTables" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO.INVENT</th>
                                            <th>NO.MESIN/LOKASI</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>DURASI</th>
                                            <th>RENTANG WAKTU PREVENTIVE</th>
                                            <th>RENTANG WAKTU PREVENTIVE</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                        ${data.offscheduledata.map((schedule, index) => {
                                            let machineHour = 0; // Deklarasikan di sini
                                            const workingHour = data.workinghourdata.find(wo => wo.id === schedule.standart_id);
                                            if (workingHour) {
                                                machineHour = workingHour.preventive_hour; // Ambil nilai preventive_hour
                                            }
                                            return `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${schedule.invent_number}</td>
                                                    <td>${schedule.machine_number || '-'}</td>
                                                    <td>${schedule.machine_name}</td>
                                                    <td>${schedule.machine_type || '-'}</td>
                                                    <td>${schedule.machine_brand || '-'}</td>
                                                    <td>${machineHour} /Jam</td>
                                                    <td>${formatDate(schedule.schedule_start)}</td>
                                                    <td>${formatDate(schedule.schedule_end)}</td>
                                                    <td><a class="btn btn-primary btn-sm" style="color:white" data-id="${schedule.machinescheduleid}" data-toggle="modal" data-target="#updateModal"><i class="bi bi-play-fill"></i>Start Preventive</a></td>
                                                </tr>
                                            `;
                                        }).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                        const button_modal =`
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                        `;
                        $('#modal_title_offschedule').html(header_modal);
                        $('#modal_data_offschedule').html(data_modal);
                        $('#modal_button_offschedule').html(button_modal);

                        $('#saveButton').on('click', function() {
                            let acceptBy = '{{ Auth::user()->id }}';
                            if (confirm("Apakah yakin sudah mengetahui preventive ini?")) {
                                $.ajax({
                                    type: 'PUT',
                                    url: '{{ route("editmonth-accept", ':id') }}'.replace(':id', scheduleId),
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'accept_by': acceptBy,
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#acceptModal').modal('hide');
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
                                            $('#acceptModal').modal('hide');
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
    </script>
@endpush
