@extends('admin.layouts.appAdmin')

@section('title','Kategorijos')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-0 text-start">Kategorijos</h2>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
            <div class="input-group" style="max-width: 200px;">
                <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
            </div>
            <button type="button" class="btn btn-secondary read-more" data-toggle="modal"
                    data-target="#createCategoryModal">
                Sukurti kategoriją
            </button>
        </div>
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
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Pavadinimas</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
        <h6>Deja, tokios kategorijos nėra</h6>
        <i class="bi bi-emoji-frown h2"></i>
    </div>

    @if ($categories->isEmpty())
        <div class="text-center">
            <h4 class="p-4">Kategorijų dar nėra</h4>
            <img src="{{ asset('/images/empty.png') }}" class="empty"  alt="Empty Illustration">
        </div>
    @else
    <div class="row category justify-content-start mb-3">
        @foreach($categories as $category)
            <div class="col-md-3 mb-3 cardContainer">
                <div class="card">
                    <div class="card-body h-100">
                        <div class="row justify-content-center">
                            <div class="col-md-12 d-flex flex-column justify-content-between">
                                <div style="margin-right: auto">
                                    <h6>
                                        {{ $category->title }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="#" class="btn btn-light" data-bs-toggle="modal"
                           data-bs-target="#deleteCategoryModal{{ $category->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <a href="#" class="btn btn-light" data-bs-toggle="modal"
                           data-bs-target="#editCategoryModal{{ $category->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    @foreach($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
             aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Kategorijos redagavimas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.categories.update', $category->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Pavadinimas</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ $category->title }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                    Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($categories as $category)
        <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1"
             aria-labelledby="deleteCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCategoryModalLabel">Pašalinti kategoriją</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="fw-medium">"{{ $category->title }}" </span>
                        kategorija bus pašalinta.
                        Ar tikrai pašalinti?
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('admin.categories.destroy', $category->id)}}" method="post">
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
@endsection
