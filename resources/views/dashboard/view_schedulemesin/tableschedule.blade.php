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
                <div id="calendar" style="padding: 1.25rem;"></div>
            </div>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="post">
                            @csrf
                            <div class="table-filter">
                                <div class="col-4">
                                    <p class="mg-b-10">Nama Mesin</p>
                                    <select class="form-control select2" name="" id="filterByName">
                                        <option selected="selected" value="">Select :</option>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <p class="mg-b-10">Input Nomor Mesin </p>
                                    <select class="form-control select2" name="" id="filterByNumber">
                                        <option selected="selected" value="">Select :</option>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <p class="mg-b-10">Status Mesin</p>
                                    <select class="form-control" name="sample" id="filterByStatus">
                                        <option selected="selected">Select :</option>
                                        <option><i class="fas fa-check-circle"></i>Sudah Dipreventive</option>
                                        <option>Belum Dipreventive</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <th>NO. INVENT</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND/MERK</th>
                                <th>JADWAL PREVENTIVE</th>
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
        <div class="modal-dialog modal-lg">
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
    <script src="{{ mix('js/app.js') }}" defer></script>
<script>
        // sett automatic soft refresh table
        setInterval(function() {
            table.ajax.reload(null, false);
        }, 30000); // 30000 milidetik = 30 second

        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route('refreshschedule') }}',
                dataSrc: function(data) {
                    // Sesuaikan data yang akan digunakan oleh DataTables
                    return data.refreshmachine.map(function(refreshmachine) {
                        let refreshschedule = data.refreshschedule.find(function(schedule) {
                            return schedule.id === refreshmachine.id;
                        });
                        return {
                            invent_number: refreshmachine.invent_number,
                            machine_name: refreshmachine.machine_name,
                            machine_type: refreshmachine.machine_type,
                            machine_brand: refreshmachine.machine_brand,
                            schedule_time: refreshschedule ? refreshschedule.schedule_time :
                                'Belum ada jadwal preventive',
                            actions: `
                                <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#addModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></button>
                            `
                        };
                    });
                }
            },
            columns: [
                { data: 'invent_number' },
                { data: 'machine_name' },
                { data: 'machine_type' },
                { data: 'machine_brand' },
                { data: 'schedule_time' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#addModal').on('shown.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let machineId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route('detailschedule', ':id') }}'.replace(':id', machineId),
                success: function(data) {
                    const header_modal = `
                        <h5 class="modal-title">Standarisasi Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;
                    const data_modal = `
                        <table class="table table-bordered">
                            <tr><th>No. Invent Mesin :</th><td>${data.refreshmachine.invent_number}</td><th>Spec/Tonage :</th><td>${data.refreshmachine.machine_spec}</td></tr>
                            <tr><th>Nama Mesin :</th><td>${data.refreshmachine.machine_name}</td><th>Buatan :</th><td>${data.refreshmachine.machine_made}</td></tr>
                            <tr><th>Brand/Merk :</th><td>${data.refreshmachine.machine_brand}</td><th>Mfg.NO :</th><td>${data.refreshmachine.mfg_number}</td></tr>
                            <tr><th>Model/Type :</th><td>${data.refreshmachine.machine_type}</td><th>Install Date :</th><td>${data.refreshmachine.install_date}</td></tr>
                        </table>
                        <h4>History Records</h4>
                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Waktu Preventive Mesin</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="schedule_time" id="schedule_time" aria-describedby="extra-text">
                            <div class="input-group-append">
                                <span class="input-group-text" id="extra-text">/Bulan</span>
                            </div>
                        </div>
                    `
                    const button_modal = `
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
                    `;
                    $('#modal_title_add').html(header_modal);
                    $('#modal_data_add').html(data_modal);
                    $('#modal_button_add').html(button_modal);

                    document.getElementById('schedule_time').addEventListener('input', function(event) {
                        const inputValue = event.target.value;
                        if (isNaN(inputValue) || inputValue.includes('e')) {
                            $('#warningText').text('Please fill with number');
                            $('#warningModal').modal('show');
                            setTimeout(function() {
                                $('#warningModal').modal('hide');
                            }, 2000);
                            // alert('Please fill with number');
                            event.target.value = '';
                        }
                    });

                    // Save button
                    $('#saveButton').on('click', function() {
                        let scheduleTime = $('#schedule_time').val();
                        if (confirm("Apakah yakin dengan waktu preventive mesin ini?")) {
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route('addschedule', ':id') }}'.replace(':id',machineId),
                                data: {
                                    '_token': '{{ csrf_token() }}', // Include the CSRF token
                                    'schedule_time': scheduleTime
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#correctModal').modal('hide');
                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                        const warningMessage = JSON.parse(xhr
                                            .responseText).error;
                                        $('#warningText').text(warningMessage);
                                        $('#warningModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#warningModal').modal('hide');
                                        $('#correctModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        } else {
                            // User cancelled the deletion, do nothing
                        }
                    });

                    // Delete button
                    $('#deleteButton').on('click', function() {
                        if (confirm("Are you sure you want to delete this record?")) {
                            $.ajax({
                                type: 'DELETE',
                                url: '{{ route('removecorrection', ':id') }}'.replace(
                                    ':id', correctId),
                                data: {
                                    '_token': '{{ csrf_token() }}', // Include the CSRF token
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#correctModal').modal('hide');
                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                        const warningMessage = JSON.parse(xhr
                                            .responseText).error;
                                        $('#warningText').text(warningMessage);
                                        $('#warningModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#warningModal').modal('hide');
                                        $('#correctModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        } else {
                            // User cancelled the deletion, do nothing
                        }
                    });
                }
            });
        });
    </script>
@endpush
