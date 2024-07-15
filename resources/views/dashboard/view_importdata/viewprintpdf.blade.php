<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Preventive Mesin</title>
    <table class="table table-bordered" id="dataTables" width="100%">
        <thead>
            <tr>
                <th>Nama Mesin</th>
                <th>Bagian Yang Dicheck</th>
                <th>Standart/Parameter</th>
                <th>Metode Pengecekan</th>
                <th>Action</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($machinedata as $row)
                <tr>
                    <td>{{ $row['machine_name'] }}</td>
                    <td>{{ $row['name_componencheck'] }}</td>
                    <td>{{ $row['name_parameter'] }}</td>
                    <td>{{ $row['name_metodecheck'] }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</html>
