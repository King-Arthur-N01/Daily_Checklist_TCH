@extends('layouts.master')
@section('title', 'Table Standart Checkpoint Machine')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Database Mesin</h1>
            <div class="card shadow">
                <div class="card card-filter collapse" id="filterCard">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <div class="table-filter">
                        <div class="col-4">
                            <p class="mg-b-10">Nomor Invent </p>
                            <input class="form-control" id="filterByNumber">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Nama Mesin</p>
                            <input class="form-control" id="filterByName">
                        </div>
                        <div class="col-4">
                            <p class="mg-b-10">Standarisasi Mesin</p>
                            <select class="form-control" id="filterByProperty">
                                <option selected="selected">Select :</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div class="div-tables">
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" data-toggle="modal" data-target="#uploadModal"><i class="fas fa-clipboard-check"></i>&nbsp; Tambah Checksheet Mesin</button>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <button type="button" class="table-buttons" id="filterButton"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{-- <div class="custom-btn-table dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                EXPORT
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" id="export_excel"><i class="bi bi-file-earmark-spreadsheet"></i>&nbsp;CSV</a>
                                <a class="dropdown-item" id="export_pdf"><i class="bi bi-file-earmark-pdf"></i>&nbsp;PDF</a>
                                <a class="dropdown-item" id="export_pdf_produksi"><i class="bi bi-file-earmark-pdf"></i>&nbsp;PDF PRODUKSI</a>
                                <a class="dropdown-item" id="export_pdf_engineering"><i class="bi bi-file-earmark-pdf"></i>&nbsp;PDF ENGINEERING</a>
                            </div>
                        </div> --}}
                        <div class="custom-btn-table dropdown">
                            <a class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                EXPORT
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" id="dropdownSubMenu1" data-toggle="dropdown"><i class="bi bi-file-earmark-spreadsheet"></i>&nbsp;CSV</a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownSubMenu1">
                                        <a class="dropdown-item export_excel" data-value="">SEMUA.csv</a>
                                        @foreach ($fetchproperties as $getproperty)
                                            <a class="dropdown-item export_excel" data-value="{{$getproperty->id}}">{{$getproperty->name_property}}.csv</a>
                                        @endforeach
                                    </ul>
                                    <a class="dropdown-item dropdown-toggle" id="dropdownSubMenu2" data-toggle="dropdown"><i class="bi bi-file-earmark-pdf"></i>&nbsp;PDF</a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownSubMenu2">
                                        <a class="dropdown-item export_pdf" data-value="">SEMUA.pdf</a>
                                        @foreach ($fetchproperties as $getproperty)
                                            <a class="dropdown-item export_pdf" data-value="{{$getproperty->id}}">{{$getproperty->name_property}}.pdf</a>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <table class="table table-bordered" id="importTables" width="100%">
                            <thead>
                                <th>NO.</th>
                                <th>NO.INVENT</th>
                                <th>NAMA MESIN</th>
                                <th>MODEL/TYPE</th>
                                <th>BRAND/MERK</th>
                                <th>NO.MESIN/AREA</th>
                                <th>KETERANGAN</th>
                                <th>KATEGORI CHECKSHEET</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal">Tambahkan Secara Manual</button>
                </div>
                <div class="modal-body">
                    <form id="formData">
                        @csrf
                        <p>Format excel harus <mark>.xlsx</mark> selain itu tidak akan terbaca dan aturan urutan Kolom pada excel</p>
                        <p class="text-upload-header">No.<mark>|</mark>No.Invent Mesin<mark>|</mark>Nama Mesin<mark>|</mark>Brand/Merk<mark>|</mark>Model/Type<mark>|</mark>Spec/Output<mark>|</mark>No.MFG<mark>|</mark>Tahun Pembuatan<mark>|</mark>Input Daya<mark>|</mark>Buatan<mark>|</mark>Install Date<mark>|</mark>No.MFG<mark>|</mark>Keterangan<mark>|</mark>No.Mesin</p>
                        <label for="importExcel" class="table-buttons" id="customButton"><i class="fas fa-file-medical"></i>&nbsp; Select a file</label>
                        <input type="file" name="fileupload" id="importExcel" hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="uploadButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Upload Modal-->

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-xxl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_add">
                </div>
                <div class="modal-body" id="modal_data_add">
                </div>
                <div class="modal-footer" id="modal_button_add">
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Modal-->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-xxl">
            <div class="modal-content">
                <div class="modal-header" id="modal_title_edit">
                </div>
                <div class="modal-body" id="modal_data_edit">
                </div>
                <div class="modal-footer" id="modal_button_edit">
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal-->

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-xxl">
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
    <!-- End View Modal-->

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-submenu/dist/css/bootstrap-submenu.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css') }}"> --}}
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/upload.js') }}"></script>

    {{-- <script src="{{asset('assets/vendor/bootstrap-submenu/dist/js/bootstrap-submenu.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/vendor/datatables/js/dataTables.buttons.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/vendor/datatables/js/buttons.bootstrap4.min.js')}}"></script> --}}

    {{-- <script src="{{asset('assets/vendor/datatables/js/buttons.html5.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/vendor/datatables/js/buttons.print.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/vendor/datatables/js/buttons.colVis.min.js')}}"></script> --}}


    {{-- <script src="{{asset('assets/vendor/datatables/ajax/buttons.print.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/vendor/datatables/ajax/pdfmake.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/vendor/datatables/ajax/vfs_fonts.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: 'Not selected :' // the text of the option
                },
                searchInputPlaceholder: 'Search',
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
            const table = $('#importTables').DataTable({
                ajax: {
                    url: '{{ route("refreshmachinedata") }}',
                    dataSrc: function(data) {
                        return data.refreshmachine.map(function(refreshmachine, index) {
                            let refreshproperty = data.refreshproperty.find(function(property) {
                                return property.id === refreshmachine.property_id;
                            });
                            return {
                                number: index + 1,
                                invent_number: refreshmachine.invent_number,
                                machine_name: refreshmachine.machine_name,
                                machine_type: refreshmachine.machine_type ?? '-',
                                machine_brand: refreshmachine.machine_brand ?? '-',
                                machine_number: refreshmachine.machine_number ?? '-',
                                machine_info: refreshmachine.machine_info ?? '-',
                                name_property: refreshproperty ? refreshproperty.name_property : 'Belum ada kategori',
                                machine_status: refreshmachine.machine_status,
                                actions: `
                                    <div class="dynamic-button-group">
                                        <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item-custom-success" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#viewModal"><i class="bi bi-eye-fill"></i>&nbsp;Detail</a>
                                            <a class="dropdown-item-custom-primary" data-toggle="modal" data-id="${refreshmachine.id}" data-target="#editModal"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a>
                                            <a class="dropdown-item-custom-danger" data-id="${refreshmachine.id}"><i class="bi bi-trash3-fill"></i>&nbsp;Delete</a>
                                        </div>
                                    </div>
                                `
                            };
                        });
                    }
                },
                columns: [
                    { data: 'number' },
                    { data: 'invent_number' },
                    { data: 'machine_name' },
                    { data: 'machine_type' },
                    { data: 'machine_brand' },
                    { data: 'machine_number' },
                    { data: 'machine_info' },
                    { data: 'name_property' },
                    { data: 'machine_status', render: function(data, type, row) {
                        if (data === 0) {
                            return '<span class="badge badge-danger">NONACTIVE</span>';
                        } else if (data === 1) {
                            return '<span class="badge badge-success">ACTIVE</span>';
                        }
                    }},
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            //fungsi upload button untuk upload mesin
            $('#uploadButton').on('click', function(e) {
                e.preventDefault();
                let file = $('#importExcel')[0].files[0];
                let formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    type: "POST",
                    url: "{{ route('uploadfile') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                            overlay.toggleClass('is-active');
                        }
                        setTimeout(function() {
                                $('#successModal').modal('hide');
                                $('#uploadModal').modal('hide');
                                overlay.removeClass('is-active');
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseText) {
                            const warningMessage = JSON.parse(xhr.responseText).error;
                            $('#failedText').text(warningMessage);
                            $('#failedModal').modal('show');
                        }
                        setTimeout(function() {
                            $('#failedModal').modal('hide');
                            $('#uploadModal').modal('hide');
                        }, 2000);
                    }
                }).always(function() {
                    table.ajax.reload(null, false);
                });
            });

            $('#addModal').on('shown.bs.modal', function(event) {
                const header_modal = `
                    <h5 class="modal-title">Standarisasi Mesin</h5>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                `;
                const data_modal = `
                    <form id="addForm" method="post">
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Invent</label>
                                    <div>
                                        <input class="form-control capslock" type="text" name="invent_number" placeholder="_-__-__-____">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_brand">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Model/Type Mesin</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_type">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_spec">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_made">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                    <div>
                                        <input class="form-control" type="text" name="mfg_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                    <div>
                                        <input class="form-control" type="text" name="install_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Mesin</label>
                                    <div>
                                        <input class="form-control capslock" type="text" name="machine_number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" align-items="center">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Tahun Pembuatan</label>
                                    <div>
                                        <input class="form-control" type="text" name="production_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Input Daya</label>
                                    <div>
                                        <input class="form-control" type="text" name="machine_power" placeholder="/kw">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="col-form-label text-sm-right" style="margin-left: 4px;">Keterangan</label>
                                    <div>
                                        <select class="form-control" name="machine_info" id="machine_info">
                                            <option label="SELECT :" disabled selected></option>
                                            <option value="custom">Lain nya</option>
                                            <option value="produksi">Produksi</option>
                                            <option value="engginering">Engginering</option>
                                        </select>
                                        <input class="custom-input-option" type="text" id="custom_input" placeholder="Enter your own result">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
                const button_modal = `
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="addButtton">Save changes</button>
                `;

                $('#modal_title_add').html(header_modal);
                $('#modal_data_add').html(data_modal);
                $('#modal_button_add').html(button_modal);

                document.getElementById('machine_info').addEventListener("change", function () {
                    const customInput = document.getElementById('custom_input');
                    if (this.value === 'custom') {
                        customInput.style.display = 'block';
                        customInput.required = true;
                        customInput.value = '';
                    } else {
                        customInput.style.display = 'none';
                        customInput.required = false;
                    }
                });

                document.getElementById('custom_input').addEventListener("change", function () {
                    const select = document.getElementById('machine_info');
                    const newOption = document.createElement("option");
                    newOption.text = this.value;
                    newOption.value = this.value;
                    select.add(newOption);
                    select.value = this.value;
                });

                // Add event listener to save button
                $('#addButtton').on('click', function() {
                    let formData = {
                        inventNumber: $('input[name="invent_number"]').val().toUpperCase(),
                        machineName: $('input[name="machine_name"]').val().toUpperCase(),
                        machineBrand: $('input[name="machine_brand"]').val().toUpperCase(),
                        machineType: $('input[name="machine_type"]').val().toUpperCase(),
                        machineSpec: $('input[name="machine_spec"]').val(),
                        machineMade: $('input[name="machine_made"]').val().toUpperCase(),
                        mfgNumber: $('input[name="mfg_number"]').val().toUpperCase(),
                        installDate: $('input[name="install_date"]').val().toUpperCase(),
                        machineNumber: $('input[name="machine_number"]').val().toUpperCase(),
                        productionDate: $('input[name="production_date"]').val().toUpperCase(),
                        machinePower: $('input[name="machine_power"]').val(),
                        machineInfo: $('select[name="machine_info"]').val().toUpperCase() === 'CUSTOM' ? $('#custom_input')
                            .val().toUpperCase() : $('select[name="machine_info"]').val().toUpperCase() // Ambil nilai dari select dan jika custom, ambil dari input kustom
                    };
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("addmachine") }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'invent_number': formData.inventNumber,
                            'machine_name': formData.machineName,
                            'machine_brand': formData.machineBrand,
                            'machine_type': formData.machineType,
                            'machine_spec': formData.machineSpec,
                            'machine_made': formData.machineMade,
                            'mfg_number': formData.mfgNumber,
                            'install_date': formData.installDate,
                            'machine_number': formData.machineNumber,
                            'production_date': formData.productionDate,
                            'machine_power': formData.machinePower,
                            'machine_info': formData.machineInfo,
                        },
                        success: function(response) {
                            if (response.success) {
                                const successMessage = response.success;
                                $('#successText').text(successMessage);
                                $('#successModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#successModal').modal('hide');
                                $('#addModal').modal('hide');
                                $('#uploadModal').modal('hide');
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseText) {
                                const warningMessage = JSON.parse(xhr.responseText).error;
                                $('#failedText').text(warningMessage);
                                $('#failedModal').modal('show');
                            }
                            setTimeout(function() {
                                $('#failedModal').modal('hide');
                                $('#addModal').modal('hide');
                                $('#uploadModal').modal('hide');
                            }, 2000);
                        }
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                });
            });

            // fungsi untuk mengedit atau menambahkan standarisasi ke mesin
            $('#editModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const machineId = button.data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("findmachineid", ':id') }}'.replace(':id', machineId),
                    success: function(data) {
                        let options_status = '';
                        if (Array.isArray(data.fetchproperty)) {
                            $.each(data.fetchproperty, function(index, propertytable) {
                                const isSelected = propertytable.id == data.fetchmachine.property_id ? 'selected' : '';
                                options_status += `<option value="${propertytable.id}" ${isSelected}>${propertytable.name_property}</option>`;
                            });
                        } else {
                            console.error('fetchproperty is not an array:', data.fetchproperty);
                        }

                        let options_standart = '';
                        if (Array.isArray(data.fetchworkinghour)) {
                            $.each(data.fetchworkinghour, function(index, standarttable) {
                                const isSelected = standarttable.id == data.fetchmachine.standart_id ? 'selected' : '';
                                options_standart += `<option value="${standarttable.id}" ${isSelected}>${standarttable.standart_name}</option>`;
                            });
                        } else {
                            console.error('fetchproperty is not an array:', data.fetchproperty);
                        }

                        const header_modal = `
                            <h5 class="modal-title">Edit Mesin</h5>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                        `;
                        const data_modal = `
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor Invent</label>
                                        <div>
                                            <input class="form-control capslock" id="inventNumber" type="text" name="invent_number" value="${data.fetchmachine.invent_number || ''}" placeholder="_-__-__-____">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nama Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_name" value="${data.fetchmachine.machine_name || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Brand/Merk Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_brand" value="${data.fetchmachine.machine_brand || ''}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Model/Type Mesin</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_type" value="${data.fetchmachine.machine_type || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Spec/Tonnage</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_spec" value="${data.fetchmachine.machine_spec || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Buatan</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_made" value="${data.fetchmachine.machine_made || ''}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Nomor MFG</label>
                                        <div>
                                            <input class="form-control" type="text" name="mfg_number" value="${data.fetchmachine.mfg_number || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Install Date</label>
                                        <div>
                                            <input class="form-control" type="text" name="install_date" value="${data.fetchmachine.install_date || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">No Mesin</label>
                                        <div>
                                            <input class="form-control capslock" type="text" name="machine_number" value="${data.fetchmachine.machine_number || ''}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align-items="center">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Tahun Pembuatan</label>
                                        <div>
                                            <input class="form-control" type="text" name="production_date" value="${data.fetchmachine.production_date || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Input Daya</label>
                                        <div>
                                            <input class="form-control" type="text" name="machine_power" placeholder="/kw" value="${data.fetchmachine.machine_power || ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-sm-right" style="margin-left: 4px;">Keterangan</label>
                                        <div>
                                            <select class="form-control" name="machine_info" id="machine_info">
                                                <option label="SELECT :" disabled selected></option>
                                                <option value="custom">Lain nya</option>
                                                <option value="PRODUKSI" ${data.fetchmachine.machine_status == 'PRODUKSI' ? 'selected' : ''}>Produksi</option>
                                                <option value="ENGGINERING" ${data.fetchmachine.machine_status == 'ENGGINERING' ? 'selected' : ''}>Engginering</option>
                                            </select>
                                            <input class="custom-input-option capslock" type="text" id="custom_input" placeholder="Enter your own result">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered" id="editTables" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kategori Mesin</th>
                                        <th>Kategori Jam PM Mesin</th>
                                        <th>Status Mesin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control" id="getproperty">
                                                <option value="">Tidak ada</option>
                                                ${options_status}
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" id="getstandart">
                                                <option value="">Tidak ada</option>
                                                ${options_standart}
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" id="getstatus">
                                                <option value="1" ${data.fetchmachine.machine_status == 1 ? 'selected' : ''}>Aktif</option>
                                                <option value="0" ${data.fetchmachine.machine_status == 0 ? 'selected' : ''}>Nonaktif</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        `;
                        const button_modal = `
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="editButton">Save changes</button>
                        `;
                        $('#modal_title_edit').html(header_modal);
                        $('#modal_data_edit').html(data_modal);
                        $('#modal_button_edit').html(button_modal);

                        document.getElementById('machine_info').addEventListener("change", function () {
                            const customInput = document.getElementById('custom_input');
                            if (this.value === 'custom') {
                                customInput.style.display = 'block';
                                customInput.required = true;
                                customInput.value = '';
                            } else {
                                customInput.style.display = 'none';
                                customInput.required = false;
                            }
                        });

                        document.getElementById('custom_input').addEventListener("change", function () {
                            const select = document.getElementById('machine_info');
                            const newOption = document.createElement("option");
                            newOption.text = this.value;
                            newOption.value = this.value;
                            select.add(newOption);
                            select.value = this.value;
                        });

                        if (data.fetchmachine && data.fetchmachine.machine_info) {
                            const select = document.getElementById('machine_info');
                            const newOption = document.createElement("option");
                            newOption.text = data.fetchmachine.machine_info;
                            newOption.value = data.fetchmachine.machine_info;
                            select.add(newOption);
                            select.value = data.fetchmachine.machine_info;
                        }

                        // Save button
                        $('#editButton').on('click', function() {
                            // let idProperty = $('#getproperty').val();
                            let formData = {
                                inventNumber: $('input[name="invent_number"]').val().toUpperCase(),
                                machineName: $('input[name="machine_name"]').val().toUpperCase(),
                                machineBrand: $('input[name="machine_brand"]').val().toUpperCase(),
                                machineType: $('input[name="machine_type"]').val().toUpperCase(),
                                machineSpec: $('input[name="machine_spec"]').val(),
                                machineMade: $('input[name="machine_made"]').val().toUpperCase(),
                                mfgNumber: $('input[name="mfg_number"]').val().toUpperCase(),
                                installDate: $('input[name="install_date"]').val().toUpperCase(),
                                machineNumber: $('input[name="machine_number"]').val().toUpperCase(),
                                productionDate: $('input[name="production_date"]').val().toUpperCase(),
                                machinePower: $('input[name="machine_power"]').val(),
                                idProperty : $('#getproperty').val(),
                                idStandart : $('#getstandart').val(),
                                machineStatus : $('#getstatus').val(),
                                machineInfo: $('select[name="machine_info"]').val().toUpperCase() === 'CUSTOM' ? $('#custom_input')
                                    .val().toUpperCase() : $('select[name="machine_info"]').val().toUpperCase() // Ambil nilai dari select dan jika custom, ambil dari input kustom

                            };
                            $.ajax({
                                type: 'PUT',
                                url: '{{ route("editmachine", ':id') }}'.replace(':id', machineId),
                                data: {
                                    '_token': '{{ csrf_token() }}', // Include the CSRF token
                                    'invent_number': formData.inventNumber,
                                    'machine_name': formData.machineName,
                                    'machine_brand': formData.machineBrand,
                                    'machine_type': formData.machineType,
                                    'machine_spec': formData.machineSpec,
                                    'machine_made': formData.machineMade,
                                    'mfg_number': formData.mfgNumber,
                                    'install_date': formData.installDate,
                                    'machine_number': formData.machineNumber,
                                    'production_date': formData.productionDate,
                                    'machine_power': formData.machinePower,
                                    'machine_info': formData.machineInfo,
                                    'property_id': formData.idProperty,
                                    'standart_id': formData.idStandart,
                                    'machine_status': formData.machineStatus
                                },
                                success: function(response) {
                                    if (response.success) {
                                        const successMessage = response.success;
                                        $('#successText').text(successMessage);
                                        $('#successModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#successModal').modal('hide');
                                        $('#editModal').modal('hide');
                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                        const warningMessage = JSON.parse(xhr.responseText).error;
                                        $('#failedText').text(warningMessage);
                                        $('#failedModal').modal('show');
                                    }
                                    setTimeout(function() {
                                        $('#failedModal').modal('hide');
                                        $('#editModal').modal('hide');
                                    }, 2000);
                                }
                            }).always(function() {
                                table.ajax.reload(null, false);
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });

            //fungsi button get detail mesin
            $('#viewModal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let machineId = button.data('id');
                // var no_mesin = $("#viewButton")$(this).attr("data-id");
                $.ajax({
                    type: 'GET',
                    url: '{{ route("detailmachine", ':id') }}'.replace(':id', machineId),
                    success: function(data) {
                        if (!data || !data.fetchmachines || data.fetchmachines.length === 0) {
                            $('#modal_data_view').html(
                                '<h4 style="text-align: center;">Error data ketegory mesin belum tersedia!</h4>'
                            );
                        } else {
                            const machine = data.fetchmachines[0];
                            const header_modal = `
                                <h5 class="modal-title">Detail Preventive Mesin</h5>
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
                            `;
                            const data_modal = `
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No. Invent Mesin :</th>
                                        <td>${machine.invent_number}</td>
                                        <th>Spec/Tonage :</th>
                                        <td>${machine.machine_spec ?? '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Mesin :</th>
                                        <td>${machine.machine_name}</td>
                                        <th>Buatan :</th>
                                        <td>${machine.machine_made ?? '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand/Merk :</th>
                                        <td>${machine.machine_brand ?? '-'}</td>
                                        <th>Mfg.NO :</th>
                                        <td>${machine.mfg_number ?? '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Model/Type :</th>
                                        <td>${machine.machine_type ?? '-'}</td>
                                        <th>Install Date :</th>
                                        <td>${machine.install_date ?? '-'}</td>
                                    </tr>
                                </table>
                                <h5>Standart Mesin</h5>
                                <table class="table table-bordered" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Bagian Yang Dicheck</th>
                                            <th>Standart/Parameter</th>
                                            <th>Metode Pengecekan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    ${data.fetchmachines.map(machine => `
                                            <tr>
                                                <td>${machine.name_componencheck}</td>
                                                <td>${machine.name_parameter}</td>
                                                <td>${machine.name_metodecheck}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            `;
                            const button_modal = `
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-id="${machineId}" id="printButton">Print Mesin</button>
                            `;
                            $('#modal_title_view').html(header_modal);
                            $('#modal_data_view').html(data_modal);
                            $('#modal_button_view').html(button_modal);
                            mergeCells();

                            // Add event listener to print button
                            $('#printButton').on('click', function() {
                                new_url_pdf = '{{ route("printmachine", ':id') }}'.replace(':id', machineId);
                                window.open(new_url_pdf, '_blank');
                                return;
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('error:', error);
                        $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            });

            // fungsi delete button untuk hapus mesin
            $('#importTables').on('click', '.dropdown-item-custom-delete', function(e) {
                e.preventDefault();
                const button = $(this);
                const machineId = button.data('id');
                if (confirm("Apakah yakin menghapus mesin ini?")) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route("removemachine", ':id') }}'.replace(':id', machineId),
                        data: {
                            '_token': '{{ csrf_token() }}'
                        }
                    }).done(function(response) {
                        if (response.success.trim()) {
                            const successMessage = response.success.trim();
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        setTimeout(function() {
                                $('#successModal').modal('hide'); // Hide success modal
                        }, 2000);
                    }).fail(function(xhr, status, error) {
                        console.error(xhr.responseText);
                        const warningMessage = JSON.parse(xhr.responseText).error;
                        $('#failedText').text(warningMessage);
                        $('#failedModal').modal('show');
                    }).always(function() {
                        table.ajax.reload(null, false);
                    });
                } else {
                    // User cancelled the deletion, do nothing
                }
            });

            $('.dropdown-menu a.export_pdf').on('click', function() {
                let buttonValue = $(this).data('value') || '';

                // Jika nilai tombol ada di rute
                if (buttonValue) {
                    const newViewPrint = '{{ route("exportpdfvalue", ":id") }}'.replace(':id', buttonValue);
                    window.open(newViewPrint, '_blank');
                } else {
                    // Default jika tidak ada nilai tombol
                    const defaultRoute = '{{ route("exportpdf") }}';
                    window.open(defaultRoute, '_blank');
                }
            });

            $('.dropdown-menu a.export_excel').on('click', function() {
                let buttonValue = $(this).data('value') || '';

                // Jika nilai tombol ada di rute
                if (buttonValue) {
                    const newViewPrint = '{{ route("exportexcelvalue", ":id") }}'.replace(':id', buttonValue);
                    window.open(newViewPrint, '_blank');
                } else {
                    // Default jika tidak ada nilai tombol
                    const defaultRoute = '{{ route("exportexcel") }}';
                    window.open(defaultRoute, '_blank');
                }
            });

            //fungsi filter button
            $('#filterButton').on('click', function() {
                const filterCard = $('#filterCard');
                filterCard.collapse('toggle');
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterByNumber = document.getElementById('filterByNumber');
            const filterByName = document.getElementById('filterByName');
            const filterByProperty = document.getElementById('filterByProperty');
            const table = document.getElementById('importTables');
            const rows = table.getElementsByTagName('tr');

            // Function to filter table
            function filterTable() {
                const numberValue = filterByNumber.value.toLowerCase();
                const nameValue = filterByName.value.toLowerCase();
                const propertyValue = filterByProperty.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const numberCell = rows[i].getElementsByTagName('td')[1];
                    const nameCell = rows[i].getElementsByTagName('td')[2];
                    const propertyCell = rows[i].getElementsByTagName('td')[7];

                    const numberText = numberCell ? numberCell.textContent.toLowerCase() : '';
                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
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
    <script>
        $('.dropdown-submenu > a').on("click", function(e) {
            var submenu = $(this);
            $('.dropdown-submenu .dropdown-menu').removeClass('show');
            submenu.next('.dropdown-menu').addClass('show');
            e.stopPropagation();
        });

        $('.dropdown').on("hidden.bs.dropdown", function() {
            // hide any open menus when parent closes
            $('.dropdown-menu.show').removeClass('show');
        });
    </script>
@endpush
