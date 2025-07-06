@extends('admin.layouts.appAdmin')

@section('title','Programos redagavimas')
@section('content')
    <div class="container">
        <div class="image-preview" style="display: none;">
            <i class="bi bi-x-lg close-preview"></i>
            <img src="" alt="Preview Image">
        </div>
        <div class="row justify-content-center ">
            <h2 class="text-center">programos redagavimas</h2>
            <div class="col-md-5" style="padding: 20px;">
                <div class="card">
                    <div class="card-body justify-content-center">
                        <div class="col-md-12">
                            <h6 class="text-center">Dabartinės nuotraukos</h6>
                            <div class="row justify-content-center">
                                @foreach ($programme->images as $image)
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             class="img-fluid preview-image" alt="Programme Image">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <form action="{{ route('admin.camps.programmes.update', $programme->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Pavadinimas</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ $programme->title }}">
                            </div>

                            <div class="row g-2" id="imageFieldsContainer">
                                <div class="mb-3">
                                    <label for="image_count" class="form-label">Nuotraukų skaičius</label>
                                    <input id="image_count" type="number"
                                           class="form-control @error('image_count') is-invalid @enderror"
                                           name="image_count" value="{{ old('image_count') }}" required
                                           autocomplete="image_count" min="1">
                                    @error('image_count')
                                    <span class="alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="additionalImageFields" class="mb-3"></div>


                            <div class="row g-2">
                                <button type="submit" class="btn btn-primary">Išsaugoti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
