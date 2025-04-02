<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* CSS Manual untuk PDF */
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }
        .title {
            font-size: 14px;
            font-weight: bold;
        }
        .period {
            font-size: 11px;
            margin: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid #333;
            padding: 3px 2px;
            text-align: center;
        }
        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-cell {
            background-color: #fff2cc;
            font-weight: bold;
        }
        .footer {
            text-align: right;
            margin-top: 10px;
            font-size: 8px;
        }
    </style>
    <!-- Tailwind untuk utility tertentu -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="header">
        <!-- Gunakan class Tailwind untuk text styling -->
        <div class="title text-lg font-bold">REKAP DISPOSISI PEGAWAI </div>
        <div class="period">
            @if($year)
                Tahun: {{ $year }}
            @else
                Semua Tahun
            @endif
        </div>
        <div class="font-semibold">Total Disposisi: {{ $grandTotal }}</div>
    </div>
   
    <table>
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                @foreach($namaBulan as $bulan)
                    <th>{{ substr($bulan, 0, 3) }}</th>
                @endforeach
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawai as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    @foreach($namaBulan as $bulan)
                        <td>{{ $row[$bulan] ?: '0' }}</td>
                    @endforeach
                    <td class="total-cell">{{ $row['total'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($namaBulan) + 2 }}">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>