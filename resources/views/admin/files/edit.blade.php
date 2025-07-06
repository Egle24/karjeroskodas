@extends('admin.layouts.appAdmin')

@section('title','Failų tvarkymas')

@section('content')
    <div class="container">
        <h2 class="text-center">Failų tvarkymas - {{ $camp->title }}</h2>
        <p>Pasirinkite failus, kuriuos norite pakeisti</p>

        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.files.update', $camp->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="select-all-files-checkbox">
                            <label class="form-check-label" for="select-all-files-checkbox">
                                Pasirinkti visus
                            </label>
                        </div>
                        <div class="row">
                            @foreach($files as $file)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input edit-file-checkbox" type="checkbox"
                                               name="selected_files[]" value="{{ $file->id }}" id="file_{{ $file->id }}">
                                        <label class="form-check-label" for="file_{{ $file->id }}">
                                            {{ $file->file_name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mt-3">
                            <label for="files">Pridėti failus (PDF)</label>
                            <input type="file" name="files[]" id="files" class="form-control" multiple>
                            <small class="form-text text-muted">Galite pasirinkti kelis failus iš karto.</small>
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Atnaujinti</button>
                        <a href="{{ route('admin.files.index') }}" type="button" class="btn btn-outline-primary mt-3">
                            Atšaukti
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('select-all-files-checkbox').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.edit-file-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
