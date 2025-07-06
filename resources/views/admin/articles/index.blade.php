@extends('admin.layouts.appAdmin')

@section('title','Straipsniai')
@section('content')
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-0 text-start">Straipsniai</h2>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
                    <div class="mr-3" style="white-space: nowrap;">{{ count($articles) }} articles</div>

                    <div class="input-group" style="max-width: 200px;">
                        <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
                    </div>
                    <a class="btn btn-secondary read-more" href="{{ route('admin.articles.create')}}">
                        Sukurti straipsnį
                    </a>
                </div>

            </div>

            <!-- HTML structure for image preview -->
            <div class="image-preview" style="display: none;">
                <i class="bi bi-x-lg close-preview"></i>
                <img src="" alt="Preview Image">
            </div>


           

            <!-- Modal -->
            <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCategoryModalLabel">Kategorijos kūrimas</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.categories.store')}}" method="POST"
                                  enctype="multipart/form-data" >
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Pavadinimas</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ old('title') }}">
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

            @if($articles->isEmpty())
                <div class="text-center">
                    <h4 class="p-4">Straipsnių dar nėra</h4>
                    <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
                </div>
            @else
            <div class="row justify-content-start mb-3">
                @foreach($articles as $article)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header text-start">
                                <a href="#"
                                   class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#deleteArticleModal{{ $article->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                                <a class="btn btn-default" href="{{ route('admin.articles.edit', $article->id) }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>

                            <div class="card-body h-100">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 h-100 d-flex justify-content-center align-items-center mb-3">
                                        <div class="smallSquare">
                                            @if ($article->image)
                                                <img class="adminCampImage preview-image"
                                                     src="{{ asset('storage/article_images/' . $article->image) }}"
                                                     alt="Article Image">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-newspaper"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-flex flex-column justify-content-between">
                                        <div class="d-flex flex-end">
                                            <div style="margin-right: auto">
                                                <h6>
                                                    {{ $article->title }}
                                                </h6>
                                                <span class="badge
                                                        @if($article->status === 'new') bg-success @elseif($article->status === 'old') bg-danger @endif">
                                                        @if($article->status === 'new')
                                                        Naujas
                                                    @elseif($article->status === 'old')
                                                        Senas
                                                    @endif
                                                </span>
                                                <ul class="row postcard__info">
                                                    <li class="col-md-8 tag__item">
                                                        <span class="fw-medium">Data: </span>
                                                        {{ date('Y-m-d', strtotime($article->date)) }}
                                                    </li>
                                                    <li class="col-md-8 tag__item">
                                                        <span class="fw-medium">Kategorija: </span>
                                                        @if ($article->category)
                                                            {{ $article->category->title }}
                                                        @else
                                                            Kategorija nepriskirta
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            <button class="btn btn-default fw-medium expand-btn"
                                                    data-attribute="article-id" data-id="{{ $article->id }}">
                                                Plačiau <i class="bi bi-chevron-down"></i>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                                <div class="expanded-row" data-article-id="{{ $article->id }}" style="display: none;">
                                <div class="row my-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content)) }}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            <div id="noResultsMessage" class="text-center" style="display: none;">
                <h6>Deja, tokio straipsnio nėra</h6>
                <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
            </div>

            @foreach($articles as $article)
                <!-- Delete Member Modal -->
                <div class="modal fade" id="deleteArticleModal{{ $article->id }}" tabindex="-1"
                     aria-labelledby="deleteArticleModalLabel{{ $article->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMemberModalLabel">Pašalinti straipsnį</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Visas straipsnis bus pašalintas.
                                Ar tikrai pašalinti?
                                <div class="row mt-4">
                                    <div class="col-md-2">
                                        <div class="smallCircle">
                                            @if ($article->image)
                                                <img class="avatar" src="{{ asset('storage/article_images/' . $article->image) }}"
                                                     alt="Profile Image">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10 d-flex text-start flex-column justify-content-center">
                                        <h5>{{ $article->title }} </h5>
                                        <span class="text-muted ml-2">{{ date('Y-m-d', strtotime($article->date)) }}</span>
                                        <span class="text-muted ml-2">
                                             @if ($article->status === 'new')
                                                <span class="badge bg-success">Naujas</span>
                                            @else
                                                <span class="badge bg-secondary">Senas</span>
                                            @endif
                                        </span>

                                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content)) }}

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="post">
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

            <script>
    document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#content-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image']
            ]
        }
    });

    const form = document.querySelector('#article-create-form');
    const hiddenContent = document.querySelector('#content');

    form.addEventListener('submit', function(event) {
        const quillHtml = quill.root.innerHTML.trim();
        const quillText = quill.getText().trim();

        // Save HTML into hidden input
        hiddenContent.value = quillHtml;

        // Optional: block empty submissions
        if (quillText.length === 0) {
            event.preventDefault();
            alert('Straipsnio turinys negali būti tuščias.');
        }
    });
});

    </script>
@endsection
