@extends('layouts.global')

@section('title')
Pengeluaran Bulanan
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        @php
        // Jika $startDate adalah string tanggal, konversi menjadi objek Carbon
        $startDate = \Carbon\Carbon::parse($startDate);
        @endphp
        <h1>Pengeluaran {{ $kategori->nama_kategori }}  bulan {{ $startDate->format('F Y') }}</h1>
        <span class="ml-auto">
            <form class="form-inline" action="{{ route('laporan.kategori', $kategori->id) }}" method="GET">
                <div class="form-group">
                    <input value="{{ $startDate->format('Y-m') }}" class="form-control" type="month" name="bulan_tahun"
                        id="bulan_tahun" required>
                </div>
                <button class="btn btn-primary ml-2" type="submit">Sortir</button>
            </form>
        </span>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12">
                        @foreach ($dateRange as $date)
                        @php
                        $tanggal = $date->toDateString();
                        $pembelian = $pembelianPerTanggal[$tanggal] ?? collect();
                        // Konversi string tanggal menjadi objek Carbon
                        $tanggalObj = \Carbon\Carbon::parse($tanggal);

                        // Format ulang tanggal
                        $tanggalFormatted = $tanggalObj->format('d F Y');
                        @endphp
                        <div class="card shadow">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h6>{{ $tanggalFormatted }}</h6>
                                @php
                                $totalHarga = 0; // Inisialisasi total harga di luar loop
                                @endphp
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <!-- Menggunakan variabel $loop->index untuk membuat ID dinamis -->
                                    <table class="table table-bordered table-md" id="dataTable_{{ $loop->index + 1 }}" style="width:100%">
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
                                            @if ($p->bahan_baku->kategori->nama_kategori !== 'lele')
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $p->bahan_baku->nama_bahan_baku }}</td>
                                                <td>{{ $p->bahan_baku->satuan }}</td>
                                                <td>{{ moneyFormat($p->harga_satuan) }}</td>
                                                <td>{{ moneyFormat($p->total_harga) }}</td>
                                                @php
                                                $totalHarga += $p->total_harga;
                                                @endphp
                                            </tr>
                                            @endif

                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table table-borderless table-md">
                                        <thead>
                                            <tr>
                                                <td colspan="4"><b>Total</b></td>
                                                <td class="text-right"><b>{{ moneyFormat($totalHarga) }}</b></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="">
                                <div class="card-body">
                                    <table class="table table-borderless table-md" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td><b>Grand Total</b></td>
                                                <td>
                                                    @if ($pembelianPerTanggal->isNotEmpty())
                                                   <b>{{ moneyFormat($pembelianPerTanggal->sum(function ($p) { return $p->sum('total_harga'); })) }}</b>
                                                @else
                                                    <b>{{ moneyFormat(0) }}</b>
                                                @endif
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h6 class="text-light">Pengeluaran bulan {{ $startDate->format('F Y') }}</h6>
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <table class="table table-bordered table-md" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                <td>
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
                                                <td><b>Total</b></td>
                                                <td>
                                                    <b>{{ moneyFormat($totalHargaPerTanggal) }}</b>
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
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    // Pastikan jQuery sudah dimuat sebelum inisialisasi DataTables
    $(document).ready(function () {
        // Inisialisasi DataTables untuk semua tabel dengan ID dinamis
        $('[id^="dataTable_"]').each(function () {
            $(this).DataTable({
                "columnDefs": [{
                    "targets": "_all",
                    "orderable": false
                }],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                destroy: true,
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false
            });
        });
    });

</script>
@endsection
