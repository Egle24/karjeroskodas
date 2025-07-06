@extends('admin.layouts.appAdmin')

@section('title','Nuotraukų šalinimas')
@section('content')
    <div class="container">
        <div class="image-preview" style="display: none;">
            <i class="bi bi-x-lg close-preview"></i>
            <img src="" alt="Preview Image">
        </div>
        <div class="row justify-content-center ">
            <h2 class="text-center">Nuotraukų šalinimas</h2>
            <p>Pasirinkite nuotraukas, kurias norite ištrinti</p>
            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="select-all-images-checkbox">
                    <label class="form-check-label">
                        Pasirinkti visas
                    </label>
                </div>
                <div class="row py-3">
                    @foreach($gallery->images as $image)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input delete-image-checkbox" type="checkbox"
                                       name="selected_images[]" value="{{ $image->id }}"
                                       id="delete_image_{{ $image->id }}">
                                <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         class="img-thumbnail" alt="Gallery Image">
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <a href="{{route('admin.gallery.index')}}" type="button" class="btn btn-outline-primary">
                        Atšaukti
                    </a>
                    <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                </div>
            </form>
        </div>
    </div>
@endsection
