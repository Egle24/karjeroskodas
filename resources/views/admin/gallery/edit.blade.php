@extends('admin.layouts.appAdmin')

@section('title','Nuotraukų redagavimas')
@section('content')
    <div class="container">
        <div class="image-preview" style="display: none;">
            <i class="bi bi-x-lg close-preview"></i>
            <img src="" alt="Preview Image">
        </div>
        <div class="row justify-content-center ">
            <h2 class="text-center">galerijos redagavimas</h2>
            <div class="col-md-6" style="padding: 20px;">
                <div class="card">
                    <div class="card-body justify-content-center">
                        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="camp_id" class="form-label">Pasirinkite stovyklą</label>
                                <select class="form-select" id="camp_id" name="camp_id">
                                    <option value="">Pasirinkite stovyklą</option>
                                    @foreach($camps as $camp)
                                        <option value="{{ $camp->id }}" {{ $camp->id == $gallery->camp_id ? 'selected' : '' }}>{{ $camp->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="camp-info">
                                <label for="title" class="form-label">Pavadinimas</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ $gallery->title }}">
                            </div>
                            <div class="mb-3" id="camp-description">
                                <label for="description" class="form-label">Aprašymas</label>
                                <textarea class="form-control" id="description" name="description"
                                          rows="3">{{ $gallery->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Įkelti nuotraukas</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>

                            <div class="row justify-content-center">
                                <div class="row justify-content-center">
                                    @foreach ($gallery->images as $image)
                                        <div class="col-md-3 mb-3">
                                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}"
                                                   class="form-check-input">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                 class="img-fluid preview-image" alt="Programme Image">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        onclick="window.location='{{ route('admin.gallery.index') }}'">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-primary">Patvirtinti</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
