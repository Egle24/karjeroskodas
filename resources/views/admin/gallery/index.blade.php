@extends('admin.layouts.appAdmin')

@section('title','Galerijos')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-0 text-start">Galerijos</h2>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
            <div class="mr-3" style="white-space: nowrap;">{{ count($galleries) }} galerijos</div>
            <div class="input-group" style="max-width: 200px;">
                <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
            </div>
            <button type="button" class="btn btn-secondary read-more" data-toggle="modal"
                    data-target="#createGalleryModal">
                Sukurti galeriją
            </button>
        </div>
    </div>

    <div class="image-preview" style="display: none;">
        <i class="bi bi-x-lg close-preview"></i>
        <img src="" alt="Preview Image">
    </div>

    <div class="modal fade" id="createGalleryModal" tabindex="-1" aria-labelledby="createGalleryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGalleryModalLabel">Galerijos kūrimas</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.gallery.store')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="camp_id" class="form-label">Pasirinkite stovyklą</label>
                            <select class="form-select @error('camp_id') is-invalid @enderror" id="camp_id"
                                    name="camp_id">
                                <option value="">Pasirinkite stovyklą</option>
                                @foreach($camps as $camp)
                                    <option value="{{ $camp->id }}">{{ $camp->title }}</option>
                                @endforeach
                            </select>
                            @error('camp_id')
                            <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3" id="camp-info" style="display: none;">
                            <label for="title" class="form-label">Pavadinimas</label>
                            <input type="text" class="form-control" id="title" name="title" value="">

                        </div>
                        <div class="mb-3" id="camp-description" style="display: none;">
                            <label for="description" class="form-label">Aprašymas</label>
                            <textarea class="form-control" id="description" name="description"
                                      rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Įkelti nuotraukas</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror"
                                   id="images" name="images[]" multiple>
                            @error('images')
                            <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                            @enderror
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

    <div id="noResultsMessage" class="text-center" style="display: none;">
        <h6>Deja, tokios galerijos nėra</h6>
        <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
    </div>


    @if($galleries->isEmpty())
        <div class="text-center">
            <h4 class="p-4">Galerijų dar nėra</h4>
            <img src="{{ asset('/images/empty.png') }}" class="empty" alt="Empty Illustration">
        </div>
    @else
    <div class="row justify-content-start">
        @foreach($galleries as $gallery)
            <div class="col-md-12 col-lg-6 col-sm-12">
                <div class="card mb-3">
                    <div class="card-header text-start">
                        <a href="{{route('admin.gallery.deleteImages', $gallery->id)}}" class="btn btn-default">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <a href="{{route('admin.gallery.edit', $gallery->id)}}" class="btn btn-default">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-sm-12 col-lg-4 d-flex justify-content-center align-items-center mb-3">
                                <div class="bigCircle">
                                    @if ($gallery->images)
                                        <img class="avatar preview-image"
                                             src="{{ $gallery->images->isNotEmpty() ? asset('storage/' . $gallery->images->first()->image_path) : ''}}"
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
                                        <h5>{{ $gallery->title }}</h5>
                                        <span class="text-muted ml-2">Nuotraukų skaičius: {{ $gallery->images->count() }}</span>
                                    </div>
                                </div>
                                <p class="card-text">
                                    <button class="btn btn-default fw-medium expand-btn"
                                            data-attribute="gallery-id" data-id="{{ $gallery->id }}">
                                        Plačiau <i class="bi bi-chevron-down"></i>
                                    </button>
                                </p>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="expanded-row" data-gallery-id="{{ $gallery->id }}" style="display: none;">
                            <div class="row my-3">
                                @foreach($gallery->images as $image)
                                    <div class="col-md-2 mb-3">
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                           data-lightbox="gallery" data-title="{{ $image->title }}">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                 class="img-fluid rounded images" alt="{{ $image->title }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    @foreach($galleries as $gallery)
        <div class="modal fade" id="deleteGalleryModal{{ $gallery->id }}" tabindex="-1"
             aria-labelledby="deleteGalleryModalLabel{{ $gallery->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteGalleryModalLabel">Galerijos šalinimas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        lightbox.option({
            'resizeDuration': 100,
            'wrapAround': true,
            'fadeDuration': 200,
        })
    </script>
@endsection
