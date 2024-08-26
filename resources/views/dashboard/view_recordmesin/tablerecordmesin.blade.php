@extends('layouts.master')
@section('title', 'Table Preventive Mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Input Checklist Mesin</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="col-sm-12 col-md-12">
                        <div>
                            <form  method="post">
                                @csrf
                                <div class="table-filter">
                                    <div class="col-4">
                                        <p class="mg-b-10">Nama Mesin</p>
                                        <select class="form-control select2" name="" id="filterByName">
                                            <option selected="selected" value="">Select :</option>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <p class="mg-b-10">Input Nomor Mesin </p>
                                        <select class="form-control select2" name="" id="filterByNumber">
                                            <option selected="selected" value="">Select :</option>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <p class="mg-b-10">Status Mesin</p>
                                        <select class="form-control" name="sample" id="filterByStatus">
                                            <option selected="selected">Select :</option>
                                            <option><i class="fas fa-check-circle"></i>Sudah Dipreventive</option>
                                            <option>Belum Dipreventive</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="successMessages">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div id="errorMessages">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="recordTables" width="100%">
                            <thead>
                                <th></th>
                                <th>NO MESIN</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                <th>STATUS</th>
                            </thead>
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'
            });

            // Set automatic soft refresh table
            setInterval(function() {
                overlay.addClass('is-active');
                table.ajax.reload(null, false);
                table.on('draw.dt', function() {
                    overlay.removeClass('is-active');
                });
            }, 30000); // 30000 milidetik = 30 second

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            let table = $('#recordTables').DataTable({
                ajax: {
                    url: '{{ route("refreshrecord") }}',
                    dataSrc: function(data) {
                        return data.map(function(refreshmachine) {
                            return {
                                id: refreshmachine.id,
                                machine_number: refreshmachine.machine_number,
                                machine_name: refreshmachine.machine_name,
                                machine_type: refreshmachine.machine_type,
                                machine_brand: refreshmachine.machine_brand,
                                status: refreshmachine.total_days && refreshmachine.total_hours ? 'Terakhir preventive ' + refreshmachine.total_days + ' hari ' + refreshmachine.total_hours + ' jam yang lalu' : 'Belum pernah dilakukan preventive',
                            };
                        });
                    }
                },
                columns: [
                    {
                        "value": 'id',
                        "defaultContent": `<i class="fas fa-angle-right toggle-icon"></i>`,
                        "orderable": false,
                        "className": 'table-accordion',
                    },
                    { data: 'machine_number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_brand' },
                    { data: 'status' },
                ]
            });

            $('#recordTables tbody').on('click', 'td.table-accordion', function () {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                let rowId = row.data().id;
                const contentRow = this.nextElementSibling;
                const toggleIcon = this.querySelector('.toggle-icon');

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    toggleIcon.classList.remove('active');
                } else {
                    $.ajax({
                        type: 'GET',
                        url: '{{route("refreshdetailrecord", ':id')}}'.replace(':id', rowId),
                        success: function(data) {
                            let detailTable = '<table class="table">' +
                                                '<tbody>';
                            $.each(data.machine, function(index, machine) {
                                detailTable += '<tr>' +
                                            '<td>' + data.machine.machine_name + '</td>' +
                                            '<td>' + data.machine.schdule_1_month + '</td>' +
                                            '<td>' + data.machine.schdule_3_month + '</td>' +
                                            '<td>' + data.machine.schdule_6_month + '</td>' +
                                            '<td>' + data.machine.schdule_12_month + '</td>' +
                                            '<td><button class="btn btn-primary">View</button></td>' +
                                            '</tr>';
                            });

                            detailTable += '</tbody></table>';

                            row.child(detailTable).show();
                            tr.addClass('shown');
                            toggleIcon.classList.add('active');
                        }
                    });
                }
            });
        });
    </script>
@endpush
