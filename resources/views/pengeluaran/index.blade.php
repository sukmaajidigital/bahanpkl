@extends('layouts.global')

@section('title')
    Pengeluaran
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2-bootstrap4.css') }}">
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Pengeluaran</h1>
        </div>
        <div class="section-body">
            <div class="row my-5">
                <div class="col-12 col-md-5">
                    <div class="card shadow">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <h3 class="text-light">Form Pengeluaran</h3>
                        </div>
                        <div class="">
                            <div class="card-body">
                                <form id="pembelianForm" action="{{ route('pengeluaran.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                                            value="{{ old('tanggal') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Bahan Baku</label>
                                        <select class="form-control select2" id="bahanBaku"></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="qty">Qty</label>
                                        <input type="text" class="form-control" name="qty" id="qty"
                                            value="{{ old('qty') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" name="keterangan"
                                            id="keterangan">{{ old('keterangan') }}</textarea>
                                    </div>
                                    @can('pengeluaran_create')
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
                            <h3 class="text-light">Data Pengeluaran</h3>
                            <form class="form-inline" id="search-form">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="tanggal" id="tanggalan">
                                </div>
                                <button class="btn btn-info ml-2" type="submit">Cari</button>
                            </form>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="card-body">
                                    <table class="table table-pembelian table-bordered table-hover" id="table-pembelian">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bahan Baku</th>
                                                <th>Qty</th>
                                                <th>Keterangan</th>
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
                            <label for="editKeterangan">Keterangan</label>
                            <textarea class="form-control" id="editKeterangan" name="editKeterangan" required></textarea>
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
                    url: "{{ route('pengeluaran') }}",
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
                    { data: 'qty' },
                    { data: 'keterangan' },
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
                url: '{{ url("/dashboard/barang-keluar/edit") }}/' + id,
                type: 'GET',
                success: function (response) {
                    console.log(response);

                    if (response) {
                        // Isi formulir modal dengan data yang diterima dari server
                        $('#editForm').attr('data-id', response.id); // Simpan ID pengeluaran
                        $('#editQty').val(response.qty);
                        $('#editKeterangan').val(response.keterangan);

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

        //update pengeluaran modal
        function updateData() {
                // Dapatkan ID pengeluaran dari atribut data-id
                var pengeluaranId = $('#editForm').data('id');

                // Dapatkan data formulir modal
                var formData = {
                    qty: $('#editQty').val(),
                    keterangan: $('#editKeterangan').val(),
                    // tambahkan data lainnya sesuai kebutuhan
                };

                // Lakukan pembaruan melalui AJAX
                $.ajax({
                    url: '{{ url("/dashboard/barang-keluar/update") }}/' + pengeluaranId,
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
                placeholder: 'Pilih Bahan Baku',
                escapeMarkup: function (markup) {
                    return markup;
                } // Mengizinkan markup HTML pada hasil pencarian
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
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DISIMPAN!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                var dataTable = $('#table-pembelian').DataTable();
                                dataTable.ajax.reload();
                                $('#qty').val('');
                                $('#keterangan').val('');
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: response.message || 'Stok tidak mencukupi untuk pengeluaran ini.',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        handleAjaxError(xhr);
                    }
                });
            });
        });

    </script>
@endsection
