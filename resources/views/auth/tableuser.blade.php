@extends('layouts.master')
@section('title', 'Manage User')

@section('content')
    {{-- this code for view --}}
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
                        <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Departement</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $userget)
                                    <tr>
                                        <td>{{ $userget->id }}</td>
                                        <td>{{ $userget->name }}</td>
                                        <td>{{ $userget->nik }}</td>
                                        <td>{{ $userget->department }}</td>
                                        <td>
                                            @if ($userget->status)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                        <td>{{ $userget->created_at }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="{{ $userget->id }}" data-target="#EditModal">Edit</a>
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

    <!-- Register Modal -->
    <div class="modal fade" id="RegisterModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register User</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="registerform" method="post">
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama User</label>
                                    <div>
                                        <input class="form-control form-control-user" type="text" name="name" placeholder="Username">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">NIK</label>
                                    <div>
                                        <input class="form-control form-control-user" type="text" name="nik" data-parsley-maxlength="5" placeholder="NIK">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Status</label>
                                    <div>
                                        <select selected="selected" class="form-control" name="status" id="category-input">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Department</label>
                                    <div>
                                        <input class="form-control form-control-user" type="text" name="department" placeholder="Department">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-space btn-primary" data-toggle="modal" id="registerButton" onclick="return confirm('Apakah sudah yakin mengisi data dengan benar?')">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Register Modal-->

    <!-- Edit Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <div id="modaledit-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-space btn-primary" data-toggle="modal" id="editButton" onclick="return confirm('Apakah sudah yakin mengisi data dengan benar?')">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal-->
@endsection

@push('style')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $('#EditModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('fetchedituser', ':id') }}'.replace(':id', id),
                    success: function(data) {
                        var html = '';
                        html += '<form id="editform" method="post">';
                        html += '<div class="row" align-items="center">';
                        html += '<div class="col-xl-6">';
                        html += '<div class="form-group">';
                        html += '<label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama User</label>';
                        html += '<div>';
                        html += '<input class="form-control form-control-user" type="text" name="name" placeholder="Username" value="'+ data.getusers.name +'">';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="col-xl-6">';
                        html += '<div class="form-group">';
                        html += '<label class="col-form-label text-sm-right" style="margin-left: 4px;">NIK</label>';
                        html += '<div>';
                        html += '<input class="form-control form-control-user" type="text" name="nik" data-parsley-maxlength="5" placeholder="NIK" value="'+ data.getusers.nik +'" readonly>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="row" align-items="center">';
                        html += '<div class="col-xl-6">';
                        html += '<div class="form-group">';
                        html += '<label class="col-form-label text-sm-right" style="margin-left: 4px;">Status</label>';
                        html += '<div>';
                        html += '<select selected="selected" class="form-control" name="status" id="category-input" value="'+ data.getusers.status +'">';
                        html += '<option value="1">Aktif</option>';
                        html += '<option value="0">Nonaktif</option>';
                        html += '</select>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="col-xl-6">';
                        html += '<div class="form-group">';
                        html += '<label class="col-form-label text-sm-right" style="margin-left: 4px;">Department</label>';
                        html += '<div>';
                        html += '<input class="form-control form-control-user" type="text" name="department" placeholder="Department" value="'+ data.getusers.department +'">';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="row" align-items="center">';
                        html += '<div class="col-xl-6">';
                        html += '<div class="form-group">';
                        html += '<div>';
                        html += '<label class="col-form-label text-sm-right" style="margin-left: 4px;">Password</label>';
                        html += '<div class="form-group" style="margin: 0px;">';
                        html += '<input class="form-control" type="password" required placeholder="Password Min:6 digits" id="password" value="'+ data.getusers.password +'" readonly>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="col-xl-6">';
                        html += '<div class="form-group">';
                        html += '<div>';
                        html += '<label class="col-form-label text-sm-right" style="margin-left: 4px;">Confirm Password</label>';
                        html += '<div class="form-group" style="margin: 0px;">';
                        html += '<input class="form-control" type="password" placeholder="Confirm Password" id="confirm_password" value="'+ data.getusers.password +'" readonly>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</form>';
                        $('#modaledit-data').html(html);
                    }
                });
            });
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
