@extends('layouts.master')
@section('title', 'Edit Mesin')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Form Edit Mesin</h5>
                <div class="card-body">
                    <form action="{{route('pusheditmachine', $machines->id)}}" id="editform" method="post">
                        @csrf
                        @method('put')
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Invent</label>
                                    <div>
                                        <input class="form-control" type="text" name="invent_number" value="{{$machines->invent_number}}" placeholder="Invent Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_number" value="{{$machines->machine_number}}" placeholder="Nomor Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_name" value="{{$machines->machine_name}}" placeholder="Nama Mesin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_brand" value="{{$machines->machine_brand}}" placeholder="Brand/Merk Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Type Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_type" value="{{$machines->machine_type}}" placeholder="Type Mesin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_spec" value="{{$machines->machine_spec}}" placeholder="Spec/Tonnage Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_made" value="{{$machines->machine_made}}" placeholder="Buatan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                    <div>
                                        <input class="form-control" type="text" name="mfg_number" value="{{$machines->mfg_number}}" placeholder="MFG Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                    <div>
                                        <input class="form-control" type="date" name="install_date" value="{{$machines->install_date}}">
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
