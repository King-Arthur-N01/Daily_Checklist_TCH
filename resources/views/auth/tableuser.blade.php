@extends('layouts.master')
@section('title', 'Manage User')

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
                    <a type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#ExtralargeModal" tabindex="0">+ Tambah User</a>
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
                                            <a class="btn btn-primary btn-sm" style="color:white" href="{{ route('edituser', $userget->id) }}">Edit</a>
                                            <a class="btn btn-danger btn-sm" style="color:white" href="{{ route('deleteaccount', $userget->id) }}" onclick="return confirm('Yakin Hapus?')">Delete</a>
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
    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register User</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="registerform" method="post">
                        @csrf
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
                    <button type="submit" class="btn btn-space btn-primary" id="submitButton" onclick="return confirm('Apakah sudah yakin mengisi data dengan benar?')">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Register Modal-->
    
@endsection

@push('style')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $('#submitButton').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission
                var formData = $('#registerform').serialize(); // Serialize the form data
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
                        $('#ExtralargeModal').modal('hide'); // Hide modal on success
                    },
                    error: function(xhr, status, error) {
                        alert('This USER already exists!'); // Alert error message
                        console.error('Error register user: ' + error);
                        $('#ExtralargeModal').modal('hide'); // Hide modal on error
                    }
                }).always(function() {
                    location.reload(); // Refresh the page whether success or error
                });
            });
        });
    </script>
@endpush