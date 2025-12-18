<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Wilayah - Desa Tegalsambi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #2563eb;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA KEPENDUDUKAN</h1>
        <h2>Desa Tegalsambi, Kecamatan Tahunan, Kabupaten Jepara</h2>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tingkat</th>
                <th>Nama Wilayah</th>
                <th>KK</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wilayahs->sortBy('nama') as $index => $wilayah)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ strtoupper($wilayah->tingkat) }}</td>
                    <td><strong>{{ $wilayah->nama }}</strong></td>
                    <td>{{ number_format($wilayah->kk) }}</td>
                    <td>{{ number_format($wilayah->l) }}</td>
                    <td>{{ number_format($wilayah->p) }}</td>
                    <td>{{ number_format($wilayah->l + $wilayah->p) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #e5e7eb; font-weight: bold;">
                <td colspan="3">TOTAL</td>
                <td>{{ number_format($wilayahs->sum('kk')) }}</td>
                <td>{{ number_format($wilayahs->sum('l')) }}</td>
                <td>{{ number_format($wilayahs->sum('p')) }}</td>
                <td>{{ number_format($wilayahs->sum('l') + $wilayahs->sum('p')) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak dari WebGIS Desa Tegalsambi</p>
        <p>© 2025 Sistem Informasi Geografis</p>
    </div>
</body>

</html>