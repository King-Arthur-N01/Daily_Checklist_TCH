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
                        <table class="table" id="dataTable" width="100%">
                            <thead>
                                <th>NO PREVENTIVE</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                <th>INVENT NUMBER</th>
                                <th>WAKTU PREVENTIVE</th>
                            </thead>
                            <tbody>
                                @foreach ($joindata as $getdata)
                                    <tr>
                                        <td>{{ $getdata->records_id }}</td>
                                        <td>{{ $getdata->machine_name }}</td>
                                        <td>{{ $getdata->machine_type }}</td>
                                        <td>{{ $getdata->machine_brand }}</td>
                                        <td>{{ $getdata->invent_number }}</td>
                                        <td>{{ $getdata->getcreatedate }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" style="color:white" data-toggle="modal" data-target="#ExtralargeModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></button>
                                        </td>
                                    </tr>
                                @endforeach
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
                    <div class="table-responsive">
                        {{-- <table class="table table-bordered table-header" width="100%">
                            <tbody>
                                <tr>
                                    <th>No. Invent Mesin :</th>
                                    <th>{{ $detailrecords[0]->invent_number }}</th>
                                    <th>Spec/Tonage :</th>
                                    <th>{{ $detailrecords[0]->machine_spec }}</th>
                                </tr>
                                <tr>
                                    <th>Nama Mesin :</th>
                                    <th>{{ $detailrecords[0]->machine_name }}</th>
                                    <th>Buatan :</th>
                                    <th>{{ $detailrecords[0]->machine_made }}</th>
                                </tr>
                                <tr>
                                    <th>Brand/Merk :</th>
                                    <th>{{ $detailrecords[0]->machine_brand }}</th>
                                    <th>Mfg.NO :</th>
                                    <th>{{ $detailrecords[0]->mfg_number }}</th>
                                </tr>
                                <tr>
                                    <th>Model/Type :</th>
                                    <th>{{ $detailrecords[0]->machine_type }}</th>
                                    <th>Install Date :</th>
                                    <th>{{ $detailrecords[0]->install_date }}</th>
                                </tr>
                                <tr>
                                    <th>PIC :</th>
                                    <th>{{ $historyrecords[0]->name }}</th>
                                    <th>Waktu Preventive :</th>
                                    <th>{{ $detailrecords[0]->created_at }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="header-input">
                            <a>Machine Number :</a>
                            <input class="form-control" type="int" name="machine_number2" id="machine_number2" value="{{ $detailrecords[0]->machine_number2 }}" placeholder="Nomor Mesin" readonly>
                        </div> --}}
                        <table class="table table-bordered" id="datatables" width="100%">
                            <thead>
                                <tr>
                                    <th>Nama Mesin</th>
                                    <th>Bagian Yang Dicheck</th>
                                    <th>Standart/Parameter</th>
                                    <th>Metode Pengecekan</th>
                                    <th>Action</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($combinedata as $row)
                                <tr>
                                    <td>{{ $row['machine_name'] }}</td>
                                    <td>{{ $row['name_componencheck'] }}</td>
                                    <td>{{ $row['name_parameter'] }}</td>
                                    <td>{{ $row['name_metodecheck'] }}</td>
                                    <td>{{ $row['operator_action'] }}</td>
                                    <td>{{ $row['result'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <div>
                                <label for="input_note" class="col-form-label text-sm-right" style="margin-left: 4px;">Keterangan</label>
                                <textarea class="form-control" id="input_note" type="text" rows="6" cols="50" readonly>#</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div><!-- End Extra Large Modal-->
@endsection

@push('style')

    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')

    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            $(document).ready(function() { //script for search2.js
                $('.select2').select2({
                    placeholder: 'Select :',
                    searchInputPlaceholder: 'Search'
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <script>
    $(document).ready(function() {
        $('#ExtralargeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route('fetchdatarecord') }}',
                data: { id: id },
                success: function(data) {
                    var html = '';
                    html += '<table class="table table-bordered">';
                    html += '<tr><th>No. Invent Mesin :</th><td>' + data.detailrecords[0].invent_number + '</td></tr>';
                    html += '<tr><th>Nama Mesin :</th><td>' + data.detailrecords[0].machine_name + '</td></tr>';
                    html += '<tr><th>Spec/Tonage :</th><td>' + data.detailrecords[0].machine_spec + '</td></tr>';
                    html += '</table>';
                    html += '<h4>History Records</h4>';
                    html += '<table class="table table-bordered">';
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
                    $('.modal-body').html(html);
                }
            });
        });
    });
    </script>
@endpush
