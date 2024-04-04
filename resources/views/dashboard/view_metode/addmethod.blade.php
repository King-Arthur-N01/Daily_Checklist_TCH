@extends('layouts.master')
@section('title', 'Tambah Metode Pengecekan Mesin')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header text-primary">Form Tambah Metode Pengecekan Mesin</h5>
                <div class="card-body">
                    <form action="{{ route('pushmethod') }}" id="registerform" method="post">
                        @csrf
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <p class="col-form-label">Input Parameter Check</p>
                                <select class="form-control select2" name="id_parameter" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    @foreach($parameters as $parameterget)
                                        <option value="{{$parameterget->id}}">{{$parameterget->name_parameter}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label" style="margin-left: 4px;">Nama Metode Pengecekan</label>
                                    <div>
                                        <input class="form-control" type="text" name="name_metodecheck" placeholder="Nama Metode Pengecekan Mesin">
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
