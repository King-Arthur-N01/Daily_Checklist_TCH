@extends('layouts.master')
@section('title', 'Schedule mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Schedule</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="col-4">
                                <p class="mg-b-10">Nama Mesin</p>
                                <input class="form-control" name="" id="filterByName">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Nomor Mesin </p>
                                <input class="form-control" name="" id="filterById">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Standarisasi Mesin</p>
                                <select class="form-control select2" name="sample" id="filterByProperty">
                                    <option selected="selected">Select :</option>
                                    <option><i class="fas fa-check-circle"></i>Sudah Dipreventive</option>
                                    <option>Belum Dipreventive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <th>NO. INVENT</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND/MERK</th>
                                <th>JADWAL PREVENTIVE</th>
                                <th>ACTION</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card-calendar">
                    <div id="calendar" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
    </div>
@endsection

@push('style')
{{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
@endpush

@push('script')
<script src="{{ mix('js/app.js') }}" defer></script>

<script>
    // sett automatic soft refresh table
    setInterval(function() {
        table.ajax.reload(null, false);
    }, 30000); // 30000 milidetik = 30 second

    // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
    const table = $('#scheduleTables').DataTable({
        ajax: {
            url: '{{ route("refreshcalendar") }}',
            dataSrc: function(data) {
                // Sesuaikan data yang akan digunakan oleh DataTables
                return data.refreshmachine.map(function(refreshmachine) {
                    let refreshschedule = data.refreshschedule.find(function(schedule) {
                        return schedule.id === refreshmachine.id;
                    });
                    return {
                        invent_number: refreshmachine.invent_number,
                        machine_name: refreshmachine.machine_name,
                        machine_type: refreshmachine.machine_type,
                        machine_brand: refreshmachine.machine_brand,
                        schedule_time: refreshschedule ? refreshschedule.schedule_time : 'Belum ada jadwal preventive',
                        actions: `
                            <div class="dynamic-button-group">
                                <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img style="height: 20px" src="{{ asset('assets/icons/list_table.png') }}"></a>
                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item-custom-detail" id="viewButton" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#viewModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}">&nbsp;Detail</a>
                                    <a class="dropdown-item-custom-edit" id="editButton" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#editModal"><img style="height: 20px" src="{{ asset('assets/icons/edit_white_table.png') }}">&nbsp;Edit</a>
                                    <a class="dropdown-item-custom-delete" id="deleteButton" data-id="${refreshmachine.id}"><img style="height: 20px" src="{{ asset('assets/icons/trash_white.png') }}">&nbsp;Delete</a>
                                </div>
                            </div>
                        `
                    };
                });
            }
        },
        columns: [
            { data: 'invent_number' },
            { data: 'machine_name' },
            { data: 'machine_type' },
            { data: 'machine_brand' },
            { data: 'schedule_time' },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });
</script>
@endpush
