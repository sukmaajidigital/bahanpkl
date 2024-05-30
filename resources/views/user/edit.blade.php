@extends('layouts.global')

@section('title')
    Edit User
@endsection
@section('content')
        <section class="section">
            <div class="section-header">
                <h1>Halaman Edit User</h1>
            </div>
            <div class="section-body">
                <div class="row my-5">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h3 class="text-light">Ubah User</h3>

                            </div>
                            <div class="">
                                <form autocomplete="off" action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">
                                                Nama
                                            </label>
                                            <input id="name" value="{{ old('name', $user->name) }}" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" />
                                            @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bold">
                                                Email
                                            </label>
                                            <input id="email" value="{{ old('email', $user->email) }}" name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" />
                                            @error('email')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="select_user_role" class="font-weight-bold">
                                                Role
                                            </label>
                                            <select id="select_user_role" name="role" data-placeholder="" class="custom-select w-100 @error('role') is-invalid @enderror">
                                                <option value="" selected="selected">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}" {{ $user->roles->first()->name === $role->name ? 'selected' : null}}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('role') }}
                                            </div>
                                            <!-- error message -->
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" value="{{ old('password', $user->password_asli) }}" class="form-control {{$errors->first('password')
                                            ? "is-invalid": ""}}" name="password" id="password" placeholder="Enter ...">
                                            <div class="invalid-feedback">
                                                {{$errors->first('password')}}
                                            </div>
                                        </div>
                                        <div class="float-right mb-4">
                                            <button type="submit" class="btn btn-success px-4">
                                                Ubah
                                            </button>
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

@endsection
