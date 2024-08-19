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
                                <th>WAKTU SCHEDULE</th>
                                <th>TERAKHIR PREVENTIVE</th>
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
        <div class="modal-dialog modal-xxl">
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
        }, 30000); // 30000 milidetik = 30 second

        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refreshschedule") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            no: index + 1,
                            schedule_name: refreshschedule.schedule_name,
                            schedule_time: refreshschedule.schedule_time,
                            schedule_record: refreshschedule.schedule_record,
                            id_machine: refreshschedule.id_machine,
                            created_at: refreshschedule.created_at,
                            actions: `
                                <div class="dynamic-button-group">
                                    <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item-custom-detail" id="viewButton" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#viewModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                        <a class="dropdown-item-custom-edit" id="editButton" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                        <a class="dropdown-item-custom-delete" id="deleteButton" data-id="${refreshschedule.id}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                    </div>
                                </div>
                            `
                        };
                    });
                }
            },
            columns: [
                { data: 'no', orderable: false, searchable: false},
                { data: 'schedule_name' },
                { data: 'schedule_time' },
                { data: 'schedule_record' },
                { data: 'id_machine' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#addModal').on('shown.bs.modal', function(event) {
            const header_modal = `
                <h5 class="modal-title">Standarisasi Mesin</h5>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
            `;
            const data_modal = `
                <form id="addForm" method="post">
                    <div class="row" align-items="center">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                <div>
                                    <input class="form-control" name="schedule_name" type="text" placeholder="Nama Jadwal">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">waktu Schdule</label>
                                <div>
                                    <input class="form-control" type="text" name="machine_name" placeholder="Nama Mesin">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                <div>
                                    <input class="form-control" type="text" name="machine_brand" placeholder="Brand/Merk Mesin">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" align-items="center">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Model/Type Mesin</label>
                                <div>
                                    <input class="form-control" type="text" name="machine_type" placeholder="Model/Type Mesin">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage</label>
                                <div>
                                    <input class="form-control" type="text" name="machine_spec" placeholder="Spec/Tonnage">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                <div>
                                    <input class="form-control" type="text" name="machine_made" placeholder="Buatan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" align-items="center">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                <div>
                                    <input class="form-control" type="text" name="mfg_number" placeholder="MFG Number">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                <div>
                                    <input class="form-control" type="text" name="install_date" placeholder="Install Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">No Mesin</label>
                                <div>
                                    <input class="form-control" type="text" name="machine_number" placeholder="Nomor Mesin">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            `;
            const button_modal = `
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
            `;
            $('#modal_title_add').html(header_modal);
            $('#modal_data_add').html(data_modal);
            $('#modal_button_add').html(button_modal);
            $('#inventNumber').mask('a-aa-99-9999');
            // definisi deklarasi mask =
            //     '9': "[0-9]",
            //     'a': "[A-Za-z]",
            //     '*': "[A-Za-z0-9]"

            // Add event listener to save button
            $('#saveButton').on('click', function() {
                let formData = {
                    inventNumber: $('input[name="invent_number"]').val(),
                    machineSpec: $('input[name="machine_spec"]').val(),
                    machineName: $('input[name="machine_name"]').val(),
                    machineMade: $('input[name="machine_made"]').val(),
                    machineBrand: $('input[name="machine_brand"]').val(),
                    mfgNumber: $('input[name="mfg_number"]').val(),
                    machineType: $('input[name="machine_type"]').val(),
                    installDate: $('input[name="install_date"]').val(),
                    machineNumber: $('input[name="machine_number"]').val()
                };
                $.ajax({
                    type: 'POST',
                    url: '#',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'invent_number': formData.inventNumber,
                        'machine_spec': formData.machineSpec,
                        'machine_name': formData.machineName,
                        'machine_made': formData.machineMade,
                        'machine_brand': formData.machineBrand,
                        'mfg_number': formData.mfgNumber,
                        'machine_type': formData.machineType,
                        'install_date': formData.installDate,
                        'machine_number': formData.machineNumber,
                    },
                    success: function(response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                            $('#addModal').modal('hide');
                            $('#uploadModal').modal('hide');
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
                            $('#addModal').modal('hide');
                            $('#uploadModal').modal('hide');
                        }, 20000);
                    }
                }).always(function() {
                    table.ajax.reload(null, false);
                });
            });
        });

    });
    </script>
@endpush
