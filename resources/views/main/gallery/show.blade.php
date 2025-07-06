@extends('main.layouts.app')

@section('title','Galerija')
@section('content')
    <div class="campContainer text-center py-6">
        <div class="textFrame w-70">
            <h2 class="text-white text-uppercase">
                Stovyklos "{{ $gallery->title }}"  galerija
            </h2>
            <h5 class="text-white text-uppercase">
                {{ $gallery->description }}
            </h5>
        </div>
    </div>

    <div class="container pt-6">
        <div class="row">
            <!-- Display files -->
            <div class="col-md-12 mt-4">
                <h4>Renginio medžiaga</h4>
                @if ($files->isNotEmpty())
                    <div class="row mt-3">
                        @foreach($files as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" class="file-download" download>
                                <p class="card-text text-truncate">{{ $file->file_name }}</p>
                                <i class="fi fi-rr-download" ></i>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="row mt-3">
                        <p>Renginio medžiaga bus įkelta greitu metu.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container py-6">
        <div class="row">
            <div class="col-md-12 mt-3">
                @if ($gallery)
                    <h4>Renginio nuotraukos</h4>
                    <div class="row mt-3">
                        @foreach($gallery->images as $index => $image)
                            <div class="col-md-4 col-sm-6 col-lg-3 mb-3">
                                <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="gallery" data-title="{{ $image->title }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded images" alt="{{ $image->title }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center">
                        <h5>Galerija šiai stovyklai dar nesukurta.</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        lightbox.option({
            'resizeDuration': 100,
            'wrapAround': true,
            'fadeDuration': 200,
        })
    </script>
@endsection
