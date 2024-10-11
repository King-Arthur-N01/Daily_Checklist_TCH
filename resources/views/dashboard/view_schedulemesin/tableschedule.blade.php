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
                            <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addScheduleYear" tabindex="0">+ Schedule Tahunan Mesin</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <th>ACTION</th>
                                <th>SCHEDULE PERTAHUN</th>
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
    <div class="modal fade" id="addScheduleYear" tabindex="-1">
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
    <div class="modal fade" id="editScheduleYear" tabindex="-1">
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

    <!-- Add Modal -->
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
    <!-- End Add Modal-->

    <!-- Add Modal -->
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
    <!-- End Add Modal-->

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
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterange-picker/daterangepicker.js') }}"></script>
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

        function formatDate(dateString) {
            const date = new Date(dateString);
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const day = date.getDate();
            const month = monthNames[date.getMonth()];
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }


        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refreshschedule") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map(function(refreshschedule) {
                        return {
                            id: refreshschedule.id,
                            name_schedule_year: refreshschedule.name_schedule_year,
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
                { data: 'name_schedule_year' },
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

                        if (!data.refreshscheduledetail || data.refreshscheduledetail.length === 0) {
                            tableRows = `
                                <tr>
                                    <td colspan="3">
                                        <h5 style="text-align: center;">ERROR NO DATA AVAILABEL!</h5>
                                    </td>
                                </tr>
                            `;
                        } else {
                            data.refreshscheduledetail.forEach((schedulemonth, key) => {
                                tableRows += `
                                    <tr>
                                        <td>${key + 1}</td>
                                        <td>${schedulemonth.name_schedule_month}</td>
                                        <td>
                                            ${schedulemonth.schedule_status === 0 ? '<span class="badge badge-danger">UNFINISHED</span>' : schedulemonth.schedule_status === 1 ? '<span class="badge badge-success">COMPLETED</span>' : ''}
                                        </td>
                                        <td>
                                            <div class="dynamic-button-group">
                                                <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item-custom-detail" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#viewScheduleMonth"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                                    <a class="dropdown-item-custom-edit" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                                    <a class="dropdown-item-custom-delete" data-id="${schedulemonth.getmonthid}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                                </div>
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
                                        <th>SCHEDULE PERBULAN</th>
                                        <th>STATUS SCHEDULE</th>
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

        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI TAMBAH MESIN PERTAHUN & PERKIRAAN WAKTU PREVENTIVE
        $('#addScheduleYear').on('shown.bs.modal', function(event) {
            $.ajax({
                type: 'GET',
                url: '{{ route("readmachineall") }}',
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Tambah Schedule Mesin Periode Pertahun</h5>
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

                    function selectDateRange() {
                        $('.daterange-picker').daterangepicker({
                            showDropdowns: true,
                            locale: {
                                format: 'DD-MM-YYYY'
                            },
                            maxSpan: {
                                days: 6
                            },
                        });
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

                        let inputSchedule = document.getElementById("name_schedule");
                        inputSchedule.addEventListener('input', function() {
                            nameSchedule = inputSchedule.value;
                        });

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
                                                    <input class="form-control daterange-picker" type="text" name="schedule_time">
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
                            <button class="btn dynamic-button btn-primary" id="addYearlyButton">Confirm<i class="bi bi-check2-circle"></i></button>
                        `;
                        if (step === 1) {
                            renderFirstMenu();
                            document.getElementById("modal_button_add").innerHTML = button_modal1;
                            document.getElementById("previousButton").disabled = true;
                        } else if (step === 2) {
                            renderSecondMenu();
                            document.getElementById("modal_button_add").innerHTML = button_modal2;
                            document.getElementById("addYearlyButton").addEventListener('click', function() {
                                addYearlySchedule();
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
                            if (nameSchedule === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2, nameSchedule);
                                selectDateRange();
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        // FUNGSI UNTUK SAVE BUTTON YEARLY SCHEDULE DAN MENGIRIM REQUEST AJAX
        function addYearlySchedule() {
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
                        $('#addScheduleYear').modal('hide');
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
                        $('#addScheduleYear').modal('hide');
                    }, 2000);
                }
            }).always(function() {
                table.ajax.reload(null, false);
            });
        }
        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END ADD YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>



        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI TAMBAH MESIN BEDASARKAN DATA DARI SCHEDULE PERTAHUN & PENENTUAN WAKTU FIX PREVENTIVE
        $('#addScheduleMonth').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("readscheduledata", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Tambah Schedule Mesin Periode Perbulan</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    let combinedMachineId = [];
                    let nameSchedule = '';
                    let idSchedule = '';

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

                    function selectSingleDate(inputElement, minDate, maxDate) {
                        $(inputElement).daterangepicker({
                            singleDatePicker: true,
                            showDropdowns: true,
                            minDate: minDate,
                            maxDate: maxDate,
                            locale: {
                                format: 'DD-MM-YYYY'
                            }
                        });
                    }

                    // Display machines in the first modal (selection menu)
                    function renderFirstMenu() {
                        // MENGAMBIL 1 VALUE PADA ARRAY MACHINE_SCHEDULE_YEARS UNTUK MENGISI MONTHLY_SCHEDULES id_schedulez_year2
                        let singleScheduleValue = data.getmachines[0].id_schedule_year;
                        getYearId = singleScheduleValue;

                        let tableRows1 = `
                            <div class="row" align-items="center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" id="name_schedule" type="text" placeholder="Periode :">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="machineTables1" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO INVENT</th>
                                            <th>NO MESIN</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th colspan="2">RENTANG WAKTU PREVENTIVE</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                    `;
                                        data.getmachines.forEach((machine, index) => {
                                            tableRows1 += `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${machine.invent_number}</td>
                                                    <td>${machine.machine_number}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type}</td>
                                                    <td>${machine.machine_brand}</td>
                                                    <td>${formatDate(machine.schedule_start)}</td>
                                                    <td>${formatDate(machine.schedule_end)}</td>
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

                        document.getElementById("modal_data_month_add").innerHTML = tableRows1;

                        let inputSchedule = document.getElementById("name_schedule");
                        inputSchedule.addEventListener('input', function() {
                            nameSchedule = inputSchedule.value;
                        });

                        // Re-add event listeners for new checkboxes
                        let checkboxes = document.getElementsByName("machineinput");
                        checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));
                    }

                    // Display the selected machines in the second modal (confirmation menu)
                    function renderSecondMenu() {
                        const selectedMachines = data.getmachines.filter(machine =>
                            combinedMachineId.includes(machine.id.toString())
                        );

                        let tableRows2 = `
                            <form id="addSchedule" method="post">
                                <input type="hidden" name="name_schedule" value="${nameSchedule}">
                                <input type="hidden" name="id_schedule" value="${getYearId}">
                                <table class="table table-bordered" id="machineTables2" width="100%">
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
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="bi bi-hourglass-split"></i>
                                                            </div>
                                                        </div>
                                                        <input name="schedule_duration" type="number" class="form-control" placeholder="Dihitung Perjam">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="bi bi-calendar3"></i>
                                                            </div>
                                                        </div>
                                                        <input name="schedule_date" type="text" class="form-control datepicker" id="datepicker-${machine.id}">
                                                        <input type="hidden" name="id_machine_schedule" value="${machine.getscheduleid}">
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                                    });
                        tableRows2 += `
                                    </tbody>
                                </table>
                            </form>
                        `;

                        document.getElementById("modal_data_month_add").innerHTML = tableRows2;

                        selectedMachines.forEach((machine, index) => {
                            const minDate = moment(machine.schedule_start);
                            const maxDate = moment(machine.schedule_end);
                            const datepickerInput = `#datepicker-${machine.id}`;
                            selectSingleDate(datepickerInput, minDate, maxDate);
                        });
                    }

                    // Modal button functionality to switch between menus
                    function changeMenu(step) {
                        const button_modal1 = `
                            <button class="btn dynamic-button btn-secondary" id="previousButton"><i class="bi bi-arrow-left"></i>Previous</button>
                            <button class="btn dynamic-button btn-primary" id="nextButton">Next<i class="bi bi-arrow-right"></i></button>
                        `;
                        const button_modal2 = `
                            <button class="btn dynamic-button btn-secondary" id="previousButton"><i class="bi bi-arrow-left"></i>Previous</button>
                            <button class="btn dynamic-button btn-primary" id="addMonthlyButton">Confirm<i class="bi bi-check2-circle"></i></button>
                        `;
                        if (step === 1) {
                            renderFirstMenu();
                            document.getElementById("modal_button_month_add").innerHTML = button_modal1;
                            document.getElementById("previousButton").disabled = true;
                        } else if (step === 2) {
                            renderSecondMenu();
                            document.getElementById("modal_button_month_add").innerHTML = button_modal2;
                            document.getElementById("addMonthlyButton").addEventListener('click', function() {
                                addMonthlySchedule();
                            });
                        }
                    }

                    $('#modal_title_month_add').html(header_modal);
                    changeMenu(1);

                    document.getElementById("modal_button_month_add").addEventListener('click', function(event) {
                        if (event.target.id === "previousButton") {
                            changeMenu(1);
                        }
                    });

                    document.getElementById("modal_button_month_add").addEventListener('click', function(event) {
                        if (event.target.id === "nextButton") {
                            if (nameSchedule === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2, nameSchedule, idSchedule);
                                selectSingleDate();
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        // FUNGSI UNTUK SAVE BUTTON MONTHLY SCHEDULE DAN MENGIRIM REQUEST AJAX
        function addMonthlySchedule() {
            event.preventDefault();
            let scheduleName = $('input[name="name_schedule"]').val();
            let scheduleId = $('input[name="id_schedule"]').val();
            let scheduleDuration = [];
            let scheduleDate = [];
            let idMachineSchedule = [];

            $('input[name="schedule_duration"]').each(function() {
                scheduleDuration.push($(this).val());
            });
            $('input[name="schedule_date"]').each(function() {
                scheduleDate.push($(this).val());
            });
            $('input[name="id_machine_schedule"]').each(function() {
                idMachineSchedule.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '{{ route("addschedulemonth") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name_schedule' : scheduleName,
                    'id_schedule' : scheduleId,
                    'schedule_duration[]': scheduleDuration,
                    'schedule_date[]': scheduleDate,
                    'id_machine_schedule[]': idMachineSchedule,
                },
                success: function(response) {
                    if (response.success) {
                        const successMessage = response.success;
                        $('#successText').text(successMessage);
                        $('#successModal').modal('show');
                    }
                    setTimeout(function() {
                        $('#successModal').modal('hide');
                        $('#addScheduleMonth').modal('hide');
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
                        $('#addScheduleMonth').modal('hide');
                    }, 2000);
                }
            }).always(function() {
                table.ajax.reload(null, false);
            });
        }
        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END ADD MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>



        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<VIEW MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>
        $('#viewScheduleMonth').on('shown.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("viewschedulemonth", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {
                    if (!data || !data.getscheduledetail || data.getscheduledetail.length === 0) {
                        $('#modal_data_view').html(
                            '<h4 style="text-align: center;">Error data property mesin belum tersedia!</h4>'
                        );
                    } else {
                        const header_modal = `
                            <h5 class="modal-title">Detail Preventive Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <table class="table table-bordered" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>NAMA MESIN</th>
                                        <th>NO INVENTARIS</th>
                                        <th>KAPASITAS</th>
                                        <th>NOMOR MESIN</th>
                                        <th>DURASI</th>
                                        <th>RENCANA TANGGAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ${data.getscheduledetail.map((schedule, index) => {
                                    const scheduleId = schedule.id; // Define a new variable
                                    return `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${schedule.machine_name}</td>
                                            <td>${schedule.invent_number}</td>
                                            <td>${schedule.machine_type}</td>
                                            <td>${schedule.machine_number}</td>
                                            <td>${schedule.schedule_duration}</td>
                                            <td>${formatDate(schedule.schedule_date)}</td>
                                        </tr>
                                    `;
                                }).join('')}
                                </tbody>
                            </table>
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-id="${scheduleId}" id="printButton">Print Mesin</button>
                        `;
                        $('#modal_title_month_view').html(header_modal);
                        $('#modal_data_month_view').html(data_modal);
                        $('#modal_button_month_view').html(button_modal);

                        // Add event listener to print button
                        $('#printButton').on('click', function() {
                            new_url_pdf = '{{ route("exportfile", ':id') }}'.replace(':id', machineId);
                            window.open(new_url_pdf, '_blank');
                            return;
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('error:', error);
                    $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        });
        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END<VIEW MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // fungsi delete button untuk hapus mesin
        $('#scheduleTables').on('click', '.deleteButton', function(e) {
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
