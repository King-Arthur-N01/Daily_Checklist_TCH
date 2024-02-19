@extends('layouts.master')
@section('title','Table Stock')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="az-content-label mg-b-5">Bordered Table</div>
                <p class="mg-b-20">Add borders on all sides of the table and cells.</p>
                    <div class="col-sm-12 col-md-12">
                        @can('view posts', Role::class)
                        <div class="dt-buttons">
                            <a type="button" class="btn btn-block btn-primary" href="{{route('additem')}}" tabindex="0" aria-controls="example">+ Tambah Barang</a>
                        </div>
                        @endcan
                    </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Min Quantity</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockitems as $stockitem)
                                <tr>
                                    <td>{{$stockitem->product_name}}</td>
                                    <td>{{$stockitem->product_code}}</td>
                                    <td>{{$stockitem->product_type}}</td>
                                    <td>{{$stockitem->product_brand}}</td>
                                    <td>{{$stockitem->quantity}}</td>
                                    <td>{{$stockitem->minimum_quantity}}</td>
                                    <td>{{$stockitem->product_note}}</td>
                                    <td>{{$stockitem->category}}</td>
                                    <td>
                                        <a class="button-table-custom-action nav-link" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{asset('assets/icons/list.png')}}"></a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                            <a class="button-table-custom-view" href="#"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                            <a class="button-table-custom-edit" href="{{route('edititem',$stockitem->id)}}"><img style="height: 20px" src="assets/icons/edit_white.png"></a>
                                            <a class="button-table-custom-delete" href="{{route('deleteitem',$stockitem->id)}}" onclick="return confirm('Yakin Hapus?')"><img style="height: 20px" src="assets/icons/trash_white.png"></a>
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
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
    </div>
@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/select.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css')}}">
@endpush

@push('script')


@endpush
