<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Permohonan</title>
    <style>
        /* Tailwind CSS */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');

       /* CSS Manual untuk PDF */
       body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            position: relative;
            margin-bottom: 30px; /* Beri ruang untuk footer */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 9pt;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .year-title {
            background-color: #333;
            color: white;
            padding: 5px 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 14pt;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 class="text-2xl font-bold">LAPORAN DATA PERMOHONAN</h2>
        <p class="text-sm">
            @if(isset($filters['year']))
                Tahun: {{ $filters['year'] }}
            @endif
            
            @if(isset($filters['months']))
                Bulan: {{ str_replace(',', '-', $filters['months']) }}
            @endif
            
            @if(isset($filters['status_permohonan']))
                Status: {{ $filters['status_permohonan'] }}
            @endif
        </p>
    </div>
    
    @foreach($permohonanGrouped as $year => $yearData)
    <div class="year-section">
        <div class="year-title">PERMOHONAN TAHUN {{ $year }}</div>

        <table>
            <thead>
                <tr>
                    <th class="border border-black p-2 text-center">No.</th>
                    <th class="border border-black p-2 text-center">ID</th>
                    <th class="border border-black p-2 text-center">Tanggal Pengajuan</th>
                    <th class="border border-black p-2 text-center">Kategori</th>
                    <th class="border border-black p-2 text-center">Layanan</th>
                    <th class="border border-black p-2 text-center">Pemohon</th>
                    <th class="border border-black p-2 text-center">Keperluan</th>
                    <th class="border border-black p-2 text-center">Disposisi</th>
                    <th class="border border-black p-2 text-center">Tanggal Selesai</th>
                    <th class="border border-black p-2 text-center">Tanggal Diambil</th>
                    <th class="border border-black p-2 text-center">Tanggal Rencana Pengumpulan Skripsi</th>
                    <th class="border border-black p-2 text-center">Tanggal Pengumpulan Skripsi</th>
                    <th class="border border-black p-2 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($yearData as $index => $pm)
                    <tr>
                        <td class="border border-black p-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-black p-2">{{ $pm->id }}</td>
                        <td class="border border-black p-2">{{ \Carbon\Carbon::parse($pm->tanggal_diajukan)->format('d/m/Y') }}</td>
                        <td class="border border-black p-2">{{ $pm->kategori_berbayar == 'Nolrupiah' ? 'Nol Rupiah' : $pm->kategori_berbayar }}</td>
                        <td class="border border-black p-2">{{ $pm->jenisLayanan->nama_jenis_layanan }}</td>
                        <td class="border border-black p-2">
                            <strong>{{ $pm->pemohon->nama_pemohon }}</strong><br>
                            @if(!empty($pm->pemohon->no_kontak))
                                {{ $pm->pemohon->no_kontak }}<br>
                            @endif
                            {{ $pm->pemohon->instansi }}
                        </td>
                        <td class="border border-black p-2">{{ $pm->deskripsi_keperluan }}</td>
                        <td class="border border-black p-2">
                            @if($pm->disposisi)
                                @php
                                    $pegawaiList = collect([
                                        optional($pm->disposisi->pegawai1)->nama,
                                        optional($pm->disposisi->pegawai2)->nama,
                                        optional($pm->disposisi->pegawai3)->nama,
                                        optional($pm->disposisi->pegawai4)->nama,
                                    ])->filter(); 
                                @endphp

                                @if ($pegawaiList->count() > 0)
                                    {{ $pegawaiList->implode(', ') }}
                                    @if($pm->disposisi->tanggal_disposisi)
                                        <br>{{ \Carbon\Carbon::parse($pm->disposisi->tanggal_disposisi)->format('d/m/Y') }}
                                    @endif
                                @else
                                    Belum Diatur
                                @endif
                            @else
                                Belum Diatur
                            @endif
                        </td>
                        <td class="border border-black p-2">{{ $pm->tanggal_selesai ? \Carbon\Carbon::parse($pm->tanggal_selesai)->format('d/m/Y') : 'Belum Diatur' }}</td>
                        <td class="border border-black p-2">{{ $pm->tanggal_diambil ? \Carbon\Carbon::parse($pm->tanggal_diambil)->format('d/m/Y') : 'Belum Diatur' }}</td>
                        <td class="border border-black p-2">{{ $pm->tanggal_rencana ? \Carbon\Carbon::parse($pm->tanggal_rencana)->format('d/m/Y') : 'Belum Diatur' }}</td>
                        <td class="border border-black p-2">{{ $pm->tanggal_pengumpulan ? \Carbon\Carbon::parse($pm->tanggal_pengumpulan)->format('d/m/Y') : 'Belum Diatur' }}</td>
                        <td class="border border-black p-2">{{ $pm->status_permohonan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer untuk setiap halaman -->
        <div class="footer">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
    </div>

    <!-- Tambahkan page break setelah setiap tahun -->
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>