@extends('main.layouts.app')

@section('title','Straipsniai')

@section('content')
    <div class="campContainer text-center py-6">
        <div class="textFrame w-70">
            <h1 class="text-white text-uppercase">
                Naujausi straipsniai
            </h1>
        </div>
    </div>
    <div class="container py-5 px-2">
        <div id="categoryFormContainer">
            <form id="categoryForm">
                <div class="custom-select-container">
                    <div class="custom-select" id="customSelect">
                        <span class="selected">Visi straipsniai</span>
                        <div class="dropdown-arrow">▼</div>
                    </div>
                    <div class="custom-options">
                        <div class="custom-option" data-value="">Visi straipsniai</div>
                        @foreach($categories as $category)
                            <div class="custom-option" data-value="{{ $category->title }}">{{ $category->title }}</div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container py-3">
        <div id="noArticlesMessage" class="text-center" style="display: none;">
            <h4 class="p-4">Straipsnių šioje kategorijoje nėra</h4>
            <img src="{{ asset('/images/empty.png') }}" class="empty" alt="Empty Illustration">
        </div>
        <div class="row justify-content-start">
            @foreach($articles as $article)
                <div class="col-lg-6 mb-4" data-category="{{ $article->category->title }}">
                    <div class="article_card mb-3" style="border: 0">
                        <div class="row m-0">
                            <div class="col-md-4 article_image" style="background-image:url('{{ asset('storage/article_images/' . $article->image) }}');"></div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $article->title }}</h5>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.getElementById('customSelect');
            var options = document.querySelectorAll('.custom-option');
            var articles = document.querySelectorAll('.col-lg-6');
            var noArticlesMessage = document.getElementById('noArticlesMessage');

            options.forEach(function (option) {
                option.addEventListener('click', function () {
                    var category = this.getAttribute('data-value');
                    var selectedText = this.textContent;
                    select.querySelector('.selected').textContent = selectedText;

                    // Flag to check if any article is visible
                    let anyVisible = false;

                    // Filter articles with animation
                    articles.forEach(function (article) {
                        if (category === '' || article.getAttribute('data-category').toLowerCase() === category.toLowerCase()) {
                            // Show article with fade-in effect
                            article.style.display = 'block';
                            setTimeout(function () {
                                article.classList.remove('hidden');
                            }, 10); // Timeout to ensure transition happens
                            anyVisible = true; // An article is visible
                        } else {
                            // Hide article with fade-out effect
                            article.classList.add('hidden');
                            setTimeout(function () {
                                article.style.display = 'none';
                            }, 500); // Match this with your CSS transition duration
                        }
                    });

                    // Show or hide the no articles message based on visibility
                    noArticlesMessage.style.display = anyVisible ? 'none' : 'block';
                });
            });
        });
    </script>
@endsection
