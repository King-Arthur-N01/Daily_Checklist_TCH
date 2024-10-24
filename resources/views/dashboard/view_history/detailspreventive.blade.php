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
                        <table class="table table-header" width="100%">
                            <tbody>
                                <tr>
                                    <th>No. Invent Mesin :</th>
                                    <th>{{ $machinedata[0]->invent_number }}</th>
                                    <th>Spec/Tonage :</th>
                                    <th>{{ $machinedata[0]->machine_spec }}</th>
                                </tr>
                                <tr>
                                    <th>Nama Mesin :</th>
                                    <th>{{ $machinedata[0]->machine_name }}</th>
                                    <th>Buatan :</th>
                                    <th>{{ $machinedata[0]->machine_made }}</th>
                                </tr>
                                <tr>
                                    <th>Brand/Merk :</th>
                                    <th>{{ $machinedata[0]->machine_brand }}</th>
                                    <th>Mfg.NO :</th>
                                    <th>{{ $machinedata[0]->mfg_number }}</th>
                                </tr>
                                <tr>
                                    <th>Model/Type :</th>
                                    <th>{{ $machinedata[0]->machine_type }}</th>
                                    <th>Install Date :</th>
                                    <th>{{ $machinedata[0]->install_date }}</th>
                                </tr>
                                <tr>
                                    <th>PIC :</th>
                                    <th>
                                        {{implode(' , ', $usernames)}}
                                    </th>
                                    <th>Waktu Preventive :</th>
                                    <th>{{ $machinedata[0]->created_at }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="header-input">
                            <a>Machine Number :</a>
                            <input class="form-control" type="int" name="machine_number2" id="machine_number2" value="{{ $machinedata[0]->machine_number2 }}" placeholder="Nomor Mesin" readonly>
                        </div>
                        <table class="table table-bordered" id="dataTables" width="100%">
                            <thead>
                                <tr>
                                    <th>Bagian Yang Dicheck</th>
                                    <th>Standart/Parameter</th>
                                    <th>Metode Pengecekan</th>
                                    <th>Action</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($combinedata as $index => $rowdata)
                                    <tr>
                                        <td>{{ $rowdata['name_componencheck'] }}</td>
                                        <td>{{ $rowdata['name_parameter'] }}</td>
                                        <td>{{ $rowdata['name_metodecheck'] }}</td>
                                        <td>{{ implode(' & ', json_decode($combineresult[0]['operator_action'])[$index]) }}</td>
                                        <td>{{ json_decode($combineresult[0]['result'])[$index] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-custom">
                            <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                            <textarea class="form-control" id="input_note" type="text" rows="6" cols="50" readonly>{{ $machinedata[0]->note }}</textarea>
                        </div>
                        <div class="form-custom">
                            <table class="table table-bordered table-custom" id="userTable">
                                <thead>
                                    <tr>
                                        <th>Disetujui oleh :</th>
                                        <th>Dikoreksi oleh :</th>
                                        <th colspan="4">Dibuat oleh :</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $recordsdata[0]->approve_by_name }}</td>
                                        <td>{{ $recordsdata[0]->correct_by_name }}</td>
                                        @foreach ($usernames as $get_user_id)
                                            <td>{{ $get_user_id }}</td>
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
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
    {{-- <script src="{{ asset('assets/vendor/custom-js/select-radiobox.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            mergeCells();
        });
    </script>
@endpush
