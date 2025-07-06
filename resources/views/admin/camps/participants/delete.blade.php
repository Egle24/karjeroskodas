@extends('admin.layouts.appAdmin')

@section('title', 'Pašalinti dalyvius')

@section('content')
    <div class="container">
        <h3 class="text-center">Pašalinti dalyvius - "{{ $camp->title }}"</h3>
        <p>Pasirinkite dalyvius, kuriuos norite pašalinti.</p>

        @if($participants->isEmpty())
            <div class="alert alert-info">
                Šiuo metu nėra užsiregistravusių dalyvių.
            </div>
        @else
            <form action="{{ route('admin.camps.participants.destroy', $camp->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="form-check mb-3">
                    <input type="checkbox" id="select-all-participants" class="form-check-input">
                    <label for="select-all-participants" class="form-check-label">
                        Pasirinkti visus
                    </label>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Vardas</th>
                            <th>Pavardė</th>
                            <th>Telefonas</th>
                            <th>El. paštas</th>
                            <th>Mokėjimo būsena</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($participants as $participant)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_participants[]" class="participant-checkbox"
                                           value="{{ $participant->id }}">
                                </td>
                                <td>{{ $participant->name }}</td>
                                <td>{{ $participant->surname }}</td>
                                <td>{{ $participant->phone_number }}</td>
                                <td>{{ $participant->email }}</td>
                                <td>
                                    {{ $participant->paid === 'yes' ? 'Sumokėta' : 'Nesumokėta' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-danger mt-3">Ištrinti pasirinktus dalyvius</button>
                <a href="{{ route('admin.camps.participants.show', $camp->id) }}" class="btn btn-outline-primary mt-3">
                    Atšaukti
                </a>
            </form>
        @endif
    </div>

    <script>
        document.getElementById('select-all-participants').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.participant-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
