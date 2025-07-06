@extends('main.layouts.app')

@section('title','Straipsniai')
@section('content')
    <div class="container pe-0 articleTop">
        <div class="row align-items-center">
            <div class="col-lg-4 pe-5">
                <div class="d-flex justify-content-between">
                    <p class="text-white">{{$article->category->title}}</p>
                    <p class="text-white">{{ date('Y-m-d', strtotime($article->date)) }}</p>
                </div>
                <hr>
                <h2 class="text-white">{{ $article->title }}</h2>
            </div>
            <div class="col-lg-8 p-0">
                <img src="{{ asset('storage/article_images/' . $article->image) }}" class="article-top-image" alt="Article Image">
            </div>
        </div>
    </div>
    <div class="container articleText py-5">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10">
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

@endsection
