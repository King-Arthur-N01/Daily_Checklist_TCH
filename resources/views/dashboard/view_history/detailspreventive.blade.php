@extends('layouts.master')
@section('title', 'Preventive mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Checklist</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <tbody>
                                <tr>
                                    <th>Machine Number :</th>
                                    <th>
                                        <input class="form-control" type="int" value="{{ $machinerecords->machine_number }}">
                                    </th>
                                </tr>
                            </tbody>
                        </table>
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
                                @foreach ($historyrecords as $historyget)
                                    <tr>
                                        <td>{{ $historyget->machine_name }}</td>
                                        <td>{{ $historyget->name_componencheck }}</td>
                                        <td>{{ $historyget->name_parameter }}</td>
                                        <td>{{ $historyget->name_metodecheck }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="form-group">
                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Keterangan</label>
                            <div>
                                <textarea class="form-control" type="text" value="{{ $machinerecords->note }}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
    </div>
@endsection

@push('style')
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/select-radiobox.js') }}"></script>
@endpush
