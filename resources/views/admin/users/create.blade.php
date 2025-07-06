@extends('admin.layouts.appAdmin')

@section('title','Nario kūrimas')
@section('content')
    @auth
        <div class="container">
            <div class="image-preview" style="display: none;">
                <i class="bi bi-x-lg close-preview"></i>
                <img src="" alt="Preview Image">
            </div>
            <div class="row justify-content-center ">
                <h2 class="text-center">Naujo nario kūrimas</h2>
                <div class="col-md-6" style="padding: 20px;">
                    <div class="card">
                        <div class="card-body justify-content-center">
                            <div class="row justify-content-center">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="bigCircle">
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.users.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Vardas') }}</label>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name', optional($user ?? null)->name) }}" required
                                           autocomplete="name">
                                    @error('name')
                                    <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label for="surname" class="form-label">{{ __('Pavardė') }}</label>
                                    <input id="surname" type="text"
                                           class="form-control @error('surname') is-invalid @enderror" name="surname"
                                           value="{{ old('surname', optional($user ?? null)->surname) }}" required
                                           autocomplete="surname">
                                    @error('surname')
                                    <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('El. paštas') }}</label>
                                    <input id="email" type="text"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email', optional($user ?? null)->email) }}" required
                                           autocomplete="email">
                                    @error('email')
                                    <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">{{ __('Nario rolė') }}</label>
                                    <select name="role" id="role" class="form-control" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-footer gap-2">
                                    <button type="button" class="btn btn-outline-primary"
                                            onclick="window.location='{{ route('admin.users.index') }}'">Atšaukti
                                    </button>
                                    <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    @endauth
@endsection
