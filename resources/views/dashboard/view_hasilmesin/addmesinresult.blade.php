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
                                <select class="form-control select2" name="machine_code" id="category-input-machinecode">
                                    @foreach($machines as $machine)
                                        <option selected="selected">Select :</option>
                                        <option value="{{ $machine->machine_name}}">{{ $machine->machine_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck1" id="category-input-componencheck1">
                                    @foreach($componenchecks as $componencheck)
                                        <option selected="selected">Select :</option>
                                        <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter1" id="category-input-parameter1">
                                    @foreach($parameters as $parameter)
                                        <option selected="selected">Select :</option>
                                        <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck1" id="category-input-metodecheck1">
                                    @foreach($metodechecks as $metodecheck)
                                        <option selected="selected">Select :</option>
                                        <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
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
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter2" id="category-input-parameter2">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck2" id="category-input-metodecheck2">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 2 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 3========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck3" id="category-input-componencheck3">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter3" id="category-input-parameter3">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck3" id="category-input-metodecheck3">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 3 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 4========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck4" id="category-input-componencheck4">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter4" id="category-input-parameter4">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck4" id="category-input-metodecheck4">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 4 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 5========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck5" id="category-input-componencheck5">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter5" id="category-input-parameter5">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck5" id="category-input-metodecheck5">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 5 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 6========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck6" id="category-input-componencheck6">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter6" id="category-input-parameter6">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck6" id="category-input-metodecheck6">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 6 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 7========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck7" id="category-input-componencheck7">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter7" id="category-input-parameter7">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck7" id="category-input-metodecheck7">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 7 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 8========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck8" id="category-input-componencheck8">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter8" id="category-input-parameter8">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck8" id="category-input-metodecheck8">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 8 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 9========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck9" id="category-input-componencheck9">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter9" id="category-input-parameter9">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck9" id="category-input-metodecheck9">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 9 END======================== -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 10========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck10" id="category-input-componencheck10">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter10" id="category-input-parameter10">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck10" id="category-input-metodecheck10">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 10 END======================= -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 11========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck11" id="category-input-componencheck11">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter11" id="category-input-parameter11">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck11" id="category-input-metodecheck11">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 11 END======================= -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- =========================INPUT ROW 12========================== -->
                        <!-- ============================================================== -->
                        <div class="row-block-custom">
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Checkpoint Komponen Mesin</p>
                                <select class="form-control select2" name="id_componencheck12" id="category-input-componencheck12">
                                    @foreach($componenchecks as $componencheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $componencheck->name_componencheck }}">{{ $componencheck->name_componencheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Parameter Mesin</p>
                                <select class="form-control select2" name="id_parameter12" id="category-input-parameter12">
                                    @foreach($parameters as $parameter)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $parameter->name_parameter }}">{{ $parameter->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p class="mg-b-10">Input Metode Pengecekan Mesin</p>
                                <select class="form-control select2" name="id_metodecheck12" id="category-input-metodecheck12">
                                    @foreach($metodechecks as $metodecheck)
                                    <option selected="selected">Select :</option>
                                    <option value="{{ $metodecheck->name_metodecheck }}">{{ $metodecheck->name_metodecheck}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- =======================INPUT ROW 12 END======================= -->
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
    <script>
        $(document).ready(function() {
        $('#category-input').select2();
        });
    </script>

@endpush
