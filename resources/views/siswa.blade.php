<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>Data Siswa</h1>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jeni Kelamin</th>
            <th>Alamat</th>
        </tr>
        @foreach($siswa as $data)
        <tr>
            <td>{{ $data['nama']}}</td>
            <td>{{ $data['kelas']}}</td>
            <td>{{ $data['jenis_kelamin']}}</td>
            <td>{{ $data['alamat']}}</td>
        </tr>
        @endforeach
    </table>
    </center>
</body>
</html>