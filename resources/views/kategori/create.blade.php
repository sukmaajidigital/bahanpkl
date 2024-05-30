@extends('layouts.global')

@section('title')
    Tambah Kategori
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Tambah Kategori</h1>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Form Tambah Kategori</h3>
                    </div>
                    <div class="">
                        <form action="{{ route('kategori.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_kategori">Kategori</label>
                                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                        placeholder="Masukkan Kategori" value="{{ old('nama_kategori') }}" name="nama_kategori">
                                        @error('nama_kategori')
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
    </div>
</section>
@endsection
