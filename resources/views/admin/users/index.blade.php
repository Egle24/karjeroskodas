@extends('admin.layouts.appAdmin')

@section('title','Nariai')

@section('content')
            <div class="row mb-3">
                <div class="col-md-6">
                    <h2 class="mb-0 text-start">Nariai</h2>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Pridėti naują narį</a>
                    <div class="mr-3" style="white-space: nowrap;">{{ count($users) }} narių</div>
                    <div class="input-group" style="max-width: 200px;">
                        <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check2-circle" style="font-size: 20px;"></i>
                    <ul class="d-flex align-items-center mb-0" style="list-style-type: none">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            @endif

            <!-- Error message -->
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if($users->isEmpty())
                <div class="text-center">
                    <h4 class="p-4">Narių dar nėra</h4>
                    <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
                </div>
            @else
            <div class="row justify-content-start">
                @foreach($users as $user)
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="card mb-3">
                            <div class="card-header text-start">
                                <a href="#" class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#deleteMemberModal{{ $user->id }}">
                                    <i class="bi bi-person-dash-fill"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-default">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-sm-12 col-lg-4 d-flex justify-content-center align-items-center mb-3">
                                        <div class="bigCircle">
                                            @if ($user->profile_image)
                                                <img class="avatar preview-image"
                                                     src="{{ asset('storage/' . $user->profile_image) }}"
                                                     alt="Article Image">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-lg-8 d-flex flex-column justify-content-between">
                                        <div class="d-flex flex-end">
                                            <div style="margin-right: auto">
                                                <span class="h5">{{ $user->name }} {{ $user->surname }}</span>
                                                <h6>
                                                    @foreach($user->roles as $role)
                                                        @if($role->name === 'admin')
                                                            <span class="badge bg-primary">Administratorius</span>
                                                        @elseif($role->name === 'member')
                                                            <span class="badge bg-success">Narys</span>
                                                        @endif
                                                    @endforeach
                                                </h6>
                                                <span class="text-muted ml-2">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            <button class="btn btn-default fw-medium expand-btn"
                                                    data-attribute="users-id" data-id="{{ $user->id }}">
                                                Plačiau <i class="bi bi-chevron-down"></i>
                                            </button>
                                        </p>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                <div class="expanded-row" data-users-id="{{ $user->id }}" style="display: none;">
                                    <div class="row my-3">
                                        @foreach ($user->memberships as $membership)
                                            <div>
                                                @if ($membership->status === 'active')
                                                    <h5>
                                                        <span class="badge bg-success">Aktyvi</span>
                                                    </h5>
                                                    <h6>
                                                        Baigia galioti
                                                        už {{ now()->diffInDays($membership->subscription_end_date) }}
                                                        dienų
                                                    </h6>
                                                @else
                                                    <h5>
                                                        <span class="badge bg-danger">Neaktyvi</span>
                                                    </h5>
                                                @endif
                                                    @if ($user->memberships->isNotEmpty())
                                                        @php
                                                            $latestMembership = $user->memberships->sortByDesc('subscription_end_date')->first();
                                                        @endphp

                                                        @if ($latestMembership->subscription_end_date < now())
                                                            <form action="{{ route('admin.users.renewMembership', $user->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary">Atnaujinti narystę</button>
                                                            </form>
                                                        @else
                                                            <span class="text-success">Narystė aktyvi iki {{ $latestMembership->subscription_end_date }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-danger">Narys neturi narystės.</span>
                                                    @endif
                                            </div>
                                        @endforeach

                                        @if ($user->memberships->isEmpty())
                                            <p>Narys neturi narystės</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Message for no search results -->
            <div id="noResultsMessage" class="text-center" style="display: none;">
                <h6>Deja, tokio nario nėra</h6>
                <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
            </div>

            @foreach($users as $user)
                <!-- Delete Member Modal -->
                <div class="modal fade" id="deleteMemberModal{{ $user->id }}" tabindex="-1"
                     aria-labelledby="deleteMemberModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMemberModalLabel">Pašalinti narį</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Visa informacija susijusi su šiuo nariu bus pašalinta.
                                Ar tikrai pašalinti?
                                <div class="row mt-4">
                                    <div class="col-md-2">
                                        <div class="smallCircle">
                                            @if ($user->profile_image)
                                                <img class="avatar" src="{{ asset('storage/' . $user->profile_image) }}"
                                                     alt="Profile Image">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10 d-flex text-start flex-column justify-content-center">
                                        <h5>{{ $user->name }} {{ $user->surname }}</h5>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <br>
                                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                        Atšaukti
                                    </button>
                                    <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
@endsection
