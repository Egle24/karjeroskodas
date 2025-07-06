@extends('main.layouts.authApp')

@section('title','Registracija į stovyklas')
@section('content')
    <div class="container">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-5">
                <div class="card text-center">
                    <div class="card-body d-flex flex-column align-items-center">
                        <i class="bi bi-check-circle successIcon"></i>
                        <h4 class="card-title">Sėkmingai užsiregistravote stovykloje :)</h4>
                        <div class="col-md-10 mb-3 text-center">
                            <p class="card-text">
                                <span class="fw-medium">Mokestį pervesti į asociacijos „Karjeros kodas“</span>
                                <span class="fw-normal">
                                    ( Įmonės kodas: 304784990, Buveinės adresas: Ežero g. 4 – 47, Šiauliai )
                                </span>
                            </p>
                            <p class="card-text">
                                <span class="fw-medium">Sąsk nr.</span> LT24 7300 0101 5471 1132
                            </p>
                            <p class="card-text">
                                <span class="fw-medium">BIC:</span> HABALT22, AB Swedbank.
                            </p>
                            <p class="card-text">
                                <span class="fw-medium">Paskirtis:</span> {{ $camp->description }} <span class="fw-medium">{{ $camp->title }} </span> dalyvio mokestis
                            </p>
                        </div>
                        <a href="{{route('home')}}" class="btn btn-primary">
                            Į pagrindinį
                            <i class="bi bi-arrow-right">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
