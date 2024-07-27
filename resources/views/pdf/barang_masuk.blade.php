<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pemberitahuan Barang Datang</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; /* Ukuran font lebih kecil */
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 2px; /* Padding lebih kecil */
            font-size: 12px; /* Ukuran font lebih kecil */
        }
        th { 
            text-align: center; 
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
            font-size: 14px; /* Ukuran font untuk header */
            font-family: 'Times New Roman', Times, serif;
        }
        .header-code {
            font-size: 14px; /* Ukuran font untuk kode */
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header-container">
    <div class="header-code">
            F.WH.03
        </div>
        <div class="header-text">
            CV. BARTEC UTAMA MANDIRI<br>
            DIVISI PENGENDALIAN DAN PENGAWASAN<br>
            DEPT WAREHOUSE & DELIVERY - WAREHOUSE BAHAN BAKU
        </div>
        
    </div>
    <table class="header-table">
        <tr>
            <th>Nomor :</th>
            <td>{{ $firstBarangMasuk ? $firstBarangMasuk->no_surat_masuk : '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal :</th>
            <td>{{ now()->format('d/M/Y') }}</td>
        </tr>
        <tr>
            <th>Kepada :</th>
            <td>{{ $firstBarangMasuk ? $firstBarangMasuk->kepada : '-' }}</td>
        </tr>
        <tr>
            <th>Revisi :</th>
            <td>-</td>
        </tr>
    </table>
    <h4 style="text-align: center;">SURAT PEMBERITAHUAN BARANG DATANG (SPBD) PEMBELIAN GD Jogoproro</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. PO/NO. SJ</th>
                <th>Kode </th>
                <th>Nama Material</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Golongan</th>
                <th>Pembawa</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangMasuks as $item)
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->no_surat_jalan }}</td>
                <td>{{ $item->bahanBaku->kode_material}}</td> <!-- Sesuaikan jika ada relasi ke nama bahan baku -->
                <td>{{ $item->bahanBaku->nama_barang }}</td> <!-- Sesuaikan jika ada relasi ke nama bahan baku -->
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->bahanBaku->satuan }}</td>
                <td>{{ $item->bahanBaku->golongan->name }}</td>
                <td>{{ $item->pembawa }}</td>
                <td>{{ $item->lokasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table class="signature-table">
        <tr>
            <td class="no-border">Penerima</td>
            <td class="no-border">Mengetahui</td>
            <td class="no-border">Diserahkan</td>
        </tr>
        <tr>
            <td class="no-border"><br><br>Gloria Putri</td>
            <td class="no-border"><br><br>Joko Priyo</td>
            <td class="no-border"><br><br>Yogi Widi H</td>
        </tr>
    </table>


</body>
</html>
