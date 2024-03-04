@extends('layouts.master')
@section('title', 'Tambah Data Standart Checklist Mesin')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Form Data Standart Checklist Mesin</h5>
                <div class="card-body">
                    <form action="{{ route('pushmachineresults') }}" id="registerform" method="post">
                        @csrf
                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 1========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Nama Mesin</p>
                                <select class="form-control select2" name="machine_coderesult" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    @foreach($machines as $machine)
                                        <option value="{{$machine->id}}">{{$machine->machine_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck1" id="category-input-componencheck1">
                                    <option selected="selected" value="">Select :</option>
                                    @foreach($componenchecks as $componencheck)
                                        <option value="{{$componencheck->id_machine }}">{{$componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter1" id="category-input-parameter1">
                                    <option selected="selected" value="">Select :</option>
                                    @foreach($parameters as $parameter)
                                        <option value="{{$parameter->id_componencheck}}">{{$parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck1" id="category-input-metodecheck1">
                                    <option selected="selected" value="">Select :</option>
                                    @foreach($metodechecks as $metodecheck)
                                        <option value="{{$metodecheck->id_parameter}}">{{$metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 1 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 2========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck2" id="category-input-componencheck2">
                                <option selected="selected" value="">Select :</option>
                                    @foreach($componenchecks as $componencheck)
                                    <option value="{{$componencheck->id_machine }}">{{$componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter2" id="category-input-parameter2">
                                <option selected="selected" value="">Select :</option>
                                    @foreach($parameters as $parameter)
                                    <option value="{{$parameter->id_componencheck }}">{{$parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck2" id="category-input-metodecheck2">
                                <option selected="selected" value="">Select :</option>
                                    @foreach($metodechecks as $metodecheck)
                                    <option value="{{$metodecheck->id_parameter }}">{{$metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 2 END======================== -->
                        <!-- ============================================================== -->


                        <div class="form-button-custom text-right">
                            <button type="submit" class="btn btn-space btn-primary">Submit</button>
                            <button type="button" href="{{ route('managemachine') }}" class="btn btn-space btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link href="{{asset('assets/lib/select2/css/select2.min.css')}}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{asset('assets/lib/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/lib/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <script src="{{asset('assets/lib/pickerjs/picker.min.js')}}"></script>
    <script src="{{asset('assets/lib/custom-js/select2search.js')}}"></script>

@endpush
