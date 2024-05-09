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
                        <div>
                            <form action="#" method="post">
                                @csrf
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
                            </form>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="preventiveTables" width="100%">
                            <thead>
                                <th>CHECKPOINT NO.</th>
                                <th>SHIFT</th>
                                <th>PIC</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                <th>WAKTU PREVENTIVE</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @if (isset($joindata) &&!empty($joindata))
                                    @foreach ($joindata as $getrecord)
                                        <tr>
                                            <td>{{ $getrecord->records_id }}</td>
                                            <td>{{ $getrecord->shift }} </td>
                                            <td>{{ $getrecord->getuser }}</td>
                                            <td>{{ $getrecord->machine_name }}</td>
                                            <td>{{ $getrecord->machine_type }}</td>
                                            <td>{{ $getrecord->machine_brand }}</td>
                                            <td>{{ $getrecord->record_time }}</td>
                                            <td>{{ $getrecord->approve_by }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" style="color:white" data-toggle="modal" data-id="{{ $getrecord->records_id }}" data-target="#ExtralargeModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td>No data found.</td></tr>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Reject</button>
                    <button type="submit" class="btn btn-primary" id="saveButton" value="{{ $joindata->first()->records_id }}">Approve</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Extra Large Modal-->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/filtertable2.js')}}"></script>
    {{-- <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js')}}"></script> --}}
    {{-- <script>
        $(function() {
            $(document).ready(function() { //script for search2.js
                $('.select2').select2({
                    placeholder: 'Select :',
                    searchInputPlaceholder: 'Search'
                });
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('#preventiveTables').DataTable({ // Disable sorting for columns
            columnDefs: [{"orderable": false, "targets": [8]}]
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
                    url: '{{ route('fetchdatarecord2', ':id') }}'.replace(':id', id),
                    success: function(data) {
                        var html = '';
                        html += '<table class="table table-bordered">';
                        html += '<tr><th>No. Invent Mesin :</th><td>' + data.detailrecords[0].invent_number + '</td><th>Spec/Tonage :</th><td>' + data.detailrecords[0].machine_spec + '</td></tr>';
                        html += '<tr><th>Nama Mesin :</th><td>' + data.detailrecords[0].machine_name + '</td><th>Buatan :</th><td>' + data.detailrecords[0].machine_made + '</td></tr>';
                        html += '<tr><th>Brand/Merk :</th><td>' + data.detailrecords[0].machine_brand + '</td><th>Mfg.NO :</th><td>' + data.detailrecords[0].mfg_number + '</td></tr>';
                        html += '<tr><th>Model/Type :</th><td>' + data.detailrecords[0].machine_type + '</td><th>Install Date :</th><td>' + data.detailrecords[0].install_date + '</td></tr>';
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
                        html += '<textarea id="input_note" type="text" rows="6" cols="50" disable>' + data.detailrecords[0].note + '</textarea>';
                        html += '</div>';
                        $('#modal-data').html(html);
                        mergeCells();
                    }
                });
            });
            $('#saveButton').on('click', function() {
                var id = $(this).val(); // Get the machine ID from the button that triggered the modal
                var approveBy = '{{ Auth::user()->id }}';
                $.ajax({
                    type: 'POST',
                    url: '{{ route('registerapproval1', ':machineId') }}'.replace(':machineId',id),
                    data: {
                        '_token': '{{ csrf_token() }}', // Include the CSRF token
                        'approve_by': approveBy
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data was successfully updated.'); // Alert success message
                        } else {
                            alert('Failed to update data.'); // Alert failure message
                        }
                        $('#ExtralargeModal').modal('hide'); // Hide modal on success
                    },
                    error: function(xhr, status, error) {
                        alert('Error: Data failed to update.'); // Alert error message
                        console.error('Error saving machine record: ' + error);
                        $('#ExtralargeModal').modal('hide'); // Hide modal on error
                    }
                }).always(function() {
                    location.reload(); // Refresh the page whether success or error
                });
            });
        });
    </script>
@endpush
