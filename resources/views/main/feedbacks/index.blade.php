@extends('main.layouts.app')

@section('title','Atsiliepimai')

@section('content')
    <div class="campContainer text-center py-6">
        <div class="textFrame w-70">
            <h1 class="text-white text-uppercase">
                Atsiliepimai
            </h1>
        </div>
    </div>
    <div class="container py-6 ps-0 pe-0 m-0 w-100 testimonials_container" style="max-width: 100%;" >
        <div class="pb-4" id="testimonials_container">
            <div id="testimonials_inner">
                @foreach ($feedbacks->take(8) as $feedback)
                    <div id="testimonial-card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <p>"{{ $feedback->feedback }}"</p>
                            <h4>{{ $feedback->name }}</h4>
                        </div>
                    </div>
                @endforeach
                @foreach ($feedbacks->take(8) as $feedback)
                    <div id="testimonial-card">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <p>"{{ $feedback->feedback }}"</p>
                            <h4>{{ $feedback->name }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-container">
        <div class="container py-5" >
            <div class="row justify-content-center formContainer">
                <div class="col-lg-6 col-md-12 col-sm-12" id="pages-image-container">
                    <img src="{{ asset('images/karjeros-kodas-atsiliepimai.png')}}" alt="campImage" class="main-articles-container-image">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 " id="container-with-color">
                    <h2>Parašyti atsiliepimą galite čia:</h2>
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <form class="form" id="form-anchor" action="{{route('feedback.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="honeypot" value="">
                        <input type="text" name="fake_field" style="display:none;">

                        <div class="mb-3">
                            <label for="name" class="form-label">Vardas</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Jūsų vardas" value="{{ auth()->check() ? auth()->user()->name . ' ' . auth()->user()->surname : '' }}">
                            @error('name')
                            <span class="alert-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Atsiliepimas</label>
                            <textarea class="form-control @error('feedback') is-invalid @enderror" id="feedback" name="feedback" placeholder="Jūsų atsiliepimas" rows="5">{{old('feedback')}}</textarea>
                            @error('feedback')
                            <span class="alert-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        <script>
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ config('captcha.sitekey') }}', { action: 'submit' }).then(function(token) {
                                    document.getElementById('g-recaptcha-response').value = token;
                                });
                            });
                        </script>

                        <button class="btn btn-primary" type="submit" id="submit">Siųsti</button>
                    </form>
                </div>

            </div>
        </div>

    </div>

@endsection
