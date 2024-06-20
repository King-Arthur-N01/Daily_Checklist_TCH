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
                    <div id="successMessages">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div id="errorMessages">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <form action="{{ route('pushuserinput') }}" id="registerform" method="post">
                            @csrf
                            @method('put')
                            <table class="table table-header">
                                <tbody>
                                    <tr>
                                        <th>No. Invent Mesin :</th>
                                        <th>{{ $joinmachine[0]->invent_number }}</th>
                                        <th>Spec/Tonage :</th>
                                        <th>{{ $joinmachine[0]->machine_spec }}</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Mesin :</th>
                                        <th>{{ $joinmachine[0]->machine_name }}</th>
                                        <th>Buatan :</th>
                                        <th>{{ $joinmachine[0]->machine_made }}</th>
                                    </tr>
                                    <tr>
                                        <th>Brand/Merk :</th>
                                        <th>{{ $joinmachine[0]->machine_brand }}</th>
                                        <th>Mfg.NO :</th>
                                        <th>{{ $joinmachine[0]->mfg_number }}</th>
                                    </tr>
                                    <tr>
                                        <th>Model/Type :</th>
                                        <th>{{ $joinmachine[0]->machine_type }}</th>
                                        <th>Install Date :</th>
                                        <th>{{ $joinmachine[0]->install_date }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="header-input">
                                <div class="col-6">
                                    <a>NO.MESIN :</a>
                                    <input class="form-control" type="int" name="machine_number2" id="machine_number2" value="{{ $joinmachine[0]->machine_number }}" placeholder="Nomor Mesin" readonly>
                                </div>
                                <div class="col-6">
                                    <a>WAKTU PREVENTIVE :</a>
                                    <input class="form-control" name="record_time" value="{{ $timenow }}" readonly>
                                </div>
                            </div>
                            <table class="table table-bordered" id="dataTables" width="100%">
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
                                    @foreach ($joinmachine as $key => $recordsget)
                                        <tr>
                                            <td>{{ $recordsget->machine_name }}</td>
                                            <td>{{ $recordsget->name_componencheck }}</td>
                                            <td>{{ $recordsget->name_parameter }}</td>
                                            <td>{{ $recordsget->name_metodecheck }}</td>
                                            <td>
                                                <input type="hidden" name="metodecheck_id[{{$key}}]" id="metodecheck_id[{{$key}}]" value="{{$recordsget->metodecheck_id}}" required>
                                                <div id="select-style-checkbox" style="display: flex; justify-content: center;">
                                                    {{-- <label>Select an option:</label> --}}
                                                    <div class="option btn-option">
                                                        <label for="option1">check</label>
                                                        <input type="checkbox" name="operator_action[{{$key}}][]" value="check" id="option1">
                                                        {{-- <img class="image-card-mini" src="{{ asset('assets/icons/magnifying-glass.png') }}"> --}}
                                                    </div>
                                                    <div class="option btn-option">
                                                        <label for="option2">cleaning</label>
                                                        <input type="checkbox" name="operator_action[{{$key}}][]" value="cleaning" id="option2">
                                                        {{-- <img class="image-card-mini"src="{{ asset('assets/icons/dust.png') }}"> --}}
                                                    </div>
                                                    <div class="option btn-option">
                                                        <label for="option3">adjust</label>
                                                        <input type="checkbox" name="operator_action[{{$key}}][]" value="adjust" id="option3">
                                                        {{-- <img class="image-card-mini"src="{{ asset('assets/icons/adjust.png') }}"> --}}
                                                    </div>
                                                    <div class="option btn-option">
                                                        <label for="option4">replace</label>
                                                        <input type="checkbox" name="operator_action[{{$key}}][]" value="replace" id="option4">
                                                        {{-- <img class="image-card-mini" src="{{ asset('assets/icons/replacement.png') }}"> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <select name="result[{{$key}}]" id="result[{{$key}}]" required>
                                                        <option label="Result" disabled selected></option>
                                                        <option value="good">OK</option>
                                                        <option value="not good">NG</option>
                                                    </select>
                                                    <input type="hidden" name="id_metodecheck">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-custom">
                                <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                                <textarea class="form-control" id="input_note" type="text" name="note" placeholder="Catatan bila diperlukan!" rows="6" cols="50"></textarea>
                                <input type="hidden" name="id_machine" value="{{ $machine_id }}">
                            </div>
                            <div class="form-custom">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>PIC 1 :</th>
                                            <th>PIC 2 :</th>
                                            <th>PIC 3 :</th>
                                            <th>PIC 4 :</th>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" name="create_by" value="{{ Auth::user()->name }}" readonly></td>
                                            <td><input class="form-control" name="create_by"></td>
                                            <td><input class="form-control" name="create_by"></td>
                                            <td><input class="form-control" name="create_by"></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="column-button">
                                <button type="submit" class="form-buttons">Submit</button>
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
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/formalert.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/custom-js/select-radiobox.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            mergeCells();
        });
    </script>
@endpush
