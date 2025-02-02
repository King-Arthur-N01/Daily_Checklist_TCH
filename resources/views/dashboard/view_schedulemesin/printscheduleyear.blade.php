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
        <tbody>
            <tr>
                <th colspan="2" rowspan="4"><img src="../public/assets/icons/trmitra_logo.png" height="70"></th>
                <th colspan="11"><h1>SCHEDULE PREVENTIVE MAINTENANCE MESIN</h1></th>
                <td colspan="2"><h3>DI SETUJUI</h3></td>
                <td colspan="2"><h3>DI KETAHUI</h3></td>
                <td colspan="2"><h3>DI BUAT</h3></td>
            </tr>
            <tr>
                {{-- <th></th> --}}
                <th colspan="11" rowspan="3"><h2>{{ $scheduledata[0]->name_schedule_year}}</h2></th>
                <th colspan="2" rowspan="2"></th>
                <th colspan="2" rowspan="2"></th>
                <th colspan="2" rowspan="2"></th>
            </tr>
            <tr>

            </tr>
            <tr>
                {{-- <th colspan="2"></th> --}}
                {{-- <th colspan="4"></th> --}}
                <td colspan="2">{{ $user_agreed_name }}</td>
                <td colspan="2">{{ $user_recognize_name}}</td>
                <td colspan="2">{{ $user_create_name}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" width="1%">NO.</th>
                <th rowspan="2" width="10%">NO.INVENTARIS</th>
                <th rowspan="2" width="10%">NAMA MESIN</th>
                <th rowspan="2" width="6%">BRAND/MERK</th>
                <th rowspan="2" width="6%">LOKASI/NO.MESIN</th>
                <th rowspan="2" width="2%">P/A</th>
                <th rowspan="2" width="5%">JANUARY</th>
                <th rowspan="2" width="5%">FEBRUARI</th>
                <th rowspan="2" width="5%">MARET</th>
                <th rowspan="2" width="5%">APRIL</th>
                <th rowspan="2" width="5%">MEI</th>
                <th rowspan="2" width="5%">JUNI</th>
                <th rowspan="2" width="5%">JULY</th>
                <th rowspan="2" width="5%">AGUSTUS</th>
                <th rowspan="2" width="5%">SEPTEMBER</th>
                <th rowspan="2" width="5%">OKTOBER</th>
                <th rowspan="2" width="5%">NOVEMBER</th>
                <th rowspan="2" width="5%">DESEMBER</th>
                <th rowspan="2" width="5%">KETERANGAN</th>
            </tr>
            <tr>

            </tr>
        </thead>
        <tbody>
            @foreach ($scheduledata as $key => $printdata1)
                @php
                    $printdata2 = $recorddata->firstWhere('machine_schedule_id', $printdata1->schedule_id);
                    $schedule_start = Carbon\Carbon::parse($printdata1->schedule_start);
                    $schedule_end = Carbon\Carbon::parse($printdata1->schedule_end);
                    $month = $schedule_start->month;
                @endphp
                <tr>
                    <td rowspan="2">{{ $key + 1 }}</td>
                    <td rowspan="2">{{ $printdata1->invent_number }}</td>
                    <td rowspan="2">{{ $printdata1->machine_name }}</td>
                    <td rowspan="2">{{ $printdata1->machine_brand }}</td>
                    <td rowspan="2">{{ $printdata1->machine_number }}</td>
                    <td>P</td>
                    @for ($i = 1; $i <= 12; $i++)
                        <td style="{{ $month === $i ? 'background-color: #53CCF8' : '' }}">
                            @if ($month === $i)
                                {{ $schedule_start->format('d') }} - {{ $schedule_end->format('d-F') }}
                            @endif
                        </td>
                    @endfor
                    <td></td>
                </tr>
                <tr>
                    <td>A</td>
                    @if ($printdata2)
                        @php
                            $record_date = Carbon\Carbon::parse($printdata2->record_date);
                            $record_month = $record_date->month;
                        @endphp
                        @for ($i = 1; $i <= 12; $i++)
                            <td style="{{ $record_month === $i ? 'background-color: #fcff40' : '' }}">
                                @if ($record_month === $i)
                                    {{ $record_date->format('d-F') }}
                                @endif
                            </td>
                        @endfor
                    @else
                        {{-- Jika tidak ada record terkait, tampilkan sel kosong --}}
                        @for ($i = 1; $i <= 12; $i++)
                            <td></td>
                        @endfor
                    @endif
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table-text">
        <tbody>
            <tr>
                <td>LD - MTN - 02</td>
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
                <td width="2%"><input type="checkbox" style="background-color: #53CCF8; color: transparent"></td>
                <td>= PLANT</td>
            </tr>
            <tr>
                <td width="2%"><input type="checkbox" style="background-color: #fcff40; color: transparent"></td>
                <td>= ACTUAL</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
