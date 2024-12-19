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

        .shadow-text{
            color: #CCCCCC
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

        .table {
            width: 100%;
            clear: both;
            /* margin-bottom: 5px; */
            /* margin-top: 6px !important; */
            /* margin-bottom: 6px !important; */
            border-spacing: 0;
            font-size: 0.5rem;
            align-items: center;
            border: 0.4px solid #000000;
        }
        .table tr th {
            text-transform: uppercase;
            border: 0.3px solid #000000;
            padding: 3px;
            text-align: center;
        }
        .table tr td{
            border: 0.3px solid #000000;
            padding: 3px;
            text-align: center;
        }
    </style>
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
</head>

<body>
    @php $format_date = Carbon\Carbon::now(); @endphp
    <table class="table">
        <tbody>
            <tr>
                <th colspan="2" rowspan="5"><img src="../public/assets/icons/trmitra_logo.png" height="60"></th>
                @if ($value == !null)
                    <th colspan="5">DAFTAR MESIN {{$value}}</th>
                @else
                    <th colspan="5">DAFTAR SEMUA MESIN</th>
                @endif

                <th colspan="3">REVISI DAFTAR MESIN</th>
                <th>DI SETUJUI</th>
                <th>DI KETAHUI</th>
                <th>DI BUAT</th>
            </tr>
            <tr>
                <th colspan="5" rowspan="4"><h2>TAHUN {{ $format_date->format('Y') }} TRIMITRA</h2></th>
                <th>TAHUN</th>
                <th>KETERANGAN</th>
                <th>PIC</th>
                <th rowspan="3"></th>
                <th rowspan="3"></th>
                <th rowspan="3"></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <thead>
            <tr>
                <th>NO.</th>
                <th>NO.INVENT</th>
                <th>NAMA MESIN</th>
                <th>BRAND/MERK</th>
                <th>MODEL/TYPE</th>
                <th>SPEC/TONNAGE</th>
                <th>MFG.NO</th>
                <th>TAHUN PEMBUATAN</th>
                <th>INPUT DAYA/KW</th>
                <th>BUATAN/EX</th>
                <th>INSTALL DATE</th>
                <th>KETERANGAN</th>
                <th>NO.MESIN/LOKASI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($machinedata as $key => $printdata)
                @php $number = $key + 1; @endphp
                <tr style="{{ $printdata->machine_status == false ? 'background-color: #FA5353;' : '' }}">
                    <td width="1%">{{ $number }}</td>
                    <td width="15%">{{ $printdata->invent_number }}</td>
                    <td width="15%">{{ $printdata->machine_name }}</td>
                    <td width="15%">{{ $printdata->machine_brand ?? '-'}}</td>
                    <td width="15%">{{ $printdata->machine_type ?? '-'}}</td>
                    <td width="15%">{{ $printdata->machine_spec ?? '-'}}</td>
                    <td width="15%">{{ $printdata->mfg_number ?? '-'}}</td>
                    <td width="15%">{{ $printdata->production_date ?? '-'}}</td>
                    <td width="15%">{{ $printdata->machine_power ?? '-'}}</td>
                    <td width="15%">{{ $printdata->machine_made ?? '-'}}</td>
                    <td width="15%">{{ $printdata->install_date ?? '-'}}</td>
                    <td width="15%">{{ $printdata->machine_info ?? '-'}}</td>
                    <td width="15%">{{ $printdata->machine_number ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table-text">
        <tbody>
            <tr>
                <td>LD - MTN - 05</td>
            </tr>

        </tbody>
    </table>
    <table class="table-text">
        <thead>
            <tr>
                <th colspan="2"><p>Keterangan :</p></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="1%"><input type="checkbox" style="background-color: #FA5353; color: transparent"></td>
                <td>= Mesin Nonaktif</td>
            </tr>
            <tr>
                <td colspan="2">
                    - Sewaktu-waktu daftar mesin bisa berubah tergantung situasi dan keadaan.
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
