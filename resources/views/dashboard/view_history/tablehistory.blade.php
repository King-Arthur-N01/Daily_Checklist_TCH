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
                    <div class="table-history">
                        <div class="col-4">
                            <p class="mg-b-10">Input Nama Mesin</p>
                            <select class="form-control select2" name="" id="category-input-machinename">
                                <option selected="selected" value="">Select :</option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Input Nomor Mesin </p>
                            <select class="form-control select2" name="" id="category-input-machinecode">
                                <option selected="selected" value="">Select :</option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Input Hari/Bulan/Tahun </p>
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
                        <table class="table table-bordered" id="historyTables" width="100%">
                            <thead>
                                <th>Checkpoint NO.</th>
                                <th>Nama Mesin</th>
                                <th>Type Mesin</th>
                                <th>Nomor Mesin</th>
                                <th>Status</th>
                                <th>Status</th>
                                <th>Shift</th>
                                <th>Waktu</th>
                                <th>Action</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-simple-datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        // Additional code for adding placeholder in search box of select2.js
        (function($) {
            var Defaults = $.fn.select2.amd.require('select2/defaults');
            $.extend(Defaults.defaults, {
                searchInputPlaceholder: ''
            });
            var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
            var _renderSearchDropdown = SearchDropdown.prototype.render;
            SearchDropdown.prototype.render = function(decorated) {
                // invoke parent method
                var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
                this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
                return $rendered;
            };
        })(window.jQuery);
    </script>
    <script>
        $(document).ready(function() {
            $('#datetimepicker').datetimepicker({ //script for calendar.js
                datepicker: true,
                timepicker: true,
                format: 'm/d/Y h:i A',
                step: 60 // Set the step interval for hour and minute selection
            });
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'});
            });

            // kode javascript untuk menginisiasi datatable dan berfungsi sebagai dynamic table
            const table = $('#historyTables').DataTable({
                ajax: {
                    url: '{{ route("refreshistory") }}',
                    dataSrc: function(data)
                    {
                        return data.joinrecords.map((joinrecords, index) => {
                            return {
                                number: joinrecords.records_id,
                                machine_name: joinrecords.machine_name,
                                machine_type: joinrecords.machine_type,
                                machine_number: joinrecords.machine_number,
                                getcorrect: joinrecords.getcorrect ? joinrecords.getcorrect : 'Belum dikoreksi',
                                getapprove: joinrecords.getapprove ? joinrecords.getapprove : 'Belum disetujui',
                                shift: joinrecords.shift,
                                getcreatedate: joinrecords.getcreatedate,
                                actions: joinrecords.records_id
                            };
                        });
                    }
                },
                columns: [
                    { data: 'number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_number' },
                    { data: 'getcorrect' },
                    { data: 'getapprove' },
                    { data: 'shift' },
                    { data: 'getcreatedate' },
                    {data: 'actions',
                    render: function(data, type, row) {
                        let url = '{{ route("detailhistory", ":id") }}';
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

            // fungsi table untuk melihat status dari sebuah preventive
            $('#historyTables tr').each(function() {
                var correctCell = $(this).find('td:eq(4)');
                var approveCell = $(this).find('td:eq(5)');
                var statusCell1 = $(this).find('td:eq(6)');
                var statusCell2 = $(this).find('td:eq(7)');
                var correct = correctCell.text().trim();
                var approve = approveCell.text().trim();
                if (correct !== '' && approve !== '') {
                    statusCell1.text('SUDAH DI KOREKSI');
                    statusCell2.text('SUDAH DI SETUJUI');
                    $(this).css("background-color", "rgba( 0, 0, 255, 0.2)");
                } else if (correct !== '' && approve === '') {
                    statusCell1.text('SUDAH DI KOREKSI');
                    statusCell2.text('BELUM DI SETUJUI');
                    $(this).css("background-color", "rgba( 0, 255, 0, 0.2)");
                } else if (correct === '' && approve === '') {
                    statusCell1.text('BELUM DI KOREKSI');
                    statusCell2.text('BELUM DI SETUJUI');
                }
            });
    </script>
@endpush
