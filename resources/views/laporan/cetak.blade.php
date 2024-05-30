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
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .section {
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        .section-header h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-inline {
            display: flex;
            align-items: center;
        }

        .form-group {
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .row {
            display: flex;
            margin-top: 20px;
        }

        .col-md-8,
        .col-md-4 {
            flex: 1;
            margin-right: 20px;
        }

        .card {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .ml-auto {
            margin-left: auto;
        }

    </style>
</head>

<body>
    <div class="section">
        <div class="section-header">
            {{-- @php
            $startDate = \Carbon\Carbon::parse($startDate);
            @endphp --}}
            <h1>Pengeluaran bulan {{ $startDate->format('F Y') }}</h1>
            <span class="ml-auto">
                <form class="form-inline" action="{{ route('laporan.bulanan') }}" method="GET">
                    <div class="form-group">
                        <input value="{{ $startDate->format('Y-m') }}" class="form-control" type="month"
                            name="bulan_tahun" id="bulan_tahun" required>
                    </div>
                    <button class="btn btn-primary ml-2" type="submit">Sortir</button>
                </form>
            </span>
        </div>
        <div class="section-body">
            <div class="row my-5">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($dateRange as $date)
                            @php
                            $tanggal = $date->toDateString();
                            $pembelian = $pembelianPerTanggal[$tanggal] ?? collect();
                            $tanggalObj = \Carbon\Carbon::parse($tanggal);
                            $tanggalFormatted = $tanggalObj->format('d F Y');
                            @endphp

                            <div class="card shadow">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h6>{{ $tanggalFormatted }}</h6>
                                    <span><b>Total :</b> {{ moneyFormat($pembelian->sum('total_harga', 0)) }}</span>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-md" id="dataTable_{{ $loop->index + 1 }}">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pembelian as $index => $p)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $p->bahan_baku->nama_bahan_baku }}</td>
                                                <td>{{ $p->bahan_baku->satuan }}</td>
                                                <td>{{ moneyFormat($p->harga_satuan) }}</td>
                                                <td>{{ moneyFormat($p->total_harga) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <h6 class="text-light">Pengeluaran bulan {{ $startDate->format('F Y') }}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dateRange as $date)
                                    @php
                                    $tanggal = $date->toDateString();
                                    $pembelian = $pembelianPerTanggal[$tanggal] ?? collect();
                                    $tanggalObj = \Carbon\Carbon::parse($tanggal);
                                    $tanggalFormatted = $tanggalObj->format('d F Y');
                                    @endphp
                                    <tr>
                                        <td>{{ $tanggalFormatted }}</td>
                                        <td>{{ moneyFormat($pembelian->sum('total_harga', 0)) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td>
                                            @if ($pembelianPerTanggal->isNotEmpty())
                                            <b>{{ moneyFormat($pembelianPerTanggal->sum(function ($p) { return $p->sum('total_harga'); })) }}</b>
                                            @else
                                            <b>{{ moneyFormat(0) }}</b>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
