@extends('admin.layouts.appAdmin')

@section('title','Straipsnio kūrimas')

@section('content')
<div class="container">
    <div class="image-preview" style="display: none;">
        <i class="bi bi-x-lg close-preview"></i>
        <img src="" alt="Preview Image">
    </div>
    <div class="row justify-content-center">
        <h2 class="text-center">Straipsnio kūrimas</h2>
        <div class="col-md-8" style="padding: 20px;">
            <div class="card">
                <div class="card-body justify-content-center">
                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="article-create-form">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Straipsnio pavadinimas</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Straipsnio pagrindinė nuotrauka</label>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" required>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategorija</label>
                            <select id="category_id" class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="">Pasirinkite kategoriją</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Data</label>
                            <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') ?: now()->format('Y-m-d') }}" required autocomplete="date">
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Nuoroda į straipsnį</label>
                            <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') }}" autocomplete="link">
                            @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Statusas</label>
                            <select id="status" class="form-select @error('status') is-invalid @enderror" name="status" required>
                                <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>Naujas</option>
                                <option value="old" {{ old('status') == 'old' ? 'selected' : '' }}>Senas</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content-editor" class="form-label">Straipsnio turinys</label>
                            <div id="content-editor" style="height: 300px;"></div>
                            <input type="hidden" name="content" id="content">
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <button type="submit" class="btn btn-primary">Išsaugoti</button>
                        </div>
                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col-md-6 -->
    </div> <!-- row -->
</div> <!-- container -->

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
