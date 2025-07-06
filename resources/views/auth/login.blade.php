@extends('main.layouts.authApp')

@section('title','Prisijungimas')

@section('content')
<div class="container vh-100">
    <div class="row justify-content-center ">
            <h2 class="text-center">PRISIJUNGIMAS</h2>
            <div class="col-lg-6 col-md-8 col-sm-10" style="padding: 20px;">
            <div class="card">
                <div class="card-body justify-content-center">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="row g-2 mb-3">
                            <label for="email" class="form-label">{{ __('El. paštas') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="row g-2 mb-3">
                            <label for="password" class="form-label">{{ __('Slaptažodis') }}</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="password">
                                <span class="input-group-text">
                                    <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                </span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-10 w-100 d-flex align-items-center justify-content-between">
                                <div class="col-md-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Prisiminti mane') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-end" href="{{ route('password.request') }}">
                                            {{ __('Pamiršote slaptažodį?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-10 w-100 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Prisijungti') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
