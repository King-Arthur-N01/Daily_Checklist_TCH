@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Schedule Preventive Mesin</h1>
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

    <!-- Add Modal Year -->
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
    <!-- End Add Modal Year-->

    <!-- Edit Modal Year -->
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
    <!-- End Edit Modal Year-->

    <!-- Add Modal Special -->
    <div class="modal fade show" id="addScheduleSpecial" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_special">
                </div>
                <div class="modal-body" id="modal_data_special">
                </div>
                <div class="modal-footer" id="modal_button_special">
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Modal Special-->

    <!-- Modal Add Machine -->
    <div class="modal fade" id="addMachineData" tabindex="-1" role="dialog" aria-labelledby="addMachineDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_machine_add"></div>
                <div class="modal-body" id="modal_data_machine_add"></div>
                <div class="modal-footer" id="modal_button_machine_add"></div>
            </div>
        </div>
    </div>
    <!-- End Modal Add Machine -->

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

            let nameScheduleYear = "";
            let nameScheduleMonth = "";
            let combinedMachineId = [];

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
                                        ${refreshschedule.schedule_recognize && refreshschedule.schedule_agreed !== null ?
                                            `<button class="btn btn-success btn-circle" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#addScheduleMonth"><i class="bi bi-plus-circle-fill"></i></button>`
                                            : ''
                                        }
                                        <button class="btn btn-warning btn-circle" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#addScheduleSpecial"><i class="bi bi-plus-circle-fill"></i></button>
                                        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item-custom-primary-more print_quarter2" data-id="${refreshschedule.id}"><i class="bi bi-printer-fill"></i>&nbsp;print Quarter 2</button>
                                            <button class="dropdown-item-custom-primary-more print_quarter1" data-id="${refreshschedule.id}"><i class="bi bi-printer-fill"></i>&nbsp;print Quarter 1</button>
                                            <button class="dropdown-item-custom-primary-more print_year" data-id="${refreshschedule.id}"><i class="bi bi-printer-fill"></i>&nbsp;Print Annual</button>
                                            <button class="dropdown-item-custom-success view_schedule_year" data-id="${refreshschedule.id}"><i class="bi bi-eye-fill"></i>&nbsp;Detail</button>
                                            <button class="dropdown-item-custom-primary" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#editScheduleYear"><i class="bi bi-pencil-square"></i>&nbsp;Edit</button>
                                            <button class="dropdown-item-custom-danger btn-delete-year" data-id="${refreshschedule.id}"><i class="bi bi-trash3-fill"></i>&nbsp;Delete</button>
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
                        return data === null ? '<span class="badge badge-danger">BELUM DIKETAHUI</span>' : '<span class="badge badge-success">SUDAH DIKETAHUI</span>';
                    }},
                    { data: 'status_2', render: function(data, type, row) {
                        return data === null ? '<span class="badge badge-danger">BELUM DISETUJUI</span>' : '<span class="badge badge-success">SUDAH DISETUJUI</span>';
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
                                                ${schedulemonth.schedule_planner  == null ? '<span class="badge badge-danger">BELUM DISETUJUI PLANNER</span>' : schedulemonth.schedule_planner  == !null ? '<span class="badge badge-success">SUDAH DISETUJUI PLANNER</span>' : ''}
                                            </td>
                                            <td>
                                                <div class="dynamic-button-group">
                                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                        <button class="dropdown-item-custom-success" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#viewScheduleMonth"><i class="bi bi-eye-fill"></i>&nbsp;Detail</button>
                                                        <button class="dropdown-item-custom-primary" data-toggle="modal" data-id="${schedulemonth.getmonthid}" data-target="#editScheduleMonth"><i class="bi bi-pencil-square"></i>&nbsp;Edit</button>
                                                        <button class="dropdown-item-custom-danger btn-delete-month" data-id="${schedulemonth.getmonthid}"><i class="bi bi-trash-fill"></i>&nbsp;Delete</button>
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

            // function mergeCells() {
            //     let db = document.getElementById("dataTables");
            //     let dbRows = db.rows;
            //     let lastValue1 = "";
            //     let lastCounter = 1;
            //     let lastRow = 0;
            //     for (let i = 0; i < dbRows.length; i++) {
            //         let thisValue1 = dbRows[i].cells[0].innerHTML;
            //         if (thisValue1 == lastValue1) {
            //             lastCounter++;
            //             dbRows[lastRow].cells[0].rowSpan = lastCounter;
            //             dbRows[i].cells[0].style.display = "none";
            //         } else {
            //             dbRows[i].cells[0].style.display = "table-cell";
            //             lastValue1 = thisValue1;
            //             lastCounter = 1;
            //             lastRow = i;
            //         }
            //     }
            //     for (let i = 0; i < dbRows.length; i++) {
            //         let thisValue2 = dbRows[i].cells[1].innerHTML;
            //         if (thisValue2 == lastValue2) {
            //             lastCounter++;
            //             dbRows[lastRow].cells[1].rowSpan = lastCounter;
            //             dbRows[i].cells[1].style.display = "none"; // Hide cells in the second column too
            //         } else {
            //             dbRows[i].cells[1].style.display = "table-cell"; // Show cells in the second column
            //             lastValue2 = thisValue2;
            //             lastCounter = 1;
            //             lastRow = i;
            //         }
            //     }
            // }


            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>

            // FUNGSI TAMBAH MESIN PERTAHUN & PERKIRAAN WAKTU PREVENTIVE
            $('#addScheduleYear').on('shown.bs.modal', function(event) {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readmachineyear") }}',
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Buat Schedule Perawatan Mesin Pertahun</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        combinedMachineId = [];
                        nameScheduleYear = "";
                        limitScheduleYear = "";

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
                                    firstDay: 1,
                                    format: 'DD-MM-YYYY'
                                },
                                maxSpan: {
                                    days: 6
                                },
                            });
                        }

                        function dropdownYear() {
                            const yearDropdown = document.getElementById('year_dropdown');
                            const currentYear = new Date().getFullYear();

                            const startYear = currentYear - 5;
                            const endYear = currentYear + 5;

                            for (let year = startYear; year <= endYear; year++) {
                                const option = document.createElement('option');
                                option.value = year;
                                option.textContent = year;
                                yearDropdown.appendChild(option);
                            }
                        }

                        function filterTable() {
                            const filterByNumber = document.getElementById('get_by_number');
                            const filterByName = document.getElementById('get_by_name');
                            const filterByInfo = document.getElementById('get_by_info');
                            const table = document.getElementById('addYearlyTable');
                            const rows = table.getElementsByTagName('tr');

                            const numberValue = filterByNumber.value.toLowerCase();
                            const nameValue = filterByName.value.toLowerCase();
                            const infoValue = filterByInfo.value.toLowerCase();

                            for (let i = 1; i < rows.length; i++) {
                                const numberCell = rows[i].getElementsByTagName('td')[1];
                                const nameCell = rows[i].getElementsByTagName('td')[2];
                                const infoCell = rows[i].getElementsByTagName('td')[5];

                                const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                const infoText = infoCell ? infoCell.textContent.toLowerCase() : '';

                                // Check if row matches the filter criteria
                                if (nameText.includes(nameValue) &&
                                    numberText.includes(numberValue) &&
                                    infoText.includes(infoValue)) {
                                    rows[i].style.display = '';  // Show the row
                                } else {
                                    rows[i].style.display = 'none';  // Hide the row
                                }
                            }

                            // Attach event listeners
                            filterByName.addEventListener('input', filterTable);
                            filterByNumber.addEventListener('input', filterTable);
                            filterByInfo.addEventListener('input', filterTable);
                        }

                        // Display machines in the first modal (selection menu)
                        function renderFirstMenu() {
                            if (!data || !Array.isArray(data.refreshmachine)) {
                                console.error("Data mesin tidak tersedia atau invalid");
                                return;
                            }

                            let tableRows1 = `
                                <div class="row" align-items="center">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                            <div>
                                                <input class="form-control" id="name_schedule_year" type="text" placeholder="Nama Jadwal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Pilih Tahun:</label>
                                            <select class="form-control" id="year_dropdown"></select>
                                        </div>
                                    </div>
                                </div>
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
                                            <p class="mg-b-10">Filter Keterangan</p>
                                            <input class="form-control" id="get_by_info">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="addYearlyTable" width="100%">
                                            <thead>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>KETERANGAN</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>PM TERAKHIR</th>
                                                <th>ADD</th>
                                            </thead>
                                            <tbody>
                                        `;
                                            data.refreshmachine.forEach((machine, index) => {
                                                let next_preventive = 'Belum ada data';
                                                const schedule = data.latestSchedules.find(
                                                    (fetchschedule) => fetchschedule.machine_id === machine.id
                                                );
                                                if (schedule) {
                                                    next_preventive = schedule.schedule_date || 'Belum ada data';
                                                }
                                                // Tambahkan baris tabel
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machine.invent_number}</td>
                                                        <td>${machine.machine_name}</td>
                                                        <td>${machine.machine_type || '-'}</td>
                                                        <td>${machine.machine_brand || '-'}</td>
                                                        <td>${machine.machine_info || '-'}</td>
                                                        <td>${machine.machine_number || '-'}</td>
                                                        <td>${next_preventive}</td>
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

                            let limitSchedule = document.getElementById("year_dropdown");
                            limitSchedule.addEventListener('change', function() {
                                limitScheduleYear = limitSchedule.value;
                            });


                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));

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
                                <h5>SAAT PEMBUATAN JADWAL PREVENTIVE MAKA JADWAL BULAN BERIKUT NYA AKAN SAMA DENGAN HARI SAAT DITENTUKAN</h5>
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_schedule_year" value="${nameScheduleYear}">
                                    <input type="hidden" name="limit_schedule_year" value="${limitScheduleYear}">
                                    <table class="table table-bordered" id="machineTables2" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>RENCANA PREVENTIVE</th>
                                                <th>DURASI PM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    `;
                                        selectedMachines.forEach((machine, index) => {
                                            tableRows2 += `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${machine.invent_number}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>
                                                        <input class="form-control daterange-picker" type="text" name="schedule_time">
                                                        <input type="hidden" name="machine_id_year" value="${machine.id}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="preventive_cycle">
                                                            <option value="3">3/Bulanan</option>
                                                            <option value="6">6/Bulanan</option>
                                                            <option value="12">12/Bulanan</option>
                                                        </select>
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
                                dropdownYear();
                                filterTable();

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
                                    changeMenu(2, nameScheduleYear, limitScheduleYear);
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
                let scheduleNameYear = null;
                let scheduleLimitYear = null;
                let scheduleCreateByYear = null;
                let scheduleTimesYear = null;
                let preventiveCycleYear = null;
                let idMachines = null;

                scheduleNameYear = $('input[name="name_schedule_year"]').val();
                scheduleLimitYear = $('input[name="limit_schedule_year"]').val();
                scheduleCreateByYear = '{{ Auth::user()->id }}';
                scheduleTimesYear = [];
                preventiveCycleYear = [];
                idMachines = [];

                $('input[name="schedule_time"]').each(function() {
                    scheduleTimesYear.push($(this).val());
                });
                $('select[name="preventive_cycle"]').each(function() {
                    preventiveCycleYear.push($(this).val());
                });
                $('input[name="machine_id_year"]').each(function() {
                    idMachines.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route("addyear") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : scheduleNameYear,
                        'limit_schedule' : scheduleLimitYear,
                        'schedule_create' : scheduleCreateByYear,
                        'schedule_time[]': scheduleTimesYear,
                        'preventive_cycle': preventiveCycleYear,
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
                            <h5 class="modal-title">Ubah Schedule Perawatan Mesin Pertahun</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        let combinedMachineId = [];
                        let nameScheduleYear = "";
                        let limitScheduleYear = "";

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
                                    firstDay: 1,
                                    format: 'DD-MM-YYYY'
                                },
                                maxSpan: {
                                    days: 6
                                }
                            });
                        }

                        function dropdownYear() {
                            const yearDropdown = document.getElementById('year_dropdown');
                            const currentYear = new Date().getFullYear();
                            const startYear = currentYear - 5;
                            const endYear = currentYear + 5;

                            for (let year = startYear; year <= endYear; year++) {
                                const option = document.createElement('option');
                                option.value = year;
                                option.textContent = year;
                                if (year == data.refreshschedule[0].schedule_year) {
                                    option.selected = true; // Tetapkan tahun default
                                }
                                yearDropdown.appendChild(option);
                            }
                            // Tetapkan nilai awal ke limitScheduleYear
                            limitScheduleYear = yearDropdown.value;
                        }


                        function filterTable() {
                            const filterByNumber = document.getElementById('get_by_number');
                            const filterByName = document.getElementById('get_by_name');
                            const filterByInfo = document.getElementById('get_by_info');
                            const table = document.getElementById('editYearlyTable');
                            const rows = table.getElementsByTagName('tr');

                            const numberValue = filterByNumber.value.toLowerCase();
                            const nameValue = filterByName.value.toLowerCase();
                            const infoValue = filterByInfo.value.toLowerCase();

                            for (let i = 1; i < rows.length; i++) {
                                const numberCell = rows[i].getElementsByTagName('td')[1];
                                const nameCell = rows[i].getElementsByTagName('td')[2];
                                const infoCell = rows[i].getElementsByTagName('td')[5];

                                const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                const infoText = infoCell ? infoCell.textContent.toLowerCase() : '';

                                // Check if row matches the filter criteria
                                if (nameText.includes(nameValue) &&
                                    numberText.includes(numberValue) &&
                                    infoText.includes(infoValue)) {
                                    rows[i].style.display = '';  // Show the row
                                } else {
                                    rows[i].style.display = 'none';  // Hide the row
                                }
                            }

                            // Attach event listeners
                            filterByName.addEventListener('input', filterTable);
                            filterByNumber.addEventListener('input', filterTable);
                            filterByInfo.addEventListener('input', filterTable);
                        }

                        // Function to render the first menu
                        function renderFirstMenu() {
                            let tableRows1 = `
                                <div class="row align-items-center">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                            <div>
                                                <input class="form-control" id="name_schedule_year_edit" type="text" placeholder="Nama Jadwal" value="${data.refreshschedule[0].name_schedule_year}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Pilih Tahun:</label>
                                            <select class="form-control" id="year_dropdown"></select>
                                        </div>
                                    </div>
                                </div>
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
                                            <p class="mg-b-10">Filter Keterangan</p>
                                            <input class="form-control" id="get_by_info">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="editYearlyTable" width="100%">
                                            <thead>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>

                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>KETERANGAN</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>PM TERAKHIR</th>
                                                <th>ADD</th>
                                            </thead>
                                            <tbody>
                                        `;
                                            // Ambil semua machine_id dari refreshschedule
                                            const selectedMachineIds = data.refreshschedule.map(schedule => schedule.machine_id);
                                            data.refreshmachine.forEach((machine, index) => {
                                                let last_preventive = 'Belum ada data';
                                                const schedule = data.latestSchedules.find(
                                                    (fetchschedule) => fetchschedule.machine_id === machine.id
                                                );
                                                if (schedule) {
                                                    last_preventive = schedule.record_date || 'Belum ada data';
                                                }
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machine.invent_number}</td>
                                                        <td>${machine.machine_name}</td>
                                                        <td>${machine.machine_type || '-'}</td>
                                                        <td>${machine.machine_brand || '-'}</td>
                                                        <td>${machine.machine_info || '-'}</td>
                                                        <td>${machine.machine_number || '-'}</td>
                                                        <td>${last_preventive}</td>
                                                        <td>
                                                            <input type="checkbox" name="machineinput" value="${machine.id}" ${selectedMachineIds.includes(machine.id) ? 'checked' : ''}>
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
                                </div>
                            `;

                            document.getElementById("modal_data_edit").innerHTML = tableRows1;

                            let inputSchedule = document.getElementById("name_schedule_year_edit");
                            nameScheduleYear = inputSchedule.value;
                            inputSchedule.addEventListener('input', function() {
                                nameScheduleYear = inputSchedule.value;
                            });

                            let limitSchedule = document.getElementById("year_dropdown");
                            limitScheduleYear = limitSchedule.value;
                            limitSchedule.addEventListener('change', function() {
                                limitScheduleYear = limitSchedule.value;
                            });

                            combinedMachineId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedMachineId.push(checkbox.value);
                                }
                                $('#modal_data_edit').off('change', "input[name='machineinput']").on('change', "input[name='machineinput']", updateSelectedMachines);
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
                                <h5>SAAT PEMBUATAN JADWAL PREVENTIVE MAKA JADWAL BULAN BERIKUT NYA AKAN SAMA DENGAN HARI SAAT DITENTUKAN</h5>
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_schedule_year_edit" value="${nameScheduleYear}">
                                    <input type="hidden" name="limit_schedule_year_edit" value="${limitScheduleYear}">
                                    <table class="table table-bordered" id="machineTables2" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>RENCANA PREVENTIVE</th>
                                                <th>DURASI PM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            `;
                                        selectedMachines.forEach((machine, index) => {
                                            const machineSchedule = data.refreshschedule.find(
                                                (schedule) => schedule.machine_id === machine.id
                                            );
                                            let startDate = machineSchedule ? moment(machineSchedule.schedule_start).format('DD-MM-YYYY') : moment().format('DD-MM-YYYY');
                                            let endDate = machineSchedule ? moment(machineSchedule.schedule_end).format('DD-MM-YYYY') : moment().add(6, 'days').format('DD-MM-YYYY');
                                            let preventiveCycleValue = machineSchedule && machineSchedule.preventive_cycle !== undefined ? machineSchedule.preventive_cycle : '';

                                            tableRows2 += `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${machine.invent_number}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>
                                                        <input class="form-control daterange-picker" id="schedule_time_${machine.id}" type="text" name="schedule_time">
                                                        <input type="hidden" name="machine_id_year_edit" value="${machine.id}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="preventive_cycle">
                                                            <option value="3" ${preventiveCycleValue == 3 ? 'selected' : ''}>3/Bulanan</option>
                                                            <option value="6" ${preventiveCycleValue == 6 ? 'selected' : ''}>6/Bulanan</option>
                                                            <option value="12" ${preventiveCycleValue == 12 ? 'selected' : ''}>12/Bulanan</option>
                                                        </select>
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
                                dropdownYear();
                                filterTable();
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
                                    changeMenu(2, nameScheduleYear, limitScheduleYear);
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
                let scheduleNameEdit = null;
                let scheduleLimitEdit = null;
                let combinedScheduleEdit = [];

                scheduleNameEdit = $('input[name="name_schedule_year_edit"]').val();
                scheduleLimitEdit = $('input[name="limit_schedule_year_edit"]').val();

                // Mengumpulkan data untuk combined_schedule
                $('input[name="machine_id_year_edit"]').each(function(index) {
                    let machineId = $(this).val();
                    let preventiveCycle = $('select[name="preventive_cycle"]').eq(index).val();
                    let scheduleTime = $('input[name="schedule_time"]').eq(index).val();

                    // Menggabungkan data menjadi format yang diinginkan
                    combinedScheduleEdit.push(`${machineId},${preventiveCycle},${scheduleTime}`);
                });

                $.ajax({
                    type: 'PUT',
                    url: '{{ route("edityear", ':id') }}'.replace(':id', scheduleId),
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule': scheduleNameEdit,
                        'limit_schedule': scheduleLimitEdit,
                        'schedule_create': "1",
                        'combined_schedule': combinedScheduleEdit,
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
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD SPECIAL SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
            // MASIH BUTUH PERBAIKAN DATA TERKAIT ABNORMALITY
            $('#addScheduleSpecial').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let scheduleId = button.data('id');
                const getDateTime = new Date().toISOString().split('T')[0]; // Mengambil tanggal dalam format yyyy-MM-dd
                const getShiftTime = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
                let shiftTime;

                if (getShiftTime >= '07:00' && getShiftTime < '15:59') {
                    shiftTime = 'Shift 1';
                } else if (getShiftTime >= '16:00' && getShiftTime < '23:59') {
                    shiftTime = 'Shift 2';
                } else {
                    shiftTime = 'Diluar Shift Atau Lembur';
                }

                $.ajax({
                    type: 'GET',
                    url: '{{ route("readyear-special") }}',
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Formulir Preventive</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        const data_modal = `
                            <div id="button-action" class="form-row align-items-center">
                                <div class="col-xl-6">
                                    <button id="start" type="button" class="btn btn-success btn-block"><i class="bi bi-play-fill"></i>&nbsp; Mulai</button>
                                </div>
                                <div class="col-xl-6">
                                    <button id="finish" type="button" class="btn btn-danger btn-block"><i class="bi bi-flag-fill"></i>&nbsp; Selesai</button>
                                </div>
                            </div>
                            <form id="form-preventive" >
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col-xl-4 col-md-4 my-1">
                                            <label for="operator_input" class="col-form-label">PIC</label>
                                            <select class="form-control" id="operator_input" name="create_by" multiple="multiple">
                                                <option value="0" selected="selected">Tidak ada</option>
                                            </select>
                                            <input type="hidden" name="id_schedule_year">
                                        </div>
                                        <div class="col-xl-4 col-md-4 my-1">
                                            <label for="shift_input" class="col-form-label">Shift</label>
                                            <input class="form-control" type="text" value="${shiftTime}" id="shift_input" name="shift" readonly>
                                        </div>
                                        <div class="col-xl-4 col-md-4 my-1">
                                            <label for="preventive_number" class="col-form-label">Nomor Preventive</label>
                                            <input class="form-control" type="text" value="" id="preventive_number" name="custom_number" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <div class="col-xl-6 col-md-6 col-sm-6 my-1">
                                            <label for="start_time_input" class="col-form-label">Waktu Mulai</label>
                                            <input class="form-control" type="time" value="${getShiftTime}" id="start_time_input" name="start_at" readonly>
                                            <input class="form-control" type="date" value="${getDateTime}" id="start_date_input" name="created_date_start" readonly>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-6 my-1">
                                            <label for="finish_time_input" class="col-form-label">Waktu Selesai</label>
                                            <input class="form-control" type="time" value="" id="finish_time_input" name="finish_at" readonly>
                                            <input class="form-control" type="date" value="" id="finish_date_input" name="created_date_finish" readonly>
                                        </div>
                                        <div class="col-xl-12 my-1 text-center">
                                            <label for="total-time-input" class="col-form-label">Total Waktu</label>
                                            <input class="form-control" type="text" value="" id="total-time-input" name="total_minutes" readonly>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid #F1F1F1; border-radius: 5px;">
                                    <div class="form-row align-items-center">
                                        <div class="col-xl-6 col-md-12 my-1">
                                            <label for="machine_input" class="col-form-label">Select Machine<span style="color:red"> *</span></label>
                                            <input class="form-control" type="text" value="" id="machine_input" name="machine_input" placeholder="Pilih mesin...">
                                        </div>
                                        <div class="col-xl-6 col-md-12 my-1">
                                            <label for="insert_invent_number" class="col-form-label">Invent Number</label>
                                            <input class="form-control" type="text" id="insert_invent_number" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <div class="col-xl-4 col-md-4 my-1">
                                            <label for="insert_machine_number" class="col-form-label">Nomor Mesin</label>
                                            <input class="form-control" type="text" id="insert_machine_number" readonly>
                                        </div>
                                        <div class="col-xl-4 col-md-4 my-1">
                                            <label for="insert_machine_type" class="col-form-label">Type Mesin</label>
                                            <input class="form-control" type="text" id="insert_machine_type" readonly>
                                        </div>
                                        <div class="col-xl-4 col-md-4 my-1">
                                            <label for="insert_machine_info" class="col-form-label">Keterangan</label>
                                            <input class="form-control" type="text" id="insert_machine_info" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <div class="col-xl-12 my-1">
                                            <label for="preventive-input" class="col-form-label">Kategori<span style="color:red"> *</span></label>
                                            <div class="input-group">
                                                <select id="preventive-input" class="custom-select" size="1" disabled>
                                                    <option value="" selected="selected">Pilih kategori...</option>
                                                </select>
                                                <input class="form-control" type="text" value="" id="preventive-custom-input"  placeholder="Masukkan kategori..." readonly>
                                                <div class="input-group-append">
                                                    <button id="switch-textbox-preventive" type="button" class="btn btn-primary btn-default pt-1 pb-1" disabled><i id="icon-textbox-preventive" class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 my-1">
                                            <label for="problem-input" class="col-form-label">Masalah<span style="color:red"> *</span></label>
                                            <textarea class="form-control" type="text" value="" id="problem-input" name="problem" readonly placeholder="Masukkan masalah..."></textarea>
                                        </div>
                                        <div class="col-xl-12 my-1">
                                            <label for="reason-description-input" class="col-form-label">Penyebab<span style="color:red"> *</span></label>
                                            <textarea class="form-control" type="text" value="" id="reason-description-input" name="reason_description" readonly placeholder="Masukkan penyebabnya..."></textarea>
                                        </div>
                                        <div class="col-xl-12 my-1">
                                            <label for="corrective-action-input" class="col-form-label">Tindakan<span style="color:red"> *</span></label>
                                            <textarea class="form-control" type="text" value="" id="corrective-action-input" name="corrective_action" readonly placeholder="Masukkan tindakannya..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="column-button">
                                    <button id="save" type="button" class="btn btn-primary btn-block"><i class="fa-solid fa-floppy-disk fa-lg">&nbsp; </i> Submit</button>
                                </div>
                            </form>
                        `;
                        const button_modal =`
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                        `;
                        $('#modal_title_special').html(header_modal);
                        $('#modal_data_special').html(data_modal);
                        $('#modal_button_special').html(button_modal);

                        const operatorSelect = $('#operator_input');
                        operatorSelect.empty(); // Bersihkan elemen sebelum menambahkan data
                        data.userdata.forEach(user => {
                            operatorSelect.append(`<option value="${user.id}">${user.name}</option>`);
                        });

                        operatorSelect.select2({
                            placeholder: 'Select :',
                            searchInputPlaceholder: 'Search'
                        });

                        $('#machine_input').on('click', function() {
                            // Tampilkan modal addMachineData
                            $('#addMachineData').modal('show');

                            // Konfigurasi modal addMachineData
                            const addMachineHeader = `
                                <h5 class="modal-title">Pilih Mesin <i class="bi bi-search"></i></h5>
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                            `;
                            const addMachineBody = `
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="machineTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO. INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>KETERANGAN</th>
                                                <th>NO. MESIN</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            `;
                            const addMachineFooter = `
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            `;

                            $('#modal_title_machine_add').html(addMachineHeader);
                            $('#modal_data_machine_add').html(addMachineBody);
                            $('#modal_button_machine_add').html(addMachineFooter);

                            // Inisialisasi DataTable untuk menampilkan data mesin
                            const machineTable = $('#machineTable').DataTable({
                                ajax: {
                                    url: '{{ route("readmachine-special") }}', // API endpoint untuk mendapatkan data mesin
                                },
                                responsive: true,
                                serverSide: true,
                                processing: true,
                                columns: [
                                    {
                                        data: null, // Tidak ada data langsung dari server
                                        render: function(data, type, row, meta) {
                                            return meta.row + meta.settings._iDisplayStart + 1; // Menampilkan nomor urut
                                        },
                                        orderable: false,
                                        searchable: false,
                                    },
                                    { data: 'invent_number' },
                                    { data: 'machine_name' },
                                    { data: 'machine_type' },
                                    { data: 'machine_brand' },
                                    { data: 'machine_info' },
                                    { data: 'machine_number' },
                                    {
                                        data: null, // Tidak ada data langsung dari server
                                        render: function(data, type, row) {
                                            return `<a class="btn btn-primary btn-sm select-machine" data-id="${row.id}" data-machine_name="${row.machine_name}" data-invent_number="${row.invent_number}" data-machine_number="${row.machine_number}" data-machine_type="${row.machine_type}" data-machine_info="${row.machine_info}"><i class="bi bi-check-square-fill"></i></a>`;
                                        },
                                        orderable: false,
                                        searchable: false,
                                    }
                                ]
                            });

                            // Event listener untuk tombol "Pilih" di dalam modal
                            $('#machineTable').on('click', '.select-machine', function() {
                                const machineName = $(this).data('machine_name');
                                const inventNumber = $(this).data('invent_number');
                                const machineNumber = $(this).data('machine_number');
                                const machineType = $(this).data('machine_type');
                                const machineInfo = $(this).data('machine_info');


                                // Isi input di form Preventive dengan data mesin yang dipilih
                                $('#machine_input').val(machineName);
                                $('#insert_invent_number').val(inventNumber);
                                $('#insert_machine_number').val(machineNumber);
                                $('#insert_machine_type').val(machineType);
                                $('#insert_machine_info').val(machineInfo);

                                // Tutup modal addMachineData
                                $('#addMachineData').modal('hide');
                            });
                        });
                    }
                });
            });


            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD SPECIAL SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
                    url: '{{ route("readyear", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Buat Schedule PM Mesin Perbulan</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        combinedScheduleId = [];
                        nameScheduleMonth = "";
                        let idSchedule = '';

                        // Check if previous selections exist in sessionStorage
                        let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                        function updateSelectedMachines() {
                            combinedScheduleId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedScheduleId.push(checkbox.value);
                                }
                            });
                            sessionStorage.setItem('tempData', JSON.stringify(combinedScheduleId));
                        }

                        function selectSingleDate(inputElement, minDate, maxDate) {
                            $(inputElement).daterangepicker({
                                parentEl: '#modal_data_month_add',
                                singleDatePicker: true,
                                showDropdowns: true,
                                minDate: minDate,
                                maxDate: maxDate,
                                locale: {
                                    firstDay: 1,
                                    format: 'DD-MM-YYYY'
                                }
                            });
                        }

                        function filterTable() {
                            const filterByNumber = document.getElementById('get_by_number');
                            const filterByName = document.getElementById('get_by_name');
                            const filterByMonth = document.getElementById('get_by_month');
                            const table = document.getElementById('addMonthlyTables');
                            const rows = table.getElementsByTagName('tr');

                            // Function to filter table
                            function filterTable() {
                                const numberValue = filterByNumber.value.toLowerCase();
                                const nameValue = filterByName.value.toLowerCase();
                                const monthValue = filterByMonth.value.toLowerCase();

                                for (let i = 1; i < rows.length; i++) {
                                    const numberCell = rows[i].getElementsByTagName('td')[1];
                                    const nameCell = rows[i].getElementsByTagName('td')[2];
                                    const monthCell = rows[i].getElementsByTagName('td')[7];

                                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                    const monthText = monthCell ? monthCell.textContent.toLowerCase() : '';

                                    // Check if row matches the filter criteria
                                    if (nameText.includes(nameValue) &&
                                        numberText.includes(numberValue) &&
                                        (monthValue === "select :" || monthText.includes(monthValue))) {
                                        rows[i].style.display = '';  // Show the row
                                    } else {
                                        rows[i].style.display = 'none';  // Hide the row
                                    }
                                }
                            }

                            // Attach event listeners
                            filterByName.addEventListener('input', filterTable);
                            filterByNumber.addEventListener('input', filterTable);
                            filterByMonth.addEventListener('change', filterTable);
                        };

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
                                        `;
                                            data.getmachines.forEach((machine, index) => {
                                                let machineHour = 0; // Deklarasikan di sini
                                                const workingHour = data.workinghourdata.find(wo => wo.id === machine.standart_id);
                                                if (workingHour) {
                                                    machineHour = workingHour.preventive_hour; // Ambil nilai preventive_hour
                                                }
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machine.invent_number}</td>
                                                        <td>${machine.machine_number || '-'}</td>
                                                        <td>${machine.machine_name}</td>
                                                        <td>${machine.machine_type || '-'}</td>
                                                        <td>${machine.machine_brand || '-'}</td>
                                                        <td>${machineHour} /Jam</td>
                                                        <td>${formatDate(machine.schedule_start)}</td>
                                                        <td>${formatDate(machine.schedule_end)}</td>
                                                        <td><input type="checkbox" name="machineinput" value="${machine.machinescheduleid}"></td>
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
                                combinedScheduleId.includes(machine.machinescheduleid.toString())
                            );

                            let tableRows2 = `
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_schedule_month" value="${nameScheduleMonth}">
                                    <input type="hidden" name="id_schedule_year" value="${selectedMachines[0].yearly_id}">
                                    <table class="table table-bordered" id="machineTables2" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
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
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="bi bi-calendar3"></i>
                                                                </div>
                                                            </div>
                                                            <input name="schedule_date" type="text" class="form-control datepicker" id="datepicker-${machine.machinescheduleid}">
                                                            <input type="hidden" name="machine_schedule_id" value="${machine.machinescheduleid}">
                                                            <input type="hidden" name="user_schedule_create" value="{{ Auth::user()->id }}">
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
                                const datepickerInput = `#datepicker-${machine.machinescheduleid}`;
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
                                filterTable();
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
                                    console.log(combinedScheduleId);
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
                let scheduleName_MonthAdd = $('input[name="name_schedule_month"]').val();
                let scheduleYearId = $('input[name="id_schedule_year"]').val();
                let scheduleCreateBy = $('input[name="user_schedule_create"]').val();
                let scheduleDate_MonthAdd = [];
                let idMachineSchedule_MonthAdd = [];

                $('input[name="schedule_date"]').each(function() {
                    scheduleDate_MonthAdd.push($(this).val());
                });
                $('input[name="machine_schedule_id"]').each(function() {
                    idMachineSchedule_MonthAdd.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route("addmonth") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : scheduleName_MonthAdd,
                        'id_schedule_year' : scheduleYearId,
                        'schedule_create' : scheduleCreateBy,
                        'schedule_date[]': scheduleDate_MonthAdd,
                        'machine_schedule_id[]': idMachineSchedule_MonthAdd,
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
                    url: '{{ route("findmonthid", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Ubah Schedule PM Mesin Perbulan</h5>
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
                                    firstDay: 1,
                                    format: 'DD-MM-YYYY'
                                }
                            });
                        }

                        function filterTable() {
                            const filterByNumber = document.getElementById('get_by_number');
                            const filterByName = document.getElementById('get_by_name');
                            const filterByMonth = document.getElementById('get_by_month');
                            const table = document.getElementById('editMonthlyTables');
                            const rows = table.getElementsByTagName('tr');

                            // Function to filter table
                            function filterTable() {
                                const numberValue = filterByNumber.value.toLowerCase();
                                const nameValue = filterByName.value.toLowerCase();
                                const monthValue = filterByMonth.value.toLowerCase();

                                for (let i = 1; i < rows.length; i++) {
                                    const numberCell = rows[i].getElementsByTagName('td')[1];
                                    const nameCell = rows[i].getElementsByTagName('td')[3];
                                    const monthCell = rows[i].getElementsByTagName('td')[6];

                                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                    const monthText = monthCell ? monthCell.textContent.toLowerCase() : '';

                                    // Check if row matches the filter criteria
                                    if (nameText.includes(nameValue) &&
                                        numberText.includes(numberValue) &&
                                        (monthValue === "select :" || monthText.includes(monthValue))) {
                                        rows[i].style.display = '';  // Show the row
                                    } else {
                                        rows[i].style.display = 'none';  // Hide the row
                                    }
                                }
                            }

                            // Attach event listeners
                            filterByName.addEventListener('input', filterTable);
                            filterByNumber.addEventListener('input', filterTable);
                            filterByMonth.addEventListener('change', filterTable);
                        };

                        // Display machines in the first modal (selection menu)
                        function renderFirstMenu() {
                            let tableRows1 = `
                                <div class="row" align-items="center">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                            <div>
                                                <input class="form-control" id="name_schedule_month_edit" type="text" placeholder="Periode :" value="${data.monthlyscheduledata.name_schedule_month}">
                                            </div>
                                        </div>
                                    </div>
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
                                        <table class="table table-bordered" id="editMonthlyTables" width="100%">
                                            <thead>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>DURASI</th>
                                                <th colspan="2">RENTANG WAKTU PREVENTIVE</th>
                                                <th>ADD</th>
                                            </thead>
                                            <tbody>
                                        `;
                                            let scheduleIds = JSON.parse(data.monthlyscheduledata.schedule_collection);
                                            data.getmachines.forEach((machine, index) => {
                                                let machineHour = 0; // Deklarasikan di sini
                                                const workingHour = data.workinghourdata.find(wo => wo.id === machine.standart_id);
                                                if (workingHour) {
                                                    machineHour = workingHour.preventive_hour; // Ambil nilai preventive_hour
                                                }
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machine.invent_number}</td>
                                                        <td>${machine.machine_number || '-'}</td>
                                                        <td>${machine.machine_name}</td>
                                                        <td>${machine.machine_type || '-'}</td>
                                                        <td>${machine.machine_brand || '-'}</td>
                                                        <td>${machineHour} /Jam</td>
                                                        <td>${formatDate(machine.schedule_start)}</td>
                                                        <td>${formatDate(machine.schedule_end)}</td>
                                                        <td>
                                                            <input type="checkbox" name="machineinput" value="${machine.machinescheduleid}" ${scheduleIds.map(String).includes(String(machine.machinescheduleid)) ? 'checked' : ''}>
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
                                combinedMachineId.includes(machine.machinescheduleid.toString())
                            );

                            let tableRows2 = `
                                <form id="editSchedule" method="post">
                                    <input type="hidden" name="name_schedule_month_edit" value="${nameScheduleMonth}">
                                    <table class="table table-bordered" id="machineTables2" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
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
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="bi bi-calendar3"></i>
                                                                </div>
                                                            </div>
                                                            <input name="schedule_date_edit" type="text" class="form-control datepicker" id="datepicker-${machine.machinescheduleid}">
                                                            <input type="hidden" name="machine_schedule_id_edit" value="${machine.machinescheduleid}">
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
                                const datepickerInput = `#datepicker-${machine.machinescheduleid}`;
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
                                filterTable();
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
                let scheduleName_MonthEdit = $('input[name="name_schedule_month_edit"]').val();
                let scheduleDate_MonthEdit = [];
                let idMachineSchedule_MonthEdit = [];

                $('input[name="schedule_date_edit"]').each(function() {
                    scheduleDate_MonthEdit.push($(this).val());
                });
                $('input[name="machine_schedule_id_edit"]').each(function() {
                    idMachineSchedule_MonthEdit.push($(this).val());
                });
                $.ajax({
                    type: 'PUT',
                    url: '{{ route("editmonth", ':id') }}'.replace(':id', scheduleId),
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : scheduleName_MonthEdit,
                        'schedule_date[]': scheduleDate_MonthEdit,
                        'machine_schedule_id[]': idMachineSchedule_MonthEdit,
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
                    url: '{{ route("viewmonth", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {
                        const header_modal = `
                            <div class="custom-header">
                                <h5 class="modal-title">Detail Preventive Mesin</h5>
                                ${data.getschedulemonth[0].schedule_recognize === null ?
                                    '<span class="badge-custom badge-danger">BELUM DISETUJUI PLANNER</span>' :
                                    '<span class="badge-custom badge-success">SUDAH DISETUJUI PLANNER</span>'
                                }
                            </div>
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
                                        <th>NO.</th>
                                        <th>NAMA MESIN</th>
                                        <th>NO INVENTARIS</th>
                                        <th>KAPASITAS</th>
                                        <th>NOMOR MESIN</th>
                                        <th>RENCANA TANGGAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.getschedulemonth.map((schedule, index) => {
                                        let reschedule_pm = null;

                                        if (schedule.reschedule_date_3) {
                                            reschedule_pm = formatDate(schedule.reschedule_date_3) + ' (Reschedule ke 3)';
                                        } else if (schedule.reschedule_date_2) {
                                            reschedule_pm = formatDate(schedule.reschedule_date_2) + ' (Reschedule ke 2)';
                                        } else if (schedule.reschedule_date_1) {
                                            reschedule_pm = formatDate(schedule.reschedule_date_1) + ' (Reschedule)';
                                        } else {
                                            reschedule_pm = formatDate(schedule.schedule_date);
                                        }
                                        return `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${schedule.machine_name}</td>
                                                <td>${schedule.invent_number}</td>
                                                <td>${schedule.machine_type || '-'}</td>
                                                <td>${schedule.machine_number || '-'}</td>
                                                <td>${reschedule_pm}</td>
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

            // fungsi delete button untuk hapus schedule pertahun
            $('#scheduleTables').on('click', '.btn-delete-year', function(e) {
                e.preventDefault();
                const button = $(this);
                const machineId = button.data('id');
                if (confirm("Apakah yakin menghapus schedule ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route("removeyear", ':id') }}'.replace(':id', machineId),
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
                        setTimeout(function() {
                            $('#failedText').text('hide');
                            $('#failedModal').modal('hide');
                        }, 2000);
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                } else {
                    // User cancelled the deletion, do nothing
                }
            });

            // fungsi delete button untuk hapus schedule perbulan
            $('#scheduleTables tbody').on('click', '.btn-delete-month', function(e) {
                e.preventDefault();
                const button = $(this);
                const machineId = button.data('id');
                if (confirm("Apakah yakin menghapus schedule ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route("removemonth", ':id') }}'.replace(':id', machineId),
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
