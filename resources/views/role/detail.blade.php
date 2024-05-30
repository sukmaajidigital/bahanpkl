@extends('layouts.global')
@section('title')
    Detail Role
@endsection
@section('content')
        <section class="section">
            <div class="section-header">
                <h1>Halaman Detail Role</h1>
            </div>
            <div class="section-body">
                <div class="row my-5">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h3 class="text-light">Detail Role</h3>
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="input_role_name" class="font-weight-bold">
                                            Nama
                                        </label>
                                        <input id="input_role_name" value="{{ $role->name }}" name="name" type="text" class="form-control"
                                            readonly />
                                    </div>
                                    <!-- permission -->
                                    <div class="form-group">
                                        <label for="input_role_permission" class="font-weight-bold">
                                            Wewenang
                                        </label>
                                        <div class="row">
                                            <!-- list manage name:start -->
                                            @forelse ($authorities as $menageName => $permissions)
                                            <ul class="list-group col-lg-3">
                                                <li class="list-group-item bg-dark text-white">
                                                    {{ str_replace("_"," ", $menageName) }}
                                                </li>
                                                @foreach ($permissions as $permission)
                                                <!-- list permission:start -->
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" onclick="return false;"
                                                            {{ in_array($permission,$rolePermissions) ? 'checked' : null }}>
                                                        <label class="form-check-label">
                                                            {{ str_replace("_"," ", $permission) }}
                                                        </label>
                                                    </div>
                                                </li>
                                                <!-- list permission:end -->
                                                @endforeach

                                            </ul>
                                            @empty

                                            @endforelse

                                            <!-- list manage name:end  -->
                                        </div>
                                    </div>
                                    <!-- button  -->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('role.index') }}" class="btn btn-primary mx-1" role="button">
                                            Back
                                        </a>
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
