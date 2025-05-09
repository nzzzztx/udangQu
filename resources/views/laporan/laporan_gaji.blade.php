<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td {
            text-align: left;
        }

        .total {
            font-weight: bold;
            margin-top: 30px;
            text-align: right;
        }

        .total-gaji {
            font-size: 18px;
        }
    </style>
</head>
<body>

    <h1>Laporan Gaji</h1>

    <h2>Rekap Gaji Per Karyawan</h2>
    
    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Bulan</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gajiPerKaryawan as $karyawan => $bulanData)
                @foreach($bulanData as $bulan => $gaji)
                    <tr>
                        <td>{{ $karyawan }}</td>
                        <td>{{ $bulan }}</td>
                        <td style="text-align: right;">Rp {{ number_format($gaji, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <h3 class="total">
        Total Gaji Keseluruhan: 
        <span class="total-gaji">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</span>
    </h3>

</body>
</html>
