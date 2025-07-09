@extends('admin.layouts.appAdmin')

@section('title','Stovyklos')
@section('content')
            <div class="row mb-3">
                <div class="col-md-6">
                    <h2 class="mb-0 text-start">Renginiai</h2>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
                    <div class="mr-3" style="white-space: nowrap;">{{ count($camps) }} stovyklos</div>
                    <div class="input-group" style="max-width: 200px;">
                        <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
                    </div>
                    <button type="button" class="btn btn-secondary read-more" data-toggle="modal"
                            data-target="#createCampModal">
                        Sukurti stovyklą
                    </button>
                </div>
            </div>

            <!-- HTML structure for image preview -->
            <div class="image-preview" style="display: none;">
                <i class="bi bi-x-lg close-preview"></i>
                <img src="" alt="Preview Image">
            </div>


            <!-- Modal -->
            <div class="modal" id="createCampModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCampModalLabel">Stovyklos pridėjimas</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.camps.store')}}" method="POST" class="forma"
                                  enctype="multipart/form-data">
                                @csrf
                                @include('admin.camps.create')
                            </form>
                        </div>
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

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>


            <div class="row justify-content-center">
                @if($camps->isEmpty())
                    <div class="text-center">
                        <h4 class="p-4">Stovyklų dar nėra</h4>
                        <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
                    </div>
                @else
                    @foreach($camps as $camp)
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="card mb-3">
                                <div class="card-header text-start">
                                    <a href="#"
                                       class="btn btn-default" data-bs-toggle="modal"
                                       data-bs-target="#deleteCampModal{{ $camp->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <a class="btn btn-default" href="{{ route('admin.camps.edit', $camp->id) }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 d-flex justify-content-center align-items-center mb-3">
                                            <div class="bigSquare">
                                                @if ($camp->main_image)
                                                    <img class="adminCampImage preview-image"
                                                         src="{{ asset('storage/' . $camp->main_image) }}"
                                                         alt="Camp image">
                                                @else
                                                    <div class="avatar-placeholder">
                                                        <i class="bi bi-newspaper"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-9 d-flex flex-column justify-content-between">
                                            <h5>
                                                {{ $camp->title }}
                                                <span class="badge mx-3 @if($camp->status == 0) bg-success @elseif($camp->status == 1) bg-danger @endif">
                                                    @if($camp->status == 0)
                                                        Būsima
                                                    @elseif($camp->status == 1)
                                                        Pasibaigusi
                                                    @endif
                                                </span>

                                                <span class="badge @if($camp->type == "stovykla")
                                                        bg-warning
                                                    @elseif($camp->type == "seminaras")
                                                        bg-info
                                                    @else
                                                        bg-danger
                                                    @endif ">
                                                    @if($camp->type == "stovykla")
                                                        Stovykla
                                                    @elseif($camp->type == "seminaras")
                                                        Seminaras
                                                    @else
                                                        Projektas
                                                    @endif
                                                </span>
                                            </h5>

                                            <div>
                                                <ul class="row postcard__info">
                                                    <li class="col-md-3 tag__item">
                                                        <span class="fw-medium">Data: </span>
                                                        {{ substr($camp->start_date, 0, 16) }}
                                                        - {{ substr($camp->end_date, 0, 16) }}
                                                    </li>
                                                    <li class="col-md-3 tag__item"><span class="fw-medium">Kaina nariams: </span> {{ $camp->priceForMembers }}
                                                        EUR
                                                    </li>
                                                    <li class="col-md-3 tag__item"><span class="fw-medium">Kaina ne nariams: </span> {{ $camp->priceForGuests }}
                                                        EUR
                                                    </li>
                                                </ul>

                                                <ul class="row postcard__info">
                                                    <li class="col-md-3 tag__item"><span
                                                                class="fw-medium">Adresas: </span> {{ $camp->address }}
                                                    </li>
                                                    <li class="col-md-3 tag__item"><span
                                                                class="fw-medium">Aprašymas: </span> {{ $camp->description }}
                                                    </li>
                                                    <li class="col-md-3 tag__item">
                                                        <a href="{{ route('admin.camps.participants.show', $camp->id) }}"
                                                           class="li_item">
                                                        <span class="fw-medium">
                                                        Dalyvių kiekis:
                                                        </span>
                                                            {{ $camp->registrations->count() }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <p class="card-text">
                                                <button class="btn btn-default fw-medium expand-btn"
                                                        data-attribute="camp-id" data-id="{{ $camp->id }}">
                                                    Plačiau <i class="bi bi-chevron-down"></i>
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="expanded-row" data-camp-id="{{ $camp->id }}" style="display: none;">
                                        @if(!empty($camp->foodChoice) || !empty($camp->accommodation) || !empty($camp->clothing))
                                            <div class="row justify-content-center my-3">
                                                <div class="col-md-3 mb-3">
                                                    <div class="campItem">
                                                        <img src="{{asset('/images/food.png')}}" alt="topFrame">
                                                        <h6>Maitinimas</h6>
                                                        <p>{{$camp->foodChoice }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="campItem">
                                                        <img src="{{asset('/images/housing.png')}}"  alt="topFrame">
                                                        <h6>Apgyvendinimas</h6>
                                                        <p>{{ $camp->accommodation }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="campItem">
                                                        <img src="{{asset('/images/clothing.png')}}"  alt="topFrame">
                                                        <h6>Apranga</h6>
                                                        <p>{{ $camp->clothing }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(!empty($camp->worth) || !empty($camp->audience))
                                            <div class="row justify-content-center mb-3">
                                                <div class="col-md-3 mb-3">
                                                    <div class="campItem">
                                                        <img src="{{asset('/images/worth.png')}}"  alt="topFrame">
                                                        <h6>Kodėl verta dalyvauti?</h6>
                                                        <p>{{ $camp->worth }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3 ">
                                                    <div class="campItem">
                                                        <img src="{{asset('/images/audience.png')}}"  alt="topFrame">
                                                        <h6>Kam skirta ši stovykla?</h6>
                                                        <p>{{ $camp->audience }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                            <div class="row mb-3 justify-content-center text-center">
                                                @foreach ($programmes as $programme)
                                                    @if ($programme->id == $camp->programme_id)
                                                        <div class="col-md-3">
                                                            <div class="programmeItem">
                                                                <h6>programa</h6>
                                                                <div class="row justify-content-center">
                                                                    @foreach ($programme->images as $image)
                                                                        @if ($image->programme_id == $programme->id)
                                                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                                 class="preview-image" alt="Programme Image"
                                                                                 style="max-width: 100px;">
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                    </div>

                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endif
            </div>
            <!-- Message for no search results -->
            <div id="noResultsMessage" class="text-center" style="display: none;">
                <h6>Deja, tokios stovyklos nėra</h6>
                <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
            </div>

            @foreach($camps as $camp)
                <div class="modal fade" id="deleteCampModal{{ $camp->id }}" tabindex="-1"
                     aria-labelledby="deleteCampModalLabel{{ $camp->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMemberModalLabel">Pašalinti stovyklą</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Stovykla bus pašalinta
                                Ar tikrai pašalinti?
                                <div class="row mt-4">
                                    <div class="col-md-2">
                                        <div class="smallCircle">
                                            @if ($camp->main_image)
                                                <img class="avatar" src="{{ asset('storage/' . $camp->main_image) }}"
                                                     alt="Profile Image">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10 d-flex text-start flex-column justify-content-center">
                                        <h5>{{ $camp->title }} </h5>
                                        <span class="text-muted ml-2">
                                            {{ substr($camp->start_date, 0, 16) }} - {{ substr($camp->end_date, 0, 16) }}
                                        </span>
                                        <span class="fw-medium ml-2">{{ $camp->description }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('admin.camps.destroy', $camp->id) }}" method="post">
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
