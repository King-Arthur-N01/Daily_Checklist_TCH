@extends('layouts.master')
@section('title', 'Tambah Mesin')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header text-primary">Form Tambah Mesin</h5>
                <div class="card-body">
                    <form action="{{ route('pushmachine') }}" id="registerform" method="post">
                        @csrf
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Invent</label>
                                    <div>
                                        <input class="form-control" type="text" name="invent_number" placeholder="Invent Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Machine</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_name" placeholder="Nama Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_brand" placeholder="Brand/Merk Mesin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Type Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_type" placeholder="Type Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_spec" placeholder="Spec/Tonnage Mesin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_made" placeholder="Buatan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                    <div>
                                        <input class="form-control" type="text" name="mfg_number" placeholder="MFG Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                    <div>
                                        <input class="form-control" type="date" name="install_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                <button type="button" href="{{ route('managemachine') }}" class="btn btn-space btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')

@endpush
@push('script')

@endpush
