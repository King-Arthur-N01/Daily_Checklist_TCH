@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

@section('content')

{{-- here is the code for view --}}
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tambah Checklist Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-filter" id="filterCard" style="display: none;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="dataTables_filter col-4" id="dataTable_filter">
                                <p class="mg-b-10">Input Nama Mesin</p>
                                <input class="form-control" id="searchInput" type="search" aria-controls="dataTable" placeholder="Search here"></input>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <select class="form-control select2" name="" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Hari/Bulan/Tahun </p>
                                <div class="wd-250 mg-b-20">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="datetimepicker" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#largeModal"><i class="fas fa-clipboard-check"></i>&nbsp; Tambah Checksheet Mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="machineTables" width="100%">
                            <thead>
                                <th>Nomor Invent</th>
                                <th>Nama Mesin</th>
                                <th>Brand/Merk</th>
                                <th>Model/Type</th>
                                <th>Buatan</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (isset($machines) && !empty($machines))
                                    @foreach ($machines as $machineget)
                                        <tr>
                                            <td>{{$machineget->invent_number}}</td>
                                            <td>{{$machineget->machine_name}}</td>
                                            <td>{{$machineget->machine_brand}}</td>
                                            <td>{{$machineget->machine_type}}</td>
                                            <td>{{$machineget->machine_made}}</td>
                                            <td>
                                                <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item-custom-detail" data-toggle="modal" data-id="{{ $machineget->id }}" data-target="#ExtralargeModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                                    <a class="dropdown-item-custom-edit" href="#"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                                    <a class="dropdown-item-custom-delete" href="#"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                                </div>
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
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="largeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                </div>
                <div class="modal-body">
                    <form id="formData">
                        @csrf
                        <p>Format excel harus <mark>.xlsx</mark> selain itu tidak akan terbaca dan aturan urutan Kolom pada excel</p>
                        <p class="text-upload-header">No.<mark>|</mark>No.Invent Mesin<mark>|</mark>No.Mesin<mark>|</mark>Nama Mesin<mark>|</mark>Brand/Merk<mark>|</mark>Model/Type<mark>|</mark>Spec/Tonnage<mark>|</mark>Buatan<mark>|</mark>MFG No.<mark>|</mark>Install Date</p>
                        <label for="importExcel" class="table-buttons" id="customButton"><i class="fas fa-file-medical"></i>&nbsp; Select a file</label>
                        <input type="file" name="fileupload" id="importExcel" hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="uploadButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Upload Modal-->

    <!-- View Machine Property Modal -->
    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Preventive Mesin</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <div id="modal-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End View Machine Property Modal-->

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
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/upload.js') }}"></script>
    <script>
        $(document).ready(function () {
            //fungsi fillter header table
            $('#machineTables').DataTable({ // Disable sorting for columns
                columnDefs: [{"orderable": false, "targets": [5]
                }]
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //fungsi upload button untuk upload mesin
            $('#uploadButton').on('click', function (e) {
                e.preventDefault();
                var file = $('#importExcel')[0].files[0];
                var formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    type: "POST",
                    url: "{{ route('uploadfile') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        $('#ExtralargeModal').modal('hide');
                    },
                    error: function (status, error, response) {
                        if (response.error) {
                            const warningMessage = response.error;
                            $('#failedext').text(warningMessage);
                            $('#failedModal').modal('show');
                        }
                        $('#ExtralargeModal').modal('hide');
                    }
                }).always(function() {
                        setTimeout(function() {
                        location.reload(); // Refresh the page after a 2-second delay
                    }, 2000); // 2000 milliseconds = 2 seconds
                });
            });
            //fungsi button get detail mesin
            $('#ExtralargeModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('fetchproperty', ':id') }}'.replace(':id', id),
                    success: function(data) {
                        var html = '';
                        html += '<table class="table table-bordered">';
                        html += '<tr><th>No. Invent Mesin :</th><td>' + data.fetchmachines[0].invent_number + '</td><th>Spec/Tonage :</th><td>' + data.fetchmachines[0].machine_spec + '</td></tr>';
                        html += '<tr><th>Nama Mesin :</th><td>' + data.fetchmachines[0].machine_name + '</td><th>Buatan :</th><td>' + data.fetchmachines[0].machine_made + '</td></tr>';
                        html += '<tr><th>Brand/Merk :</th><td>' + data.fetchmachines[0].machine_brand + '</td><th>Mfg.NO :</th><td>' + data.fetchmachines[0].mfg_number + '</td></tr>';
                        html += '<tr><th>Model/Type :</th><td>' + data.fetchmachines[0].machine_type + '</td><th>Install Date :</th><td>' + data.fetchmachines[0].install_date + '</td></tr>';
                        html += '</table>';
                        html += '<h5>Standart Mesin</h5>';
                        html += '<table class="table table-bordered" id="dataTables">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th>Nama Mesin</th>';
                        html += '<th>Bagian Yang Dicheck</th>';
                        html += '<th>Standart/Parameter</th>';
                        html += '<th>Metode Pengecekan</th>';
                        html += '</tr>';
                        html += '</thead>';
                        $.each(data.fetchmachines, function(index, row) {
                            html += '<tr>';
                            html += '<td>' + row.machine_name + '</td>';
                            html += '<td>' + row.name_componencheck + '</td>';
                            html += '<td>' + row.name_parameter + '</td>';
                            html += '<td>' + row.name_metodecheck + '</td>';
                            html += '</tr>';
                        });
                        html += '</table>';
                        $('#modal-data').html(html);
                        mergeCells();
                    }
                });
            });
            //fungsi fillter button
            $('#filterButton').on('click', function () {
            const filterCard = document.getElementById("#filterCard");
            if ($filterCard.css('display') === 'none') {
                $filterCard.fadeIn(1000);
                $filterCard.css('display', 'block');
            } else {
                $filterCard.fadeOut(1000);
                $filterCard.css('display', 'none');
            }
            });
        });
    </script>
@endpush
