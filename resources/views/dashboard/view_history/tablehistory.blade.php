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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
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
                    <div class="table-responsive ">
                        <table class="table" id="datatables" width="100%" cellspacing="0">
                            <thead>
                                <th>Checkpoint NO.</th>
                                <th>Nama Mesin</th>
                                <th>Type Mesin</th>
                                <th>Nomor Mesin</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (isset($joinrecords) &&!empty($joinrecords))
                                    @foreach ($joinrecords as $recordsget)
                                        <tr>
                                            <td>{{ $recordsget->records_id }}</td>
                                            <td>{{ $recordsget->machine_name }}</td>
                                            <td>{{ $recordsget->machine_type }}</td>
                                            <td>{{ $recordsget->machine_number }}</td>
                                            <td>{{ $recordsget->getcreatedate }}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('detailhistory', $recordsget->records_id) }}"><img style="height: 20px" src="assets/icons/eye_white.png"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td>No data found.</td></tr>
                                @endif
                            </tbody>
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
        // Additional code for adding placeholder in search box of select2
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
        $(function() {
            $('#datetimepicker').datetimepicker({ //script for calendar.js
                datepicker: true,
                timepicker: true,
                format: 'm/d/Y h:i A',
                step: 60 // Set the step interval for hour and minute selection
            });

            $(document).ready(function() { //script for search2.js
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'});
            });
        });
    </script>
@endpush
