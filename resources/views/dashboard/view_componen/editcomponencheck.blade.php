@extends('layouts.master')
@section('title', 'Edit Checkpoint Komponen Mesin')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Form Edit Bagian Checkpoint Mesin</h5>
                <div class="card-body">
                    <form action="{{route('pusheditcomponencheck', $componenchecks->id)}}" id="editcomponencheckform" method="post">
                        @csrf
                        @method('put')
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <p class="mg-b-10">Input Nama Mesin</p>
                                <select class="form-control select2" name="machine_code_componencheck" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    @foreach($componenchecks as $componencheckget)
                                    <option value="{{$componencheckget->machine_code}}">{{$componencheckget->machine_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Bagian Komponen Mesin Yang Di Check</label>
                                    <div>
                                        <input class="form-control" type="text" name="name_componencheck" value="{{$componencheckget->name_componencheck}}" placeholder="Nama Bagian Komponen Mesin Yang Di Check">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                <button type="button" href="{{ route('managecomponencheck') }}" class="btn btn-space btn-secondary">Cancel</button>
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
