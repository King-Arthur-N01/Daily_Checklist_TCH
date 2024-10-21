@extends('layouts.master')
@section('title', 'Table History')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table History</h1>
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="historyTables" width="100%">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>NAMA MESIN</th>
                                    <th>TYPE MESIN</th>
                                    <th>NOMOR MESIN</th>
                                    <th>STATUS</th>
                                    <th>STATUS</th>
                                    <th>STATUS PREVENTIVE</th>
                                    <th>SHIFT</th>
                                    <th>WAKTU PREVENTIVE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- view Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_view">
                </div>
                <div class="modal-body" id="modal_data_view">
                </div>
                <div class="modal-footer" id="modal_button_view">
                </div>
            </div>
        </div>
    </div>
    <!-- End view Modal-->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
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
            const table = $('#historyTables').DataTable({
                ajax: {
                    url: '{{ route("refreshistory") }}',
                    dataSrc: function(data)
                    {
                        return data.joinrecords.map((joinrecords, index) => {
                            return {
                                number: index + 1,
                                machine_name: joinrecords.machine_name,
                                machine_type: joinrecords.machine_type,
                                machine_number: joinrecords.machine_number,
                                correct_status: joinrecords.getcorrect ? joinrecords.getcorrect : 'Belum dikoreksi',
                                approve_status: joinrecords.getapprove ? joinrecords.getapprove : 'Belum disetujui',
                                record_status: joinrecords.machinerecord_status,
                                shift: joinrecords.shift,
                                getcreatedate: joinrecords.created_date,
                                actions: `
                                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-id="${joinrecords.records_id}" data-target="#viewModal"><img style="height: 20px" src="{{ asset('assets/icons/eye_white.png') }}"></a>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_number' },
                    { data: 'correct_status' },
                    { data: 'approve_status' },
                    { data: 'record_status', render: function(data, type, row) {
                        if (data === 0) {
                            return '<span class="badge badge-danger">ABNORMAL</span>';
                        } else if (data === 1) {
                            return '<span class="badge badge-success">NORMAL</span>';
                        }
                    }},
                    { data: 'shift' },
                    { data: 'getcreatedate' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#viewModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const machineId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("detailhistory", ':id') }}'.replace(':id', machineId),
                    success: function(data) {
                        let table_modal = '';
                        data.machinedata.forEach((rowdata, index) => {
                            const actions = JSON.parse(data.combineresult[0].operator_action)[index].join(' & ');
                            const result = JSON.parse(data.combineresult[0].result)[index];

                            table_modal += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${rowdata.name_componencheck}</td>
                                    <td>${rowdata.name_parameter}</td>
                                    <td>${rowdata.name_metodecheck}</td>
                                    <td>${actions}</td>
                                    <td>${result}</td>
                                </tr>
                            `;
                        });

                        const header_modal = `
                            <h5 class="modal-title">Lihat Hasil Preventive</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;

                        const data_modal = `
                            <div class="table-responsive">
                                <table class="table table-header" width="100%">
                                    <tbody>
                                        <tr>
                                            <th>No. Invent Mesin :</th>
                                            <th>${data.machinedata[0].invent_number}</th>
                                            <th>Spec/Tonage :</th>
                                            <th>${data.machinedata[0].machine_spec}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Mesin :</th>
                                            <th>${data.machinedata[0].machine_name}</th>
                                            <th>Buatan :</th>
                                            <th>${data.machinedata[0].machine_made}</th>
                                        </tr>
                                        <tr>
                                            <th>Brand/Merk :</th>
                                            <th>${data.machinedata[0].machine_brand}</th>
                                            <th>Mfg.NO :</th>
                                            <th>${data.machinedata[0].mfg_number}</th>
                                        </tr>
                                        <tr>
                                            <th>Model/Type :</th>
                                            <th>${data.machinedata[0].machine_type}</th>
                                            <th>Install Date :</th>
                                            <th>${data.machinedata[0].install_date}</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="header-input">
                                    <div class="col-6">
                                        <a>NO.MESIN :</a>
                                        <input class="form-control" type="int" name="machine_number" id="machine_number" value="${data.usersdata[0].machine_number2}" readonly>
                                    </div>
                                    <div class="col-6">
                                        <a>WAKTU PREVENTIVE :</a>
                                        <input class="form-control" value="${new Date(data.usersdata[0].created_at).toLocaleDateString()}" readonly>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="dataTables" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Bagian Yang Dicheck</th>
                                            <th>Standart/Parameter</th>
                                            <th>Metode Pengecekan</th>
                                            <th>Action</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${table_modal}
                                    </tbody>
                                </table>
                                <div class="form-custom">
                                    <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                                    <textarea class="form-control" id="input_note" type="text" rows="6" cols="50" readonly>${data.usersdata[0].note}</textarea>
                                </div>
                                    <a>Abnormality terhadap preventive</a>
                                    <input class="form-control" value="${data.abnormals}" readonly>
                                </div>
                                <div class="form-custom">
                                    <table class="table table-bordered table-custom" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>Shift :</th>
                                                <th>Disetujui oleh :</th>
                                                <th>Dikoreksi oleh :</th>
                                                <th colspan="4">Dibuat oleh :</th>
                                            </tr>
                                            <tr>
                                                <td>${data.usersdata[0].shift}</td>
                                                <td>${data.usersdata[0].approve_by_name ? data.usersdata[0].approve_by_name : 'Belum disetujui'}</td>
                                                <td>${data.usersdata[0].correct_by_name ? data.usersdata[0].correct_by_name : 'Belum dikoreksi'}</td>
                                                ${data.usernames.map((get_user_id) => `
                                                    <td>${get_user_id}</td>
                                                `).join('')}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        `;

                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="printButton">Print</button>
                        `;

                        $('#modal_title_view').html(header_modal);
                        $('#modal_data_view').html(data_modal);
                        $('#modal_button_view').html(button_modal);
                        mergeCells();
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });

            // fungsi table untuk melihat status dari sebuah preventive
            // $('#historyTables tr').each(function() {
            //     var correctCell = $(this).find('td:eq(4)');
            //     var approveCell = $(this).find('td:eq(5)');
            //     var statusCell1 = $(this).find('td:eq(6)');
            //     var statusCell2 = $(this).find('td:eq(7)');
            //     var correct = correctCell.text().trim();
            //     var approve = approveCell.text().trim();
            //     if (correct !== '' && approve !== '') {
            //         statusCell1.text('SUDAH DI KOREKSI');
            //         statusCell2.text('SUDAH DI SETUJUI');
            //         $(this).css("background-color", "rgba( 0, 0, 255, 0.2)");
            //     } else if (correct !== '' && approve === '') {
            //         statusCell1.text('SUDAH DI KOREKSI');
            //         statusCell2.text('BELUM DI SETUJUI');
            //         $(this).css("background-color", "rgba( 0, 255, 0, 0.2)");
            //     } else if (correct === '' && approve === '') {
            //         statusCell1.text('BELUM DI KOREKSI');
            //         statusCell2.text('BELUM DI SETUJUI');
            //     }
            // });
        });
    </script>
@endpush
