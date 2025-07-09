@extends('main.layouts.app')


@section('title','Profilis')
@section('content')
    <div class="campContainer text-center py-5">
        <div class="textFrame w-70">
            <h1 class="text-white text-uppercase">
                Jūsų profilis
            </h1>
        </div>
    </div>
    <div class="container py-5">
        <div class="profile-section text-center">
            <div class="row justify-content-center py-4">
                <div class="col-lg-4 col-sm-6">
                    <div class="card p-2 profile-card">
                        <div class="card-body h-100">
                            @if (session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger mt-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            <h3 class="card-title">{{ auth()->user()->name }} {{ auth()->user()->surname }}</h3>
                            <div class="bigCircle">
                                @if (auth()->user()->profile_image)
                                <img class="avatar" src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image">

                                @else
                                    <div class="avatar-placeholder">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            @if (auth()->user()->profile_image)
                                <a href="#" class="btn btn-primary pb-2 " data-toggle="modal" data-target="#updateImageModal">
                                    Įkelti nuotrauką
                                </a>
                                <a href="#" class="btn btn-primary pb-2 " data-toggle="modal" data-target="#deleteImageModal">
                                    Ištrinti nuotrauką
                                </a>
                            @else
                                <a href="#" class="btn btn-primary pb-2 " data-toggle="modal" data-target="#updateImageModal">
                                    Įkelti nuotrauką
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <nav class="navbar navbar-expand-sm navbar-light justify-content-center py-2" id="navUsersSecond">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarProfile" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarProfile">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-section="userCamps">Mano stovyklos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="otherInfo">Narystė</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="profileInfo">Profilio informacija</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="row mb-3 justify-content-center text-center">
            <!-- Profilio informacija Section -->
            <div id="profileInfo" class="profile-info-section" style="display: none; width: 50%;">
                <div class="card">
                    <div class="card-body text-start">
                        <h5 class="card-title">Profilio informacija</h5>
                        <form action="{{ route('profile.updateName') }}" method="POST" class="mb-3 d-flex align-items-center gap-2">
                            @csrf
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Vardas</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="surname" class="form-label">Pavardė</label>
                                    <div class="input-group">
                                        <input type="text" name="surname" id="surname" value="{{ auth()->user()->surname }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Išsaugoti</button>
                                </div>
                            </div>
                        </form>
                        <p class="card-text">
                            <strong>Rolė:</strong>
                            @foreach(auth()->user()->roles as $role)
                                {{ $role->name === 'admin' ? 'Administratorius' : 'Narys' }}
                            @endforeach
                        </p>
                        <p class="card-text">
                            <strong>Paskutinė profilio keitimo data:</strong>
                            {{ auth()->user()->updated_at->format('Y-m-d') }}
                        </p>

                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updatePasswordModal">
                            Keisti slaptažodį
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Slaptažodžio keitimas</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <form action="{{ route('profile.updatePassword') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Dabartinis slaptažodis</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Naujas slaptažodis</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <div class="password-strength mt-2">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <small class="strength-text" id="strengthText">Įveskite slaptažodį</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Patvirtinti naują slaptažodis</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            <div class="password-match mt-2">
                                <small class="match-text" id="matchText" style="display: none;"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti</button>
                            <button type="submit" class="btn btn-secondary">Atnaujinti</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 justify-content-center text-center">
            <div id="userCamps" class="camps-section">
                @if ($userCamps->isNotEmpty())
                    @foreach ($userCamps as $camp)
                        @php
                            $camp = \App\Models\Camp::find($camp->camp_id);
                        @endphp
                        @if ($camp)
                            <article class="postcard">
                                <img src="{{ asset('storage/' . $camp->main_image) }}" alt="campImage" class="postcard__img">
                                <div class="postcard__text">
                                    <h5 class="postcard__title headings">
                                        {{ $camp->title }}
                                    </h5>
                                    <ul class="postcard__info">
                                        <li class="tag__item">{{ substr($camp->start_date, 0, 16) }} - {{ substr($camp->end_date, 0, 16) }}</li>
                                    </ul>
                                    <p class="card-text">
                                        {{ $camp->description }}
                                    </p>

                                    <a href="{{ route('camps.show', ['slug' => $camp->slug]) }}" class="btn btn-primary w-50">
                                        Plačiau
                                    </a>
                                </div>
                            </article>
                        @endif
                    @endforeach
                @else
                    <p class="fw-medium">Jūs dar nesate užsiregistravę į stovyklas</p>
                    <a href="{{ route('camps.index') }}" class="btn btn-primary">Peržiūrėti stovyklas</a>
                @endif
            </div>


            <!-- Display other information -->
            <div id="otherInfo" class="membership-section" style="display: none;">
                @php
                    $userMemberships = auth()->user()->memberships()->get();
                @endphp
                @if ($userMemberships->isNotEmpty())
                    @foreach ($userMemberships as $membership)
                        <h6 class="mb-3">Jūsų narystė galioja iki {{ $membership->subscription_end_date }}</h6>
                        <h6 class="mb-3">Iki narystės pabaigos liko:</h6>
                        <div class="row gap-3 mb-3 justify-content-center w-50">
                            <div class="countdown">
                                <h5 class="card-title">
                                    @php
                                        $now = now();
                                        $subscriptionEndDate = \Carbon\Carbon::parse($membership->subscription_end_date);
                                        $remainingTime = $now->diff($subscriptionEndDate);
                                        $months = $remainingTime->m + ($remainingTime->y * 12);
                                        $days = $remainingTime->d;
                                            echo $months;
                                    @endphp
                                </h5>
                                <p class="card-text">
                                    mėn.
                                </p>
                            </div>
                            <div class="countdown">
                                <h5 class="card-title">
                                    @php
                                        echo $days;
                                    @endphp

                                </h5>
                                <p class="card-text">
                                    d.
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="updateImageModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateImageModalLabel">Profilio nuotraukos įkėlimas</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <form action="{{ route('profile.updateImage') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!-- Display validation errors -->
                                

                                <div class="col-md-12">
                                    <label for="profile_image" class="form-label">Pasirinkite nuotrauką</label>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                        Atšaukti
                                    </button>
                                    <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteImageModalLabel">Profilio nuotraukos pašalinimas</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ar tikrai norite pašalinti profilio nuotrauką?</p>
                    </div>

                    <div class="modal-footer">
                        <form action="{{ route('profile.deleteImage') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <br>
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                                Atšaukti
                            </button>
                            <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
