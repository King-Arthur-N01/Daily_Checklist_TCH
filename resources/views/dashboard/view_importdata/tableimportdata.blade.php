@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tambah Checklist Machine</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-filter" id="filterCard" style="display: none;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="dataTables_filter col-4" id="dataTable_filter">
                                <p class="mg-b-10">Input Nama Mesin</p>
                                <input class="form-control" type="search" aria-controls="dataTable"></input>
                                {{-- <select class="form-control select2" name="" id="category-input-machinename">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select> --}}
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
                    </form>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#largeModal"><i class="fas fa-clipboard-check"></i>&nbsp; Tambah Checksheet Mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                            <thead>
                                <th>Nama Mesin</th>
                                <th>Bagian Yang Dicheck</th>
                                <th>Standart/Parameter</th>
                                <th>Metode Pengecekan</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($machines as $machineget)
                                    <tr>
                                        <td>{{$machineget->machine_name}}</td>
                                        <td>{{$machineget->name_componencheck}}</td>
                                        <td>{{$machineget->name_parameter}}</td>
                                        <td>{{$machineget->name_metodecheck}}</td>
                                        <td>
                                            <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                                <a class="dropdown-item-custom-edit" style="text-align: center" href="#"><img style="height: 20px"src="{{ asset('assets/icons/edit_white_table.png') }}">Edit</a>
                                                <a class="dropdown-item-custom-delete" style="text-align: center" href="#" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">Delete</a>
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

    <!-- Large Modal -->
    <div class="modal fade" id="largeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                </div>
                <div class="modal-body">
                    <form id="formData">
                        <p>Format excel harus <mark>.xlsx</mark> selain itu tidak akan terbaca dan aturan urutan Kolom pada excel</p>
                        <p>Part Number<mark>|</mark>Line Name<mark>|</mark>Line Group<mark>|</mark>∑ Bersih<mark>|</mark>C.T (Detik)<mark>|</mark>Member Diluar Line</p>

                        <label for="importExle" class="table-buttons" id="customButton"><i class="fas fa-file-medical"></i>&nbsp; Select a file</label>
                        <input type="file" name="fileupload" id="importExle" hidden accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitButtonAjax">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Large Modal-->
@endsection

@push('style')
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/upload.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#submitButtonAjax').click(function() {
                var file = $('#importExle')[0].files[0];
                var formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    url: "{{ route('uploadfile') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.success);
                            $('#largeModal').modal('hide');
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(error) {
                        console.log(error.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        const filterButton = document.getElementById("filterButton");
        const filterCard = document.getElementById("filterCard");

        filterButton.addEventListener("click", () => {
        if (filterCard.style.display === "none") {
            filterCard.style.display = "block";
        } else {
            filterCard.style.display = "none";
        }
        });
    </script>
@endpush
