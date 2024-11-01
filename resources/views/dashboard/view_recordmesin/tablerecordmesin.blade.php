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
                        <div class="table-filter">
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <input class="form-control" id="filterByNumber">
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Nama Mesin</p>
                                <input class="form-control" id="filterByName">
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
                    </div>
                    {{-- <div id="successMessages">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div id="errorMessages">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered" id="recordTables" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>NAMA SCHEDULE</th>
                                    <th>JUMLAH MESIN</th>
                                    <th>STATUS</th>
                                </tr>
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

    @if (session('success'))
    <!-- Alert Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <span id="successText" class="modal-alert">Checklist added successfully.</span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Success Modal -->

    @elseif(session('failed'))
    <!-- Alert Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <span id="warningText" class="modal-alert">You can submit the form again after 24 hours.</span>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alert Warning Modal -->
    @endif
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
            }, 60000); // 60000 milidetik = 60 second

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            let table = $('#recordTables').DataTable({
                ajax: {
                    url: '{{ route("refreshrecord") }}',
                    dataSrc: function(data) {
                        return data.refreshrecords.map(function(refreshrecords) {
                            return {
                                id: refreshrecords.id,
                                name_schedule: refreshrecords.name_schedule_month,
                                total_machine: refreshrecords.machine_count,
                                schedule_status: refreshrecords.schedule_status,
                            };
                        });
                    }
                },
                columns: [
                    {
                        "data": 'id',
                        "render": function(data, type, row) {
                            return `<button value="${data}"><i class="fas fa-angle-right toggle-icon"></i></button>`;
                        },
                        "className": 'table-accordion',
                        "orderable": false,
                    },
                    { data: 'name_schedule' },
                    { data: 'total_machine' },
                    { data: 'schedule_status', render: function(data, type, row) {
                        if (data === 0) {
                            return '<span class="badge badge-danger">UNFINISHED</span>';
                        } else if (data === 1) {
                            return '<span class="badge badge-success">COMPLETED</span>';
                        }
                    }}
                ]
            });

            $('#recordTables tbody').on('click', 'td.table-accordion', function () {
                let tr = $(this).closest('tr');
                let row = table.row(tr);

                // Ensure row.data() is valid
                if (!row.data()) {
                    console.error("Row data is not available.");
                    return;
                }

                let rowId = row.data().id;
                const toggleIcon = this.querySelector('.toggle-icon');

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    toggleIcon.classList.remove('active');
                } else {
                    $.ajax({
                        type: 'GET',
                        url: '{{route("refreshdetailrecord", ":id")}}'.replace(':id', rowId),
                        success: function(data) {
                            let detailTable = `
                                <table class="table-child" id="recordTablesChild">
                                    <thead>
                                        <tr>
                                            <th>INVENT NUMBER</th>
                                            <th>NOMOR MESIN</th>
                                            <th>NAMA MESIN</th>
                                            <th>BRAND MESIN</th>
                                            <th>TYPE MESIN</th>
                                            <th>BATAS WAKTU PREVENTIVE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;
                            let currentTime = new Date();
                            data.refreshdetailrecord.forEach(recordmachine => {
                                let scheduleEnd = new Date(recordmachine.schedule_end);
                                let isPast = scheduleEnd && scheduleEnd < currentTime;
                                detailTable += `
                                    <tr class="${(isPast ? 'elapsed-time' : '')}">
                                        <td>${recordmachine.invent_number}</td>
                                        <td>${recordmachine.machine_number}</td>
                                        <td>${recordmachine.machine_name}</td>
                                        <td>${recordmachine.machine_brand}</td>
                                        <td>${recordmachine.machine_type}</td>
                                        <td>${(scheduleEnd ? scheduleEnd.toLocaleString('en-ID', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: '2-digit',
                                        }) : 'N/A')}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm btn-Id" href="${'{{ route("formpreventive", ":id") }}'.replace(':id', recordmachine.schedule_id)}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                            });
                            detailTable += `
                                    </tbody>
                                </table>
                            `;

                            row.child(detailTable).show();
                            tr.addClass('shown');
                            toggleIcon.classList.add('active');
                        },
                        error: function(xhr, error) {
                            if (xhr.responseText) {
                                const warningMessage = JSON.parse(xhr.responseText).error;
                                $('#warningText').text(warningMessage);
                                $('#warningModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#warningModal').modal('hide');
                                $('#correctModal').modal('hide');
                            }, 2000);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterByNumber = document.getElementById('filterByNumber');
            const filterByName = document.getElementById('filterByName');
            const filterByStatus = document.getElementById('filterByStatus');
            const table = document.getElementById('recordTables');
            const rows = table.getElementsByTagName('tr');

            // Function to filter table
            function filterTable() {
                const nameValue = filterByName.value.toLowerCase();
                const numberValue = filterByNumber.value.toLowerCase();
                const statusValue = filterByStatus.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const numberCell = rows[i].getElementsByTagName('td')[1];
                    const nameCell = rows[i].getElementsByTagName('td')[2];
                    const statusCell = rows[i].getElementsByTagName('td')[5];

                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                    const propertyText = statusCell ? statusCell.textContent.toLowerCase() : '';

                    // Check if row matches the filter criteria
                    if (nameText.includes(nameValue) &&
                        numberText.includes(numberValue) &&
                        (statusValue === "select :" || propertyText.includes(statusValue))) {
                        rows[i].style.display = '';  // Show the row
                    } else {
                        rows[i].style.display = 'none';  // Hide the row
                    }
                }
            }

            // Attach event listeners
            filterByNumber.addEventListener('input', filterTable);
            filterByName.addEventListener('input', filterTable);
            filterByStatus.addEventListener('change', filterTable);
        });
    </script>
@endpush
