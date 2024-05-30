@extends('layouts.global')

@section('title')
    Pengaturan
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Pengaturan</h1>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Tabel Pengaturan</h3>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Kelola {{ $stok->nama }}</td>
                                        @if ($stok->status == 'on')
                                        <td><span class="badge badge-success px-4">{{ $stok->status }}</span></td>
                                        <td width="10%">
                                            <button onclick="mati(this.id)" id="{{$stok->id}}" type="submit" class="btn btn-danger px-4 float-right">
                                                Matikan
                                            </button>
                                        </td>
                                        @else
                                        <td><span class="badge badge-danger">{{ $stok->status }}</span></td>
                                        <td width="10%">
                                        <button onclick="aktif(this.id)" id="{{$stok->id}}" type="submit" class="btn btn-info float-right">
                                            Aktifkan
                                        </button>
                                        </td>
                                        @endif
                                </tr>
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
        function aktif(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN ?',
                text: "INGIN MENGAKTIFKAN INI!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, AKTIFKAN!',
            }).then((result) => {
                if (result.isConfirmed) {
                    //ajax delete
                    jQuery.ajax({
                        url: `settings/onupdate/${id}`,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'PUT',
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIAKTIFKAN!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIUBAH!',
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
        function mati(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN ?',
                text: "INGIN MEMATIKAN INI!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, MATIKAN!',
            }).then((result) => {
                if (result.isConfirmed) {
                    //ajax delete
                    jQuery.ajax({
                        url: `settings/offupdate/${id}`,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'PUT',
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIMATIKAN!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIUBAH!',
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
