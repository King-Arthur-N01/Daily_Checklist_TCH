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
                <div class="modal-header" style="background-color: #f6c23e;" id="modal_title_special">
                </div>
                <div class="modal-body" id="modal_data_special">
                </div>
                <div class="modal-footer" id="modal_button_special">
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Modal Special-->

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
                                                <div class="dynamic-button-group">
                                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                        <button class="dropdown-item-custom-success" data-toggle="modal" data-id="${schedulespecial.getspecialid}" data-target="#viewScheduleMonth"><i class="bi bi-eye-fill"></i>&nbsp;Detail</button>
                                                        <button class="dropdown-item-custom-primary" data-toggle="modal" data-id="${schedulespecial.getspecialid}" data-target="#editScheduleMonth"><i class="bi bi-pencil-square"></i>&nbsp;Edit</button>
                                                        <button class="dropdown-item-custom-danger btn-delete-month" data-id="${schedulespecial.getspecialid}"><i class="bi bi-trash-fill"></i>&nbsp;Delete</button>
                                                    </div>
                                                </div>
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

                        let combinedAddMachineId = [];
                        let yearlyNameData = "";
                        let yearlyLimitData = "";

                        // Check if previous selections exist in sessionStorage
                        let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                        function updateSelectedMachines() {
                            sessionStorage.removeItem('tempData');
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedAddMachineId.push(checkbox.value);
                                }
                            });
                            sessionStorage.setItem('tempData', JSON.stringify(combinedAddMachineId));
                        }

                        function selectDateRange() {
                            $('.daterange-picker').daterangepicker({
                                parentEl: '#modal_data_add',
                                showDropdowns: true,
                                locale: {
                                    firstDay: 1,
                                    format: 'DD-MM-YYYY' // Format tanggal
                                },
                                maxSpan: {
                                    days: 6 // Maksimal rentang tanggal
                                },
                            }).on('apply.daterangepicker', function(ev, picker) {
                                // Ketika tanggal dipilih, tambahkan kelas "is-valid"
                                $(this).removeClass('is-invalid');
                                $(this).addClass('is-valid');
                            }).on('cancel.daterangepicker', function(ev, picker) {
                                // Jika tanggal dibatalkan, hapus kelas "is-valid"
                                $(this).removeClass('is-valid');
                                $(this).addClass('is-invalid');
                            });
                        }

                        function dropdownYear() {
                            const yearDropdown = document.getElementById('year_dropdown');
                            const currentYear = new Date().getFullYear();

                            const startYear = currentYear - 5;
                            const endYear = currentYear + 5;

                            const defaultOption = document.createElement('option');
                            defaultOption.value = "";
                            defaultOption.textContent = 'Pilih tahun :';
                            defaultOption.selected = true;
                            yearDropdown.appendChild(defaultOption);

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
                                yearlyNameData = inputSchedule.value;
                            });

                            let limitSchedule = document.getElementById("year_dropdown");
                            limitSchedule.addEventListener('change', function() {
                                yearlyLimitData = limitSchedule.value;
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
                                combinedAddMachineId.includes(machine.id.toString())
                            );

                            let tableRows2 = `
                                <h5>SAAT PEMBUATAN JADWAL PREVENTIVE MAKA JADWAL BULAN BERIKUT NYA AKAN SAMA DENGAN HARI SAAT DITENTUKAN</h5>
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
                                            <p class="mg-b-10">Filter No.Mesin/Lokasi</p>
                                            <input class="form-control" id="get_by_info">
                                        </div>
                                    </div>
                                </div>
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_schedule_year" value="${yearlyNameData}">
                                    <input type="hidden" name="limit_schedule_year" value="${yearlyLimitData}">
                                    <table class="table table-bordered" id="addYearlyTable" width="100%">
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
                                                        <input class="form-control daterange-picker is-invalid" type="text" name="schedule_time" oninput="validateInput(this)">
                                                        <input type="hidden" name="machine_id_year" value="${machine.id}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="preventive_cycle">
                                                            <option value="3">3/Bulanan</option>
                                                            <option value="6" selected>6/Bulanan</option>
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
                                filterTable();
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
                                if (yearlyNameData === "" || yearlyLimitData === "") {
                                    alert("Nama schedule atau tahun schedule tidak boleh kosong.!!!");
                                } else {
                                    changeMenu(2, yearlyNameData, yearlyLimitData);
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
                let yearlyScheduleName = null;
                let yearlyScheduleLimit = null;
                let yearlyScheduleCreateBy = null;
                let yearlyScheduleTimes = null;
                let yearlyPreventiveCycle = null;
                let yearlyMachinesId = null;

                yearlyScheduleName = $('input[name="name_schedule_year"]').val();
                yearlyScheduleLimit = $('input[name="limit_schedule_year"]').val();
                yearlyScheduleCreateBy = '{{ Auth::user()->id }}';
                yearlyScheduleTimes = [];
                yearlyPreventiveCycle = [];
                yearlyMachinesId = [];

                $('input[name="schedule_time"]').each(function() {
                    yearlyScheduleTimes.push($(this).val());
                });
                $('select[name="preventive_cycle"]').each(function() {
                    yearlyPreventiveCycle.push($(this).val());
                });
                $('input[name="machine_id_year"]').each(function() {
                    yearlyMachinesId.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route("addyear") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : yearlyScheduleName,
                        'limit_schedule' : yearlyScheduleLimit,
                        'schedule_create' : yearlyScheduleCreateBy,
                        'schedule_time[]': yearlyScheduleTimes,
                        'preventive_cycle': yearlyPreventiveCycle,
                        'machine_id[]': yearlyMachinesId,
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
                    url: '{{ route("findyearid", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Ubah Schedule Perawatan Mesin Pertahun</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        let combinedEditMachineId = [];
                        let yearlyNameEditData = "";
                        let yearlyLimitEditData = "";

                        // Check if previous selections exist in sessionStorage
                        let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                        // Function to update selected machines
                        function updateSelectedMachines() {
                            sessionStorage.removeItem('tempData');
                            combinedEditMachineId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedEditMachineId.push(checkbox.value);
                                }
                            });
                            sessionStorage.setItem('tempData', JSON.stringify(combinedEditMachineId));
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
                            }).on('apply.daterangepicker', function(ev, picker) {
                                // Ketika tanggal dipilih, tambahkan kelas "is-valid"
                                $(this).removeClass('is-invalid');
                                $(this).addClass('is-valid');
                            }).on('cancel.daterangepicker', function(ev, picker) {
                                // Jika tanggal dibatalkan, hapus kelas "is-valid"
                                $(this).removeClass('is-valid');
                                $(this).addClass('is-invalid');
                            });

                            // Validasi awal
                            if (startDate == undefined || endDate == undefined) {
                                $(inputSelector).addClass('is-invalid');
                            } else {
                                $(inputSelector).removeClass('is-invalid');
                            }
                        }

                        function dropdownYear() {
                            const yearDropdown = document.getElementById('year_dropdown');
                            const currentYear = new Date().getFullYear();
                            const startYear = currentYear - 5;
                            const endYear = currentYear + 5;

                            const defaultOption = document.createElement('option');
                            defaultOption.value = "";
                            defaultOption.textContent = 'Pilih tahun :';
                            yearDropdown.appendChild(defaultOption);

                            for (let year = startYear; year <= endYear; year++) {
                                const option = document.createElement('option');
                                option.value = year;
                                option.textContent = year;
                                if (year == data.refreshschedule[0].schedule_year) {
                                    option.selected = true; // Tetapkan tahun default
                                }
                                yearDropdown.appendChild(option);
                            }
                            // Tetapkan nilai awal ke yearlyLimitEditData
                            yearlyLimitEditData = yearDropdown.value;
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
                            yearlyNameEditData = inputSchedule.value;
                            inputSchedule.addEventListener('input', function() {
                                yearlyNameEditData = inputSchedule.value;
                            });

                            let limitSchedule = document.getElementById("year_dropdown");
                            yearlyLimitEditData = limitSchedule.value;
                            limitSchedule.addEventListener('change', function() {
                                yearlyLimitEditData = limitSchedule.value;
                            });

                            combinedEditMachineId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedEditMachineId.push(checkbox.value);
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
                            sessionStorage.setItem('tempData', JSON.stringify(combinedEditMachineId));
                        }

                        // Function to render the second menu with dynamic date ranges
                        function renderSecondMenu() {
                            const selectedMachines = data.refreshmachine.filter(machine =>
                                combinedEditMachineId.includes(machine.id.toString())
                            );

                            let tableRows2 = `
                                <h5>SAAT PEMBUATAN JADWAL PREVENTIVE MAKA JADWAL BULAN BERIKUT NYA AKAN SAMA DENGAN HARI SAAT DITENTUKAN</h5>
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
                                            <p class="mg-b-10">Filter No.Mesin/Lokasi</p>
                                            <input class="form-control" id="get_by_info">
                                        </div>
                                    </div>
                                </div>
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_schedule_year_edit" value="${yearlyNameEditData}">
                                    <input type="hidden" name="limit_schedule_year_edit" value="${yearlyLimitEditData}">
                                    <table class="table table-bordered" id="editYearlyTable" width="100%">
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
                                            let currentTime = new Date();
                                            let startDate = null;
                                            let endDate = null;
                                            let preventiveCycleValue = null;

                                            if (machineSchedule == undefined) {
                                                startDate = undefined;
                                                endDate = undefined;
                                                preventiveCycleValue = undefined;
                                            } else {
                                                startDate = machineSchedule ? moment(machineSchedule.schedule_start).format('DD-MM-YYYY') : moment().format('DD-MM-YYYY');
                                                endDate = machineSchedule ? moment(machineSchedule.schedule_end).format('DD-MM-YYYY') : moment().add(6, 'days').format('DD-MM-YYYY');
                                                preventiveCycleValue = machineSchedule && machineSchedule.preventive_cycle !== undefined ? machineSchedule.preventive_cycle : '';
                                            }
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
                                filterTable();
                            }
                        }

                        $('#modal_title_edit').html(header_modal);
                        changeMenu(1);

                        document.getElementById("modal_button_edit").addEventListener('click', function(event) {
                            if (event.target.id === "previousButton") {
                                changeMenu(1);
                            } else if (event.target.id === "nextButton") {
                                if (yearlyNameEditData === "" || yearlyLimitEditData === "") {
                                    alert("Nama schedule atau tahun schedule tidak boleh kosong.!!!");
                                } else {
                                    changeMenu(2, yearlyNameEditData, yearlyLimitEditData);
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
                let yearlyScheduleNameEdit = null;
                let yearlyScheduleLimitEdit = null;
                let combinedYearlyScheduleEdit = [];

                yearlyScheduleNameEdit = $('input[name="name_schedule_year_edit"]').val();
                yearlyScheduleLimitEdit = $('input[name="limit_schedule_year_edit"]').val();

                // Mengumpulkan data untuk combined_schedule
                $('input[name="machine_id_year_edit"]').each(function(index) {
                    let yearlyMachinesIdEdit = $(this).val();
                    let yearlyPreventiveCycleEdit = $('select[name="preventive_cycle"]').eq(index).val();
                    let yearlyScheduleTime = $('input[name="schedule_time"]').eq(index).val();

                    // Menggabungkan data menjadi format yang diinginkan
                    combinedYearlyScheduleEdit.push(`${yearlyMachinesIdEdit},${yearlyPreventiveCycleEdit},${yearlyScheduleTime}`);
                });

                $.ajax({
                    type: 'PUT',
                    url: '{{ route("edityear", ':id') }}'.replace(':id', scheduleId),
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule': yearlyScheduleNameEdit,
                        'limit_schedule': yearlyScheduleLimitEdit,
                        'combined_schedule': combinedYearlyScheduleEdit,
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
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD SPECIAL SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
            // MASIH BUTUH PERBAIKAN DATA TERKAIT SPECIAL SCHEDULE
            $('#addScheduleSpecial').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const scheduleId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readyear-special", ':id') }}'.replace(':id', scheduleId),
                    success: function(data) {

                        const header_modal = `
                            <h5 class="modal-title">Buat Special Schedule PM Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        let combinedSpecialScheduleId = [];
                        let monthlyNameSpecialData = "";

                        // Check if previous selections exist in sessionStorage
                        let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                        function updateSelectedMachines() {
                            sessionStorage.removeItem('tempData');
                            combinedSpecialScheduleId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedSpecialScheduleId.push(checkbox.value);
                                }
                            });
                            sessionStorage.setItem('tempData', JSON.stringify(combinedSpecialScheduleId));
                        }

                        function selectSingleDate(inputElement) {
                            $(inputElement).daterangepicker({
                                parentEl: '#modal_data_special',
                                singleDatePicker: true,
                                showDropdowns: true,
                                locale: {
                                    firstDay: 1,
                                    format: 'DD-MM-YYYY'
                                }
                            }).on('apply.daterangepicker', function(ev, picker) {
                                // Ketika tanggal dipilih, tambahkan kelas "is-valid"
                                $(this).removeClass('is-invalid');
                                $(this).addClass('is-valid');
                            }).on('cancel.daterangepicker', function(ev, picker) {
                                // Jika tanggal dibatalkan, hapus kelas "is-valid"
                                $(this).removeClass('is-valid');
                                $(this).addClass('is-invalid');
                            });
                        }

                        function filterTable() {
                            const filterByNumber = document.getElementById('get_by_number');
                            const filterByName = document.getElementById('get_by_name');
                            const filterByMonth = document.getElementById('get_by_month');
                            const table = document.getElementById('addSpecialTables');
                            const rows = table.getElementsByTagName('tr');

                            // Function to filter table
                            function filterTable() {
                                const numberValue = filterByNumber.value.toLowerCase();
                                const nameValue = filterByName.value.toLowerCase();
                                const monthValue = filterByMonth.value.toLowerCase();

                                for (let i = 1; i < rows.length; i++) {
                                    const numberCell = rows[i].getElementsByTagName('td')[1];
                                    const nameCell = rows[i].getElementsByTagName('td')[2];
                                    const startDate = rows[i].getElementsByTagName('td')[7];
                                    const endDate = rows[i].getElementsByTagName('td')[8];

                                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                    const startText = startDate ? startDate.textContent.toLowerCase() : '';
                                    const endText = endDate ? endDate.textContent.toLowerCase() : '';

                                    // Check if row matches the filter criteria
                                    if (nameText.includes(nameValue) &&
                                        numberText.includes(numberValue) &&
                                        (monthValue === "select :" || startText.includes(monthValue) || endText.includes(monthValue))) {
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
                                            <p class="mg-b-10">Filter Waktu Preventive</p>
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
                                        <table class="table table-bordered" id="addSpecialTables" width="100%">
                                            <thead>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>DURASI</th>
                                                <th colspan="2">RENTANG WAKTU PREVENTIVE</th>
                                                <th>STATUS</th>
                                                <th>ADD</th>
                                            </thead>
                                            <tbody>
                                        `;
                                            data.specialscheduledata.forEach((machineSchedule, index) => {
                                                let machineHour = 0; // Deklarasikan di sini
                                                const workingHour = data.workinghourdata.find(wo => wo.id === machineSchedule.standart_id);
                                                if (workingHour) {
                                                    machineHour = workingHour.preventive_hour; // Ambil nilai preventive_hour
                                                }

                                                let schedule_status = null;
                                                if (machineSchedule.machine_schedule_status === 0) {
                                                    schedule_status = '<span class="badge badge-danger">BELUM DIKERJAKAN</span>';
                                                } else if (machineSchedule.machine_schedule_status === 1) {
                                                    schedule_status = '<span class="badge badge-success" value="0">SUDAH DIKERJAKAN</span>';
                                                } else if (machineSchedule.machine_schedule_status === 2){
                                                    schedule_status = '<span class="badge badge-danger" value="0">TERJADI ABNORMAL</span>';
                                                }
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machineSchedule.invent_number}</td>
                                                        <td>${machineSchedule.machine_name}</td>
                                                        <td>${machineSchedule.machine_type || '-'}</td>
                                                        <td>${machineSchedule.machine_brand || '-'}</td>
                                                        <td>${machineSchedule.machine_number || '-'}</td>
                                                        <td>${machineHour} /Jam</td>
                                                        <td>${formatDate(machineSchedule.schedule_start)}</td>
                                                        <td>${formatDate(machineSchedule.schedule_end)}</td>
                                                        <td>${schedule_status}</td>
                                                        <td><input type="checkbox" name="machineinput" value="${machineSchedule.machinescheduleid}"></td>
                                                    </tr>
                                                `;
                                            });
                            tableRows1 += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;

                            document.getElementById("modal_data_special").innerHTML = tableRows1;

                            let inputSchedule = document.getElementById("name_schedule_month");
                            inputSchedule.addEventListener('input', function() {
                                monthlyNameSpecialData = inputSchedule.value;
                            });

                            // Re-add event listeners for new checkboxes
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));
                        }

                        // Display the selected machines in the second modal (confirmation menu)
                        function renderSecondMenu() {
                            const selectedMachines = data.specialscheduledata.filter(machine =>
                                combinedSpecialScheduleId.includes(machine.machinescheduleid.toString())
                            );

                            let tableRows2 = `
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_special_schedule" value="${monthlyNameSpecialData}">
                                    <input type="hidden" name="id_special_schedule_year" value="${selectedMachines[0].yearly_id}">
                                    <input type="hidden" name="user_special_schedule" value="{{ Auth::user()->id }}">
                                    <table class="table table-bordered" id="addSpecialTables2" width="100%">
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
                                                            <input class="form-control datepicker is-invalid" name="special_schedule_date" type="text"  id="datepicker-${machine.machinescheduleid}">
                                                            <input type="hidden" name="machine_special_schedule_id" value="${machine.machinescheduleid}">
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

                            document.getElementById("modal_data_special").innerHTML = tableRows2;

                            selectedMachines.forEach((machine, index) => {
                                const datepickerInput = `#datepicker-${machine.machinescheduleid}`;
                                selectSingleDate(datepickerInput);
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
                                document.getElementById("modal_button_special").innerHTML = button_modal1;
                                document.getElementById("previousButton").disabled = true;
                                filterTable();
                            } else if (step === 2) {
                                renderSecondMenu();
                                document.getElementById("modal_button_special").innerHTML = button_modal2;
                                document.getElementById("addMonthlyButton").addEventListener('click', function() {
                                    addSpecialSchedule();
                                });
                            }
                        }

                        $('#modal_title_special').html(header_modal);
                        changeMenu(1);

                        document.getElementById("modal_button_special").addEventListener('click', function(event) {
                            if (event.target.id === "previousButton") {
                                changeMenu(1);
                            }
                        });

                        document.getElementById("modal_button_special").addEventListener('click', function(event) {
                            if (event.target.id === "nextButton") {
                                if (monthlyNameSpecialData === "") {
                                    alert("Harap masukan nama untuk jadwal.!!!");
                                } else {
                                    changeMenu(2, monthlyNameSpecialData, combinedSpecialScheduleId);
                                    selectSingleDate();
                                    console.log(combinedSpecialScheduleId);
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });

            // FUNGSI UNTUK SAVE BUTTON SPECIAL SCHEDULE DAN MENGIRIM REQUEST AJAX
            function addSpecialSchedule() {
                event.preventDefault();
                let specialScheduleName = $('input[name="name_special_schedule"]').val();
                let specialScheduleYearId = $('input[name="id_special_schedule_year"]').val();
                let specialScheduleCreateBy = $('input[name="user_special_schedule"]').val();
                let specialScheduleDate = [];
                let machineSpecialSchedule = [];

                $('input[name="special_schedule_date"]').each(function() {
                    specialScheduleDate.push($(this).val());
                });
                $('input[name="machine_special_schedule_id"]').each(function() {
                    machineSpecialSchedule.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route("addmonth-special") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : specialScheduleName,
                        'id_schedule_year' : specialScheduleYearId,
                        'schedule_create' : specialScheduleCreateBy,
                        'schedule_date[]': specialScheduleDate,
                        'machine_schedule_id[]': machineSpecialSchedule,
                    },
                    success: function(response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                            $('#addScheduleSpecial').modal('hide');
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
                            $('#addScheduleSpecial').modal('hide');
                        }, 2000);
                    }
                }).always(function() {
                    table.ajax.reload(null, false);
                });
            }

            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD SPECIAL SCHEDULE END>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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

                        let combinedAddScheduleId = [];
                        let monthlyNameAddData = "";

                        // Check if previous selections exist in sessionStorage
                        let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                        function updateSelectedMachines() {
                            sessionStorage.removeItem('tempData');
                            combinedAddScheduleId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedAddScheduleId.push(checkbox.value);
                                }
                            });
                            sessionStorage.setItem('tempData', JSON.stringify(combinedAddScheduleId));
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
                            }).on('apply.daterangepicker', function(ev, picker) {
                                // Ketika tanggal dipilih, tambahkan kelas "is-valid"
                                $(this).removeClass('is-invalid');
                                $(this).addClass('is-valid');
                            }).on('cancel.daterangepicker', function(ev, picker) {
                                // Jika tanggal dibatalkan, hapus kelas "is-valid"
                                $(this).removeClass('is-valid');
                                $(this).addClass('is-invalid');
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
                                    const startDate = rows[i].getElementsByTagName('td')[7];
                                    const endDate = rows[i].getElementsByTagName('td')[8];

                                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                    const startText = startDate ? startDate.textContent.toLowerCase() : '';
                                    const endText = endDate ? endDate.textContent.toLowerCase() : '';

                                    // Check if row matches the filter criteria
                                    if (nameText.includes(nameValue) &&
                                        numberText.includes(numberValue) &&
                                        (monthValue === "select :" || startText.includes(monthValue) || endText.includes(monthValue))) {
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
                                            <p class="mg-b-10">Filter Waktu Preventive</p>
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
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>DURASI</th>
                                                <th colspan="2">RENTANG WAKTU PREVENTIVE</th>
                                                <th>STATUS</th>
                                                <th>ADD</th>
                                            </thead>
                                            <tbody>
                                        `;
                                            data.machinescheduledata.forEach((machineSchedule, index) => {
                                                let machineHour = 0; // Deklarasikan di sini
                                                const workingHour = data.workinghourdata.find(wo => wo.id === machineSchedule.standart_id);
                                                if (workingHour) {
                                                    machineHour = workingHour.preventive_hour; // Ambil nilai preventive_hour
                                                }

                                                let schedule_status = null;
                                                if (machineSchedule.machine_schedule_status === 0) {
                                                    schedule_status = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                                } else if (machineSchedule.machine_schedule_status === 1) {
                                                    schedule_status = '<span class="badge badge-success" value="0">Sudah Dikerjakan</span>';
                                                } else if (machineSchedule.machine_schedule_status === 2){
                                                    schedule_status = '<span class="badge badge-danger" value="0">Terjadi Abnomal</span>';
                                                }
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machineSchedule.invent_number}</td>
                                                        <td>${machineSchedule.machine_name}</td>
                                                        <td>${machineSchedule.machine_type || '-'}</td>
                                                        <td>${machineSchedule.machine_brand || '-'}</td>
                                                        <td>${machineSchedule.machine_number || '-'}</td>
                                                        <td>${machineHour} /Jam</td>
                                                        <td>${formatDate(machineSchedule.schedule_start)}</td>
                                                        <td>${formatDate(machineSchedule.schedule_end)}</td>
                                                        <td>${schedule_status}</td>
                                                        <td><input type="checkbox" name="machineinput" value="${machineSchedule.machinescheduleid}"></td>
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
                                monthlyNameAddData = inputSchedule.value;
                            });

                            // Re-add event listeners for new checkboxes
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));
                        }

                        // Display the selected machines in the second modal (confirmation menu)
                        function renderSecondMenu() {
                            const selectedMachines = data.machinescheduledata.filter(machine =>
                                combinedAddScheduleId.includes(machine.machinescheduleid.toString())
                            );

                            let tableRows2 = `
                                <form id="addSchedule" method="post">
                                    <input type="hidden" name="name_schedule_month" value="${monthlyNameAddData}">
                                    <input type="hidden" name="id_schedule_year" value="${selectedMachines[0].yearly_id}">
                                    <input type="hidden" name="user_schedule_create" value="{{ Auth::user()->id }}">
                                    <table class="table table-bordered" id="addMonthlyTables" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
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
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="bi bi-calendar3"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control datepicker is-invalid" name="schedule_date" type="text" id="datepicker-${machine.machinescheduleid}">
                                                            <input type="hidden" name="machine_schedule_id" value="${machine.machinescheduleid}">
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
                                if (monthlyNameAddData === "") {
                                    alert("Harap masukan nama untuk jadwal.!!!");
                                } else {
                                    changeMenu(2, monthlyNameAddData, combinedAddScheduleId);
                                    selectSingleDate();
                                    console.log(combinedAddScheduleId);
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
                let monthlyScheduleName = $('input[name="name_schedule_month"]').val();
                let monthlyScheduleYearId = $('input[name="id_schedule_year"]').val();
                let monthlyScheduleCreateBy = $('input[name="user_schedule_create"]').val();
                let monthlyScheduleDate = [];
                let monthlyMachineScheduleId = [];

                $('input[name="schedule_date"]').each(function() {
                    monthlyScheduleDate.push($(this).val());
                });
                $('input[name="machine_schedule_id"]').each(function() {
                    monthlyMachineScheduleId.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route("addmonth") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : monthlyScheduleName,
                        'id_schedule_year' : monthlyScheduleYearId,
                        'schedule_create' : monthlyScheduleCreateBy,
                        'schedule_date[]': monthlyScheduleDate,
                        'machine_schedule_id[]': monthlyMachineScheduleId,
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

                        let combinedEditScheduleId = [];
                        let monthlyNameEditData = "";

                        // Check if previous selections exist in sessionStorage
                        let tempData = JSON.parse(sessionStorage.getItem('tempData')) || [];

                        function updateSelectedMachines() {
                            sessionStorage.removeItem('tempData');
                            combinedEditScheduleId = [];
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    combinedEditScheduleId.push(checkbox.value);
                                }
                            });
                            sessionStorage.setItem('tempData', JSON.stringify(combinedEditScheduleId));
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
                            }).on('apply.daterangepicker', function(ev, picker) {
                                // Ketika tanggal dipilih, tambahkan kelas "is-valid"
                                $(this).removeClass('is-invalid');
                                $(this).addClass('is-valid');
                            }).on('cancel.daterangepicker', function(ev, picker) {
                                // Jika tanggal dibatalkan, hapus kelas "is-valid"
                                $(this).removeClass('is-valid');
                                $(this).addClass('is-invalid');
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
                                    const nameCell = rows[i].getElementsByTagName('td')[2];
                                    const startDate = rows[i].getElementsByTagName('td')[7];
                                    const endDate = rows[i].getElementsByTagName('td')[8];

                                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                    const startText = startDate ? startDate.textContent.toLowerCase() : '';
                                    const endText = endDate ? endDate.textContent.toLowerCase() : '';

                                    // Check if row matches the filter criteria
                                    if (nameText.includes(nameValue) &&
                                        numberText.includes(numberValue) &&
                                        (monthValue === "select :" || startText.includes(monthValue) || endText.includes(monthValue))) {
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
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
                                                <th>DURASI</th>
                                                <th colspan="2">RENTANG WAKTU PREVENTIVE</th>
                                                <th>STATUS</th>
                                                <th>ADD</th>
                                            </thead>
                                            <tbody>
                                        `;
                                            let scheduleIds = JSON.parse(data.monthlyscheduledata.schedule_collection);
                                            data.machinescheduledata.forEach((machineSchedule, index) => {
                                                let machineHour = 0; // Deklarasikan di sini
                                                const workingHour = data.workinghourdata.find(wo => wo.id === machineSchedule.standart_id);
                                                if (workingHour) {
                                                    machineHour = workingHour.preventive_hour; // Ambil nilai preventive_hour
                                                }

                                                let schedule_status = null;
                                                if (machineSchedule.machine_schedule_status === 0) {
                                                    schedule_status = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                                } else if (machineSchedule.machine_schedule_status === 1) {
                                                    schedule_status = '<span class="badge badge-success" value="0">Sudah Dikerjakan</span>';
                                                } else if (machineSchedule.machine_schedule_status === 2){
                                                    schedule_status = '<span class="badge badge-danger" value="0">Terjadi Abnomal</span>';
                                                }
                                                tableRows1 += `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${machineSchedule.invent_number}</td>
                                                        <td>${machineSchedule.machine_name}</td>
                                                        <td>${machineSchedule.machine_type || '-'}</td>
                                                        <td>${machineSchedule.machine_brand || '-'}</td>
                                                        <td>${machineSchedule.machine_number || '-'}</td>
                                                        <td>${machineHour} /Jam</td>
                                                        <td>${formatDate(machineSchedule.schedule_start)}</td>
                                                        <td>${formatDate(machineSchedule.schedule_end)}</td>
                                                        <td>
                                                            <input type="checkbox" name="machineinput" value="${machineSchedule.machinescheduleid}" ${scheduleIds.map(String).includes(String(machineSchedule.machinescheduleid)) ? 'checked' : ''}>
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
                            monthlyNameEditData = inputSchedule.value;
                            inputSchedule.addEventListener('input', function() {
                                monthlyNameEditData = inputSchedule.value;
                            });

                            // Re-add event listeners for new checkboxes
                            let checkboxes = document.getElementsByName("machineinput");
                            checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedMachines));
                        }

                        // Display the selected machines in the second modal (confirmation menu)
                        function renderSecondMenu() {
                            const selectedMachines = data.getmachines.filter(machine =>
                                combinedEditScheduleId.includes(machine.machinescheduleid.toString())
                            );

                            let tableRows2 = `
                                <form id="editSchedule" method="post">
                                    <input type="hidden" name="name_schedule_month_edit" value="${monthlyNameEditData}">
                                    <table class="table table-bordered" id="editMonthlyTables" width="100%">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NO.INVENT</th>
                                                <th>NAMA MESIN</th>
                                                <th>MODEL/TYPE</th>
                                                <th>BRAND/MERK</th>
                                                <th>NO.MESIN/LOKASI</th>
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
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="bi bi-calendar3"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control datepicker is-invalid" name="schedule_date_edit" type="text" id="datepicker-${machine.machinescheduleid}">
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
                                if (monthlyNameEditData === "") {
                                    alert("Harap masukan nama untuk jadwal.!!!");
                                } else {
                                    changeMenu(2, monthlyNameEditData, combinedEditScheduleId);
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
                let monthlyScheduleNameEdit = $('input[name="name_schedule_month_edit"]').val();
                let monthlyScheduleDateEdit = [];
                let monthlyMachineScheduleIdEdit = [];

                $('input[name="schedule_date_edit"]').each(function() {
                    monthlyScheduleDateEdit.push($(this).val());
                });
                $('input[name="machine_schedule_id_edit"]').each(function() {
                    monthlyMachineScheduleIdEdit.push($(this).val());
                });
                $.ajax({
                    type: 'PUT',
                    url: '{{ route("editmonth", ':id') }}'.replace(':id', scheduleId),
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name_schedule' : monthlyScheduleNameEdit,
                        'schedule_date[]': monthlyScheduleDateEdit,
                        'machine_schedule_id[]': monthlyMachineScheduleIdEdit,
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
                                        let scheduleHour = schedule.schedule_hour;
                                        if (scheduleHour == null) {
                                            scheduleHour = 'Belum ada'
                                        }
                                        let schedule_status = null;

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
                                            schedule_status = '<span class="badge badge-danger">Belum Dikerjakan</span>';
                                        } else if (schedule.machine_schedule_status === 1) {
                                            schedule_status = '<span class="badge badge-success">Sudah Dikerjakan</span>';
                                        } else if (schedule.machine_schedule_status === 2){
                                            schedule_status = '<span class="badge badge-danger">Terjadi Abnormal</span>';
                                        }
                                        return `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${schedule.machine_name}</td>
                                                <td>${schedule.invent_number}</td>
                                                <td>${schedule.machine_type || '-'}</td>
                                                <td>${schedule.machine_number || '-'}</td>
                                                <td>${reschedulePM}</td>
                                                <td>${scheduleHour.split(':').slice(0, 2).join(':')}</td>
                                                <td>${schedule_status}</td>
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
