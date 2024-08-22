@extends('layouts.master')
@section('title', 'Add schedule mesin')

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
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div class="row" align-items="center">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Schedule</label>
                                <div>
                                    <input class="form-control" name="schedule_name" type="text" placeholder="Nama Jadwal">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label text-sm-right" style="margin-left: 4px;">Waktu Schedule</label>
                                <select class="form-control" id="filterByProperty">
                                    <option selected="selected">Select :</option>
                                    <option value="1">1/Bulan</option>
                                    <option value="3">3/Bulan</option>
                                    <option value="6">6/Bulan</option>
                                    <option value="12">12/Bulan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-history">
                        <div class="col-4">
                            <p class="mg-b-10">Filter Nomor Mesin</p>
                            <input class="form-control" id="filterByNumber">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Filter Nama Mesin </p>
                            <input class="form-control" id="filterByName">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Filter Hari/Bulan/Tahun </p>
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <th>NO.</th>
                                <th>NO.INVENT</th>
                                <th>NO MESIN</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND/MERK</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach($machines as $key => $getmachine)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $getmachine->invent_number }}</td>
                                        <td>{{ $getmachine->machine_number }}</td>
                                        <td>{{ $getmachine->machine_name }}</td>
                                        <td>{{ $getmachine->machine_type }}</td>
                                        <td>{{ $getmachine->machine_brand }}</td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gridCheck1">
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

    <!-- Alert Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <span id="warningText" class="modal-alert"></span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Warning Modal -->
@endsection

@push('style')

@endpush

@push('script')
<script>
    $(document).ready(function() {
        $('#scheduleTables').DataTable();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterByName = document.getElementById('filterByName');
        const filterByNumber = document.getElementById('filterByNumber');
        const filterByProperty = document.getElementById('filterByProperty');
        const table = document.getElementById('scheduleTables');
        const rows = table.getElementsByTagName('tr');

        // Function to filter table
        function filterTable() {
            const nameValue = filterByName.value.toLowerCase();
            const numberValue = filterByNumber.value.toLowerCase();
            const propertyValue = filterByProperty.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByTagName('td')[1];
                const numberCell = rows[i].getElementsByTagName('td')[0];
                const propertyCell = rows[i].getElementsByTagName('td')[5];

                const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                const propertyText = propertyCell ? propertyCell.textContent.toLowerCase() : '';

                // Check if row matches the filter criteria
                if (nameText.includes(nameValue) &&
                    numberText.includes(numberValue) &&
                    (propertyValue === "select :" || propertyText.includes(propertyValue))) {
                    rows[i].style.display = '';  // Show the row
                } else {
                    rows[i].style.display = 'none';  // Hide the row
                }
            }
        }

        // Attach event listeners
        filterByName.addEventListener('input', filterTable);
        filterByNumber.addEventListener('input', filterTable);
        filterByProperty.addEventListener('change', filterTable);
    });
</script>
@endpush
