@extends('main.layouts.authApp')


@section('title','Narystė')
@section('content')
    <div class="container" style="height: 70vh;">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-5">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Atsiprašome, jūs neturite prieigos prie šio puslapio.</h4>
                        <p class="card-text">Bandykite dar kartą arba susisiekite su mumis. Tai padaryti galite
                            skiltyje "Kontaktai" užpildydami susisiekimo formą arba pasinaudodami
                            joje esančia kontaktine informacija.</p>
                        <a href="{{route('contactForm')}}" class="btn btn-primary">
                            Kontaktai
                            <i class="bi bi-arrow-right">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
