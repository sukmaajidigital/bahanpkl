@extends('layouts.global')

@section('title')
Pengeluaran Kasir
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2-bootstrap4.css') }}">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Pengeluaran Kasir</h1>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-12 col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Form Pengeluaran Kasir</h3>

                    </div>
                    <div class="">
                        <div class="card-body">
                            <form id="pembelianForm" action="{{ route('pembelian.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                        name="tanggal" id="tanggal" value="{{ old('tanggal') }}">
                                    @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label>Barang</label>
                                            <select class="form-control select2" id="bahanBaku"></select>
                                        </div>
                                    </div>

                                    <div class="col-2" style="padding-left: 0 !important">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary mt-4 px-3 py-2"
                                                data-toggle="modal" data-target="#bahanBakuModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                        name="qty" id="qty" value="{{ old('qty') }}">
                                    @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="harga_satuan">Harga Satuan</label>
                                    <input type="text" class="form-control @error('harga_satuan') is-invalid @enderror"
                                        name="harga_satuan" id="harga_satuan" value="{{ old('harga_satuan') }}">
                                    @error('harga_satuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total_harga">Total Harga</label>
                                    <input type="text" class="form-control @error('total_harga') is-invalid @enderror"
                                        name="total_harga" id="total_harga" value="{{ old('total_harga') }}">
                                    @error('total_harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @can('pembelian_create')
                                    <button type="submit" class="btn btn-info btn-block">Simpan</button>
                                @endcan

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Data Pengeluaran Kasir</h3>
                        <form class="form-inline" id="search-form">
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal" id="tanggalan">
                            </div>
                            <button class="btn btn-info ml-2" type="submit">Cari</button>
                        </form>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="card-body data-pembelian">
                                <table class="table table-pembelian table-bordered table-hover" id="table-pembelian">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bahan Baku</th>
                                            <th>Harga</th>
                                            <th>qty</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="bahanBakuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tmabah Bahan Baku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bahanBakuForm" action="{{ route('pengeluaranKasirBarang.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_bahan_baku">Bahan Baku</label>
                            <input type="text" class="form-control @error('nama_bahan_baku') is-invalid @enderror"
                                placeholder="Masukkan Bahan Baku" value="{{ old('nama_bahan_baku') }}"
                                name="nama_bahan_baku" id="nama_bahan_baku">
                            @error('nama_bahan_baku')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror"
                                placeholder="Masukkan Satuan" value="{{ old('satuan') }}" name="satuan">
                            @error('satuan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" data-id="" action="#" method="POST">
                    <div class="form-group">
                        <label>Bahan Baku</label>
                        <input type="text" class="form-control" id="bahanBakuEdit" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editQty">Qty</label>
                        <input type="text" class="form-control" id="editQty" name="editQty" required>
                    </div>
                    <div class="form-group">
                        <label for="editHarga">Harga Satuan</label>
                        <input type="text" class="form-control" id="editHarga" name="editHarga">
                    </div>
                    <div class="form-group">
                        <label for="editTotal">Total</label>
                        <input type="text" class="form-control" id="editTotal" name="editTotal">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        var table = $('#table-pembelian').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            paging: false,
            info: false,
            ordering: false,
            ajax: {
                url: "{{ route('kasir-keluar') }}",
                data: function (d) {
                    d.tanggal = $('#tanggalan').val();
                }
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Menampilkan nomor urut (dimulai dari 1)
                    }
                },
                { data: 'bahan_baku.nama_bahan_baku' },
                { data: 'harga_satuan' },
                { data: 'qty' },
                { data: 'total_harga' },
                {
                    data: null,
                    render: function (data) {
                        return '<button class="btn btn-warning" onclick="openEditModal(' + data.id + ')" id="editBtn' + data.id + '">Edit</button>';
                    }
                }
            ]
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            console.log("Tanggal yang dipilih:", $('#tanggalan').val()); // Tambahkan log untuk memeriksa tanggal yang dipilih
            table.ajax.reload();
        });

        $('#tanggalan').on('change', function () {
            table.ajax.reload();
        });
    });
    function openEditModal(id) {
        // Dapatkan data dari server berdasarkan ID
        $.ajax({
            url: '{{ url("/dashboard/pembelian/edit") }}/' + id,
            type: 'GET',
            success: function (response) {
                console.log(response);

                if (response) {
                    // Isi formulir modal dengan data yang diterima dari server
                    $('#editForm').attr('data-id', response.id); // Simpan ID pengeluaran
                    $('#editQty').val(response.qty);
                    $('#editHarga').val(response.harga_satuan);
                    $('#editTotal').val(response.total_harga);

                    // Akses objek BahanBaku dari relasi
                    var bahanBaku = response.bahan_baku;

                    if (bahanBaku && bahanBaku.hasOwnProperty('nama_bahan_baku')) {
                        var bahanBakuData = {
                            id: bahanBaku.id,
                            text: bahanBaku.nama_bahan_baku
                        };

                        // Set nilai pada elemen input bahanBakuEdit
                        $('#bahanBakuEdit').val(bahanBakuData.text);

                        // Tampilkan modal
                        $('#editModal').modal('show');
                    } else {
                            console.error('Objek BahanBaku tidak ditemukan atau tidak memiliki properti nama_bahan_baku.');
                    }
                } else {
                    console.error('Data tidak ditemukan atau struktur respons tidak sesuai.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    // Menangani perubahan pada input qty
    $('#editQty').on('input', function () {
        editTotalHarga();
    });

    // Menangani perubahan pada input harga_satuan
    $('#editHarga').on('input', function () {
        editTotalHarga();
    });

    // Menangani perubahan pada input total_harga
    $('#editTotal').on('input', function () {
        editQtyAndHargaSatuan();
    });

    // Fungsi untuk menghitung total harga berdasarkan input qty dan harga_satuan
    function editTotalHarga() {
        var qty = parseFloat($('#editQty').val()) || 0;
        var hargaSatuan = parseFloat($('#editHarga').val()) || 0;
        var totalHarga = qty * hargaSatuan;
        $('#editTotal').val(totalHarga);
    }

    // Fungsi untuk menghitung qty dan harga_satuan berdasarkan input total_harga
    function editQtyAndHargaSatuan() {
        var totalHarga = parseFloat($('#editTotal').val()) || 0;
        var qty = parseFloat($('#editQty').val()) || 0;
        if (qty !== 0) {
            var hargaSatuan = totalHarga / qty;
            $('#editHarga').val(hargaSatuan);
        }
    }

     //update pengeluaran modal
    function updateData() {
        // Dapatkan ID pengeluaran dari atribut data-id
        var pengeluaranId = $('#editForm').data('id');

        // Dapatkan data formulir modal
        var formData = {
            qty: $('#editQty').val(),
            harga_satuan: $('#editHarga').val(),
            total_harga: $('#editTotal').val(),
        };

        // Lakukan pembaruan melalui AJAX
        $.ajax({
            url: '{{ url("/dashboard/pembelian/update") }}/' + pengeluaranId,
            type: 'PUT',
            data: formData,
            success: function (response) {
                if (response.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'BERHASIL!',
                        text: 'DATA BERHASIL DISIMPAN!',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(function () {
                        $('#editModal').modal('hide');
                        var dataTable = $('#table-pembelian').DataTable();
                        dataTable.ajax.reload();
                    });
                    // Tutup modal setelah pembaruan berhasil


                    // Tampilkan pesan sukses atau lakukan tindakan lainnya
                    console.log('Pembaruan berhasil!');
                } else {
                    console.error('Pembaruan gagal: ' + response.message || 'Terjadi kesalahan.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Function to handle AJAX errors
        function handleAjaxError(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                // Display validation errors
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        var errorMessage = errors[key][0];
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<div class="invalid-feedback">' + errorMessage + '</div>');
                    }
                }
            } else {
                console.error(xhr.responseText);
            }
        }

        $("#bahanBaku").select2({
            ajax: {
                url: '/dashboard/pembelian/bahanbaku',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // Parameter pencarian
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.nama_bahan_baku
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Jumlah karakter minimal sebelum pencarian dimulai
            placeholder: 'Pilih Barang',
            escapeMarkup: function (markup) {
                return markup;
            } // Mengizinkan markup HTML pada hasil pencarian
        });

        $("#bahanBakuForm").submit(function (e) {
            e.preventDefault();

            // Serialize form data
            var formData = $(this).serialize();

            // Clear previous styles and error messages
            $(".form-control").removeClass('is-invalid');
            $(".invalid-feedback").remove();

            // AJAX request
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'BERHASIL!',
                        text: 'DATA BERHASIL DISIMPAN!',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(function () {
                        $("#bahanBakuModal").modal('hide');
                    });
                },
                error: function (xhr, status, error) {
                    handleAjaxError(xhr);
                }
            });
        });

        $("#pembelianForm").submit(function (e) {
            e.preventDefault();

            // Serialize form data
            var formData = $(this).serialize();
            var bahanBakuId = $("#bahanBaku").val();
            formData += "&bahanBaku=" + bahanBakuId;

            // Clear previous styles and error messages
            $(".form-control").removeClass('is-invalid');
            $(".invalid-feedback").remove();

            // AJAX request
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'BERHASIL!',
                        text: 'DATA BERHASIL DISIMPAN!',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(function () {
                        // $(".data-pembelian").load(location.href +
                        //     ' .data-pembelian')
                        var dataTable = $('#table-pembelian').DataTable();
                        dataTable.ajax.reload();
                        $('#harga_satuan').val('');
                        $('#qty').val('');
                        $('#total_harga').val('');
                        $('#bahanBaku').val('').trigger('change');
                    });
                },
                error: function (xhr, status, error) {
                    handleAjaxError(xhr);
                }
            });
        });

        // Menangani perubahan pada input qty
        $('#qty').on('input', function () {
            updateTotalHarga();
        });

        // Menangani perubahan pada input harga_satuan
        $('#harga_satuan').on('input', function () {
            updateTotalHarga();
        });

        // Menangani perubahan pada input total_harga
        $('#total_harga').on('input', function () {
            updateQtyAndHargaSatuan();
        });

        // Fungsi untuk menghitung total harga berdasarkan input qty dan harga_satuan
        function updateTotalHarga() {
            var qty = parseFloat($('#qty').val()) || 0;
            var hargaSatuan = parseFloat($('#harga_satuan').val()) || 0;
            var totalHarga = qty * hargaSatuan;
            $('#total_harga').val(totalHarga);
        }

        // Fungsi untuk menghitung qty dan harga_satuan berdasarkan input total_harga
        function updateQtyAndHargaSatuan() {
            var totalHarga = parseFloat($('#total_harga').val()) || 0;
            var qty = parseFloat($('#qty').val()) || 0;
            if (qty !== 0) {
                var hargaSatuan = totalHarga / qty;
                $('#harga_satuan').val(hargaSatuan);
            }
        }
    });

</script>
@endsection
