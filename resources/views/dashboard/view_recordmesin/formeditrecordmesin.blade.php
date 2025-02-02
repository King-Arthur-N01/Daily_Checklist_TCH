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
                    <div id="errorMessages"></div>
                    <div class="table-responsive">
                        <form action="{{ route('editpreventive', $preventivedata[0]->record_id) }}" id="updateform" method="post">
                            @csrf
                            @method('put')
                            <table class="table table-header">
                                <tbody>
                                    <tr>
                                        <th>No. Invent Mesin :</th>
                                        <th>{{ $preventivedata[0]->invent_number }}</th>
                                        <th>Spec/Tonage :</th>
                                        <th>{{ $preventivedata[0]->machine_spec }}</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Mesin :</th>
                                        <th>{{ $preventivedata[0]->machine_name }}</th>
                                        <th>Buatan :</th>
                                        <th>{{ $preventivedata[0]->machine_made }}</th>
                                    </tr>
                                    <tr>
                                        <th>Brand/Merk :</th>
                                        <th>{{ $preventivedata[0]->machine_brand }}</th>
                                        <th>Mfg.NO :</th>
                                        <th>{{ $preventivedata[0]->mfg_number }}</th>
                                    </tr>
                                    <tr>
                                        <th>Model/Type :</th>
                                        <th>{{ $preventivedata[0]->machine_type }}</th>
                                        <th>Install Date :</th>
                                        <th>{{ $preventivedata[0]->install_date }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="header-input">
                                <div class="col-6">
                                    <a>NO.MESIN :</a>
                                    <input class="form-control" type="int" value="{{ $preventivedata[0]->machine_number }}" placeholder="Nomor Mesin" readonly>
                                </div>
                                <div class="col-6">
                                    <a>WAKTU PREVENTIVE :</a>
                                    @php
                                        $recordDate = \Carbon\Carbon::parse($preventivedata[0]->record_date);
                                    @endphp
                                    <input class="form-control" value="{{ $recordDate->format('Y-m-d') }}" readonly>
                                </div>
                            </div>
                            <table class="table table-bordered" id="dataTables" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Bagian Yang Dicheck</th>
                                        <th>Standart/Parameter</th>
                                        <th>Metode Pengecekan</th>
                                        <th>Action</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $operatorActionArray = json_decode($preventivedata[0]->operator_action);
                                        $resultArray = json_decode($preventivedata[0]->result);

                                        $maxLength = min(
                                            count($preventivedata),
                                            count($operatorActionArray),
                                            count($resultArray)
                                        );
                                    ?>
                                    @for ($index = 0; $index < $maxLength; $index++)
                                        <?php
                                            $actions = isset($operatorActionArray[$index]) ? implode(' & ', $operatorActionArray[$index]) : 'No actions';
                                            $result = isset($resultArray[$index]) ? $resultArray[$index] : 'No result';
                                        ?>
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $preventivedata[$index]->name_componencheck }}</td>
                                            <td>{{ $preventivedata[$index]->name_parameter }}</td>
                                            <td>{{ $preventivedata[$index]->name_metodecheck }}</td>
                                            <td>{{ $actions }}</td>
                                            <td>{{ $result }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            <div class="form-custom">
                                <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                                <textarea class="form-control" id="input_note" type="text" name="note" placeholder="Catatan bila diperlukan!" rows="6" cols="50">{{ $preventivedata[0]->note }}</textarea>
                                {{-- <input type="hidden" name="schedule_id" value="{{ $preventivedata[0]->schedule_id }}"> --}}
                            </div>
                            <div class="form-custom">
                                <table class="table table-bordered" id="abnormalityTable">
                                    <thead>
                                        <tr>
                                            <th>Masalah :</th>
                                            <th>Penyebab :</th>
                                            <th>Tindakan :</th>
                                            <th>Status :</th>
                                            <th>Target :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <textarea class="form-control abnormal-input" type="text" name="problem" placeholder="Isi bila diperlukan!" rows="6" cols="50">{{ $preventivedata[0]->problem }}</textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control abnormal-input" type="text" name="cause" placeholder="Isi bila diperlukan!" rows="6" cols="50">{{ $preventivedata[0]->cause }}</textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control abnormal-input" type="text" name="action" placeholder="Isi bila diperlukan!" rows="6" cols="50">{{ $preventivedata[0]->action }}</textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control abnormal-input" type="text" name="status" placeholder="Isi bila diperlukan!" rows="6" cols="50">{{ $preventivedata[0]->status }}</textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control abnormal-input" type="text" name="target" placeholder="Isi bila diperlukan!" rows="6" cols="50">{{ $preventivedata[0]->target }}</textarea>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                            <div class="form-custom">
                                <table class="table table-bordered" id="userTables">
                                    <thead>
                                        <tr>
                                            <th>PIC 1 :</th>
                                            <th>PIC 2 :</th>
                                            <th>PIC 3 :</th>
                                            <th>PIC 4 :</th>
                                        </tr>
                                        <tr>
                                            <?php $usernames = json_decode($user_operator); ?>
                                            @foreach ($usernames as $eachuser)
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $eachuser }}" disabled>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="column-button">
                                <button type="submit" class="form-buttons">Submit Perbaikan Abnormal PM Mesin</button>
                            </div>
                        </form>
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/custom-js/multi-input-user.js') }}"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            mergeCells();
        });
    </script>
@endpush
