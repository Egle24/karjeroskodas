@extends('admin.layouts.appAdmin')

@section('title','Atsiliepimai')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-0 text-start">Atsiliepimai</h2>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
            <div class="mr-3" style="white-space: nowrap;">{{ count($feedbacks) }} atsiliepimai</div>
            <div class="input-group" style="max-width: 200px;">
                <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
            </div>
        </div>
    </div>
    <div class="messages">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check2-circle" style="font-size: 20px;"></i>
                <ul class="d-flex align-items-center mb-0" style="list-style-type: none">
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>

    @if ($feedbacks->isEmpty())
        <div class="text-center">
            <div class="text-center">
                <h4 class="p-4">Atsiliepimų dar nėra</h4>
                <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
            </div>
        </div>
    @else
        <div class="row justify-content-start">
            @foreach($feedbacks as $feedback)
                <div class="col-md-6 col-sm-12 col-lg-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header text-end">
                            <a href="#" class="btn btn-default" data-bs-toggle="modal"
                               data-bs-target="#confirmFeedbackModal{{ $feedback->id }}">
                                <i class="bi bi-check-circle-fill"></i>
                            </a>
                            <a href="#" class="btn btn-default" data-bs-toggle="modal"
                               data-bs-target="#unconfirmFeedbackModal{{ $feedback->id }}">
                                <i class="bi bi-eye-slash-fill"></i>
                            </a>
                            <a href="#" class="btn btn-default" data-bs-toggle="modal"
                               data-bs-target="#deleteFeedbackModal{{ $feedback->id }}">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-sm-12 col-lg-3 d-flex justify-content-center align-items-center mb-3">
                                    <div class="bigCircle">
                                        @if ($feedback->user && $feedback->user->profile_image)
                                            <img class="avatar-placeholder"
                                                 src="{{ asset('storage/' . $feedback->user->profile_image) }}"
                                                 alt="Article Image">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-9 d-flex flex-column justify-content-between">
                                    <div class="d-flex flex-end">
                                        <div style="margin-right: auto">
                                            <span class="h5">
                                                @if ($feedback->user)
                                                    {{ $feedback->name }}
                                                @else
                                                    {{ $feedback->name }} {{ $feedback->surname }}
                                                @endif
                                            </span>
                                            <span class="h6">
                                                        @if ($feedback->status == 'unconfirmed')
                                                    <span class="badge bg-danger">Nepatvirtintas</span>
                                                @elseif ($feedback->status == 'confirmed')
                                                    <span class="badge bg-success">Patvirtintas</span>
                                                @endif
                                                    </span>
                                            <p class="fw-normal">
                                                {{ $feedback->feedback }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div id="noResultsMessage" class="text-center" style="display: none;">
        <h6>Deja, tokio atsiliepimo nėra</h6>
        <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
    </div>

    @foreach($feedbacks as $feedback)
        <!-- Confirmation modal for approving feedback -->
        <div class="modal fade" id="confirmFeedbackModal{{ $feedback->id }}" tabindex="-1"
             aria-labelledby="confirmFeedbackModalLabel{{ $feedback->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmFeedbackModalLabel">Patvirtinti atsiliepimą</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Šis atsiliepimas bus patvirtintas.
                        Ar tikrai norite patvirtinti?
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <div class="smallCircle">
                                    @if ($feedback->user && $feedback->user->profile_image)
                                        <img class="avatar"
                                             src="{{ asset('storage/' . $feedback->user->profile_image) }}"
                                             alt="Profile Image">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-10 d-flex text-start flex-column justify-content-center">
                                        <span class="fw-medium">
                                            @if ($feedback->user)
                                                {{ $feedback->user->name }} {{ $feedback->user->surname }}
                                            @else
                                                {{ $feedback->name }} {{ $feedback->surname }}
                                            @endif
                                        </span>
                                <span class="fw-normal">
                                            {{ $feedback->feedback }}
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.feedbacks.update', $feedback->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
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
    @endforeach

    @foreach($feedbacks as $feedback)
        <!-- Confirmation modal for approving feedback -->
        <div class="modal fade" id="unconfirmFeedbackModal{{ $feedback->id }}" tabindex="-1"
             aria-labelledby="confirmFeedbackModalLabel{{ $feedback->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="unconfirmFeedbackModalLabel">Paslėpti atsiliepimą</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Šis atsiliepimas nebebus matomas vartotojams.
                        Ar tikrai norite patvirtinti?
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <div class="smallCircle">
                                    @if ($feedback->user && $feedback->user->profile_image)
                                        <img class="avatar"
                                             src="{{ asset('storage/' . $feedback->user->profile_image) }}"
                                             alt="Profile Image">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-10 d-flex text-start flex-column justify-content-center">
                                        <span class="fw-medium">
                                            @if ($feedback->user)
                                                {{ $feedback->user->name }} {{ $feedback->user->surname }}
                                            @else
                                                {{ $feedback->name }} {{ $feedback->surname }}
                                            @endif
                                        </span>
                                <span class="fw-normal">
                                            {{ $feedback->feedback }}
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.feedbacks.update', $feedback->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="unconfirmed">
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
    @endforeach


    @foreach($feedbacks as $feedback)
        <div class="modal fade" id="deleteFeedbackModal{{ $feedback->id }}" tabindex="-1"
             aria-labelledby="deleteFeedbackModalLabel{{ $feedback->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteFeedbackModalLabel">Pašalinti atsiliepimą</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Šis atsiliepimas bus ištrintas.
                        Ar tikrai pašalinti?
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <div class="smallCircle">
                                    @if ($feedback->user && $feedback->user->profile_image)
                                        <img class="avatar"
                                             src="{{ asset('storage/' . $feedback->user->profile_image) }}"
                                             alt="Profile Image">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-10 d-flex text-start flex-column justify-content-center">
                                        <span class="fw-medium">
                                            @if ($feedback->user)
                                                {{ $feedback->user->name }} {{ $feedback->user->surname }}
                                            @else
                                                {{ $feedback->name }} {{ $feedback->surname }}
                                            @endif
                                        </span>
                                <span class="fw-normal">
                                            {{ $feedback->feedback }}
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="post">
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
    @endforeach
@endsection
