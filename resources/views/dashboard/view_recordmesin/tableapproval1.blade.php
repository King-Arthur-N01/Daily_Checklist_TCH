@extends('layouts.master')
@section('title', 'Table koreksi preventive')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Koreksi Checklist Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-filter">
                            <div class="col-4">
                                <p class="mg-b-10">Nama Mesin</p>
                                <select class="form-control select2" name="" id="category-input-machinename">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <select class="form-control select2" name="" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Status Mesin</p>
                                <select class="form-control" name="sample" id="statusMachine">
                                    <option selected="selected">Select :</option>
                                    <option>Sudah Dipreventive</option>
                                    <option>Belum Dipreventive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="preventiveTables1" width="100%">
                            <thead>
                                <th>NO.</th>
                                <th>SHIFT</th>
                                <th>PIC</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                <th>WAKTU PREVENTIVE</th>
                                <th>STATUS</th>
                                <th style="display: none;">REJECT</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @if (isset($getrecords) && !empty($getrecords))
                                    @foreach ($getrecords as $viewrecords)
                                        <tr>
                                            <td>{{ $viewrecords->records_id }}</td>
                                            <td>{{ $viewrecords->shift }} </td>
                                            <td>{{ $viewrecords->getuser }}</td>
                                            <td>{{ $viewrecords->machine_name }}</td>
                                            <td>{{ $viewrecords->machine_type }}</td>
                                            <td>{{ $viewrecords->machine_brand }}</td>
                                            <td>{{ $viewrecords->record_time }}</td>
                                            <td>{{ $viewrecords->correct_by }}</td>
                                            <td style="display: none;">{{ $viewrecords->reject_by }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="{{ $viewrecords->records_id }}" data-target="#ExtralargeModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No data found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
    </div>

    <!-- Extra Large Modal -->
    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Extra Large Modal</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <div id="modal-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="rejectButton" data-toggle="modal" onclick="return confirm('Apakah sudah yakin untuk di REJECT?')">Reject</button>
                    <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Extra Large Modal-->

    <!-- Alert Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <i class="modal-alert">Data Preventive was successfully ACCEPTED</i>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Success Modal -->

    <!-- Alert Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <i class="modal-alert">Data Preventive was successfully REJECT</i>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Reject Modal -->

    <!-- Alert Notification Modal -->
    <div class="modal fade" id="nontifModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i>
                        <i class="modal-alert">Data update failed. Record already corrected by someone else.</i>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Notification Modal -->

    <!-- Alert Danger Modal -->
    <div class="modal fade" id="failedModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <i class="modal-alert">Data Preventive failed to be updated !!!!</i>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Danger Modal -->

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/filtertable1.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#preventiveTables1').DataTable({ // Disable sorting for columns
                columnDefs: [{"orderable": false, "targets": [8]
                }]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ExtralargeModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('fetchcorrection', ':id') }}'.replace(':id', id),
                    success: function(data) {
                        var html = '';
                        html += '<table class="table table-bordered">';
                        html += '<tr><th>No. Invent Mesin :</th><td>' + data.machinedata[0].invent_number + '</td><th>Spec/Tonage :</th><td>' + data.machinedata[0].machine_spec + '</td></tr>';
                        html += '<tr><th>Nama Mesin :</th><td>' + data.machinedata[0].machine_name + '</td><th>Buatan :</th><td>' + data.machinedata[0].machine_made + '</td></tr>';
                        html += '<tr><th>Brand/Merk :</th><td>' + data.machinedata[0].machine_brand + '</td><th>Mfg.NO :</th><td>' + data.machinedata[0].mfg_number + '</td></tr>';
                        html += '<tr><th>Model/Type :</th><td>' + data.machinedata[0].machine_type + '</td><th>Install Date :</th><td>' + data.machinedata[0].install_date + '</td></tr>';
                        html += '</table>';
                        html += '<h4>History Records</h4>';
                        html += '<table class="table table-bordered" id="dataTables">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th>Nama Mesin</th>';
                        html += '<th>Bagian Yang Dicheck</th>';
                        html += '<th>Standart/Parameter</th>';
                        html += '<th>Metode Pengecekan</th>';
                        html += '<th>Action</th>';
                        html += '<th>Result</th>';
                        html += '</tr>';
                        html += '</thead>';
                        $.each(data.combinedata, function(index, row) {
                            html += '<tr>';
                            html += '<td>' + row.machine_name + '</td>';
                            html += '<td>' + row.name_componencheck + '</td>';
                            html += '<td>' + row.name_parameter + '</td>';
                            html += '<td>' + row.name_metodecheck + '</td>';
                            html += '<td>' + row.operator_action + '</td>';
                            html += '<td>' + row.result + '</td>';
                            html += '</tr>';
                        });
                        html += '</table>';
                        html += '<div class="form-custom">';
                        html += '<label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>';
                        html += '<textarea id="input_note" type="text" rows="6" cols="50" readonly>' + data.machinedata[0].note + '</textarea>';
                        html += '</div>';
                        html += '<div class="form-custom">';
                        html += '<table class="table table-bordered" id="userTable">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th>Direject oleh :</th>';
                        html += '<th>Disetujui oleh :</th>';
                        html += '<th>Dikoreksi oleh :</th>';
                        html += '<th>Dibuat oleh :</th>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '<td>' + data.recordsdata[0].reject_by + '</td>';
                        html += '<td>' + data.recordsdata[0].approve_by + '</td>';
                        html += '<td>' + data.recordsdata[0].correct_by + '</td>';
                        html += '<td>' + data.recordsdata[0].create_by + '</td>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '</table>';
                        html += '</div>';
                        $('#modal-data').html(html);
                        mergeCells();
                    }
                });
            });
            $(".btn-Id").on('click', function() {
                console.log($(this).attr("data-id"));
                $("#rejectButton").attr("value", $(this).attr("data-id"));
                $("#saveButton").attr("value", $(this).attr("data-id"));
            });
            $('#saveButton').on('click', function() {
                var machineId = $(this).val(); // Get the machine ID from the button that triggered the modal
                var correctedBy = '{{ Auth::user()->id }}';
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('pushcorrection', ':id') }}'.replace(':id', machineId),
                    data: {
                        '_token': '{{ csrf_token() }}', // Include the CSRF token
                        'correct_by': correctedBy
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#successModal').modal('show'); // Show success modal
                        } else {
                            $('#failedModal').modal('show'); // Show failed modal
                        }
                        $('#ExtralargeModal').modal('hide'); // Hide modal on success
                    },
                    error: function(xhr, status, error) {
                        $('#nontifModal').modal('show'); // Show nontif modal
                        console.error('Error saving machine record: ' + error);
                        $('#ExtralargeModal').modal('hide'); // Hide modal on error
                    }
                }).always(function() {
                    setTimeout(function() {
                        location.reload(); // Refresh the page after a 2-second delay
                    }, 2000); // 2000 milliseconds = 2 seconds
                });
            });
            $('#rejectButton').on('click', function() {
                var machineId = $(this).val(); // Get the machine ID from the button that triggered the modal
                var rejectBy = '{{ Auth::user()->id }}';
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('pushreject1', ':id') }}'.replace(':id', machineId),
                    data: {
                        '_token': '{{ csrf_token() }}', // Include the CSRF token
                        'reject_by': rejectBy
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#rejectModal').modal('show'); // Show success modal
                        } else {
                            $('#failedModal').modal('show'); // Show failed modal
                        }
                        $('#ExtralargeModal').modal('hide'); // Hide modal on success
                    },
                    error: function(xhr, status, error) {
                        $('#nontifModal').modal('show'); // Show nontif modal
                        console.error('Error saving machine record: ' + error);
                        $('#ExtralargeModal').modal('hide'); // Hide modal on error
                    }
                }).always(function() {
                    setTimeout(function() {
                        location.reload(); // Refresh the page after a 2-second delay
                    }, 2000); // 2000 milliseconds = 2 seconds
                });
            });

        });
    </script>
@endpush
