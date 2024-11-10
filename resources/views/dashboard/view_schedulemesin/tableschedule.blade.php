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
                <div class="card card-filter collapse" id="filterCard">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <div class="table-filter">
                        <div class="col-4">
                            <p class="mg-b-10">Tahun Schedule </p>
                            <input class="form-control" id="filterByNumber">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Nama Mesin</p>
                            <input class="form-control" id="filterByName">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Standarisasi Mesin</p>
                            <select class="form-control" id="filterByProperty">
                                {{-- <option selected="selected">Select :</option>
                                @foreach ($fetchmachines as $getmachine)
                                    <option value="{{$getmachine->name_property}}">{{$getmachine->name_property}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#addScheduleYear" tabindex="0"><i class="bi bi-calendar2-plus-fill"></i>&nbsp; Schedule Tahunan Mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <tr>
                                    <th>ACTION</th>
                                    <th>NO.</th>
                                    <th>SCHEDULE PERTAHUN</th>
                                    <th>JUMLAH MESIN</th>
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

    <!-- Add Modal -->
    <div class="modal fade show" id="addScheduleYear" tabindex="-1">
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
    <div class="modal fade show" id="editScheduleYear" tabindex="-1">
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

    <!-- Add Modal Month -->
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
    <!-- End Add Modal Month-->

    <!-- Edit Modal Month -->
    <div class="modal fade" id="editScheduleMonth" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_month_edit">
                </div>
                <div class="modal-body" id="modal_data_month_edit">
                </div>
                <div class="modal-footer" id="modal_button_month_edit">
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal Month-->


    <!-- Add Modal Month -->
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
    <!-- End Add Modal Month-->

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

        let nameScheduleYear = "";
        let nameScheduleMonth = "";
        let combinedMachineId = [];

        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refreshschedule") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            number: index + 1,
                            id: refreshschedule.id,
                            name_schedule_year: refreshschedule.name_schedule_year,
                            id_machine: JSON.parse(refreshschedule.machine_collection.split(',').length),
                            schedule_status: refreshschedule.schedule_status,
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                <div class="dynamic-button-group">
                                    <button class="btn btn-success btn-circle" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#addScheduleMonth"><i class="bi bi-plus-circle-fill"></i></button>
                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item-custom-detail" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#viewScheduleYear"><i class="bi bi-eye-fill"></i>&nbsp;Detail</a>
                                            <a class="dropdown-item-custom-edit" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#editScheduleYear"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a>
                                            <a class="dropdown-item-custom-delete delete_button_year" data-id="${refreshschedule.id}" id="delete_schedule_month"><i class="bi bi-trash3-fill"></i>&nbsp;Delete</a>
                                        </div>
                                    </a>
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
                { data: 'name_schedule_year' },
                { data: 'id_machine' },
                { data: 'schedule_status', render: function(data, type, row) {
                    if (data === 0) {
                        return '<span class="badge badge-danger">UNFINISHED</span>';
                    } else if (data === 1) {
                        return '<span class="badge badge-success">COMPLETED</span>';
                    }
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
                    url: '{{route("refreshdetailschedule", ":id")}}'.replace(':id', rowId),
                    success: function(data) {

                        let tableRows = '';

                        if (!data.refreshscheduledetail || data.refreshscheduledetail.length === 0) {
                            tableRows = `
                                <tr>
                                    <td colspan="5">
                                        <h5 style="text-align: center;">ERROR DATA PERBULAN TIDAK DITEMUKAN!</h5>
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
                                            ${schedulemonth.schedule_status === 0 ? '<span class="badge badge-danger">UNFINISHED</span>' : schedulemonth.schedule_status === 1 ? '<span class="badge badge-success">COMPLETED</span>' : ''}
                                        </td>
                                        <td>
                                            <div class="dynamic-button-group">
                                                <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item-custom-detail" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#viewScheduleMonth"><i class="bi bi-eye-fill"></i>&nbsp;Detail</a>
                                                    <a class="dropdown-item-custom-edit" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#editScheduleMonth"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a>
                                                    <a class="dropdown-item-custom-delete delete_button_month" data-id="${schedulemonth.getmonthid}" id="delete_schedule_month"><i class="bi bi-trash-fill"></i>&nbsp;Delete</a>
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
                                        <th>JUMLAH MESIN</th>
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
                url: '{{ route("readmachinedata") }}',
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Tambah Schedule Mesin Periode Pertahun</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    combinedMachineId = [];
                    nameScheduleYear = "";

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
                            parentEl: '#modal_data_add',
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
                                            <input class="form-control" id="name_schedule_year" type="text" placeholder="Nama Jadwal">
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
                                    <div class="form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" style="margin-right: 20px;" for="gridCheck1">
                                            Check All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `;

                        document.getElementById("modal_data_add").innerHTML = tableRows1;

                        let inputSchedule = document.getElementById("name_schedule_year");
                        inputSchedule.addEventListener('input', function() {
                            nameScheduleYear = inputSchedule.value;
                        });

                        let checkboxes = document.getElementsByName("machineinput");
                        checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));

                        // Add event listener for the "Check All" checkbox
                        const checkAll = document.getElementById("checkAll");
                        checkAll.addEventListener('change', function() {
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = checkAll.checked;
                            });
                            updateSelectedMachines();
                        });
                    }

                    // Display the selected machines in the second modal (confirmation menu)
                    function renderSecondMenu() {
                        const selectedMachines = data.refreshmachine.filter(machine =>
                            combinedMachineId.includes(machine.id.toString())
                        );

                        let tableRows2 = `
                            <h5>SAAT PEMBUATAN JADWAL PREVENTIVE DIUSAHAKAN AMBIL DITANGGAL YANG BERTEPATAN DENGAN HARI SENIN!!!!</h5>
                            <form id="addSchedule" method="post">
                                <input type="hidden" name="name_schedule_year" value="${nameScheduleYear}">
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
                                                    <input type="hidden" name="machine_id_year" value="${machine.id}">
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
                            if (nameScheduleYear === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2, nameScheduleYear);
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
            let scheduleName = $('input[name="name_schedule_year"]').val();
            let scheduleTimes = [];
            let idMachines = [];

            $('input[name="schedule_time"]').each(function() {
                scheduleTimes.push($(this).val());
            });
            $('input[name="machine_id_year"]').each(function() {
                idMachines.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '{{ route("addschedule") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name_schedule' : scheduleName,
                    'schedule_time[]': scheduleTimes,
                    'machine_id[]': idMachines,
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
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<EDIT YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI UBAH MESIN PERTAHUN & PERKIRAAN WAKTU PREVENTIVE
        $('#editScheduleYear').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("findscheduleid", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Edit Schedule Mesin Periode Pertahun</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    combinedMachineId = [];
                    nameScheduleYear = "";

                    // Check if previous selections exist in sessionStorage
                    let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                    // Function to update selected machines
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

                    // Function to initialize date range picker with dynamic values
                    function selectDateRange(inputSelector, startDate, endDate) {
                        $(inputSelector).daterangepicker({
                            parentEl: '#modal_data_edit',
                            startDate: startDate,
                            endDate: endDate,
                            showDropdowns: true,
                            locale: {
                                format: 'DD-MM-YYYY'
                            },
                            maxSpan: {
                                days: 6
                            }
                        });
                    }

                    // Function to render the first menu
                    function renderFirstMenu() {
                        let tableRows1 = `
                            <div class="row align-items-center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" id="name_schedule_year_edit" type="text" placeholder="Nama Jadwal" value="${data.refreshschedule.name_schedule_year}">
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
                                        let machineIds = JSON.parse(data.refreshschedule.machine_collection);
                                        data.refreshmachine.forEach((machine, index) => {
                                            tableRows1 += `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${machine.invent_number}</td>
                                                    <td>${machine.machine_number}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type}</td>
                                                    <td>${machine.machine_brand}</td>
                                                    <td>
                                                        <input type="checkbox" name="machineinput" value="${machine.id}" ${machineIds.map(String).includes(String(machine.id)) ? 'checked' : ''}>
                                                    </td>
                                                </tr>
                                            `;
                                        });
                        tableRows1 += `
                                        </tbody>
                                    </table>
                                    <div class="form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" style="margin-right: 20px;" for="gridCheck1">
                                            Check All
                                        </label>
                                    </div>
                                </div>
                            </div>`;

                        document.getElementById("modal_data_edit").innerHTML = tableRows1;

                        let inputSchedule = document.getElementById("name_schedule_year_edit");
                        nameScheduleYear = inputSchedule.value;
                        inputSchedule.addEventListener('input', function() {
                            nameScheduleYear = inputSchedule.value;
                        });

                        combinedMachineId = [];
                        let checkboxes = document.getElementsByName("machineinput");
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                combinedMachineId.push(checkbox.value);
                            }
                            $('#modal_data_edit').off('change', "input[name='machineinput']").on('change', "input[name='machineinput']", updateSelectedMachines);
                            // checkbox.addEventListener('change', updateSelectedMachines);
                        });
                        // Add event listener for the "Check All" checkbox
                        const checkAll = document.getElementById("checkAll");
                        checkAll.addEventListener('change', function() {
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = checkAll.checked;
                            });
                            updateSelectedMachines();
                        });
                        updateSelectedMachines();
                        sessionStorage.setItem('tempData', JSON.stringify(combinedMachineId));
                    }

                    // Function to render the second menu with dynamic date ranges
                    function renderSecondMenu() {
                        const selectedMachines = data.refreshmachine.filter(machine =>
                            combinedMachineId.includes(machine.id.toString())
                        );

                        let tableRows2 = `
                            <h5>SAAT PEMBUATAN JADWAL PREVENTIVE DIUSAHAKAN AMBIL DITANGGAL YANG BERTEPATAN DENGAN HARI SENIN!!!!</h5>
                            <form id="addSchedule" method="post">
                                <input type="hidden" name="name_schedule_year_edit" value="${nameScheduleYear}">
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
                                        let machineSchedule = data.refreshmachineschedule.find(schedule => schedule.machine_id === machine.id);
                                        let ScheduleIds = machineSchedule ? machineSchedule.id : ''; // Assign schedule ID if available
                                        let startDate = machineSchedule ? moment(machineSchedule.schedule_start).format('DD-MM-YYYY') : moment().format('DD-MM-YYYY');
                                        let endDate = machineSchedule ? moment(machineSchedule.schedule_end).format('DD-MM-YYYY') : moment().add(6, 'days').format('DD-MM-YYYY');
                                        tableRows2 += `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${machine.invent_number}</td>
                                                <td>${machine.machine_number}</td>
                                                <td>${machine.machine_name}</td>
                                                <td>${machine.machine_type}</td>
                                                <td>${machine.machine_brand}</td>
                                                <td>
                                                    <input class="form-control daterange-picker" id="schedule_time_${machine.id}" type="text" name="schedule_time">
                                                    <input type="hidden" name="machine_id_year2" value="${machine.id}">
                                                    <input type="hidden" name="machine_schedule_id" value="${ScheduleIds}">
                                                </td>
                                            </tr>
                                        `;

                                        setTimeout(() => {
                                            selectDateRange(`#schedule_time_${machine.id}`, startDate, endDate);
                                        }, 0);
                                    });
                    tableRows2 += `
                                    </tbody>
                                </table>
                            </form>`;

                        document.getElementById("modal_data_edit").innerHTML = tableRows2;
                    }

                    // Modal button functionality to switch between menus
                    function changeMenu(step) {
                        const button_modal1 = `
                            <button class="btn dynamic-button btn-secondary" id="previousButton"><i class="bi bi-arrow-left"></i>Previous</button>
                            <button class="btn dynamic-button btn-primary" id="nextButton">Next<i class="bi bi-arrow-right"></i></button>
                        `;
                        const button_modal2 = `
                            <button class="btn dynamic-button btn-secondary" id="previousButton"><i class="bi bi-arrow-left"></i>Previous</button>
                            <button class="btn dynamic-button btn-primary" id="editYearlyButton">Confirm<i class="bi bi-check2-circle"></i></button>
                        `;
                        if (step === 1) {
                            renderFirstMenu();
                            document.getElementById("modal_button_edit").innerHTML = button_modal1;
                            document.getElementById("previousButton").disabled = true;
                        } else if (step === 2) {
                            renderSecondMenu();
                            document.getElementById("modal_button_edit").innerHTML = button_modal2;
                            document.getElementById("editYearlyButton").addEventListener('click', function() {
                                editYearlySchedule(scheduleId);
                            });
                        }
                    }

                    $('#modal_title_edit').html(header_modal);
                    changeMenu(1);

                    document.getElementById("modal_button_edit").addEventListener('click', function(event) {
                        if (event.target.id === "previousButton") {
                            changeMenu(1);
                        } else if (event.target.id === "nextButton") {
                            if (nameScheduleYear === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2, nameScheduleYear);
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
        function editYearlySchedule(scheduleId) {
            event.preventDefault();
            let scheduleName = $('input[name="name_schedule_year_edit"]').val();
            let scheduleTimes = [];
            let idMachines = [];
            let idMachineSchedule = [];

            $('input[name="schedule_time"]').each(function() {
                scheduleTimes.push($(this).val());
            });
            $('input[name="machine_id_year2"]').each(function() {
                idMachines.push($(this).val());
            });
            $('input[name="machine_schedule_id"]').each(function() {
                idMachineSchedule.push($(this).val());
            });
            $.ajax({
                type: 'PUT',
                url: '{{ route("editschedule", ':id') }}'.replace(':id', scheduleId),
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name_schedule_edit' : scheduleName,
                    'schedule_time[]': scheduleTimes,
                    'machine_id[]': idMachines,
                    'machine_schedule_id[]': idMachineSchedule,
                },
                success: function(response) {
                    if (response.success) {
                        const successMessage = response.success;
                        $('#successText').text(successMessage);
                        $('#successModal').modal('show');
                    }
                    setTimeout(function() {
                        $('#successModal').modal('hide');
                        $('#editScheduleYear').modal('hide');
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
                        $('#editScheduleYear').modal('hide');
                    }, 2000);
                }
            }).always(function() {
                table.ajax.reload(null, false);
            });
        }
        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END EDIT YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
                url: '{{ route("readscheduleyear", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Tambah Schedule Mesin Periode Perbulan</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    combinedMachineId = [];
                    nameScheduleMonth = "";
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
                            parentEl: '#modal_data_month_add',
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
                        // MENGAMBIL 1 VALUE PADA ARRAY MACHINE_SCHEDULE_YEARS UNTUK MENGISI MONTHLY_SCHEDULES id_schedule_year
                        let tableRows1 = `
                            <div class="row" align-items="center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" id="name_schedule_month" type="text" placeholder="Periode :">
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

                        let inputSchedule = document.getElementById("name_schedule_month");
                        inputSchedule.addEventListener('input', function() {
                            nameScheduleMonth = inputSchedule.value;
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
                                <input type="hidden" name="name_schedule_month" value="${nameScheduleMonth}">
                                <input type="hidden" name="id_schedule_year" value="${selectedMachines[0].yearly_id}">
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
                                                        <input type="hidden" name="machine_schedule_id" value="${machine.getmachinescheduleid}">
                                                        <input type="hidden" name="machine_id_month" value="${machine.id}">
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
                            if (nameScheduleMonth === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2, nameScheduleMonth, idSchedule);
                                selectSingleDate();
                                console.log(combinedMachineId);
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
            let scheduleName = $('input[name="name_schedule_month"]').val();
            let scheduleYearId = $('input[name="id_schedule_year"]').val();
            let scheduleDuration = [];
            let scheduleDate = [];
            let idMachines = [];
            let idMachineSchedule = [];

            $('input[name="schedule_duration"]').each(function() {
                scheduleDuration.push($(this).val());
            });
            $('input[name="schedule_date"]').each(function() {
                scheduleDate.push($(this).val());
            });
            $('input[name="machine_id_month"]').each(function() {
                idMachines.push($(this).val());
            });
            $('input[name="machine_schedule_id"]').each(function() {
                idMachineSchedule.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '{{ route("addschedulemonth") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name_schedule' : scheduleName,
                    'id_schedule_year' : scheduleYearId,
                    'schedule_duration[]': scheduleDuration,
                    'schedule_date[]': scheduleDate,
                    'machine_id[]': idMachines,
                    'machine_schedule_id[]': idMachineSchedule,
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
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<EDIT MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI EDIT MESIN BEDASARKAN DATA DARI SCHEDULE PERTAHUN & PENENTUAN WAKTU FIX PREVENTIVE
        $('#editScheduleMonth').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("findschedulemonthid", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Edit Schedule Mesin Periode Perbulan</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    combinedMachineId = [];
                    nameScheduleMonth = "";
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
                            parentEl: '#modal_data_month_edit',
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
                        let tableRows1 = `
                            <div class="row" align-items="center">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                        <div>
                                            <input class="form-control" id="name_schedule_month_edit" type="text" placeholder="Periode :" value="${data.refreshschedule.name_schedule_month}">
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
                                        let machineIds = JSON.parse(data.refreshschedule.machine_collection2);
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
                                                    <td>
                                                        <input type="checkbox" name="machineinput" value="${machine.id}" ${machineIds.map(String).includes(String(machine.id)) ? 'checked' : ''}>
                                                    </td>
                                                </tr>
                                            `;
                                        });
                        tableRows1 += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;

                        document.getElementById("modal_data_month_edit").innerHTML = tableRows1;

                        let inputSchedule = document.getElementById("name_schedule_month_edit");
                        nameScheduleMonth = inputSchedule.value;
                        inputSchedule.addEventListener('input', function() {
                            nameScheduleMonth = inputSchedule.value;
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
                                <input type="hidden" name="name_schedule_month_edit" value="${nameScheduleMonth}">
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
                                                        <input name="schedule_duration" type="number" class="form-control" value="${machine.schedule_duration}" placeholder="Dihitung Perjam">
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
                                                        <input type="hidden" name="machine_schedule_id" value="${machine.getmachinescheduleid}">
                                                        <input type="hidden" name="machine_id_month2" value="${machine.id}">
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

                        document.getElementById("modal_data_month_edit").innerHTML = tableRows2;

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
                            <button class="btn dynamic-button btn-primary" id="editMonthlyButton">Confirm<i class="bi bi-check2-circle"></i></button>
                        `;
                        if (step === 1) {
                            renderFirstMenu();
                            document.getElementById("modal_button_month_edit").innerHTML = button_modal1;
                            document.getElementById("previousButton").disabled = true;
                        } else if (step === 2) {
                            renderSecondMenu();
                            document.getElementById("modal_button_month_edit").innerHTML = button_modal2;
                            document.getElementById("editMonthlyButton").addEventListener('click', function() {
                                editMonthlySchedule(scheduleId);
                            });
                        }
                    }

                    $('#modal_title_month_edit').html(header_modal);
                    changeMenu(1);

                    document.getElementById("modal_button_month_edit").addEventListener('click', function(event) {
                        if (event.target.id === "previousButton") {
                            changeMenu(1);
                        }
                    });

                    document.getElementById("modal_button_month_edit").addEventListener('click', function(event) {
                        if (event.target.id === "nextButton") {
                            updateSelectedMachines();
                            if (nameScheduleMonth === "") {
                                alert("Harap masukan nama untuk jadwal.!!!");
                            } else {
                                changeMenu(2, nameScheduleMonth, idSchedule);
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
        function editMonthlySchedule(scheduleId) {
            event.preventDefault();
            let scheduleName = $('input[name="name_schedule_month_edit"]').val();
            let scheduleDuration = [];
            let scheduleDate = [];
            let idMachines = [];
            let idMachineSchedule = [];

            $('input[name="schedule_duration"]').each(function() {
                scheduleDuration.push($(this).val());
            });
            $('input[name="schedule_date"]').each(function() {
                scheduleDate.push($(this).val());
            });
            $('input[name="machine_id_month2"]').each(function() {
                idMachines.push($(this).val());
            });
            $('input[name="machine_schedule_id"]').each(function() {
                idMachineSchedule.push($(this).val());
            });
            $.ajax({
                type: 'PUT',
                url: '{{ route("editschedulemonth", ':id') }}'.replace(':id', scheduleId),
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name_schedule' : scheduleName,
                    'schedule_duration[]': scheduleDuration,
                    'schedule_date[]': scheduleDate,
                    'machine_id[]': idMachines,
                    'machine_schedule_id[]': idMachineSchedule,
                },
                success: function(response) {
                    if (response.success) {
                        const successMessage = response.success;
                        $('#successText').text(successMessage);
                        $('#successModal').modal('show');
                    }
                    setTimeout(function() {
                        $('#successModal').modal('hide');
                        $('#editScheduleMonth').modal('hide');
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
                        $('#editScheduleMonth').modal('hide');
                    }, 2000);
                }
            }).always(function() {
                table.ajax.reload(null, false);
            });
        }
        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END EDIT MONTHLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
                    const header_modal = `
                        <div class="custom-header">
                            <h5 class="modal-title">Detail Preventive Mesin</h5>
                            ${data.getscheduledetail[0].schedule_status === 0 ?
                                '<span class="badge-custom badge-danger">UNFINISHED</span>' :
                                '<span class="badge-custom badge-success">COMPLETED</span>'
                            }
                        </div>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;
                    const data_modal = `
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                <div>
                                    <input class="form-control" type="text" value="${data.getscheduledetail[0].name_schedule_month}" readonly>
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
                                    <th>RENCANA TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.getscheduledetail.map((schedule, index) => {
                                    let scheduleStart = new Date(schedule.schedule_start);
                                    let scheduleEnd = new Date(schedule.schedule_end);
                                    let scheduleDate = new Date(schedule.schedule_date);
                                    let isNotCorrect = !(scheduleDate >= scheduleStart && scheduleDate <= scheduleEnd);
                                    let displayDate = isNotCorrect ? 'Data Perlu Diperbaiki' : formatDate(schedule.schedule_date);
                                    return `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${schedule.machine_name}</td>
                                            <td>${schedule.invent_number}</td>
                                            <td>${schedule.machine_type}</td>
                                            <td>${schedule.machine_number}</td>
                                            <td>${schedule.schedule_duration}</td>
                                            <td>${displayDate}</td>
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
                        new_url_pdf = '{{ route("printschedulemonth", ':id') }}'.replace(':id', scheduleId);
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

        // fungsi delete button untuk hapus schedule pertahun
        $('#scheduleTables').on('click', '.delete_button_year', function(e) {
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

        // fungsi delete button untuk hapus schedule perbulan
        $('#scheduleTables tbody').on('click', '.delete_button_month', function(e) {
            e.preventDefault();
            const button = $(this);
            const machineId = button.data('id');
            if (confirm("Apakah yakin menghapus schedule ini?")) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("removeschedulemonth", ':id') }}'.replace(':id', machineId),
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

    //fungsi filter button
        $('#filterButton').on('click', function() {
        const filterCard = $('#filterCard');
        filterCard.collapse('toggle');
    });
</script>

@endpush
