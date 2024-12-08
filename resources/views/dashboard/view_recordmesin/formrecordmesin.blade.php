@extends('layouts.master')
@section('title', 'Preventive mesin')

@section('content')
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Table Checklist</h1>
            <div class="card shadow mt-4 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
                    <div id="errorMessages"></div>
                    <div class="table-responsive">
                        <form action="{{ route('addrecord') }}" id="registerform" method="post">
                            @csrf
                            @method('post')
                            <table class="table table-header">
                                <tbody>
                                    <tr>
                                        <th>No. Invent Mesin :</th>
                                        <th>{{ $joinmachine[0]->invent_number }}</th>
                                        <th>Spec/Tonage :</th>
                                        <th>{{ $joinmachine[0]->machine_spec }}</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Mesin :</th>
                                        <th>{{ $joinmachine[0]->machine_name }}</th>
                                        <th>Buatan :</th>
                                        <th>{{ $joinmachine[0]->machine_made }}</th>
                                    </tr>
                                    <tr>
                                        <th>Brand/Merk :</th>
                                        <th>{{ $joinmachine[0]->machine_brand }}</th>
                                        <th>Mfg.NO :</th>
                                        <th>{{ $joinmachine[0]->mfg_number }}</th>
                                    </tr>
                                    <tr>
                                        <th>Model/Type :</th>
                                        <th>{{ $joinmachine[0]->machine_type }}</th>
                                        <th>Install Date :</th>
                                        <th>{{ $joinmachine[0]->install_date }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="header-input">
                                <div class="col-6">
                                    <a>NO.MESIN :</a>
                                    <input class="form-control" type="int" id="machine_number" value="{{ $joinmachine[0]->machine_number }}" placeholder="Nomor Mesin" readonly>
                                </div>
                                <div class="col-6">
                                    <a>WAKTU PREVENTIVE :</a>
                                    <input class="form-control" name="record_date" value="{{ $timenow->format('Y-m-d') }}" readonly>
                                </div>
                            </div>
                            <table class="table table-bordered" id="dataTables" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Bagian Yang Dicheck</th>
                                        <th>Standart/Parameter</th>
                                        <th>Metode Pengecekan</th>
                                        <th>Action</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($joinmachine as $key => $recordsget)
                                        @for ($number=0; $number<=$key; $number ++)
                                        @endfor
                                        <tr>
                                            <td>{{ $number }}</td>
                                            <td>{{ $recordsget->name_componencheck }}</td>
                                            <td>{{ $recordsget->name_parameter }}</td>
                                            <td>{{ $recordsget->name_metodecheck }}</td>
                                            <td>
                                                <div id="select-style-checkbox" style="display: flex; justify-content: center;">
                                                    <div class="option btn-option">
                                                        <label for="option1">check</label>
                                                        <input type="checkbox" name="operator_action[{{ $key }}][]" value="check" id="option1">
                                                    </div>
                                                    <div class="option btn-option">
                                                        <label for="option2">cleaning</label>
                                                        <input type="checkbox" name="operator_action[{{ $key }}][]" value="cleaning" id="option2">
                                                    </div>
                                                    <div class="option btn-option">
                                                        <label for="option3">adjust</label>
                                                        <input type="checkbox" name="operator_action[{{ $key }}][]" value="adjust" id="option3">
                                                    </div>
                                                    <div class="option btn-option">
                                                        <label for="option4">replace</label>
                                                        <input type="checkbox" name="operator_action[{{ $key }}][]" value="replace" id="option4">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <select name="result[{{ $key }}]" id="result[{{ $key }}]" required>
                                                        <option label="Result" disabled selected></option>
                                                        <option value="custom">Others</option>
                                                        <option value="OK">OK</option>
                                                        <option value="NG">NG</option>
                                                    </select>
                                                    <input class="custom-input-option" type="text" id="custom_input_{{ $key }}" placeholder="Enter your own result"/>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-custom">
                                <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
                                <textarea class="form-control" id="input_note" type="text" name="note" placeholder="Catatan bila diperlukan!" rows="6" cols="50"></textarea>
                                <input type="hidden" name="id_schedule" value="{{ $machine_id }}">
                                <input type="hidden" name="combined_create_by[]" id="combined_create_by">
                                <input type="hidden" name="combined_abnormal[]" id="combined_abnormal_value">
                            </div>
                            <div class="form-custom">
                                <label>Opsi jika terdapat abnormal terhadap preventive</label>
                                <div class="switch-container">
                                    <label>Abnormal</label>
                                    <div class="custom-radio">
                                        <input type="radio" id="yes" name="option">
                                        <label for="yes" class="yes-label">Iya</label>
                                        <input type="radio" id="no" name="option" checked>
                                        <label for="no" class="no-label">Tidak</label>
                                    </div>
                                </div>
                                <select class="form-control select2" id="abnormality" multiple="multiple" disabled>
                                    @foreach ($getcomponen as $listcomponen)
                                        <option value="{{ $listcomponen->id }}">{{ $listcomponen->name_componencheck }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-custom">
                                <table class="table table-bordered" id="userTables">
                                    <thead>
                                        <tr>
                                            <th>PIC 1 :</th>
                                            <th>PIC 2 :</th>
                                            <th>PIC 3 :</th>
                                            <th>PIC 4 :</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-control select2-no-search" id="create_by_1" readonly>
                                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control select2" id="create_by_2">
                                                    <option value="0" selected="selected">Tidak ada</option>
                                                    @foreach ($users as $getuser)
                                                        <option value="{{ $getuser->id }}">{{ $getuser->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control select2" id="create_by_3">
                                                    <option value="0" selected="selected">Tidak ada</option>
                                                    @foreach ($users as $getuser)
                                                        <option value="{{ $getuser->id }}">{{ $getuser->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control select2" id="create_by_4">
                                                    <option value="0" selected="selected">Tidak ada</option>
                                                    @foreach ($users as $getuser)
                                                        <option value="{{ $getuser->id }}">{{ $getuser->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="column-button">
                                <button type="submit" class="form-buttons">Submit</button>
                            </div>
                        </form>
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
    <script src="{{ asset('assets/vendor/custom-js/mergecell.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/formalert.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/select-radiobox.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/custom-js/multi-input-user.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $('.select2').select2({
                placeholder: 'Select :',
                searchInputPlaceholder: 'Search'
            });

            // Initialize Select2 for abnormality selection
            $('#abnormality').select2();

            // Event listener for abnormality select changes
            $('#abnormality').on('change', function() {
                var selectedValues = $(this).val();
                $('#combined_abnormal_value').val(selectedValues);
            });

            document.querySelectorAll('select[name^="result"]').forEach(select => {
                select.addEventListener("change", function () {
                    const key = this.id.match(/\d+/)[0]; // Mendapatkan kunci dari id
                    const customInput = document.getElementById(`custom_input_${key}`);
                    if (this.value === 'custom') {
                        customInput.style.display = 'block';
                        customInput.required = true;
                    } else {
                        customInput.style.display = 'none';
                        customInput.required = false;
                    }
                    customInput.removeEventListener("change", handleCustomInputChange);
                    customInput.addEventListener("change", handleCustomInputChange);
                });
            });

            function handleCustomInputChange(event) {
                const customInput = event.target;
                const key = customInput.id.match(/\d+/)[0];
                const select = document.getElementById(`result[${key}]`);

                // Cek apakah opsi sudah ada
                const existingOption = Array.from(select.options).find(
                    option => option.value === customInput.value
                );
                if (!existingOption) {
                    const newOption = document.createElement("option");
                    newOption.text = customInput.value;
                    newOption.value = customInput.value;
                    select.add(newOption, select.options[select.selectedIndex]);
                }
                select.value = customInput.value;
            }

            // Enable/Disable abnormality select based on the switch
            $('input[name="option"]').on('change', function() {
                if ($(this).attr('id') === 'yes') {
                    $('#abnormality').prop('disabled', false);
                } else {
                    $('#abnormality').prop('disabled', true).val(null).trigger('change');
                    $('#combined_abnormal_value').val('');
                }
            });
            combineCreateByUsers();
            disableDoubleSelectUsers()
            mergeCells();
        });
    </script>
@endpush
