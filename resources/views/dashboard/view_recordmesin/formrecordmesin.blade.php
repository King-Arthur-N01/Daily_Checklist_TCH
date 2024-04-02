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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <form action="{{ route('pushuserinput') }}" id="registerform" method="post">
                            @csrf
                            @method('put')
                            <table class="table table-bordered" width="100%">
                                <tbody>
                                    <tr>
                                        <th>Machine Number :</th>
                                        <th>
                                            <input class="form-control" type="int" name="machine_number" id="machine_number" placeholder="Nomor Mesin" required>
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
                                    @foreach ($machines as $key => $recordsget)
                                        <tr>
                                            <td>{{ $recordsget->machine_name }}</td>
                                            <td>{{ $recordsget->name_componencheck }}</td>
                                            <td>{{ $recordsget->name_parameter }}</td>
                                            <td>{{ $recordsget->name_metodecheck }}</td>
                                            <td>
                                                <input type="hidden" name="metodecheck_id[{{$key}}]" id="metodecheck_id[{{$key}}]" value="{{$recordsget->metodecheck_id}}" required>
                                                <div id="select-style-radio"
                                                    style="display: flex; justify-content: center;">
                                                    {{-- <label>Select an option:</label> --}}
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{$key}}]" value="check" id="option1">
                                                        <img class="image-card-mini" src="{{ asset('assets/icons/magnifying-glass.png') }}">
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{$key}}]" value="cleaning" id="option2">
                                                        <img class="image-card-mini"src="{{ asset('assets/icons/dust.png') }}">
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{$key}}]" value="adjust" id="option3">
                                                        <img class="image-card-mini"src="{{ asset('assets/icons/adjust.png') }}">
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{$key}}]" value="replace" id="option4">
                                                        <img class="image-card-mini" src="{{ asset('assets/icons/replacement.png') }}">
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
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Keterangan</label>
                                <div>
                                    <textarea class="form-control" type="text" name="note" placeholder="Catatan bila diperlukan!"></textarea>
                                    <input type="hidden" name="id_machine2" value="{{$machine_id}}">
                                </div>
                            </div>
                            <div class="dt-buttons">
                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div id="errorMessages">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
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
    <script src="{{ asset('assets/vendor/custom-js/select-radiobox.js') }}"></script>
@endpush
