@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

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
                        <a type="button" class="btn btn-block btn-primary" href="{{ route('addmachineresults') }}"
                            tabindex="0" aria-controls="example">+ Tambah Mesin</a>
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
                                    <th>Nama Mesin</th>
                                    <th>Bagian Yang Dicheck</th>
                                    <th>Standart/Parameter</th>
                                    <th>Metode Pengecekan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($filltertable)
                                    @foreach ($filltertable as $filltertables)
                                        <tr>
                                            <td>{{ $filltertables->machine_code }}</td>
                                            <td>{{ $filltertables->id_componencheck1 }}</td>
                                            <td>{{ $filltertables->id_componencheck2 }}</td>
                                            <td>{{ $filltertables->id_componencheck3 }}</td>
                                            <td>{{ $filltertables->id_componencheck4 }}</td>
                                            <td>{{ $filltertables->id_componencheck5 }}</td>
                                            <td>{{ $filltertables->id_componencheck6 }}</td>
                                            <td>{{ $filltertables->id_componencheck7 }}</td>
                                            <td>{{ $filltertables->id_componencheck8 }}</td>
                                            <td>{{ $filltertables->id_componencheck9 }}</td>
                                            <td>{{ $filltertables->id_componencheck10 }}</td>
                                            <td>{{ $filltertables->id_componencheck11 }}</td>
                                            <td>{{ $filltertables->id_componencheck12 }}</td>
                                            <td>{{ $filltertables->id_parameter1 }}</td>
                                            <td>{{ $filltertables->id_parameter2 }}</td>
                                            <td>{{ $filltertables->id_parameter3 }}</td>
                                            <td>{{ $filltertables->id_parameter4 }}</td>
                                            <td>{{ $filltertables->id_parameter5 }}</td>
                                            <td>{{ $filltertables->id_parameter6 }}</td>
                                            <td>{{ $filltertables->id_parameter7 }}</td>
                                            <td>{{ $filltertables->id_parameter8 }}</td>
                                            <td>{{ $filltertables->id_parameter9 }}</td>
                                            <td>{{ $filltertables->id_parameter10 }}</td>
                                            <td>{{ $filltertables->id_parameter11 }}</td>
                                            <td>{{ $filltertables->id_parameter12 }}</td>
                                            <td>{{ $filltertables->id_metodecheck1 }}</td>
                                            <td>{{ $filltertables->id_metodecheck2 }}</td>
                                            <td>{{ $filltertables->id_metodecheck3 }}</td>
                                            <td>{{ $filltertables->id_metodecheck4 }}</td>
                                            <td>{{ $filltertables->id_metodecheck5 }}</td>
                                            <td>{{ $filltertables->id_metodecheck6 }}</td>
                                            <td>{{ $filltertables->id_metodecheck7 }}</td>
                                            <td>{{ $filltertables->id_metodecheck8 }}</td>
                                            <td>{{ $filltertables->id_metodecheck9 }}</td>
                                            <td>{{ $filltertables->id_metodecheck10 }}</td>
                                            <td>{{ $filltertables->id_metodecheck11 }}</td>
                                            <td>{{ $filltertables->id_metodecheck12 }}</td>
                                            <td>
                                                <a class="button-table-custom-action dropdown" id="navbarDropdownMenuLink2"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                                        style="height: 20px"
                                                        src="{{ asset('assets/icons/list_table.png') }}"></a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                    <a class="button-table-custom-view" href="#"><img style="height: 20px"
                                                            src="assets/icons/eye_white.png"></a>
                                                    <a class="button-table-custom-edit"
                                                        href="{{ route('editmachineresult', $machine->id) }}"><img
                                                            style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}"></a>
                                                    <a class="button-table-custom-delete"
                                                        href="{{ route('deletemachineresult', $machine->id) }}"
                                                        onclick="return confirm('Yakin Hapus?')"><img style="height: 20px"
                                                            src="{{ asset('assets/icons/trash_white.png') }}"></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>Tidak ada</td>
                                        <td>Tidak ada</td>
                                        <td>Tidak ada</td>
                                        <td>Tidak ada</td>
                                    </tr>
                                @endisset

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
