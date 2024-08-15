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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="userTable" width="100%">
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
                <div class="modal-header" id="modal_title_register">
                </div>
                <div class="modal-body" id="modal_data_register">
                </div>
                <div class="modal-footer" id="modal_button_register">
                </div>
            </div>
        </div>
    </div>
    <!-- End Register Modal-->

    <!-- Edit Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_edit">
                </div>
                <div class="modal-body" id="modal_data_edit">
                </div>
                <div class="modal-footer" id="modal_button_edit">
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal-->

    <!-- Alert Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <span id="successText" class="modal-alert"></span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Success Modal -->

    <!-- Alert Danger Modal -->
    <div class="modal fade" id="failedModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <span id="failedText" class="modal-alert"></span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Danger Modal -->
@endsection

@push('style')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            // Set automatic soft refresh table
            setInterval(function() {
                overlay.addClass('is-active');
                table.ajax.reload(null, false);
                table.on('draw.dt', function() {
                    overlay.removeClass('is-active');
                });
            }, 30000); // 30000 milidetik = 30 second

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#userTable').DataTable({
                ajax: {
                    url: '{{ route("refreshuser") }}',
                    dataSrc: function(data) {
                        return data.refreshusers.map(function(refreshusers) {
                            return {
                                id: refreshusers.id,
                                name: refreshusers.name,
                                nik: refreshusers.nik,
                                department: refreshusers.department,
                                status: refreshusers.status,
                                created_at: new Date(refreshusers.created_at).toLocaleString('en-US', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                }),
                                actions: `
                                    <button class="btn btn-primary btn-sm" style="color:white" data-toggle="modal" data-id="${refreshusers.id}" data-target="#EditModal">Edit</button>
                                    <button class="btn btn-danger btn-sm deleteButton" style="color:white" data-id="${refreshusers.id}">Delete</button>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'nik' },
                    { data: 'department' },
                    {data: 'status',
                        render: function(data, type, row) {
                            if (data == 0) {
                                return 'Inactive';
                            } else if (data == 1) {
                                return 'Active';
                            }
                        }
                    },
                    { data: 'created_at' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            // kode $ajax untuk menampilkan menu register
            $('#RegisterModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readuser", ':id') }}'.replace(':id', userId),
                    success: function(data) {
                        const header_modal = `
                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>                    <h5 class="modal-title">Register User</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
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
                                                <input class="form-control form-control-user" type="text" name="nik" placeholder="NIK">
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
                                                    <input class="form-control" type="password" name="password" required placeholder="Enter Password" id="password">
                                                </div>
                                            </div>
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
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-space btn-primary" data-toggle="modal" id="registerButton">Submit</button>
                        `;
                        $('#modal_title_register').html(header_modal);
                        $('#modal_data_register').html(data_modal);
                        $('#modal_button_register').html(button_modal);

                        // kode $ajax untuk mengirim request register user baru
                        $('#registerButton').on('click', function(e) {
                            e.preventDefault();
                            var formData = {
                                'name': $('input[name="name"]').val(),
                                'nik': $('input[name="nik"]').val(),
                                'status': $('select[name="status"]').val(),
                                'department': $('input[name="department"]').val(),
                                'password': $('input[name="password"]').val(),
                                'password_confirmation': $('input[name="password_confirmation"]').val()
                            };
                            if (confirm('Apakah sudah yakin mengisi data dengan benar?')) {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route("registeruser") }}',
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'name': formData.name,
                                        'nik': formData.nik,
                                        'status': formData.status,
                                        'department': formData.department,
                                        'password': formData.password,
                                        'password_confirmation': formData.password_confirmation
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            const successMessage = response.success;
                                            $('#successText').text(successMessage);
                                            $('#successModal').modal('show');
                                            overlay.toggleClass('is-active');
                                        }
                                        setTimeout(function() {
                                                $('#successModal').modal('hide');
                                                $('#RegisterModal').modal('hide');
                                                overlay.removeClass('is-active');
                                        }, 2000);
                                    },
                                    error: function(xhr, status, error) {
                                        if (xhr.responseText) {
                                            const warningMessage = JSON.parse(xhr.responseText).error;
                                            $('#failedText').text(warningMessage);
                                            $('#failedModal').modal('show');
                                        }
                                        setTimeout(function() {
                                            $('#failedModal').modal('hide');
                                            $('#RegisterModal').modal('hide');
                                        }, 2000);
                                    }
                                }).always(function() {
                                    table.ajax.reload(null, false);
                                });
                            } else {
                                // User cancelled the deletion, do nothing
                            }
                        });
                    }
                });
            });

            // kode $ajax untuk menampilkan menu edit
            $('#EditModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("readuser", ':id') }}'.replace(':id', userId),
                    success: function(data) {
                        const header_modal = `
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <form id="editForm" method="post">
                                <div class="row align-items-center">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama User</label>
                                            <input class="form-control form-control-user" type="text" name="name" placeholder="Username" value="${data.getusers.name}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">NIK</label>
                                            <input class="form-control form-control-user" type="text" name="nik" placeholder="NIK" value="${data.getusers.nik}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Status</label>
                                            <select class="form-control" name="status" id="category-input">
                                                <option value="1" ${data.getusers.status == 1 ? 'selected' : ''}>Aktif</option>
                                                <option value="0" ${data.getusers.status == 0 ? 'selected' : ''}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Department</label>
                                            <input class="form-control form-control-user" type="text" name="department" placeholder="Department" value="${data.getusers.department}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Password</label>
                                            <input class="form-control" type="password" required placeholder="Password Min:6 digits" id="password" value="${data.getusers.password}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-sm-right" style="margin-left: 4px;">Confirm Password</label>
                                            <input class="form-control" type="password" placeholder="Confirm Password" id="confirm_password" value="${data.getusers.password}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-space btn-primary" data-toggle="modal" id="editButton" onclick="return confirm('Apakah sudah yakin mengisi data dengan benar?')">Submit</button>
                        `;
                        $('#modal_title_edit').html(header_modal);
                        $('#modal_data_edit').html(data_modal);
                        $('#modal_button_edit').html(button_modal);

                        // kode $ajax untuk mengirim request edit user
                        $('#editButton').on('click', function() {
                            var formData = $('#editForm').serialize();
                            formData +='&_token={{ csrf_token() }}'; // Add CSRF token
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("updateuser", ':id') }}'.replace(':id', userId),
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                        overlay.toggleClass('is-active');
                                    }
                                    setTimeout(function() {
                                            $('#successModal').modal('hide');
                                            $('#EditModal').modal('hide');
                                            overlay.removeClass('is-active');
                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                        const warningMessage = xhr.responseText;
                                        $('#failedText').text(warningMessage);
                                        $('#failedModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#failedModal').modal('hide');
                                        $('#EditModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        });
                    }
                });
            });



            // kode $ajax untuk menghapus user
            $('#userTable').on('click', '.deleteButton', function(e) {
                e.preventDefault();
                const button = $(this);
                const userId = button.data('id');
                if (confirm("Apakah yakin menghapus user ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('removeuser', ':id') }}".replace(':id', userId),
                        data: {
                            '_token': '{{ csrf_token() }}'
                        }
                    }).done(function(response) {
                        if (response.success) {
                            alert(
                            'USER was successfully delete!.'); // Alert success message
                        } else {
                            alert('Error: USER failed to delete.'); // Alert failure message
                        }
                        $('#ExtralargeModal').modal('hide');
                    }).fail(function(xhr, status, error) {
                        alert('This USER has been deleted by someone!'); // Alert error message
                        $('#EditModal').modal('hide'); // Hide modal on error
                    }).always(function() {
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    });
                } else {
                    // User cancelled the deletion, do nothing
                }
            });
        });
    </script>
@endpush
