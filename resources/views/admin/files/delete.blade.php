@extends('admin.layouts.appAdmin')

@section('title','Failų šalinimas')

@section('content')
    <div class="container">
        <h2 class="text-center">Failų šalinimas - {{ $camp->title }}</h2>
        <p>Pasirinkite failus, kuriuos norite ištrinti</p>

        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.files.destroy', ['file' => $campId]) }}" method="POST">
                        @csrf
                        @method('DELETE')
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
                                        <input class="form-check-input delete-file-checkbox" type="checkbox"
                                               name="selected_files[]" value="{{ $file->id }}" id="file_{{ $file->id }}">
                                        <label class="form-check-label" for="file_{{ $file->id }}">
                                            {{ $file->file_name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Ištrinti pasirinktas</button>
                        <a href="{{route('admin.files.index')}}" type="button" class="btn btn-outline-primary mt-3">
                            Atšaukti
                        </a>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <script>
        document.getElementById('select-all-files-checkbox').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.delete-file-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
