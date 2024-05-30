@extends('layouts.global')

@section('title')
    Ubah Bahan Baku
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Halaman Ubah Bahan Baku</h1>
    </div>
    <div class="section-body">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Form Ubah Bahan Baku</h3>
                    </div>
                    <div class="">
                        <form action="{{ route('bahanbaku.update', $bahanbaku->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_bahan_baku">Bahan Baku</label>
                                    <input type="text" class="form-control @error('nama_bahan_baku') is-invalid @enderror"
                                        placeholder="Masukkan Bahan Baku" value="{{ old('nama_bahan_baku') ? old('nama_bahan_baku') : $bahanbaku->nama_bahan_baku }}" name="nama_bahan_baku">
                                        @error('nama_bahan_baku')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                        placeholder="Masukkan Satuan" value="{{ old('satuan') ? old('satuan') : $bahanbaku->satuan }}" name="satuan">
                                        @error('satuan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kategori_id">Kategori</label>
                                    <select name="kategori_id" id="" class="form-control @error('kategori_id') is-invalid @enderror">
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}" {{ old('kategori_id', $bahanbaku->kategori_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
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
