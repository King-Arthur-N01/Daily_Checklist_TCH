@extends('layouts.master')
@section('title', 'Edit Metode Pengecekan Mesin')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Form Edit Metode Pengecekan</h5>
                <div class="card-body">
                    <form action="{{route('pusheditmethod', $metodechecks->id)}}" id="editmethodform" method="post">
                        @csrf
                        @method('put')
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">ID Componen</label>
                                    <div>
                                        <input class="form-control" type="text" name="id_metodecheck" value="{{$metodechecks->id}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Metode Pengecekan Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="name_metodecheck" value="{{$metodechecks->name_metodecheck}}" placeholder="Nama Metode Pengecekan Mesin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                <button type="button" href="{{ route('managemethod') }}" class="btn btn-space btn-secondary">Cancel</button>
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