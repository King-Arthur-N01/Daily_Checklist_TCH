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
                <th colspan="2" rowspan="4"><img src="../public/assets/icons/trmitra_logo.png" height="70"></th>
                <th colspan="4">INFORMASI PREV.MTC.MACHINE</th>
                <td>DI SETUJUI</td>
                <td>DI KETAHUI</td>
                <td>DI BUAT</td>
            </tr>
            <tr>
                <th colspan="4" rowspan="3"><h2>{{ $scheduledata[0]->name_schedule_month }}</h2></th>
                <th rowspan="2">{{ 'Signed By ' . ($user_agreed_name ?? 'Belum Ada') }}</th>
                <th rowspan="2">{{ 'Signed By ' . ($user_recognize_name ?? 'Belum Ada') }}</th>
                <th rowspan="2">{{ 'Signed By ' . ($user_create_name ?? 'Belum Ada') }}</th>
            </tr>
            <tr></tr>
            <tr>
                <td>{{ $user_agreed_name}}</td>
                <td>{{ $user_recognize_name}}</td>
                <td>{{ $user_create_name}}</td>

            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
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
                <th>TGL</th>
                <th>TGL</th>
                <th>JAM</th>
                <th>(PPC)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scheduledata as $key => $printdata)
                @php
                    $machineHourData = $workinghourdata->firstWhere('id', $printdata->standart_id);
                    $machineHour = $machineHourData ? $machineHourData->preventive_hour : '0';
                    $reschedule_pm = null;
                    $scheduleHour = json_decode($printdata->schedule_hour, true); // Menggunakan json_decode untuk mengubah string menjadi array
                    $startTime = is_array($scheduleHour) && count($scheduleHour) > 0 ? $scheduleHour[0] : 'Belum ada';
                    $endTime = is_array($scheduleHour) && count($scheduleHour) > 1 ? $scheduleHour[1] : 'Belum ada';

                    // Mengambil tanggal reschedule yang valid
                    if ($printdata->reschedule_date_3) {
                        $reschedule_pm = $printdata->reschedule_date_3;
                    } elseif ($printdata->reschedule_date_2) {
                        $reschedule_pm = $printdata->reschedule_date_2;
                    } elseif ($printdata->reschedule_date_1) {
                        $reschedule_pm = $printdata->reschedule_date_1;
                    }
                @endphp
                <tr>
                    <td width="2%">{{ $key + 1 }}</td> <!-- Menggunakan $key + 1 untuk nomor urut -->
                    <td width="25%">{{ $printdata->machine_name }}</td>
                    <td width="15%">{{ $printdata->invent_number }}</td>
                    <td width="15%">{{ $printdata->machine_spec }}</td>
                    <td width="15%">{{ $printdata->machine_number }}</td>
                    <td width="15%">{{ $machineHour }} Jam</td>
                    <td width="20%">
                        @php $schedule_date = Carbon\Carbon::parse($printdata->schedule_date)->format('d-F-Y'); @endphp
                        {{ $schedule_date }}
                    </td>
                    <td width="10%">
                        @php
                            $reschedule_date = $reschedule_pm ? Carbon\Carbon::parse($reschedule_pm)->format('d-F-Y') : 'Sesuai';
                            if ($printdata->schedule_planner) {
                                $reschedule_date = $reschedule_pm ? Carbon\Carbon::parse($reschedule_pm)->format('d-F-Y') : 'Sesuai';
                            } else {
                                $reschedule_date = $reschedule_pm ? Carbon\Carbon::parse($reschedule_pm)->format('d-F-Y') : 'Belum ada';
                            }
                        @endphp
                        {{ $reschedule_date }}
                    </td>
                    <td width="10%">
                        {{ $startTime }}-{{ $endTime }}
                    </td>
                    <td width="20%">{{ $printdata->reschedule_note ?? ($user_planner_name) }}</td>
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
