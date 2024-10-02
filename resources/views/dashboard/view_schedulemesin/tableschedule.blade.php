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
                            <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addModal" tabindex="0">+ Schedule mesin</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <th>NO.</th>
                                <th>NAMA SCHEDULE</th>
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
    <div class="modal fade" id="addModal" tabindex="-1">
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
    <div class="modal fade" id="editModal" tabindex="-1">
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

    <!-- View Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_schedule">
                </div>
                <div class="modal-body" id="modal_data_schedule">
                </div>
                <div class="modal-footer" id="modal_button_schedule">
                </div>
            </div>
        </div>
    </div>
    <!-- End View Modal-->

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
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
@endpush

@push('script')
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
                url: '{{ route("refreshschedule") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            no: index + 1,
                            name_schedule: refreshschedule.name_schedule,
                            id_machine: JSON.parse(refreshschedule.id_machine.split(',').length),
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                <div class="dynamic-button-group">
                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item-custom-more-edit" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#scheduleModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;More Edit</a>
                                        <a class="dropdown-item-custom-edit" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                        <a class="dropdown-item-custom-delete" data-id="${refreshschedule.id}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                    </div>
                                </div>
                            `
                        };
                    });
                }
            },
            columns: [
                { data: 'no', orderable: false, searchable: false},
                { data: 'name_schedule' },
                { data: 'id_machine' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#addModal').on('shown.bs.modal', function(event) {
            $.ajax({
                type: 'GET',
                url: '{{ route("fetchmachine") }}',
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Tambah Jadwal Preventive Mesin</h5>
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
                            </div>
                            <div class="row" align-items="center">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="machineTables1" width="100%">
                                        <thead>
                                            <th>NO.</th>
                                            <th>NO. INVENT</th>
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

                        // Re-add event listeners for new checkboxes
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
                                            <th>NO</th>
                                            <th>NO. INVENT</th>
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
                                                <td><input class="form-control" type="date" name="schedule_time"></td>
                                                <input type="hidden" name="id_machine" value="${machine.id}">
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
                            <button class="btn dynamic-button btn-primary" id="confirmButton">Confirm<i class="bi bi-check2-circle"></i></button>
                        `;
                        if (step === 1) {
                            renderFirstMenu();
                            document.getElementById("modal_button_add").innerHTML = button_modal1;
                            document.getElementById("previousButton").disabled = true;
                        } else if (step === 2) {
                            renderSecondMenu();
                            document.getElementById("modal_button_add").innerHTML = button_modal2;
                            document.getElementById("confirmButton").addEventListener('click', function() {
                                confirmButton();
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
                            nameSchedule = $('#name_schedule').val();
                            changeMenu(2);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        function confirmButton() {
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
                url: '{{ route("addmachineschedule") }}',
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
                        $('#scheduleModal').modal('hide');
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    if (xhr.responseText) {
                        const warningMessage = xhr.responseText;
                        $('#failedText').text(warningMessage);
                        $('#failedModal').modal('show');
                    }
                    setTimeout(function() {
                        $('#failedModal').modal('hide');
                        $('#scheduleModal').modal('hide');
                    }, 2000);
                }
            }).always(function() {
                table.ajax.reload(null, false);
            });
        }


        // fungsi delete button untuk hapus mesin
        $('#scheduleTables').on('click', '.dropdown-item-custom-delete', function(e) {
            e.preventDefault();
            const button = $(this);
            const machineId = button.data('id');
            if (confirm("Apakah yakin menghapus mesin ini?")) {
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
