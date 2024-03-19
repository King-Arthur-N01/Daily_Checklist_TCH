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
                            <table class="table table-bordered" id="datatables" width="100%">
                                <thead>
                                    {{-- <tr>
                                        <th>No Invent Mesin = {{ $machines->invent_number }}<br>
                                            Nama Mesin = {{ $machines->machine_name }}<br>
                                            Brand/Merk = {{ $machines->machine_brand }}<br>
                                            Model/Type = {{ $machines->machine_type }}
                                        </th>
                                    </tr> --}}
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
                                    @foreach ($machines as $recordsget)
                                        <tr>
                                            <td>{{ $recordsget->machine_name }}</td>
                                            <td>{{ $recordsget->name_componencheck }}</td>
                                            <td>{{ $recordsget->name_parameter }}</td>
                                            <td>{{ $recordsget->name_metodecheck }}</td>
                                            <td>
                                                <div id="select-style-radio"
                                                    style="display: flex; justify-content: center;">
                                                    {{-- <label>Select an option:</label> --}}
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{ $recordsget->id }}]"
                                                            value="check" id="option1">
                                                        {{-- <label for="option1">CHECK</label> --}}
                                                        <img class="image-card-mini"
                                                            src="{{ asset('assets/icons/magnifying-glass.png') }}">
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{ $recordsget->id }}]"
                                                            value="cleaning" id="option2">
                                                        {{-- <label for="option2">CLEANING</label> --}}
                                                        <img class="image-card-mini"
                                                            src="{{ asset('assets/icons/dust.png') }}">
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{ $recordsget->id }}]"
                                                            value="adjust" id="option3">
                                                        {{-- <label for="option3">ADJUST</label> --}}
                                                        <img
                                                            class="image-card-mini"src="{{ asset('assets/icons/adjust.png') }}">
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="operator_action[{{ $recordsget->id }}]"
                                                            value="replace" id="option4">
                                                        {{-- <label for="option3">REPLACE</label> --}}
                                                        <img class="image-card-mini"
                                                            src="{{ asset('assets/icons/replacement.png') }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <select name="result[{{ $recordsget->id }}]">
                                                        <option label="Result" disabled selected></option>
                                                        <option value="good">OK</option>
                                                        <option value="not good">NG</option>
                                                    </select>
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
                                </div>
                            </div>
                            <div class="dt-buttons">
                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
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
    <script src="{{ asset('assets/vendor/custom-js/select-radiobox.js') }}"></script>
@endpush
