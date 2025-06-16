{{-- <!DOCTYPE html>
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


    <table class="details">
        <tr>
            <td class="label">Kode</td>
            <td>: 11</td>
            <td class="label right">Periode</td>
            <td>: January 2009</td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td>: Hani Hadiyanti</td>
            <td class="label right">No Reff</td>
            <td>: 000000011</td>
        </tr>
        <tr>
            <td class="label">Departemen</td>
            <td>: Head Quarter</td>
            <td class="label right">Jabatan</td>
            <td>: Staff</td>
        </tr>
    </table>

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
</html> --}}

@php
    $bulanIndo = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
@endphp


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji Sederhana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: navy;
        }

        .subtitle {
            font-size: 18px;
            font-weight: bold;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0;
        }

        .table-info, .table-salary {
            width: 100%;
            margin-top: 10px;
        }

        .table-info td {
            padding: 4px;
            vertical-align: top;
        }

        .table-salary td {
            padding: 3px 8px;
        }

        .right {
            text-align: right;
        }

        .signature {
            margin-top: 30px;
        }

        .signature td {
            padding-top: 20px;
        }

        .bold {
            font-weight: bold;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="center title">Slip Gaji Sederhana</div>
    <div class="center subtitle">UdangQu</div>

    <div class="line"></div>

    <table class="table-info">
        <tr>
            <td width="60">Nama</td>
            <td>:</td>
            <td>{{ $data->nama }}</td>

            <td class="right">Periode</td>
            <td class="right" width="5">:</td>
            <td class="right" width="60">{{ $bulanIndo[$data->bulan] ?? '-' }} {{ $data->tahun }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                @if($data->jenis_kelamin === 'Laki-laki' || $data->jenis_kelamin === 'L')
                    Laki-laki
                @else
                    Perempuan
                @endif
            </td>

            {{-- <td class="right">No Reff</td>
            <td>:</td>
            <td>000000011</td> --}}
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="4">
                {{ $data->alamat_karyawan }}
            </td>
        </tr>
    </table>


    <br>

    <table class="table-salary">
        <tr>
            {{-- <td>Sistem Pembayaran : Transfer</td> --}}
            <td></td>
            <td class="right">Gaji Harian</td>
            <td class="right">:</td>
            <td class="right">{{ number_format($data->gaji_harian, 0, ',', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="right">Total Presensi</td>
            <td class="right">:</td>
            <td class="right">{{ $data->total_absen }}</td>
        </tr>
        {{-- <tr>
            <td></td>
            <td class="right">Uang Lembur :</td>
            <td class="right">0</td>
        </tr>
        <tr>
            <td></td>
            <td class="right">Pengurang Gaji :</td>
            <td class="right">50,000</td>
        </tr>
        <tr>
            <td></td>
            <td class="right">Potongan Pinjaman :</td>
            <td class="right">0</td>
        </tr>
        <tr>
            <td></td>
            <td class="right">Tunjangan PPh :</td>
            <td class="right">0</td>
        </tr>
        <tr>
            <td></td>
            <td class="right">Potongan PPh 21 :</td>
            <td class="right">438,062</td>
        </tr> --}}
        <tr>
            <td></td>
            <td class="right bold">Total</td>
            <td class="right bold">:</td>
            <td class="right bold">{{ number_format($data->total_gaji, 0, ',', ',') }}</td>
        </tr>
    </table>

    <br><br>

    <table class="table-info">
        <tr>
            <td class="left">Disetujui Oleh :</td>
            <td class="right">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="left"><br><br><br><br><br><span class="bold">(..................................)</span></td>
            <td class="right">Di Terima Oleh :<br><br><br><br><br> (Hani Hadiyanti)</td>
        </tr>
    </table>

</body>
</html>

