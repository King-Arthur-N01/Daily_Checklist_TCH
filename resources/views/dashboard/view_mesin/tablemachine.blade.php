@extends('layouts.master')
@section('title', 'Table Machine')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="custom-card-table col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-top">
                <div class="az-content-label mg-b-5">Bordered Table</div>
                <p class="mg-b-20">Add borders on all sides of the table and cells.</p>
                <div class="col-sm-12 col-md-12">
                    <div class="dt-buttons">
                        <a type="button" class="btn btn-block btn-primary" href="{{ route('addmachine') }}" tabindex="0"
                            aria-controls="example">+ Tambah Mesin</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Invent Number</th>
                                    <th>Nama Mesin</th>
                                    <th>Brand Mesin</th>
                                    <th>Type Mesin</th>
                                    <th>Tonage Mesin</th>
                                    <th>Install Date</th>
                                    <th>MFG Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($machines as $machine)
                                    <tr>
                                        <td>{{ $machine->invent_number }}</td>
                                        <td>{{ $machine->machine_name }}</td>
                                        <td>{{ $machine->machine_brand }}</td>
                                        <td>{{ $machine->machine_type }}</td>
                                        <td>{{ $machine->machine_spec }}</td>
                                        <td>{{ $machine->install_date }}</td>
                                        <td>{{ $machine->mfg_number }}</td>
                                        <td>
                                            <a class="button-table-custom-action dropdown" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                <a class="button-table-custom-view" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                                <a class="button-table-custom-edit" href="{{ route('editmachine', $machine->id) }}"><img style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}"></a>
                                                <a class="button-table-custom-delete" href="{{ route('deletemachine', $machine->id) }}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}"></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
@endpush
