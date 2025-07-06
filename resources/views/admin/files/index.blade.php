@extends('admin.layouts.appAdmin')

@section('title','Failų Valdymas')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-0 text-start">Failai</h2>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end gap-2">
            <div class="mr-3" style="white-space: nowrap;">{{ count($files) }} Failai</div>
            <div class="input-group" style="max-width: 200px;">
                <input type="text" class="form-control" placeholder="🔍 Paieška" id="searchInput">
            </div>
            <button type="button" class="btn btn-secondary read-more" data-toggle="modal"
                    data-target="#createFilesModal">
                Pridėti failus
            </button>
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

    @if($files->isEmpty())
        <div class="text-center">
            <h4 class="p-4">Failų dar nėra</h4>
            <img src="{{ asset('/images/empty.png') }}" class="empty" alt="Empty Illustration">
        </div>
    @else
        <div class="row justify-content-start">
            @foreach($files as $campId => $groupedFiles)
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="card-header text-start">
                            <a href="{{route('admin.files.deleteFiles', $campId)}}" class="btn btn-default">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                            <a href="{{route('admin.files.edit', $campId)}}" class="btn btn-default">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-sm-12 col-lg-4 d-flex justify-content-center align-items-center mb-3">
                                    <div class="bigCircle">
                                        @if ($groupedFiles->first()->camp->main_image && !empty($groupedFiles->first()->camp->main_image))
                                            <img class="avatar preview-image"
                                                 src="{{ asset('storage/camp_images/' . $groupedFiles->first()->camp->main_image) }}"
                                                 alt="Gallery Image">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="bi bi-folder-fill" style="font-size: 50px;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-12 col-lg-8 d-flex flex-column justify-content-between">
                                    <div class="d-flex flex-end">
                                        <div style="margin-right: auto">
                                            <h5>{{ $groupedFiles->first()->camp->title }}</h5>
                                            <span class="text-muted ml-2">
                                                Failų skaičius: {{ $groupedFiles->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="card-text">
                                        <button class="btn btn-default fw-medium expand-btn"
                                                data-attribute="gallery-id" data-id="{{ $campId }}">
                                            Peržiūrėti failus <i class="bi bi-chevron-down"></i>
                                        </button>
                                    </p>
                                </div>
                                <div class="expanded-row" data-gallery-id="{{ $campId }}" style="display: none;">
                                    <div class="row my-3">
                                        @foreach($groupedFiles as $file)
                                            <div class="col-md-12 mb-2">
                                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                                                    <div>
                                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                            {{ $file->file_name }}
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('admin.files.deleteFiles', $file->camp_id) }}" class="btn btn-sm btn-danger">
                                                            Ištrinti
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="modal fade" id="createFilesModal" tabindex="-1" aria-labelledby="createFilesModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFilesModalLabel">Pridėti failus</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.files.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="camp_id">Pasirinkite stovyklą</label>
                            <select name="camp_id" id="camp_id" class="form-control" required>
                                <option value="">Pasirinkite...</option>
                                @foreach($camps as $camp)
                                    <option value="{{ $camp->id }}">{{ $camp->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="files">Pasirinkite failus (PDF)</label>
                            <input type="file" name="files[]" id="files" class="form-control" multiple required>
                            <small class="form-text text-muted">Galite pasirinkti kelis failus iš karto.</small>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Įkelti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
