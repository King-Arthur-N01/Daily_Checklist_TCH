@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
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
                            <p class="mg-b-10">Nama Mesin</p>
                            <input class="form-control" id="filterByName">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Prioritas Mesin</p>
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
                    <h6 class="m-0 font-weight-bold text-primary">Jam Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div id="errorMessages"></div>
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#addWorkingHour" tabindex="0"><i class="bi bi-calendar2-plus-fill"></i>&nbsp; Standart Preventive Mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="workingHourTables" width="100%">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>NAMA STANDART MESIN</th>
                                    <th>PRIORITAS</th>
                                    <th>JUMLAH MESIN</th>
                                    <th>PREVENTIVE HOURS</th>
                                    <th>MAN POWER</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal WO -->
    <div class="modal fade show" id="addWorkingHour" tabindex="-1">
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
    <!-- End Add Modal WO-->

    <!-- Edit Modal WO -->
        <div class="modal fade show" id="editWorkingHour" tabindex="-1">
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
    <!-- End Edit Modal WO-->

    <!-- VIew Modal WO -->
        <div class="modal fade show" id="viewWorkingHour" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header" id="modal_title_view">
                    </div>
                    <div class="modal-body" id="modal_data_view">
                    </div>
                    <div class="modal-footer" id="modal_button_view">
                    </div>
                </div>
            </div>
        </div>
    <!-- End View Modal WO-->

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

@endpush

@push('script')
    <script>
        $(document).ready(function() {
            // Set automatic soft refresh table
            setInterval(function() {
                overlay.addClass('is-active');
                table.ajax.reload(null, false);
                table.on('draw.dt', function() {
                    overlay.removeClass('is-active');
                });
            }, 60000); // 60000 milidetik = 60 second\


            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#workingHourTables').DataTable({
                ajax: {
                    url: '{{ route("refreshworkinghour") }}',
                    dataSrc: function(data) {
                        return data.refreshworkinghours.map((refreshwo, index) => {
                            return {
                                number: index + 1,
                                standart_name: refreshwo.standart_name,
                                priority: refreshwo.priority,
                                machine_total: refreshwo.machine_total.split(',').length,
                                preventive_hour: refreshwo.preventive_hour,
                                man_power: refreshwo.man_power,
                                actions: `
                                    <div class="dynamic-button-group">
                                        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item-custom-detail" data-toggle="modal" data-id="${refreshwo.id}" data-target="#viewWorkingHour"><i class="bi bi-eye-fill"></i>&nbsp;Detail</button>
                                            <button class="dropdown-item-custom-edit" data-toggle="modal" data-id="${refreshwo.id}" data-target="#editWorkingHour"><i class="bi bi-pencil-square"></i>&nbsp;Edit</button>
                                            <button class="dropdown-item-custom-delete delete_schedule_year" data-id="${refreshwo.id}"><i class="bi bi-trash3-fill"></i>&nbsp;Delete</button>
                                        </div>
                                    </div>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'number' },
                    { data: 'standart_name' },
                    { data: 'priority' },
                    { data: 'machine_total' },
                    { data: 'preventive_hour' },
                    { data: 'man_power' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });



            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD WORKING HOUR>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>

            // fungsi untuk mengedit atau menambahkan standarisasi ke mesin
            $('#addWorkingHour').on('shown.bs.modal', function(event) {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readmachinewo") }}',
                    success: function(data) {
                        let tableRows = '';

                        function filterTable() {
                            const filterByName = document.getElementById('filter_by_name');
                            const filterByBrand = document.getElementById('filter_by_brand');
                            const filterBySpec = document.getElementById('filter_by_spec');
                            const table = document.getElementById('addWorkingHour');
                            const rows = table.getElementsByTagName('tr');

                            const nameValue = filterByName.value.toLowerCase();
                            const brandValue = filterByBrand.value.toLowerCase();
                            const specValue = filterBySpec.value.toLowerCase();

                            for (let i = 1; i < rows.length; i++) {
                                const nameCell = rows[i].getElementsByTagName('td')[2];
                                const brandCell = rows[i].getElementsByTagName('td')[4];
                                const specCell = rows[i].getElementsByTagName('td')[5];

                                const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                const brandText = brandCell ? brandCell.textContent.toLowerCase() : '';
                                const specText = specCell ? specCell.textContent.toLowerCase() : '';

                                // Check if row matches the filter criteria
                                if (nameText.includes(nameValue) &&
                                    brandText.includes(brandValue) &&
                                    specText.includes(specValue)) {
                                    rows[i].style.display = '';  // Show the row
                                } else {
                                    rows[i].style.display = 'none';  // Hide the row
                                }
                            }
                        }

                        data.refreshmachine.forEach((machine, index) => {
                            tableRows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${machine.invent_number}</td>
                                    <td>${machine.machine_name}</td>
                                    <td>${machine.machine_type || '-'}</td>
                                    <td>${machine.machine_brand || '-'}</td>
                                    <td>${machine.machine_spec || '-'}</td>
                                    <td>${machine.machine_info || '-'}</td>
                                    <td>${machine.machine_number || '-'}</td>
                                    <td>
                                        <input type="checkbox" name="machine_input" value="${machine.id}"}>
                                    </td>
                                </tr>
                            `;
                        });

                        const header_modal = `
                            <h5 class="modal-title">Tambah Standarisasi Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <form id="addForm" method="post">
                                <div class="row" align-items="center">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Standarisasi Mesin</label>
                                            <div>
                                                <input class="form-control" type="text" name="standart_name" placeholder="Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Prioritas</label>
                                            <div>
                                                <input class="form-control" type="text" name="priority" placeholder="Priority">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Durasi PM</label>
                                            <div>
                                                <input class="form-control" type="number" name="preventive_hour" placeholder="Dihitung Perjam">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Man Power</label>
                                            <div>
                                                <input class="form-control" type="number" name="man_power" placeholder="Jumlah Operator Dilibatkan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" align-items="center">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="mg-b-10">Filter Nama Mesin</p>
                                            <input class="form-control" id="filter_by_name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="mg-b-10">Filter Merk Mesin</p>
                                            <input class="form-control" id="filter_by_brand">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="mg-b-10">Filter Spec Mesin </p>
                                            <input class="form-control" id="filter_by_spec">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="addWorkingHour" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO.INVENT</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>SPEC/TONNAGE</th>
                                            <th>KETERANGAN</th>
                                            <th>NO.MESIN/LOKASI</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                            ${tableRows}
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        `;

                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="addButton">Save changes</button>
                        `;

                        $('#modal_title_add').html(header_modal);
                        $('#modal_data_add').html(data_modal);
                        $('#modal_button_add').html(button_modal);

                        const filterByName = document.getElementById('filter_by_name');
                        const filterByBrand = document.getElementById('filter_by_brand');
                        const filterBySpec = document.getElementById('filter_by_spec');

                        filterByName.addEventListener('input', filterTable);
                        filterByBrand.addEventListener('input', filterTable);
                        filterBySpec.addEventListener('input', filterTable);

                        // Add event listener to save button
                        $('#addButton').on('click', function() {
                            let formData = {
                                standartName: $('input[name="standart_name"]').val().toUpperCase(),
                                priority: $('input[name="priority"]').val().toUpperCase(),
                                preventiveHour: $('input[name="preventive_hour"]').val().toUpperCase(),
                                manPower: $('input[name="man_power"]').val().toUpperCase(),
                            };
                            let machineInput = [];
                            $('input[name="machine_input"]:checked').each(function() {
                                machineInput.push($(this).val());
                            });

                            if (confirm("Apakah anda sudah yakin semua data terisi dengan benar?")) {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route("addworkinghour") }}',
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'standart_name': formData.standartName,
                                        'priority': formData.priority,
                                        'preventive_hour': formData.preventiveHour,
                                        'man_power': formData.manPower,
                                        'machine_input': machineInput,
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#addWorkingHour').modal('hide');
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
                                            $('#addWorkingHour').modal('hide');
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
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });
            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END ADD WORKING HOUR>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>



            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<EDIT WORKING HOUR>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>

            // fungsi untuk mengedit atau menambahkan standarisasi ke mesin
            $('#editWorkingHour').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let workingHourId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("findworkinghour", ':id') }}'.replace(':id', workingHourId),
                    success: function(data) {
                        let tableRows = '';

                        function filterTable() {
                            const filterByName = document.getElementById('filter_by_name');
                            const filterByBrand = document.getElementById('filter_by_brand');
                            const filterBySpec = document.getElementById('filter_by_spec');
                            const table = document.getElementById('addWorkingHour');
                            const rows = table.getElementsByTagName('tr');

                            const nameValue = filterByName.value.toLowerCase();
                            const brandValue = filterByBrand.value.toLowerCase();
                            const specValue = filterBySpec.value.toLowerCase();

                            for (let i = 1; i < rows.length; i++) {
                                const nameCell = rows[i].getElementsByTagName('td')[2];
                                const brandCell = rows[i].getElementsByTagName('td')[4];
                                const specCell = rows[i].getElementsByTagName('td')[5];

                                const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                                const brandText = brandCell ? brandCell.textContent.toLowerCase() : '';
                                const specText = specCell ? specCell.textContent.toLowerCase() : '';

                                // Check if row matches the filter criteria
                                if (nameText.includes(nameValue) &&
                                    brandText.includes(brandValue) &&
                                    specText.includes(specValue)) {
                                    rows[i].style.display = '';  // Show the row
                                } else {
                                    rows[i].style.display = 'none';  // Hide the row
                                }
                            }
                        }

                        let machineCollection = JSON.parse(data.refreshworkinghours.machine_total);
                        data.refreshmachine.forEach((machine, index) => {
                            tableRows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${machine.invent_number}</td>
                                    <td>${machine.machine_name}</td>
                                    <td>${machine.machine_type || '-'}</td>
                                    <td>${machine.machine_brand || '-'}</td>
                                    <td>${machine.machine_spec || '-'}</td>
                                    <td>${machine.machine_info || '-'}</td>
                                    <td>${machine.machine_number || '-'}</td>
                                    <td>
                                        <input type="checkbox" name="machine_input_edit" value="${machine.id}" ${machineCollection.map(String).includes(String(machine.id)) ? 'checked' : ''}>
                                    </td>
                                </tr>
                            `;
                        });

                        const header_modal = `
                            <h5 class="modal-title">Ubah Standarisasi Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <form id="addForm" method="post">
                                <div class="row" align-items="center">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Standarisasi Mesin</label>
                                            <div>
                                                <input class="form-control" type="text" name="standart_name_edit" placeholder="Name" value="${data.refreshworkinghours.standart_name}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Prioritas</label>
                                            <div>
                                                <input class="form-control" type="text" name="priority_edit" placeholder="priority" value="${data.refreshworkinghours.priority}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Durasi PM</label>
                                            <div>
                                                <input class="form-control" type="number" name="preventive_hour_edit" placeholder="Dihitung Perjam" value="${data.refreshworkinghours.preventive_hour}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Man Power</label>
                                            <div>
                                                <input class="form-control" type="number" name="man_power_edit" placeholder="Jumlah Operator Dilibatkan" value="${data.refreshworkinghours.man_power}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" align-items="center">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="mg-b-10">Filter Nama Mesin</p>
                                            <input class="form-control" id="filter_by_name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="mg-b-10">Filter Merk Mesin</p>
                                            <input class="form-control" id="filter_by_brand">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="mg-b-10">Filter Spec Mesin </p>
                                            <input class="form-control" id="filter_by_spec">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="addWorkingHour" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO.INVENT</th>
                                            <th>NAMA MESIN</th>
                                            <th>MODEL/TYPE</th>
                                            <th>BRAND/MERK</th>
                                            <th>SPEC/TONNAGE</th>
                                            <th>KETERANGAN</th>
                                            <th>NO.MESIN/LOKASI</th>
                                            <th>ADD</th>
                                        </thead>
                                        <tbody>
                                            ${tableRows}
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        `;

                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="editButton">Save changes</button>
                        `;

                        $('#modal_title_edit').html(header_modal);
                        $('#modal_data_edit').html(data_modal);
                        $('#modal_button_edit').html(button_modal);

                        const filterByName = document.getElementById('filter_by_name');
                        const filterByBrand = document.getElementById('filter_by_brand');
                        const filterBySpec = document.getElementById('filter_by_spec');

                        filterByName.addEventListener('input', filterTable);
                        filterByBrand.addEventListener('input', filterTable);
                        filterBySpec.addEventListener('input', filterTable);

                        // Add event listener to save button
                        $('#editButton').on('click', function() {
                            let formDataEdit = {
                                standartName: $('input[name="standart_name_edit"]').val().toUpperCase(),
                                priority: $('input[name="priority_edit"]').val().toUpperCase(),
                                preventiveHour: $('input[name="preventive_hour_edit"]').val().toUpperCase(),
                                manPower: $('input[name="man_power_edit"]').val().toUpperCase(),
                            };
                            let machineInput = [];
                            $('input[name="machine_input_edit"]:checked').each(function() {
                                machineInput.push($(this).val());
                            });

                            if (confirm("Apakah anda sudah yakin semua data terisi dengan benar?")) {
                                $.ajax({
                                    type: 'PUT',
                                    url: '{{ route("editworkinghour", ':id') }}'.replace(':id', workingHourId),
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'standart_name': formDataEdit.standartName,
                                        'priority': formDataEdit.priority,
                                        'preventive_hour': formDataEdit.preventiveHour,
                                        'man_power': formDataEdit.manPower,
                                        'machine_input': machineInput,
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#editWorkingHour').modal('hide');
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
                                            $('#editWorkingHour').modal('hide');
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
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });
            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END EDIT WORKING HOUR>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>


            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<VIEW WORKING HOUR>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>
            $('#viewWorkingHour').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let workingHourId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("viewworkinghour", ':id') }}'.replace(':id', workingHourId),
                    success: function(data) {

                        let tableRows = '';

                        data.getworkinghour.forEach((machine_wo, index) => {
                            tableRows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${machine_wo.invent_number}</td>
                                    <td>${machine_wo.machine_name}</td>
                                    <td>${machine_wo.machine_type || '-'}</td>
                                    <td>${machine_wo.machine_brand || '-'}</td>
                                    <td>${machine_wo.machine_spec || '-'}</td>
                                    <td>${machine_wo.machine_info || '-'}</td>
                                    <td>${machine_wo.machine_number || '-'}</td>
                                    <td>${machine_wo.preventive_hour || '-'}</td>
                                    <td>${machine_wo.man_power || '-'}</td>
                                </tr>
                            `;
                        });

                        const header_modal = `
                            <h5 class="modal-title">Lihat Standarisasi Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <div class="table-responsive">
                                <table class="table table-bordered" id="addWorkingHour" width="100%">
                                    <thead>
                                        <th>NO.</th>
                                        <th>NO.INVENT</th>
                                        <th>NAMA MESIN</th>
                                        <th>MODEL/TYPE</th>
                                        <th>BRAND/MERK</th>
                                        <th>SPEC/TONNAGE</th>
                                        <th>KETERANGAN</th>
                                        <th>NO.MESIN/LOKASI</th>
                                        <th>DURASI PM</th>
                                        <th>MAN POWER</th>
                                    </thead>
                                    <tbody>
                                        ${tableRows}
                                    </tbody>
                                </table>
                            </div>
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        `;
                        $('#modal_title_view').html(header_modal);
                        $('#modal_data_view').html(data_modal);
                        $('#modal_button_view').html(button_modal);
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });
            // <===========================================================================================>
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<END VIEW WORKING HOUR>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            // <===========================================================================================>

            //fungsi filter button
            $('#filterButton').on('click', function() {
                const filterCard = $('#filterCard');
                filterCard.collapse('toggle');
            });
        });
    </script>
@endpush
