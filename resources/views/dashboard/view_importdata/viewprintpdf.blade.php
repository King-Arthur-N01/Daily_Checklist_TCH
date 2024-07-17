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
            color: #858796;
            /* text-align: center; */
            background-color: #fff;
        }
        .col-1 {
            flex: 0 0 8.33333%;
            max-width: 8.33333%
        }

        .col-2 {
            flex: 0 0 16.66667%;
            max-width: 16.66667%
        }

        .col-3 {
            flex: 0 0 25%;
            max-width: 25%
        }

        .col-4 {
            flex: 0 0 33.33333%;
            max-width: 33.33333%
        }

        .col-5 {
            flex: 0 0 41.66667%;
            max-width: 41.66667%
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%
        }

        .col-7 {
            flex: 0 0 58.33333%;
            max-width: 58.33333%
        }

        .col-8 {
            flex: 0 0 66.66667%;
            max-width: 66.66667%
        }

        .col-9 {
            flex: 0 0 75%;
            max-width: 75%
        }

        .col-10 {
            flex: 0 0 83.33333%;
            max-width: 83.33333%
        }

        .col-11 {
            flex: 0 0 91.66667%;
            max-width: 91.66667%
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%
        }

        .form-header{
            color: #000000;
            font-size: 1.1em;
        }
        .form-title{
            color: #000000;
            font-size: 1.4em;
            text-align: center;
        }

        .header-input{
            display: flex;
            flex-wrap: wrap;
        }

        .table-header {
            width: 100%;
            clear: both;
            margin-top: 6px !important;
            margin-bottom: 6px !important;
            max-width: none !important;
            border-collapse: separate !important;
            border-spacing: 0;
            font-size: smaller;

            border: 0.5px solid #000000;
            color: #282828;
        }
        .table-header tr th {
            text-transform: uppercase;
            border: 0.5px transparent;
            padding: 5px;
            vertical-align: top;
            text-align: left;
            /* border: 0.5px solid #000000; */
        }

        .table {
            width: 100%;
            clear: both;
            margin-top: 6px !important;
            margin-bottom: 6px !important;
            max-width: none !important;
            border-collapse: separate !important;
            border-spacing: 0;
            font-size: smaller;
            border: 0.5px solid #000000;
            color: #282828;
        }
        .table tr th {
            text-transform: uppercase;
            border: 0.5px solid #000000;
            padding: 5px;
            vertical-align: top;
        }
        .table tr td{
            border: 0.5px solid #000000;
            padding: 5px;
            vertical-align: top;
        }
        .form-control {
            width: 100%;
            /* height: calc(1.5em + .75rem + 2px); */
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            border: 0.5px solid #000000;
            /* border-radius: .35rem; */
        }
        .form-custom{
            width: 100%;
            line-height: 1.5;
            padding: .375rem .75rem;
        }
    </style>
</head>

<body>
    <h3 class="form-header">PT. TRIMITRA CHITRAHASTA</h3>
    <h3 class="form-header">MTC DEPARTMENT</h3>
    <h3 class="form-title">Check Point Mesin</h3>
    <table class="table-header">
        <tbody>
            <tr>
                <th>No. Invent Mesin</th>
                <th>:</th>
                <th>{{ $machinedata[0]->invent_number }}</th>
                <th>Spec/Tonage</th>
                <th>:</th>
                <th>{{ $machinedata[0]->machine_spec }}</th>
            </tr>
            <tr>
                <th>Nama Mesin</th>
                <th>:</th>
                <th>{{ $machinedata[0]->machine_name }}</th>
                <th>Buatan</th>
                <th>:</th>
                <th>{{ $machinedata[0]->machine_made }}</th>
            </tr>
            <tr>
                <th>Brand/Merk</th>
                <th>:</th>
                <th>{{ $machinedata[0]->machine_brand }}</th>
                <th>Mfg.NO</th>
                <th>:</th>
                <th>{{ $machinedata[0]->mfg_number }}</th>
            </tr>
            <tr>
                <th>Model/Type</th>
                <th>:</th>
                <th>{{ $machinedata[0]->machine_type }}</th>
                <th>Install Date</th>
                <th>:</th>
                <th>{{ $machinedata[0]->install_date }}</th>
            </tr>
        </tbody>
    </table>
    <table class="table-header">
        <tbody>
            <tr>
                <th>NO.MESIN :</th>
                <th><input class="form-custom"></th>
                <th>TANGGAL :</th>
                <th><input class="form-custom"></th>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">Nama Mesin</th>
                <th rowspan="2">Bagian Yang Dicheck</th>
                <th rowspan="2">Standart/Parameter</th>
                <th rowspan="2">Metode Pengecekan</th>
                <th colspan="4">Action</th>
                <th rowspan="2">Result</th>
            </tr>
            <tr>
                <th>ch</th>
                <th>cl</th>
                <th>adj</th>
                <th>rep</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($machinedata as $key => $recordsget)
                <tr>
                    <td>{{ $recordsget->machine_name }}</td>
                    <td>{{ $recordsget->name_componencheck }}</td>
                    <td>{{ $recordsget->name_parameter }}</td>
                    <td>{{ $recordsget->name_metodecheck }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
        <textarea class="form-control" id="input_note" type="text" name="note" placeholder="Catatan bila diperlukan!"rows="6" cols="50"></textarea>
    </div>
</body>

</html>
