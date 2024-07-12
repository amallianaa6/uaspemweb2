<!DOCTYPE html>
<html>
<head>
    <title>TOPSIS - Klinik Skincare</title>
</head>
<body>
    <h1>Hasil Perhitungan TOPSIS</h1>
    <table border="10">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Klinik</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ranked as $index => $klinik)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $klinik['name'] }}</td>
                    <td>{{ $klinik['score'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
