@extends('admin.layouts.appAdmin')

@section('title','Programos')
@section('content')
        <div class="row mb-3">
            <div class="col-md-6">
                <h2 class="mb-0 text-start">Programos</h2>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
                <div class="mr-3" style="white-space: nowrap;">{{ count($programmes) }} programos</div>
                <div class="input-group" style="max-width: 200px;">
                    <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
                </div>
                <button type="button" class="btn btn-secondary read-more" data-toggle="modal"
                        data-target="#programmeModal">
                    Sukurti programą
                </button>
            </div>
        </div>


        <!-- HTML structure for image preview -->
        <div class="image-preview" style="display: none;">
            <i class="bi bi-x-lg close-preview"></i>
            <img src="" alt="Preview Image">
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

        <div class="modal fade" id="programmeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="programmeModalLabel">Progamos kūrimas</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.camps.programmes.store')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Pavadinimas</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}">
                            </div>
                            <div class="row g-2" id="imageFieldsContainer">
                                <div class="mb-3">
                                    <label for="image_count" class="form-label">Nuotraukų skaičius</label>
                                    <input id="image_count" type="number"
                                           class="form-control @error('image_count') is-invalid @enderror"
                                           name="image_count" value="{{ old('image_count') }}" required
                                           autocomplete="image_count" min="1">
                                    @error('image_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="additionalImageFields" class="mb-3"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if($programmes->isEmpty())
                <div class="text-center">
                    <h4 class="p-4">Programų dar nėra</h4>
                    <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
                </div>
            @else
                @foreach($programmes as $programme)
                    <div class="col-md-4 col-lg-4 col-sm-6">
                        <div class="card mb-3">
                            <div class="card-header text-start">
                                <a href="#"
                                   class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#deleteProgrammeModal{{ $programme->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                                <a class="btn btn-default"
                                   href="{{route('admin.camps.programmes.edit', $programme->id)}}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <h4>{{$programme->title}}</h4>
                                    @foreach ($programme->images as $image)
                                        <div class="col-sm-6">
                                            <a href="{{ asset('storage/' . $image->image_path) }}"
                                               data-lightbox="programme" data-title="{{ $image->title }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                     class="img-fluid rounded images" alt="{{ $image->title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="noResultsMessage" class="text-center" style="display: none;">
            <h6>Deja, tokios programos nėra</h6>
            <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
        </div>


        @foreach($programmes as $programme)
            <div class="modal fade" id="deleteProgrammeModal{{ $programme->id }}" tabindex="-1"
                 aria-labelledby="deleteProgrammeModalLabel{{ $programme->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProgrammeModalLabel">Programos šalinimas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Ši programa su visomis nuotraukomis bus ištrinta. Ar tikrai pašalinti?
                            <div class="row mt-4">
                                <h5 class="text-center">{{ $programme->title }}</h5>
                            </div>

                            <div class="row mt-4 justify-content-center">
                                @foreach ($programme->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Programme Image"
                                         style="max-width: 100px;">
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.camps.programmes.destroy', $programme->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <br>
                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection
