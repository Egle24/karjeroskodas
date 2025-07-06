@extends('main.layouts.app')

@section('title','Galerija')
@section('content')
    <div class="campContainer text-center py-6">
        <div class="textFrame w-70">
            <h1 class="text-white text-uppercase">
                Galerija
            </h1>
        </div>
    </div>
    <div class="container py-5 px-2">
        @if ($galleries->isEmpty())
            <div class="text-center">
                <h4 class="p-4">Galerijų dar nėra</h4>
                <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
            </div>
        @else
        <div class="row justify-content-center gap-4">
            @foreach($galleries as $gallery)
                <a href="{{ route('gallery.show', ['slug' => $gallery->slug]) }}" class="card text-white card-has-bg click-col" id="galleryCard" style="background-image:url('{{ asset('storage/' . $gallery->images->first()->image_path) }}');">
                    <img class="card-img d-none" src="{{ asset('storage/' . $gallery->images->first()->image_path) }}" alt="Gallery Image">
                    <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                            <h4 class="card-title mt-0 ">"{{ $gallery->title }}"</h4>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        @endif

        <div class="mt-4">
            {{ $galleries->links() }}
        </div>
    </div>
@endsection
