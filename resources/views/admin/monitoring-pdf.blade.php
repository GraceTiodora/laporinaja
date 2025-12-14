<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring & Statistik</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f1f5f9; }
        h2 { margin-top: 24px; }
    </style>
</head>
<body>
    <h1>Laporan Monitoring & Statistik</h1>
    <h2>Daftar Laporan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Pelapor</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $r)
            <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->title }}</td>
                <td>{{ $r->category->name ?? '-' }}</td>
                <td>{{ $r->status }}</td>
                <td>{{ $r->user->name ?? '-' }}</td>
                <td>{{ $r->created_at ? $r->created_at->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Statistik Per Kategori</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Total Laporan</th>
                <th>Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataKategori as $cat)
            <tr>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->total ?? 0 }}</td>
                <td>{{ $cat->selesai ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>