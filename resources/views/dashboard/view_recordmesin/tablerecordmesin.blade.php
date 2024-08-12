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
                        <table class="table" id="recordTables" width="100%">
                            <thead>
                                <th>NO MESIN</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND</th>
                                <th>JADWAL PREVENTIVE MESIN</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
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
            const table = $('#recordTables').DataTable({
                ajax: {
                    url: '{{ route("refreshrecord") }}',
                    dataSrc: function(data) {
                        return data.map(function(refreshmachine) {
                            // let refreshschedule = data.refreshschedule.find(function(schedule) {
                            //     return refreshmachine.id === schedule.id_machine2;
                            // });
                            return {
                                machine_number: refreshmachine.machine_number,
                                machine_name: refreshmachine.machine_name,
                                machine_type: refreshmachine.machine_type,
                                machine_brand: refreshmachine.machine_brand,
                                machine_schedule: refreshmachine.getschedule !== null ? 'Setiap ' + refreshmachine.getschedule + ' Bulan Sekali' : 'Waktu preventive belum diatur',
                                status: refreshmachine.total_days && refreshmachine.total_hours ? 'Terakhir preventive ' + refreshmachine.total_days + ' hari ' + refreshmachine.total_hours + ' jam yang lalu' : 'Belum pernah dilakukan preventive',
                                actions: refreshmachine.id
                            };
                        });
                    }
                },
                columns: [
                    { data: 'machine_number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_brand' },
                    { data: 'machine_schedule' },
                    { data: 'status' },
                    {data: 'actions',
                    render: function(data, type, row) {
                        let url = '{{ route("formpreventive", ":id") }}';
                        url = url.replace(':id', data);
                        return `
                        <div class="dynamic-button-group">
                            <a class="btn btn-primary btn-sm" style="color:white" href="${url}"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}"></a>
                        </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
