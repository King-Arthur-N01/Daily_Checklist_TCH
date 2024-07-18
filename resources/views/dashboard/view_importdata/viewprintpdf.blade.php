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

        .form-header{
            color: #000000;
            font-size: 1.1em;
        }
        .form-title{
            color: #000000;
            font-size: 1.4em;
            text-align: center;
        }

        .table-header {
            width: 100%;
            clear: both;
            /* margin-top: 5px !important; */
            /* margin: 4px 0px 4px 0px !important; */
            max-width: none !important;
            border-spacing: 0;
            font-size: smaller;

            border: 0.5px solid #000000;
            color: #282828;
        }
        .table-header tr th {
            text-transform: uppercase;
            border: 0.5px transparent;
            /* padding: 5px; */
            vertical-align: top;
            text-align: left;
            /* border: 0.5px solid #000000; */
        }

        .table-input {
            width: 100%;
            clear: both;
            /* margin-top: 5px !important; */
            margin: 4px 0px 4px 0px !important;
            max-width: none !important;
            border-spacing: 0;
            font-size: smaller;
            border: 0.3px solid #000000;
            color: #282828;
        }
        .table-input tr th {
            text-transform: uppercase;
            padding: 5px;
            vertical-align: top;
            text-align: left;
            border: 0.2px solid #000000;
        }

        .table-text{
            padding: 0px 0px 4px 0px;
            width: 100%;
            color: #000000;
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
            color: #000000;
            max-width: none !important;
            border-spacing: 0;
            font-size: smaller;
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
            margin: 14px 0px 14px 0px !important;
            /* margin-top: 6px !important; */
            /* margin-bottom: 6px !important; */
            max-width: none !important;
            border-spacing: 0;
            font-size: smaller;
            align-items: center;
            border: 0.4px solid #000000;
            color: #000000;
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
        .textarea-control{
            height: 150px;
        }

        #hidden-column {
            border: none
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
    <table class="table-input">
        <tbody>
            <tr>
                <th>NO. MESIN :</th>
                <th>TANGGAL :</th>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th width="5%" rowspan="2">No.</th>
                <th width="23%" rowspan="2">Bagian Yang Dicheck</th>
                <th width="23%" rowspan="2">Standart/Parameter</th>
                <th width="20%" rowspan="2">Metode Pengecekan</th>
                <th width="15%" colspan="4">Action</th>
                <th width="12%" rowspan="2">Result</th>
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
                    <td>1</td>
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
    <table class="table-text">
        <tbody>
            <tr>
                <td colspan="5">LD - MTN - 03</td>
            </tr>
            <tr>
                <td width="15%"></td>
                <th width="25%" colspan="2">Action :</th>
                <th width="15%"></th>
                <th width="20%">Result :</th>
            </tr>
            <tr>
                <td></td>
                <td> ✓ = Check</td>
                <td> ✓ = Adjust</td>
                <td></td>
                <td>O = Oke</td>
            </tr>
            <tr>
                <td></td>
                <td> ✓ = Cleaning</td>
                <td> ✓ = Replace/ganti</td>
                <td></td>
                <td>X = ng</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <tbody>
            <tr>
                <th>keterangan :</th>
            </tr>
            <tr>
                <th height="15%"></th>
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
                <td height="5%" id="hidden-column"></td>
                <td height="5%"></td>
                <td height="5%"></td>
                <td height="5%"></td>
            </tr>
            <tr>
                <td width="55%" id="hidden-column"></td>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </tbody>
    </table>
</body>

</html>
