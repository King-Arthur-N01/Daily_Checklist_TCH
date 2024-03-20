@extends('layouts.master')
@section('title', 'Table History')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table History</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-history">
                        <div class="col-4">
                            <p class="mg-b-10">Input Nama Mesin</p>
                            <select class="form-control select2" name="" id="category-input-machinecode">
                                <option selected="selected" value="">Select :</option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Input Nomor Mesin </p>
                            <select class="form-control select2" name="" id="category-input-machinecode">
                                <option selected="selected" value="">Select :</option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Input Hari/Bulan/Tahun </p>
                            <div class="wd-250 mg-b-20">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="datetimepicker" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                            <thead>
                                <th>Invent Number</th>
                                <th>Nama Mesin</th>
                                <th>Brand Mesin</th>
                                <th>Type Mesin</th>
                                <th>Tonage Mesin</th>
                                <th>Install Date</th>
                                <th>MFG Number</th>
                                <th>Action</th>
                            </thead>
                            {{-- <tbody>
                                @foreach ($machines as $machineget)
                                    <tr>
                                        <td>{{ $machineget->invent_number }}</td>
                                        <td>{{ $machineget->machine_name }}</td>
                                        <td>{{ $machineget->machine_brand }}</td>
                                        <td>{{ $machineget->machine_type }}</td>
                                        <td>{{ $machineget->machine_spec }}</td>
                                        <td>{{ $machineget->install_date }}</td>
                                        <td>{{ $machineget->mfg_number }}</td>
                                        <td>
                                            <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                                <a class="dropdown-item-custom-edit" style="text-align: center" href="{{ route('editmachine', $machineget->id) }}"><img style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}">Edit</a>
                                                <a class="dropdown-item-custom-delete" style="text-align: center" href="{{ route('deletemachine', $machineget->id) }}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<link rel="stylesheet" href="{{asset('assets/vendor/jquery-simple-datetimepicker/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/jquery-simple-datetimepicker/jquery.datetimepicker.min.css')}}">
@endpush

@push('script')
<script src="{{asset('assets/vendor/jquery-simple-datetimepicker/jquery-ui.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-simple-datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>
<script>
    $(function() {
      $('#datetimepicker').datetimepicker({
        datepicker: true,
        timepicker: true,
        format: 'm/d/Y h:i A',
        step: 60 // Set the step interval for hour and minute selection
      });
    });
</script>
@endpush
