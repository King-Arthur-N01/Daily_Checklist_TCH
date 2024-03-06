@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- valifation types -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Form Edit User</h5>
                <div class="card-body">
                    <form action="{{ route('pushedit') }}" id="validationform" method="post">
                        @csrf
                        @method('put')
                        <div class="row" align-items="center">
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama User</label>
                                    <div>
                                        <input class="form-control" type="text" name="name" placeholder="Username">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">NIK</label>
                                    <div>
                                        <input class="form-control" type="text" name="nik" data-parsley-maxlength="5" placeholder="NIK">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">NIK</label>
                                    <div>
                                        <input class="form-control" type="text" name="status" data-parsley-maxlength="5" placeholder="NIK">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown col-xl-2">
                                <div class="form-group searchable">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Status</label>
                                    <div>
                                        <select selected="selected" class="form-control" name="status" id="category-input">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <div>
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Password</label>
                                        <div class="form-group" style="margin: 0px;">
                                            <input class="form-control" type="password" name="password" required placeholder="Password Min:6 digits" id="password">
                                        </div>
                                    </div>
                                    @error('password')
                                        <strong>{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <div>
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Confirm Password</label>
                                        <div class="form-group" style="margin: 0px;">
                                            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" id="confirm_password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                <button type="button" href="{{ route('manageuser') }}"class="btn btn-space btn-secondary">Cancel</button>
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
