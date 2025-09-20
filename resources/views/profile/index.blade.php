@extends('main.layouts.app')

@section('title','Profilis')
@section('content')
<div class="campContainer text-center py-5">
    <div class="textFrame w-70">
        <h1 class="text-white text-uppercase">Jūsų profilis</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Tabs above content -->
<div class="col-md-8 p-0">
    <!-- Tab buttons (no gap) -->
    <div class="btn-group w-100 mb-4" id="profile-tabs" role="tablist">
        <button class="btn btn-shadow-info active flex-fill" id="profile-info-tab" data-bs-toggle="pill" data-bs-target="#profileInfo" type="button" role="tab">
            Profilio informacija
        </button>
        <button class="btn btn-shadow-info flex-fill" id="user-camps-tab" data-bs-toggle="pill" data-bs-target="#userCamps" type="button" role="tab">
            Mano stovyklos
        </button>
        <button class="btn btn-shadow-info flex-fill" id="membership-tab" data-bs-toggle="pill" data-bs-target="#otherInfo" type="button" role="tab">
            Narystė
        </button>
    </div>

    <!-- Tab content -->
    <div class="tab-content" id="profile-tabContent">
        <!-- Profilio informacija -->
        <div class="tab-pane fade show active" id="profileInfo" role="tabpanel">
            <div class="card profile">
                <div class="card-body">
                    {{-- Your profile info content --}}
                </div>
            </div>
        </div>

        <!-- Mano stovyklos -->
        <div class="tab-pane fade" id="userCamps" role="tabpanel">
            <div class="card profile">
                <div class="card-body">
                    {{-- Your camps content --}}
                </div>
            </div>
        </div>

        <!-- Narystė -->
        <div class="tab-pane fade" id="otherInfo" role="tabpanel">
            <div class="card profile">
                <div class="card-body">
                    {{-- Your membership content --}}
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Tab content -->
        <div class="col-md-6 p-0">
            <div class="tab-content" id="profile-tabContent">
                <!-- Profilio informacija -->
                <div class="tab-pane fade show active" id="profileInfo" role="tabpanel">
                    <div class="card profile">
                        <div class="card-body">
                            
                                <h3>{{ auth()->user()->name }} {{ auth()->user()->surname }}</h3>
                                <div class="bigCircle my-3">
                                    @if (auth()->user()->profile_image)
                                        <img class="avatar" src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image">
                                    @else
                                        <div class="avatar-placeholder"><i class="bi bi-person"></i></div>
                                    @endif
                                </div>
                                <div class="profile-mygtukai pb-4">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updateImageModal">
                                        Įkelti nuotrauką
                                    </a>
                                    @if (auth()->user()->profile_image)
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteImageModal">
                                        Ištrinti nuotrauką
                                    </a>
                                    @endif
                                </div>
                            
                           
                                <h5 class="card-title">Profilio informacija</h5>
                                <form action="{{ route('profile.updateName') }}" method="POST" class="mb-3 d-flex align-items-center gap-2">
                                    @csrf
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Vardas</label>
                                            <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="surname" class="form-label">Pavardė</label>
                                            <input type="text" name="surname" id="surname" value="{{ auth()->user()->surname }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">Išsaugoti</button>
                                        </div>
                                    </div>
                                </form>

                                <p><strong>Rolė:</strong>
                                    @foreach(auth()->user()->roles as $role)
                                        {{ $role->name === 'admin' ? 'Administratorius' : 'Narys' }}
                                    @endforeach
                                </p>
                                <p><strong>Paskutinė profilio redagavimo data:</strong> {{ auth()->user()->updated_at->format('Y-m-d') }}</p>

                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updatePasswordModal">
                                    Keisti slaptažodį
                                </a>
                            
                        </div>
                    </div>
                </div>

                <!-- Mano stovyklos -->
                <div class="tab-pane fade" id="userCamps" role="tabpanel">
                     <div class="card profile">
                        <div class="card-body">
                            @if ($userCamps->isNotEmpty())
                                @foreach ($userCamps as $camp)
                                    @php $camp = \App\Models\Camp::find($camp->camp_id); @endphp
                                    @if ($camp)
                                    <article class="postcard">
                                        <img src="{{ asset('storage/camp_images/' . $camp->main_image) }}" alt="campImage" class="postcard__img">
                                        <div class="postcard__text">
                                            <h5 class="postcard__title headings">{{ $camp->title }}</h5>
                                            <ul class="postcard__info">
                                                <li class="tag__item">{{ substr($camp->start_date, 0, 16) }} - {{ substr($camp->end_date, 0, 16) }}</li>
                                            </ul>
                                            <p>{{ $camp->description }}</p>
                                            <a href="{{ route('camps.show', ['slug' => $camp->slug]) }}" class="btn btn-primary w-50">Plačiau</a>
                                        </div>
                                    </article>
                                    @endif
                                @endforeach
                            @else
                                <p class="fw-medium">Jūs dar nesate užsiregistravę į stovyklas</p>
                                <a href="{{ route('camps.index') }}" class="btn btn-primary">Peržiūrėti stovyklas</a>
                            @endif
                        </div>
                     </div>
                </div>

                <!-- Narystė -->
                <div class="tab-pane fade" id="otherInfo" role="tabpanel">
                    @php $userMemberships = auth()->user()->memberships()->get(); @endphp
                    @if ($userMemberships->isNotEmpty())
                        @foreach ($userMemberships as $membership)
                            <h6 class="mb-3">Jūsų narystė galioja iki {{ $membership->subscription_end_date }}</h6>
                            <h6 class="mb-3">Iki narystės pabaigos liko:</h6>
                            <div class="row gap-3 mb-3 justify-content-center w-50">
                                <div class="countdown">
                                    <h5>
                                        @php
                                            $now = now();
                                            $subscriptionEndDate = \Carbon\Carbon::parse($membership->subscription_end_date);
                                            $remainingTime = $now->diff($subscriptionEndDate);
                                            $months = $remainingTime->m + ($remainingTime->y * 12);
                                            $days = $remainingTime->d;
                                            echo $months;
                                        @endphp
                                    </h5>
                                    <p>mėn.</p>
                                </div>
                                <div class="countdown">
                                    <h5>{{ $days }}</h5>
                                    <p>d.</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="fw-medium">Jūs neturite narystės.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('main.layouts.profile-modals')

@endsection
