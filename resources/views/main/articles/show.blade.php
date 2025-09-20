@extends('main.layouts.app')

@section('title',$article->title)
@section('content')
    <div class="container pe-0 articleTop">
        <div class="row align-items-center">
            <div class="col-lg-6 pe-5">
                <h1>{{ $article->title }}</h1>
                <hr>
                <div class="article-icons">
                    <i class="fi fi-rr-suitcase-alt"></i>
                    <p>{{$article->category->title}}</p>
                </div>
                <div class="article-icons">
                    <i class="fi fi-rr-calendar-lines"></i>
                    <p>{{ date('Y-m-d', strtotime($article->date)) }}</p>
                </div>
                
            </div>
            <div class="col-lg-6 p-0">
                <img src="{{ asset('storage/article_images/' . $article->image) }}" class="article-top-image" alt="Article Image">
            </div>
        </div>
    </div>
    <div class="container articleText pt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10">
                <h3>Renginio aprašymas</h3>
                <div class="article-content">
                    {!! $article->content !!} <!-- This will display the content as HTML -->
                </div>
                <hr>
                @if($article->link)
                    <p>
                        Straipsnį taip pat galite skaityti čia:
                        <a href="{{ $article->link }}" target="_blank">{{ $article->link }}</a>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">
            <!-- Display files -->
            <div class="col-md-12 mt-4">
                <h3>Renginio medžiaga</h3>
                @if (!empty($files) && count($files) > 0)
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

    <div class="container pt-3">
        <div class="row">
            <div class="col-md-12 mt-4">
                <h3>Renginio nuotraukos</h3>
                @if ($gallery)
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
                    <div class="row mt-3">
                        <p>Renginio galerija bus įkelta greitu metu.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
 
        <div class="container py-5">
            <div class="row gap-4" id="articles">
                <h2>Taip pat skaitykite: </h2>
                <div class="row justify-content-start">
                    @foreach($relatedArticles as $article)
                    <div class="col-lg-6 mb-4" data-category="{{ $article->category->title }}">
                        <div class="article_card mb-3" style="border: 0">
                            <div class="row m-0">
                                <div class="col-md-4 article_image" style="background-image:url('{{ asset('storage/article_images/' . $article->image) }}');"></div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }}</h5>
                                        <p class="card-text">
                                            {!! \Illuminate\Support\Str::limit($article->content, 300) !!}
                                        </p>
                                        <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($article->date)->format('Y-m-d') }}</small></p>
                                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}"  class="card-text"><small>Skaityti daugiau</small></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
