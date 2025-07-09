@extends('main.layouts.app')

@section('title','Renginiai')

@section('content')
    <div class="campContainer text-center py-6">
        <div class="textFrame w-70">
            <h1 class="text-white text-uppercase">
            Renginiai
            </h1>
        </div>
    </div>

    <div class="container py-5 px-2">
    <div id="statusFormContainer">
        <form id="statusForm">
            <div class="custom-select-container">
                <div class="custom-select" id="customSelect">
                    <span class="selected">Visi renginiai</span>
                    <div class="dropdown-arrow">▼</div>
                </div>
                <div class="custom-options">
                    <div class="custom-option" data-value="">Visi renginiai</div>
                    <div class="custom-option" data-value="stovykla">Stovyklos</div>
                    <div class="custom-option" data-value="seminaras">Seminarai</div>
                    <div class="custom-option" data-value="projektas">Projektai</div>
                </div>
            </div>
        </form>
    </div>
</div>

    <div class="container py-3">
        <div class="camps">
            <div class="headers mb-3">
            </div>
            

            @if($camps->isEmpty())
            <div class="text-center no-camps-message" style="display: none;">
                <h4 class="p-4">Renginių dar nėra</h4>
                <img src="{{ asset('images/empty.png') }}" class="empty" alt="Empty Illustration">
            </div>
            @else

            <div class="text-center no-camps-message" style="display: none;">
                <h4 class="p-4">Renginių pagal jūsų užklausą dar nėra</h4>
                <img src="{{ asset('images/empty.png') }}" class="empty" alt="Empty Illustration">
            </div>
            @foreach($camps as $camp)
                <div class="postcard" data-type="{{ $camp->type }}">
                    <img src="{{ asset('storage/camp_images/' . $camp->main_image) }}" alt="campImage" class="postcard__img">
                    <div class="postcard__text">
                        <h5 class="postcard__title headings">
                            "{{ $camp->title }}"
                        </h5>
                        <ul class="postcard__info">
                            <li class="tag__item">{{ substr($camp->start_date, 0, 16) }} - {{ substr($camp->end_date, 0, 16) }}</li>
                            <li class="tag__item">@auth {{ $camp->priceForMembers }} EUR @else {{ $camp->priceForGuests }} EUR @endauth</li>
                        </ul>
                        <p class="card-text">
                            {{ $camp->description }}
                        </p>
                        @php
                            $gallery = $camp->gallery;
                        @endphp
                        @if($camp->status == 1)
                                <a href="{{ route('gallery.show', $gallery->slug ?? '') }}" class="btn btn-primary w-50">
                                    Plačiau
                                </a>
                            @else
                                <a href="{{ route('camps.show', ['slug' => $camp->slug]) }}" class="btn btn-primary w-50">
                                    Plačiau
                                </a>
                            @endif
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
    var options = document.querySelectorAll('.custom-option');
    var camps = document.querySelectorAll('.postcard');
    var noCampsMessage = document.querySelector('.no-camps-message');
    var customSelect = document.getElementById('customSelect');

    options.forEach(function (option) {
        option.addEventListener('click', function () {
            var filterValue = this.getAttribute('data-value');
            var selectedText = this.textContent;
            var visibleCount = 0;

            // Update dropdown text
            if (customSelect) {
                customSelect.querySelector('.selected').textContent = selectedText;
            }

            camps.forEach(function (camp) {
                var campType = camp.getAttribute('data-type');
                var show = (filterValue === '') || (campType === filterValue);

                if (show) {
                    camp.style.display = 'flex';
                    visibleCount++;
                } else {
                    camp.style.display = 'none';
                }
            });

            if (noCampsMessage) {
                noCampsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    });

    // Initial state: show all
    var initialVisible = camps.length;
    if (noCampsMessage) {
        noCampsMessage.style.display = initialVisible === 0 ? 'block' : 'none';
    }
});
    </script>
@endsection
