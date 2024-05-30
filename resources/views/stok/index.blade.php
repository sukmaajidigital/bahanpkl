@extends('layouts.global')

@section('title')

@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Stok</h1>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Tabel Stok</h3>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <table class="table table-pembelian table-bordered table-md" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bahan Baku</th>
                                        <th>Stok</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stok as $no=>$item)
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $item->nama_bahan_baku }}</td>
                                            <td>{{ $item->stok }} {{ $item->satuan }}</td>
                                            <td>
                                                @can('stok_update')
                                                    <button class="btn btn-warning" onclick="openEditModal({{ $item->id }})" id="editBtn{{ $item->id }}">Edit Stok</button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        <input type="text" class="form-control" id="stok" name="stok" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function openEditModal(id) {
        // Dapatkan data dari server berdasarkan ID
        $.ajax({
            url: '{{ url("/dashboard/stok/edit") }}/' + id,
            type: 'GET',
            success: function (response) {
                console.log(response);

                if (response) {
                    // Isi formulir modal dengan data yang diterima dari server
                    $('#editForm').attr('data-id', response.id); // Simpan ID pengeluaran
                    $('#bahanBakuEdit').val(response.nama_bahan_baku);
                    $('#stok').val(response.stok);

                    // Tampilkan modal
                    $('#editModal').modal('show');

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
            stok: $('#stok').val(),
            // tambahkan data lainnya sesuai kebutuhan
        };

        // Lakukan pembaruan melalui AJAX
        $.ajax({
            url: '{{ url("/dashboard/stok/update") }}/' + pengeluaranId,
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
                        $(".table-pembelian").load(location.href +
                            ' .table-pembelian')
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
        $("table").DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
                destroy: true,
                responsive: true
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    });
</script>
@endsection
