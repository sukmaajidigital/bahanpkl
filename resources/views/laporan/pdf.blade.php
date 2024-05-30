<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
    // Jika $startDate adalah string tanggal, konversi menjadi objek Carbon
    $startDate = \Carbon\Carbon::parse($startDate);
    @endphp
    <title>Pengeluaran Bulan {{ $startDate->format('F Y') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .container {
            display: grid;
            grid-template-columns: 8fr 4fr;
            /* Mengatur lebar kolom dengan fr unit */
            gap: 20px;
            /* Mengatur jarak antar kolom */
            max-width: 1280px;
            /* Mengatur lebar maksimum container */
            margin: 20px auto;
            /* Memberikan jarak dari tepi halaman */
        }

        /* Contoh styling untuk kolom */
        .col-8 {
            /* background-color: #e0e0e0; */
            padding: 20px;
        }

        .hijau {
            background-color: #A9D08E;
        }

        .col-4 {
            /* background-color: #c0c0c0; */
            padding: 20px;
        }

        .table {
            border-collapse: collapse;
            border: solid 1px #999;
            width: 100%;
            margin-bottom: 10px
        }

        .table tr td,
        .table tr th {
            border: solid 1px #999;
            padding: 3px;
            font-size: 12px
        }

        table tr td {
            vertical-align: top
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="col-8">
            <table class="table">
                <tr>
                    <th class="text-center">Pengeluaran Bulan {{ $startDate->format('F Y') }}</th>
                </tr>
            </table>
            @foreach ($dateRange as $date)
            @php
            $tanggal = $date->toDateString();
            $pembelian = $pembelianPerTanggal[$tanggal] ?? collect();
            $tanggalObj = \Carbon\Carbon::parse($tanggal);
            $tanggalFormatted = $tanggalObj->format('d F Y');
            @endphp
            <table class="table">
                <tr>
                    <th colspan="6" class="text-center">{{ $tanggalFormatted }}</th>
                    @php
                    $totalHarga = 0; // Inisialisasi total harga di luar loop
                    @endphp
                </tr>
                <tr class="hijau">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
                @foreach ($pembelian as $index => $p)
                @if ($p->bahan_baku->kategori->nama_kategori !== 'lele')
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->bahan_baku->nama_bahan_baku }}</td>
                    <td>{{ $p->qty }}</td>
                    <td>{{ $p->bahan_baku->satuan }}</td>
                    <td>{{ moneyFormat($p->harga_satuan) }}</td>
                    <td>{{ moneyFormat($p->total_harga) }}</td>
                    @php
                    $totalHarga += $p->total_harga;
                    @endphp
                </tr>
                @endif
                @endforeach
                <tr>
                    <td colspan="5" class="text-center"><strong>Total</strong></td>
                    <td>{{ moneyFormat($totalHarga) }}</td>
                </tr>
            </table>
            @endforeach
        </div>
        <div class="col-4">
            <table class="table">
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="text-right">
                        @if ($pembelianPerTanggal->isNotEmpty())
                        <b>{{ moneyFormat($pembelianPerTanggal->sum(function ($p) { return $p->sum('total_harga'); })) }}</b>
                        @else
                        <b>{{ moneyFormat(0) }}</b>
                        @endif
                    </td>
                </tr>
            </table>
            <table class="table">
                <tr>
                    <th colspan="2" class="text-center">Pengeluaran Bulan Januari</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                </tr>
                @php
                $totalHargaPerTanggal = 0; // Inisialisasi total harga per tanggal
                @endphp
                @foreach ($dateRange as $date)
                @php
                $tanggal = $date->toDateString();
                $pembelian = $pembelianPerTanggal[$tanggal] ?? collect();
                // Konversi string tanggal menjadi objek Carbon
                $tanggalObj = \Carbon\Carbon::parse($tanggal);

                // Format ulang tanggal
                $tanggalFormatted = $tanggalObj->format('d F Y');
                @endphp
                <tr>
                    <td>{{ $tanggalFormatted }}</td>
                    <td class="text-right">
                        @php
                        $totalHarga = $pembelian->sum(function ($p) {
                        return $p->bahan_baku->kategori->nama_kategori !== 'lele' ?
                        $p->total_harga : 0;
                        });
                        $totalHargaPerTanggal += $totalHarga;
                        @endphp
                        {{ moneyFormat($totalHarga) }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><b>{{ moneyFormat($totalHargaPerTanggal) }}</b></td>
                </tr>
            </table>
            <table class="table">
                <tr>
                    <th colspan="2" class="text-center">Pengeluaran lele Januari</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                </tr>
                @php
                $totalHargaPerTanggal = 0; // Inisialisasi total harga per tanggal
                @endphp

                @foreach ($dateRange as $date)
                @php
                $tanggal = $date->toDateString();
                $pembelian = $pembelianPerTanggal[$tanggal] ?? collect();
                // Konversi string tanggal menjadi objek Carbon
                $tanggalObj = \Carbon\Carbon::parse($tanggal);

                // Format ulang tanggal
                $tanggalFormatted = $tanggalObj->format('d F Y');
                @endphp
                <tr>
                    <td>{{ $tanggalFormatted }}</td>
                    <td class="text-right">
                        @php
                        $totalHarga = $pembelian->sum(function ($p) {
                        return $p->bahan_baku->kategori->nama_kategori == 'lele' ?
                        $p->total_harga : 0;
                        });

                        $totalSatuan = $pembelian->sum(function ($p) {
                        return $p->bahan_baku->kategori->nama_kategori == 'lele' ?
                        $p->qty : 0;
                        });
                        $totalHargaPerTanggal += $totalHarga;
                        @endphp
                        {{ $totalSatuan }} kg
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td><b>Total</b></td>
                    <td class="text-right">
                        <b>{{ moneyFormat($totalHargaPerTanggal) }}</b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        function PrintWindow() {
            window.print();
            CheckWindowState();
        }

        function CheckWindowState() {
            if (document.readyState == "complete") {
                window.close();
            } else {
                setTimeout("CheckWindowState()", 1000)
            }
        }
        PrintWindow();

    </script>
</body>

</html>
