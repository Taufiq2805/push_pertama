<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>Data Ortu</h1>
    <table border="1">
        <tr>
            <th>Nama Ortu</th>
            <th>Jeni Kelamin</th>
            <th>Telepon</th>
        </tr>
        @foreach($ortu as $data)
        <tr>
            <td>{{ $data['nama_ortu']}}</td>
            <td>{{ $data['jenis_kelamin']}}</td>
            <td>{{ $data['telepon']}}</td>
        </tr>
        @endforeach
    </table>
    </center>
</body>
</html>