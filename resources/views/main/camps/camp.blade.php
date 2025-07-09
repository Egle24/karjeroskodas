@extends('main.layouts.app')

@section('title','Stovyklos')
@section('content')
    <div class="camp-hero py-6" 
     style="background: url('{{asset('storage/camp_images/' . $camp->main_image) }}') no-repeat center center; background-size: cover;">
        <div class="container">
                <h1 class="text-white text-start">
                    {{ $camp->title }}
                </h1>
                <div class="camp_info">
                        <div class="event_info">
                            <i class="fi fi-rr-map-marker"></i>
                            <p class="text-center">{{ $camp->address }}</p>
                        </div>
                        <div class="event_info">
                            <i class="fi fi-rr-calendar-clock"></i>
                        <p class="text-center"> {{ \Carbon\Carbon::parse($camp->start_date)->format('Y-m-d') }}  -
                             {{ \Carbon\Carbon::parse($camp->end_date)->format('Y-m-d') }}</p>
                        </div>
                </div>  
        </div>
    </div>


    <div class="container py-6">
        <div class="row justify-content-between">
            <div class="col-lg-8">
                <h2>Stovyklos aprašymas</h2>
                 <p class="pb-3">{{ $camp->description }}</p>
                <img src="{{asset('storage/camp_images/' . $camp->main_image) }}" alt="campImage" class="image-in-container">
            </div>
            <div class="col-lg-4 camp-right-column">
                <div class="event_imp_info_card">
                    <div class="event_imp_info_card_body gap-3">
                         <div class="price-box">
                            <span class="camp-price">
                                @auth
                                    {{ $camp->priceForMembers }}
                                @else
                                    {{ $camp->priceForGuests }}
                                @endauth
                                €
                            </span>
                            <span class="per-person">/ dalyviui</span>
                        </div>
                        <a href="{{route('camp.show', $camp)}}" class="btn btn-secondary">Dalyvauti</a>
                        <h5>Svarbi informacija:</h5>
                        <div class="event_info-black">
                            <i class="fi fi-rr-restaurant"></i>
                            <p>Maitinimas: {{ $camp->foodChoice }}</p>
                        </div>
                        <div class="event_info-black">
                            <i class="fi fi-rr-tents"></i>
                            <p>Apgyvendinimas: {{ $camp->accommodation }}</p>
                        </div>
                        <div class="event_info-black">
                            <i class="fi fi-rr-tshirt"></i>
                            <p>Apranga: {{ $camp->clothing }}</p>
                        </div>
                    </div>
                 </div>

                 <div class="additional-info">
                    <h5>Kodėl verta dalyvauti ir kam skirtas renginys?</h5>
                    <div class="event_info-black">
                    <i class="fi fi-rr-circle-1"></i>
                    <p>{{ $camp->worth }}</p>
                    </div>
                    <div class="event_info-black">
                    <i class="fi fi-rr-circle-2"></i>
                    <p>{{ $camp->audience }}</p>
                    </div>
                    

                 </div>
            </div>
        </div>
    </div>

    <div class="bg-container">
        <div class="container py-6">
            <div class="row gap-4 justify-content-center px-5 pt-5">
                <h2 class="text-center mb-3">Renginio programa</h2>
                @if ($camp->programme)
                    <div class="col-lg-8 col-md-12 col-sm-12 mb-3">
                        <div class="row">
                            @foreach ($camp->programme->images as $image)
                                <div class="col-md-6 mb-3">
                                    <div class="image-container">
                                        <a href="{{ asset('storage/camp_images/' . $image->image_path) }}" data-lightbox="programme" data-title="{{ $image->title }}">
                                            <img src="{{ asset('storage/camp_images/' . $image->image_path) }}" class="img-fluid rounded images" alt="{{ $image->title }}">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center campBottom">
            <h4>Dalyvauk „{{ $camp->title }}"</h4>
            <br>
            <a href="{{route('camp.show', $camp)}}" class="btn btn-secondary w-30">Dalyvauti</a>
            <br>
            <p class="fw-medium">Iškilo klausimų? <a href="{{route('contactForm')}}" class="link">SUSISIEK SU MUMIS!</a></p>
        </div>

    <script>
        lightbox.option({
            'resizeDuration': 100,
            'wrapAround': true,
            'fadeDuration': 200,
        })
    </script>
@endsection
