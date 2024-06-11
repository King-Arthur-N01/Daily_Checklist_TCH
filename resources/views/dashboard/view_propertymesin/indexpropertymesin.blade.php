@extends('layouts.master')
@section('title', 'Tambah Property Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Bordered Table</h1>
            <div class="col-sm-12 col-md-12">
                <div class="dt-buttons">
                    <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#RegisterModal" tabindex="0">+ Tambah User</a>
                </div>
            </div>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="propertyTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Standart Mesin</th>
                                    <th>Jumlah Component Yang Dicheck</th>
                                    <th>Jumlah Standart/Parameter Mesin</th>
                                    <th>Jumlah Metode Pengecekan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($joinproperty as $propertyget)
                                    <tr>
                                        <td>{{ $propertyget->property_id }}</td>
                                        <td>{{ $propertyget->name_property }}</td>
                                        <td>{{ $propertyget->name_componencheck }}</td>
                                        <td>{{ $propertyget->name_parameter }}</td>
                                        <td>{{ $propertyget->name_metodecheck }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="{{ $propertyget->id }}" data-target="#EditModal">Edit</a>
                                            <a class="btn btn-danger btn-sm" style="color:white" href="#" onclick="return confirm('Yakin Hapus?')">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end basic table  -->
        <!-- ============================================================== -->
    </div>
@endsection

@push('style')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $(".btn-Id").on('click', function() {
                console.log($(this).attr("data-id"));
                $("#editButton").attr("value", $(this).attr("data-id"));
            });
            $('#registerButton').on('click', function(e) {
                e.preventDefault();
                var formData = {
                    '_token': '{{ csrf_token() }}',
                    'name': $('input[name="name"]').val(),
                    'nik': $('input[name="nik"]').val(),
                    'department': $('input[name="department"]').val(),
                    'status': $('select[name="status"]').val()
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pushregisteruser') }}',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('USER was successfully added.'); // Alert success message
                        } else {
                            alert('Error: USER failed to register.'); // Alert failure message
                        }
                        $('#RegisterModal').modal('hide'); // Hide modal on success
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            alert(xhr.responseJSON.error); // Alert error message
                        } else {
                            alert('An error occurred while registering the USER.'); // Alert error message
                            console.error('Error register USER: ' + error);
                        }
                        $('#RegisterModal').modal('hide'); // Hide modal on error
                    }
                }).always(function() {
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                });
            });
            $('#editButton').on('click', function() {
                var formData = $('#editform').serialize();
                var userId = $(this).val();
                formData += '&_token={{ csrf_token() }}'; // Add CSRF token
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('pushedituser', ':id') }}'.replace(':id', userId),
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('USER was successfully update.'); // Alert success message
                        } else {
                            alert('Error: USER failed to update.'); // Alert failure message
                        }
                        $('#EditModal').modal('hide'); // Hide modal on success
                    },
                    error: function(xhr, status, error) {
                        alert('This USER already exists!'); // Alert error message
                        console.error('Error update USER: ' + error);
                        $('#EditModal').modal('hide'); // Hide modal on error
                    }
                }).always(function() {
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                });
            });
        });
    </script>
@endpush
