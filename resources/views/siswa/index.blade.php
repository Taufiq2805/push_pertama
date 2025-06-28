<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <center>
        <h1>Data Siswa</h1>
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <a href="{{ route('siswa.create') }}">Tambah Siswa</a>
        
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Aksi</th> {{-- Ganti dari Alamat ke Aksi --}}
            </tr>
            @forelse($siswa as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['kelas'] }}</td>
                    <td>
                        <a href="{{ route('siswa.edit', $item['id']) }}">Edit</a> |
                        <form action="{{ route('siswa.destroy', $item['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus siswa ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data siswa.</td>
                </tr>
            @endforelse
        </table>
    </center>
</body>
</html>
