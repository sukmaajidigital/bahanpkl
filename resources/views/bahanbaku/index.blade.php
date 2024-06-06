@extends('layouts.global')

@section('title')
    Bahan Baku
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Bahan Baku</h1>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Tabel Bahan Baku</h3>
                        <a href="{{ route('bahanbaku.create') }}" class="btn btn-light"><i
                            class="bi-plus-circle me-2"></i>Tambah Bahan Baku</a>

                    </div>
                    <div class="">
                        <div class="card-body">
                            <table class="table table-bordered table-md" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bahan Baku</th>
                                        <th>Satuan</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahanbaku as $no=>$bahan)
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $bahan->kategori->nama_kategori }} <a href="">  </a> {{ $bahan->nama_bahan_baku }}</td>
                                            <td>{{ $bahan->satuan }}</td>
                                            <td>{{ $bahan->kategori->nama_kategori }}</td>
                                            <td>
                                                @can('bahan_update')
                                                    <a href="{{ route('bahanbaku.edit', $bahan->id) }}" class="btn btn-warning">Edit</a>
                                                @endcan
                                                @can('bahan_delete')
                                                    <button onclick="destroy(this.id)" id="{{$bahan->id}}" type="submit" class="btn btn-danger">
                                                        delete
                                                    </button>
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
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $("table").DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                    destroy: true,
                    responsive: true
            });
        });

        function destroy(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN ?',
                text: "INGIN MENGHAPUS DATA INI!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, HAPUS!',
            }).then((result) => {
                if (result.isConfirmed) {
                    //ajax delete
                    jQuery.ajax({
                        url: `bahanbaku/${id}`,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            })
        }
    </script>
@endsection
