<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Preventive Mesin</title>
    <style>
        body {
            margin: 0;
            font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 0.5em;
            font-weight: 400;
            line-height: 1.5;
            color: #000000;
            /* text-align: center; */
            background-color: #fff;
        }

        .form-header{
            font-size: 1.1em;
            margin: 0px;
        }
        .form-title{
            font-size: 1.4em;
            text-align: center;
            margin: 0px 0px 2px 0px;
        }

        .table-header {
            width: 100%;
            clear: both;
            /* margin-top: 5px !important; */
            /* margin: 4px 0px 4px 0px !important; */
            margin-bottom: 10px;
            border-spacing: 0;
            /* font-size: smaller; */

            border: 0.5px solid #000000;
        }
        .table-header tr th {
            text-transform: uppercase;
            border: 0.5px transparent;
            /* padding: 5px; */
            vertical-align: top;
            text-align: left;
            /* border: 0.5px solid #000000; */
        }
        /* #header-name-control{
            width: 15%;
        }
        #header-value-control{
            width: 30%;
        } */

        .table-input {
            width: 100%;
            clear: both;
            /* margin-top: 5px !important; */
            margin-bottom: 10px;
            border-spacing: 0;
            /* font-size: smaller; */
            border: 0.5px solid #000000;
        }
        .table-input tr th {
            text-transform: uppercase;
            padding: 5px;
            vertical-align: top;
            text-align: left;
            /* border: 0.2px solid #000000; */
        }

        .table-text{
            /* margin-bottom: 5px; */
            width: 100%;
            /* border: 0.5px solid #000000; */
        }
        .table-text tr td{
            /* border: 0.5px solid #000000; */
            text-align: left;
            /* vertical-align: top; */
        }
        .table-text tr th{
            text-transform: uppercase;
            text-align: left;
            /* vertical-align: top; */
        }

        .table-signature{
            clear: both;
            margin: 14px 0px 14px 0px !important;
            /* padding: 0px 0px 4px 0px; */
            width: 100%;
            border-spacing: 0;
            /* font-size: smaller; */
            align-items: center;
            /* border: 0.4px solid #000000; */
        }
        .table-signature tr td{
            border: 0.3px solid #000000;
            border-block: 0.3px, solid #000000;
            padding: 3px;
        }
        .table-signature tr th{
            text-transform: uppercase;
            text-align: center;
            border: 0.3px solid #000000;
            padding: 3px;
        }

        .table {
            width: 100%;
            clear: both;
            /* margin-bottom: 5px; */
            /* margin-top: 6px !important; */
            /* margin-bottom: 6px !important; */
            border-spacing: 0;
            font-size: 0.6rem;
            align-items: center;
            border: 0.4px solid #000000;
        }
        .table tr th {
            text-transform: uppercase;
            border: 0.3px solid #000000;
            padding: 3px;
        }
        .table tr td{
            border: 0.3px solid #000000;
            padding: 3px;
        }

        .form-control {
            width: 100%;
            /* height: calc(1.5em + .75rem + 2px); */
            /* padding: 5px 5px 5px 5px; */
            /* font-weight: 400; */
            line-height: 20px;
            border: 0.5px solid #000000;
            /* border-radius: .35rem; */
        }

        .table-note{
            width: 100%;
            clear: both;
            border-spacing: 0;
            font-size: 0.6rem;
            align-items: center;
            border: 0.4px solid #000000;
        }
        .table-note tr td{
            border: 0.3px solid #000000;
            padding: 3px;
            justify-content: start;
            text-align: left;
        }
        .table-note tr th{
            text-transform: uppercase;
            border: 0.3px solid #000000;
            padding: 3px;
            text-transform: uppercase;
            text-align: center;
        }

        .check-mark{
            display:inline;
            justify-content: center;
            align-content: center;
        }

        .text-area{
            border-color: transparent;
            height: 10%;
        }

        .abnormal-input{
            border-color: transparent;
            height: 5%;
        }

        #hidden-column {
            border: none
        }
    </style>
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
</head>

<body>
    <h3 class="form-header">PT. TRIMITRA CHITRAHASTA</h3>
    <h3 class="form-header">MTC DEPARTMENT</h3>
    <h3 class="form-title">CHECK POINT MESIN</h3>
    <table class="table-header" id="tablePrint">
        <tbody>
            <tr>
                <th id="header-name-control">No. Invent Mesin</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->invent_number }}</th>
                <th id="header-name-control">Spec/Tonage</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->machine_spec }}</th>
            </tr>
            <tr>
                <th id="header-name-control">Nama Mesin</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->machine_name }}</th>
                <th id="header-name-control">Buatan</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->machine_made }}</th>
            </tr>
            <tr>
                <th id="header-name-control">Brand/Merk</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->machine_brand }}</th>
                <th id="header-name-control">Mfg.NO</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->mfg_number }}</th>
            </tr>
            <tr>
                <th id="header-name-control">Model/Type</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->machine_type }}</th>
                <th id="header-name-control">Install Date</th>
                <th>:</th>
                <th id="header-value-control">{{ $machinedata[0]->install_date }}</th>
            </tr>
        </tbody>
    </table>
    @php
        $date = new DateTime($preventivedata[0]->record_date);
        $formattedDate = $date->format('d-m-Y');
    @endphp
    <table class="table-input">
        <tbody>
            <tr>
                <th width="10%">NO. MESIN</th>
                <th width="25%">:</th>
                <th width="25%">{{$machinedata[0]->machine_number}}</th>
                <th width="10%" style="border-left: 0.5px solid #000000">TANGGAL</th>
                <th width="25%">:</th>
                <th width="25%">{{$formattedDate}}</th>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" width="4%">No.</th>
                <th rowspan="2" width="23%">Bagian Yang Dicheck</th>
                <th rowspan="2" width="23%">Standart/Parameter</th>
                <th rowspan="2" width="20%">Metode Pengecekan</th>
                <th rowspan="2" width="16%">Action</th>
                <th rowspan="2" width="14%">Result</th>
            </tr>
            <tr>
            </tr>
        </thead>
        <tbody>
            <?php
            $rowspanData = []; // Menyimpan jumlah kemunculan tiap "Bagian Yang Dicheck";
            // Hitung jumlah kemunculan setiap "Bagian Yang Dicheck"
            foreach ($machinedata as $record) {
                $bagian = $record->name_componencheck;
                if (!isset($rowspanData[$bagian])) {
                    $rowspanData[$bagian] = 0;
                }
                $rowspanData[$bagian]++;
            }

            $printedSection = []; // Untuk melacak apakah "Bagian Yang Dicheck" sudah dicetak
            $number = 1; // Nomor urut

            foreach ($machinedata as $index => $record):
                $bagian = $record->name_componencheck;
                $actions = json_decode($combineresult[0]['operator_action'], true)[$index] ?? [];
                $result = json_decode($combineresult[0]['result'], true)[$index] ?? ''
            ?>
                <tr>
                    <td style="text-align: center;"><?= $number++ ?></td>

                    <?php if (!isset($printedSection[$bagian])): ?>
                        <td rowspan="<?= $rowspanData[$bagian] ?>"><?= $bagian ?></td>
                        <?php $printedSection[$bagian] = true; ?>
                    <?php endif; ?>

                    <td>{{ $record->name_parameter }}</td>
                    <td>{{ $record->name_metodecheck }}</td>
                    <td>{{ implode(' & ', $actions) }}</td>
                    <td>{{ $result }}</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="table-text">
        <tbody>
            <tr>
                <td colspan="5">LD - MTN - 03</td>
            </tr>
        </tbody>
    </table>
    <table class="table-note">
        <tbody>
            <tr>
                <th colspan="5">keterangan :</th>
            </tr>
            <tr>
                <td colspan="5">
                    <textarea class="text-area">{{$preventivedata[0]->note}}</textarea>
                </td>
            </tr>
            <tr>
                <th>Masalah :</th>
                <th>Penyebab :</th>
                <th>Tindakan :</th>
                <th>Status :</th>
                <th>Target :</th>
            </tr>
            <tr>
                <td width="20%">
                    <textarea class="abnormal-input" type="text">{{ $preventivedata[0]->problem }}</textarea>
                </td>
                <td width="20%">
                    <textarea class="abnormal-input" type="text">{{ $preventivedata[0]->cause }}</textarea>
                </td>
                <td width="20%">
                    <textarea class="abnormal-input" type="text">{{ $preventivedata[0]->action }}</textarea>
                </td>
                <td width="20%">
                    <textarea class="abnormal-input" type="text">{{ $preventivedata[0]->status }}</textarea>
                </td>
                <td width="20%">
                    <textarea class="abnormal-input" type="text">{{ $preventivedata[0]->target }}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table-signature">
        <tbody>
            <tr>
                <th width="55%" id="hidden-column"></th>
                <th>Disetujui</th>
                <th>Dikoreksi</th>
                <th>Dibuat</th>
            </tr>
            <tr>
                <td height="4%" id="hidden-column"></td>
                <th height="4%">{{ 'Signed By ' . ($preventivedata[0]->approve_by_name ?? 'Belum Ada') }}</th>
                <th height="4%">{{ 'Signed By ' . ($preventivedata[0]->correct_by_name ?? 'Belum Ada') }}</th>
                <th height="4%">Signed By Operator</th>
            </tr>
            <tr>
                <td width="55%" id="hidden-column"></td>
                <th>{{$preventivedata[0]->approve_by_name}}</th>
                <th>{{$preventivedata[0]->correct_by_name}}</th>
                <th>@foreach ($usernames as $get_user_id)
                    {{$get_user_id}},
                @endforeach</th>
            </tr>
        </tbody>
    </table>
</body>
</html>
