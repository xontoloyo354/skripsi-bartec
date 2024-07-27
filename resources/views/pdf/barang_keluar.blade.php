<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pemberitahuan Barang Keluar</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 2px; 
            font-size: 12px;
        }
        th { 
            text-align: center; 
            font-weight: bold;
        }
        td { 
            text-align: center; 
        }
        .header-table { 
            width: 100%; 
            margin-bottom: 20px; 
        }
        .header-table th, .header-table td { 
            border: none; 
            padding: 4px; 
            text-align: left; 
        }
        .header-table th { 
            width: 70px; 
        }
        .signature-table { 
            width: 100%; 
            margin-top: 20px; 
        }
        .signature-table th, .signature-table td { 
            border: none; 
            padding: 20px; 
            text-align: center; 
        }
        .no-border { 
            border: none; 
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .header-text {
            font-size: 14px;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
        }
        .header-code {
            font-size: 14px; 
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="header-text">
            CV. BARTEC UTAMA MANDIRI<br>
            DIVISI PENGENDALIAN DAN PENGAWASAN<br>
            DEPT WAREHOUSE & DELIVERY - BAHAN BAKU
        </div>
        <div class="header-code">
            F.WH.08
        </div>
    </div>
    <table class="header-table">
        <tr>
            <th>Nomor :</th>
            <td>{{ $firstBarangKeluar ? $firstBarangKeluar->no_surat_keluar : '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal :</th>
            <td>{{ now()->format('d/M/Y') }}</td>
        </tr>
    </table>
    <h4 style="text-align: center;">SURAT PEMBERITAHUAN BARANG KELUAR BAHAN BAKU WAREHOUSE JOGOPRONO</h4>
    <p>Pemberitahuan barang keluar dari gudang sebagai berikut :</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
                <th>Kode</th>
                <th>Nama Material</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Pembawa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluars as $barangKeluar)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $barangKeluar->created_at->format('d/m/Y')}}</td>
                    <td>{{ $barangKeluar->tujuan }}</td>
                    <td>{{ $barangKeluar->bahanBaku->kode_material }}</td>
                    <td>{{ $barangKeluar->bahanBaku->nama_barang }}</td>
                    <td>{{ $barangKeluar->jumlah }}</td>
                    <td>{{ $barangKeluar->bahanBaku->satuan }}</td>
                    <td>{{ $barangKeluar->pengambil }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="signature-table">
        <tr>
            <td class="no-border">penerima</td>
            <td class="no-border">mengetahui</td>
            <td class="no-border">diserahkan</td>
        </tr>
        <tr>
            <td class="no-border">(Gloria Putri)</td>
            <td class="no-border">(Joko Priyo)</td>
            <td class="no-border">(Yogi Widi H)</td>
        </tr>
    </table>
</body>
</html>
