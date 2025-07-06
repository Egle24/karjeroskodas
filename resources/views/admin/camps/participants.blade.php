@extends('admin.layouts.appAdmin')

@section('title','Dalyviai')

@section('content')
    <h3>"{{ $camp->title }}" dalyviai </h3>
    <div class="mb-3">
        <a href="{{route('admin.camps.participants.delete', $camp->id) }}" id="bulkDeleteButton" class="btn btn-danger">Ištrinti pasirinktus</a>
    </div>
    @if($participants->isEmpty())
        <p>Šiuo metu nėra užsiregistravusių dalyvių.</p>
    @else
        <div class="table-responsive">
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
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Dalyvio tipas</th>
                    <th>Vardas</th>
                    <th>Pavardė</th>
                    <th>Telefonas</th>
                    <th>El. paštas</th>
                    <th>Darbavietė</th>
                    <th>Mokėjimas</th>
                    <th>Sąskaita</th>
                    <th>Maisto pasirinkimas</th>
                    <th>Specialūs poreikiai</th>
                    <th>Sumokėta</th>
                    <th>Kaina dalyviui</th>
                    <th>Veiksmai</th>
                </tr>
                </thead>
                <tbody>
                @foreach($participants as $participant)
                    <tr>
                        <td>
                            @if ($participant->user_id && App\Models\User::where('id', $participant->user_id)->exists())
                                Narys
                            @else
                                Svečias
                            @endif
                        </td>

                        <td>{{ $participant->name }}</td>
                        <td>{{ $participant->surname }}</td>
                        <td>{{ $participant->phone_number }}</td>
                        <td>{{ $participant->email }}</td>
                        <td>{{ $participant->workplace }}</td>
                        <td>
                            {{ $participant->payment==='manual' ? 'Mokėsiu pats' : 'Mokės mokykla' }}
                        </td>
                        <td>
                            @if ($participant->invoice === 'pre_invoice')
                                Man reikės sąskaitos išankstiniam apmokėjimui (atsiunčiama prieš renginį, tuomet reikia
                                organizacijos rekvizitų)
                            @elseif ($participant->invoice === 'no')
                                Man nereikės sąskaitos išankstiniam apmokėjimui
                            @elseif ($participant->invoice === 'post_invoice')
                                Man reikės sąskaitos-faktūros (išduodama po renginio)
                            @endif
                        </td>
                        <td>
                            @if ($participant->food_choice === 'everything')
                                Valgau viską
                            @elseif ($participant->food_choice === 'vegetarian_no_meat')
                                Esu vegetaras/-ė (nevalgau jokios mėsos)
                            @elseif ($participant->food_choice === 'vegetarian_fish_only')
                                Esu vegetaras/-ė (valgau žuvį)
                            @elseif ($participant->food_choice === 'vegan')
                                Esu veganas/-ė
                            @endif
                        </td>
                        <td>{{ $participant->special_needs }}</td>
                        <td>
                            @if ($participant->paid === 'yes')
                                Sumokėta
                            @else
                                Nesumokėta
                            @endif
                        </td>
                        <td>
                            @php
                                $isMember = $participant->user_id !== null;

                                // Get the corresponding camp price
                                $campPrice = $isMember ? $camp->priceForMembers : $camp->priceForGuests;

                                // Calculate the total amount paid
                                $totalPaid =  $campPrice;
                            @endphp
                            {{ $totalPaid }} EUR
                        </td>
                        <td>
                            @if ($participant->paid === 'yes')

                                <a href="#" class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#unconfirmPaymentModal{{ $participant->id }}">
                                    <i class="bi bi-x-square-fill" style="color: red"></i>
                                </a>
                                <a href="" class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#deleteParticipantModal{{ $participant->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            @else
                                <a href="" class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#confirmPaymentModal{{ $participant->id }}">
                                    <i class="bi bi-check-circle-fill" style="color: green"></i>
                                </a>
                                <a href="" class="btn btn-default" data-bs-toggle="modal"
                                   data-bs-target="#deleteParticipantModal{{ $participant->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @foreach($participants as $participant)
            <div class="modal fade" id="deleteParticipantModal{{ $participant->id }}" tabindex="-1"
                 aria-labelledby="deleteParticipantModalLabel{{ $participant->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteParticipantModalLabel">Pašalinti dalyvį</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Šis dalyvis bus pašalintas:
                            <span class="fw-medium">{{ $participant->name }} {{ $participant->surname }}</span>
                            Ar tikrai norite patvirtinti?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.camps.participants.destroy', ['campId' => $camp->id, 'participantId' => $participant->id]) }}"
                                  method="POST">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($participants as $participant)
            <div class="modal fade" id="confirmPaymentModal{{ $participant->id }}" tabindex="-1"
                 aria-labelledby="confirmPaymentModalLabel{{ $participant->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmPaymentModalLabel">Patvirtinti mokėjimą</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Patvirtinsite, kad dalyvis <span
                                    class="fw-medium">{{ $participant->name }} {{ $participant->surname }}</span>
                            sumokėjo už stovyklą.
                            Ar tikrai norite patvirtinti?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.camps.participants.update', ['campId' => $camp->id, 'participantId' => $participant->id]) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="paid" value="yes">
                                <br>
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($participants as $participant)
            <div class="modal fade" id="unconfirmPaymentModal{{ $participant->id }}" tabindex="-1"
                 aria-labelledby="unconfirmPaymentModalModalLabel{{ $participant->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="unconfirmPaymentModalLabel">Atšaukti mokėjimą</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Patvirtinsite, kad dalyvis <span
                                    class="fw-medium">{{ $participant->name }} {{ $participant->surname }}</span>
                            nesumokėjo už stovyklą.
                            Ar tikrai norite patvirtinti?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.camps.participants.update', ['campId' => $camp->id, 'participantId' => $participant->id]) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="paid" value="no">
                                <br>
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

@endsection
