@extends('layouts.global')
@section('title')
    Hak Akses
@endsection
@section('content')
        <section class="section">
            <div class="section-header">
                <h1>Halaman Hak Akses</h1>
            </div>
            <div class="section-body">
                <div class="row my-5">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h3 class="text-light">Data Hak Akses</h3>
                                @can('role_create')
                                    <a class="btn btn-light" href="{{ route('role.create') }}"><i
                                        class="bi-plus-circle me-2"></i>Tambah Hak Akses</a>
                                @endcan
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <!-- list role -->
                                        @forelse ($roles as $role)
                                        <li
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
                                            <label class="mt-auto mb-auto">
                                                {{ $role->name }}
                                            </label>
                                            <div>
                                                   <!-- detail -->
                                                <a href="{{ route('role.show', $role->id) }}" class="btn btn-sm btn-success"
                                                    role="button">
                                                    Detail
                                                </a>
                                                @can('role_edit')
                                                    <!-- edit -->
                                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-warning"
                                                        role="button">
                                                        Ubah
                                                    </a>
                                                @endcan
                                                @can('role_delete')
                                                    <!-- delete -->
                                                    <button onclick="destroy(this.id)" id="{{$role->id}}" class="btn btn-sm btn-danger">
                                                        Hapus
                                                    </button>
                                                @endcan


                                            </div>
                                        </li>
                                        @empty
                                        <p>
                                            <strong>
                                                Wewenang Belum Tersedia!
                                            </strong>
                                        </p>
                                        @endforelse
                                        <!-- list role -->
                                    </ul>
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
                    url: `role/${id}`,
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
                                text: 'DATA GAGAL DIHAPUS KARENA SEDANG DIGUNAKAN!',
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
