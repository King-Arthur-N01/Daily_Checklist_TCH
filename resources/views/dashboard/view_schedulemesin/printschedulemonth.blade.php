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
    <table class="table">
        <thead>
            <tr>
                <th colspan="2" rowspan="5"><img src="../public/assets/icons/trmitra_logo.png" height="70"></th>
                <th colspan="4">INFORMASI PREV.MTC.MACHINE</th>
                <td>DI SETUJUI</td>
                <td colspan="2">DI KETAHUI</td>
                <td>DI BUAT</td>
            </tr>
            <tr>
                {{-- <th></th> --}}
                <th colspan="4" rowspan="4"><h2>{{ $scheduledata[0]->name_schedule_month}}</h2></th>
                <th rowspan="2"></th>
                <th rowspan="2" colspan="2"></th>
                <th rowspan="2"></th>
            </tr>
            <tr>

            </tr>
            <tr>
                {{-- <th colspan="2"></th> --}}
                {{-- <th colspan="4"></th> --}}
                <th></th>
                <th colspan="2"></th>
                <th></th>
            </tr>
            <tr>
                {{-- <th colspan="2"></th> --}}
                {{-- <th colspan="4"></th> --}}
                <td>MNG. MTN</td>
                <td colspan="2"> AST. MGR</td>
                <td>SPV. MTN</td>
            </tr>
            <tr>
                <th rowspan="2">NO.</th>
                <th rowspan="2">NAMA MESIN</th>
                <th rowspan="2">NO. INVENT</th>
                <th rowspan="2">KAPASITAS</th>
                <th rowspan="2">NO. MESIN</th>
                <th rowspan="2">DURASI</th>
                <th>RENCANA</th>
                <th colspan="2">KESEDIAAN</th>
                <th>PARAF/OKE</th>
            </tr>
            <tr>
                {{-- <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th> --}}
                <th>TGL</th>
                <th>TGL</th>
                <th>JAM</th>
                <th>(PPC)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scheduledata as $key => $printdata)
            @for ($number=0; $number<=$key; $number ++)
            @endfor
                <tr>
                    <td width="2%">{{ $number }}</td>
                    <td width="25%">{{ $printdata->machine_name }}</td>
                    <td width="15%">{{ $printdata->invent_number }}</td>
                    <td width="15%">{{ $printdata->machine_spec }}</td>
                    <td width="15%">{{ $printdata->machine_number }}</td>
                    <td width="15%">{{ $printdata->schedule_duration }}</td>
                    <td width="20%">
                        @php $format_date = Carbon\Carbon::parse($printdata->schedule_date)->format('d-F-Y'); @endphp
                        {{$format_date}}
                    </td>
                    <td width="10%"></td>
                    <td width="10%"></td>
                    <td width="20%"></td>
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
                <th><p>Keterangan :</p></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    - Pada saat waktu preventive maintenance mesin dilaksanakan, kami harap sebelum nya mesin dalam keadaan tidak dioperasikan/tidak ada SPK
                    <br>- Atas perhatian dan kerja sama nya kami ucapkan terimakasih.
                    <br>- Untuk jam pelaksanaan preventive harus diisi departement PPC
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
