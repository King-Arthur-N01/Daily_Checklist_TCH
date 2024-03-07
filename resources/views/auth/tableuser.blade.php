@extends('layouts.master')
@section('title','Manage User')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- basic table  -->
        <!-- ============================================================== -->
        <div class="custom-card-table col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-top">
                <div class="az-content-label mg-b-5">Bordered Table</div>
                <p class="mg-b-20">Add borders on all sides of the table and cells.</p>
                <div class="col-sm-12 col-md-12">
                    <div class="dt-buttons">
                        <a type="button" class="btn btn-block btn-primary" href="{{ route('registeruser') }}" tabindex="0" aria-controls="example">+ Tambah User</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered second" id="table-user">
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
                                    <td>{{$userget->id}}</td>
                                    <td>{{$userget->name}}</td>
                                    <td>{{$userget->nik}}</td>
                                    <td>{{$userget->department}}</td>
                                    <td>
                                        @if ($userget->status)
                                          Active
                                        @else
                                          Inactive
                                        @endif
                                    </td>
                                    <td>{{$userget->created_at}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" style="color:white" href="{{route('edituser',$userget->id)}}">Edit</a>
                                        <a class="btn btn-danger btn-sm" style="color:white" href="{{route('deleteaccount',$userget->id)}}" onclick="return confirm('Yakin Hapus?')">Delete</a>
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
@endpush
