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
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Preventive Mesin</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="scheduleTables" width="100%">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>SCHEDULE PERTAHUN</th>
                                    <th>JUMLAH MESIN</th>
                                    <th>STATUS SCHEDULE</th>
                                    <th>TANGGAL PEMBUATAN</th>
                                    <th>ACTION</th>
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

    <!-- recognize Schedule Year -->
    <div class="modal fade show" id="recognizeModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_recognize">
                </div>
                <div class="modal-body" id="modal_data_recognize">
                </div>
                <div class="modal-footer" id="modal_button_recognize">
                </div>
            </div>
        </div>
    </div>
    <!-- End recognize Schedule Year -->

    <!-- View Schedule Month -->
    <div class="modal fade" id="viewScheduleMonth" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_month_view">
                </div>
                <div class="modal-body" id="modal_data_month_view">
                </div>
                <div class="modal-footer" id="modal_button_month_view">
                </div>
            </div>
        </div>
    </div>
    <!-- End View Schedule Month-->

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
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterange-picker/daterangepicker.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/formatdate.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script> --}}
    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
<script>
    $(document).ready(function() {
        // Set automatic soft refresh table
        setInterval(function() {
            overlay.addClass('is-active');
            table.ajax.reload(null, false);
            table.on('draw.dt', function() {
                overlay.removeClass('is-active');
            });
        }, 60000); // 60000 milidetik = 60 second


        // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
        const table = $('#scheduleTables').DataTable({
            ajax: {
                url: '{{ route("refreshyear") }}',
                dataSrc: function(data) {
                    return data.refreshschedule.map((refreshschedule, index) => {
                        return {
                            number: index + 1,
                            name_schedule_year: refreshschedule.name_schedule_year,
                            id_machine: JSON.parse(refreshschedule.machine_collection.split(',').length),
                            schedule_status: refreshschedule.schedule_recognize ? (refreshschedule.schedule_recognize > 0 ? 'Sudah Diketahui' : 'Belum Diketahui') : 'Belum Diketahui',
                            created_at: new Date(refreshschedule.created_at).toLocaleString('en-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            }),
                            actions: `
                                    <button type="button" class="btn btn-primary btn-sm btn-Id" style="color:white" data-toggle="modal" data-id="${refreshschedule.id}" data-target="#recognizeModal"><i class="bi bi-pencil-square"></i></button>
                                `
                        };
                    });
                }
            },
            columns: [
                { data: 'number' },
                { data: 'name_schedule_year' },
                { data: 'id_machine' },
                { data: 'schedule_status' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });


        // <===========================================================================================>
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD YEARLY SCHEDULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // <===========================================================================================>

        // FUNGSI TAMBAH MESIN PERTAHUN & PERKIRAAN WAKTU PREVENTIVE
        $('#recognizeModal').on('shown.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('id');
            $.ajax({
                type: 'GET',
                url: '{{ route("readyear-recognize", ':id') }}'.replace(':id', scheduleId),
                success: function(data) {

                    const header_modal = `
                        <h5 class="modal-title">Ketahui Schedule Mesin</h5>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                    `;

                    const data_modal = `
                        <div class="row align-items-center">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="machineTables1" width="100%">
                                    <thead>
                                        <th>NO.</th>
                                        <th>NO.INVENT</th>
                                        <th>NO.MESIN/LOKASI</th>
                                        <th>NAMA MESIN</th>
                                        <th>MODEL/TYPE</th>
                                        <th>BRAND/MERK</th>
                                        <th colspan="2">RENTANG WAKTU PREVENTIVE</th>
                                    </thead>
                                        <tbody>
                                            ${data.scheduledata.map((machine, index) => `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${machine.invent_number}</td>
                                                    <td>${machine.machine_number || '-'}</td>
                                                    <td>${machine.machine_name}</td>
                                                    <td>${machine.machine_type || '-'}</td>
                                                    <td>${machine.machine_brand || '-'}</td>
                                                    <td>${formatDate(machine.schedule_start)}</td>
                                                    <td>${formatDate(machine.schedule_end)}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                </table>
                            </div>
                        </div>;
                    `;
                    const button_modal =`
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" data-toggle="modal">Confirm</button>
                    `;
                    $('#modal_title_recognize').html(header_modal);
                    $('#modal_data_recognize').html(data_modal);
                    $('#modal_button_recognize').html(button_modal);

                    $('#saveButton').on('click', function() {
                        let recognizeBy = '{{ Auth::user()->id }}';
                        if (confirm("Apakah yakin sudah mengetahui preventive ini?")) {
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("edityear-recognize", ':id') }}'.replace(':id', scheduleId),
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'recognize_by': recognizeBy,
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#recognizeModal').modal('hide');
                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                        const warningMessage = JSON.parse(xhr.responseText).error;
                                        $('#warningText').text(warningMessage);
                                        $('#warningModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#warningModal').modal('hide');
                                        $('#recognizeModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        } else {
                            // User cancelled the deletion, do nothing
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    });

    //fungsi filter button
        $('#filterButton').on('click', function() {
        const filterCard = $('#filterCard');
        filterCard.collapse('toggle');
    });
</script>

@endpush
