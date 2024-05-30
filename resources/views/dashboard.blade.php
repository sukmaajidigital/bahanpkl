@extends('layouts.global')

@section('title')
    Dashboard
@endsection

@section('title')
    <link rel="stylesheet" href="{{ asset('assets/modules/apexcharts-bundle/dist/apexcharts.css') }}">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="co-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Pembelian Bulan ini</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bahan Baku</th>
                                    <th>Total Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->nama_bahan_baku }}</td>
                                        <td>{{ $p->pembelian->sum('qty') }}</td>
                                        <td>{{ moneyFormat($p->pembelian->sum('total_harga')) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="co-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Stok Terendah</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Bahan Baku</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok as $index => $s)
                                <tr>
                                    <td>{{ $s->nama_bahan_baku }}</td>
                                    <td>{{ $s->stok }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/modules/apexcharts-bundle/dist/apexcharts.min.js') }}"></script>
<script>
    var options = {
          series: [{
            name: "Total Pengeluaran",
            data: @json($dataTotalPengeluaran)
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Data Pengeluaran Bulanan',
          align: 'left'
        },
        subtitle: {
          text: 'Total Pengeluaran Resto Tiap Bulan.',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: @json($dataBulan),
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return value.toLocaleString("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    });
                }
            },
        },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>
@endsection
