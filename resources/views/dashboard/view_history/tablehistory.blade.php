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
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="historyTables" width="100%">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>NO.INVENT</th>
                                    <th>NAMA MESIN</th>
                                    <th>TYPE MESIN</th>
                                    <th>NOMOR MESIN</th>
                                    <th>STATUS KOREKSI</th>
                                    <th>STATUS SETUJUI</th>
                                    <th>STATUS PM</th>
                                    <th>WAKTU PM</th>
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
    <script src="{{ asset('assets/vendor/custom-js/formatdate.js') }}"></script>
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
                                invent_number: joinrecords.invent_number,
                                machine_type: joinrecords.machine_type || '-',
                                machine_number: joinrecords.machine_number || '-',
                                correct_status: joinrecords.getcorrect,
                                approve_status: joinrecords.getapprove,
                                record_status: joinrecords.machinerecord_status,
                                getcreatedate: formatDate(joinrecords.preventive_date),
                                schedule_status: joinrecords.schedule_time_status,
                                actions: `
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-id="${joinrecords.records_id}" data-target="#viewModal"><i class="bi bi-eye-fill"></i></button>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'number' },
                    { data: 'machine_name' },
                    { data: 'invent_number' },
                    { data: 'machine_type' },
                    { data: 'machine_number' },
                    { data: 'correct_status', render: function(data, type, row) {
                        return data === null ? '<span class="badge badge-danger">Belum Diketahui</span>' : '<span class="badge badge-success">Sudah Diketahui</span>';
                    }},
                    { data: 'approve_status', render: function(data, type, row) {
                        return data === null ? '<span class="badge badge-danger">Belum Disetujui</span>' : '<span class="badge badge-success">Sudah Disetujui</span>';
                    }},
                    { data: 'record_status', render: function(data, type, row) {
                        if (data === 0) {
                            return '<span class="badge badge-success">OPEN</span>';
                        } else if (data === 1) {
                            return '<span class="badge badge-info">CLOSE</span>';
                        } else if (data === 2) {
                            return '<span class="badge badge-warning">ABNORMAL</span>';
                        }
                    }},
                    {
                        data: 'getcreatedate',
                    },
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
                        const operatorActionArray = JSON.parse(data.combineresult[0].operator_action || '[]');
                        const resultArray = JSON.parse(data.combineresult[0].result || '[]');
                        const maxLength = Math.min(
                            data.machinedata.length,
                            operatorActionArray.length,
                            resultArray.length
                        );

                        let header_input_modal = '';
                        if (data.preventivedata[0].fix_abnormal_date == null) {
                            header_input_modal += `
                                <div class="col-6">
                                    <a>NO.MESIN :</a>
                                    <input class="form-control" type="int" name="machine_number" id="machine_number" value="${data.machinedata[0].machine_number || '-'}" readonly>
                                </div>
                                <div class="col-6">
                                    <a>WAKTU PREVENTIVE :</a>
                                    <input class="form-control" value="${formatDate(data.preventivedata[0].record_date)} (${data.preventivedata[0].shift})" readonly>
                                </div>
                            `;
                        } else {
                            header_input_modal += `
                                <div class="col-4">
                                    <a>NO.MESIN :</a>
                                    <input class="form-control" type="int" name="machine_number" id="machine_number" value="${data.machinedata[0].machine_number || '-'}" readonly>
                                </div>
                                <div class="col-4">
                                    <a>WAKTU PREVENTIVE :</a>
                                    <input class="form-control" value="${formatDate(data.preventivedata[0].record_date)} (${data.preventivedata[0].shift})" readonly>
                                </div>
                                <div class="col-4">
                                    <a>WAKTU PERBAIKAN MESIN :</a>
                                    <input class="form-control" value="${formatDate(data.preventivedata[0].fix_abnormal_date)}" readonly>
                                </div>
                            `;
                        }

                        for (let index = 0; index < maxLength; index++) {
                            const actions = operatorActionArray[index]?.join(' & ') || 'No actions';
                            const result = resultArray[index] || 'No result';

                            table_modal += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${data.machinedata[index].name_componencheck}</td>
                                    <td>${data.machinedata[index].name_parameter}</td>
                                    <td>${data.machinedata[index].name_metodecheck}</td>
                                    <td>${actions}</td>
                                    <td>${result}</td>
                                </tr>
                            `;
                        }

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
                                    ${header_input_modal}
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
                                    <textarea class="form-control" id="input_note" type="text" rows="6" cols="50" disabled>${data.preventivedata[0].note || '-'}</textarea>
                                    <table class="table table-bordered" id="abnormalityTable">
                                        <thead>
                                            <tr>
                                                <th>Masalah :</th>
                                                <th>Penyebab :</th>
                                                <th>Tindakan :</th>
                                                <th>Status :</th>
                                                <th>Target :</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <textarea class="form-control abnormal-input" type="text" id="problem" placeholder="Isi bila diperlukan!" rows="6" cols="50" disabled>${data.preventivedata[0].problem || '-'}</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control abnormal-input" type="text" id="cause" placeholder="Isi bila diperlukan!" rows="6" cols="50" disabled>${data.preventivedata[0].cause || '-'}</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control abnormal-input" type="text" id="action" placeholder="Isi bila diperlukan!" rows="6" cols="50" disabled>${data.preventivedata[0].action || '-'}</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control abnormal-input" type="text" id="status" placeholder="Isi bila diperlukan!" rows="6" cols="50" disabled>${data.preventivedata[0].status || '-'}</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control abnormal-input" type="text" id="target" placeholder="Isi bila diperlukan!" rows="6" cols="50" disabled>${data.preventivedata[0].target || '-'}</textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-custom">
                                    <table class="table table-bordered table-custom" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>Disetujui oleh :</th>
                                                <th>Dikoreksi oleh :</th>
                                                <th colspan="4">Dibuat oleh :</th>
                                            </tr>
                                            <tr>
                                                <td>${data.preventivedata[0].approve_by_name ? data.preventivedata[0].approve_by_name : 'Belum disetujui'}</td>
                                                <td>${data.preventivedata[0].correct_by_name ? data.preventivedata[0].correct_by_name : 'Belum dikoreksi'}</td>
                                                ${JSON.parse(data.preventivedata[0].create_by).map((get_user_id) => `
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
                            <button type="submit" class="btn btn-primary" data-id="${data.preventivedata[0].record_id}" id="printButton">Print</button>
                        `;

                        $('#modal_title_view').html(header_modal);
                        $('#modal_data_view').html(data_modal);
                        $('#modal_button_view').html(button_modal);
                        mergeCells();

                        // Add event listener to print button
                        $('#printButton').on('click', function() {
                            new_url_pdf = '{{ route("printrecord", ':id') }}'.replace(':id', machineId);
                            window.open(new_url_pdf, '_blank');
                            return;
                        });
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
