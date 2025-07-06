@extends('main.layouts.app')

@section('title','Pagrindinis')
@section('content')

    <div class="hero">
        <div class="container hero-left">
            <div class="textFrame">
                <div class="hero-text">
                    <h1 class="text-center">KARJEROS KODAS</h1>
                    <p class="text-center">
                        Kūrybingų ir entuziastingai nusiteikusių bendraminčių asociacija, kurios tikslas - didinti narių sąmoningumą asmeninių kompetencijų tobulinimo ir karjeros ugdymo srityse.
                    </p>

                </div>

                <div id="banner_with_icons">
                    <div class="banner-icon">
                        <i class="fi fi-rr-heart-partner-handshake"></i>
                        <h6>
                            Pagarba <br> dalyviams
                        </h6>
                    </div>
                    <div class="banner-icon">
                        <i class="fi fi-rr-sparkles"></i>
                        <h6>
                            Užtikriname <br> gerą nuotaiką
                        </h6>
                    </div>
                    <div class="banner-icon">
                        <i class="fi fi-rr-direction-signal-arrow"></i>
                        <h6>
                            Esame lankstūs <br> kitų poreikiams
                        </h6>
                    </div>
                    <div class="banner-icon">
                        <i class="fi fi-rr-diploma"></i>
                        <h6>
                            Ilgametė <br> patirtis
                        </h6>
                    </div>
                </div>
                <div class="titles-left">
                    <a href="{{route('camps.index')}}" class="btn btn-primary">
                        Dalyvaukite renginiuose
                    </a>
                </div>

            </div>
            <div class="hero-image">
                <img src="{{ asset('/images/karjeros-kodas-stovykla-1.png') }}" class="hero-img">
            </div>
        </div>
    </div>

     <div class="container py-6">
            <div class="row justify-content-center gap-4">
                <h2 class="text-center">Kodėl verta dalyvauti mūsų renginiuose?</h2>
                    <div class="row gap-4">
                            <div class="col veikla_card">
                                <div class="card-body">
                                    <i class="fi fi-rr-circle-1"></i>
                                    <h5 class="mb-2">Asmeninis <br> tobulėjimas</h5>
                                    Skatiname asmeninį ir profesinį augimą
                                </div>
                            </div>
                            <div class=" col veikla_card">
                                <div class="card-body">
                                    <i class="fi fi-rr-circle-2"></i>
                                    <h5 class="mb-2">Įkvepianti <br> bendruomenė</h5>
                                    Vienijame kūrybingus bendraminčius
                                </div>
                            </div>
                            <div class="col veikla_card">
                                <div class="card-body">
                                    <i class="fi fi-rr-circle-3"></i>
                                    <h5 class="mb-2">Lankstumas ir <br> prisitaikymas</h5>
                                    Pritaikome veiklas pagal dalyvių poreikius
                                </div>
                            </div>

                            <div class="col veikla_card">
                                <div class="card-body">
                                    <i class="fi fi-rr-circle-4"></i>
                                    <h5 class="mb-2">Praktiniai <br> įgūdžiai</h5>
                                    Suteikiame naudingų, realiai pritaikomų įgūdžių
                                </div>
                            </div>
                    </div>
                    <div class="titles">
                        <a href="{{route('camps.index')}}" class="btn btn-primary">
                            Peržiūrėti veiklas
                        </a>
                    </div>
                </div>
            </div>

    <div id="stats-section" class="stats-section py-6">
        <div class="overlay">
            <div class="row gap-4 justify-content-center text-center w-100">
                <div class="col-lg-2 col-md-3">
                    <h2 id="camps-count" class="counter" data-target="20+">0+</h2>
                    <p>Renginių</p>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h2 id="memberships-count" class="counter" data-target="20">0</h2>
                    <p>Narių</p>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h2 id="projects-count" class="counter" data-target="2018m.">0m.</h2>
                    <p>Pradėta veikla</p>
                </div>
            </div>
        </div>
    </div>


    <div class="container py-6" >
        <div class="row justify-content-center gap-4">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-sm-12">
                    <h2 class="text-left">Naujienos ir <br> pranešimai</h2>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p class="mb-4 text-left">
                        Mes dalinamės naujienomis ir pranešimais, padedančiais tobulinti asmenines kompetencijas ir siekti sėkmingos karjeros. Tikimės, kad čia rasite naudingos informacijos, kuri paskatins dalyvauti mūsų renginiuose!</p>
                    <a href="{{route('articles.index')}}" class="btn btn-primary">
                        Peržiūrėti straipsnius
                    </a>
                </div>
            </div>
            @if($articles->isEmpty())
                <div class="text-center">
                    <h4 class="p-4">Straipsnių dar nėra</h4>
                    <img src="{{ asset('/images/empty.png') }}" class="empty" alt="Empty Illustration">
                </div>
            @else
                <div class="row justify-content-start">
                    @foreach($articles->sortByDesc('date')->take(2) as $article)
                        <div class="col-lg-6 col-md-12">
                            <div class="article_card mb-3" style="border: 0">
                                <div class="row m-0">
                                    <div class="col-md-4 article_image" style="background-image:url('{{ asset('storage/article_images/' . $article->image) }}');"></div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $article->title }}</h5>
                                            <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($article->date)->format('Y-m-d') }}</small></p>
                                            <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="card-text"><small>Skaityti daugiau</small></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <div class="bg-container">
        <div class="container py-6" >
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 col-sm-12"  id="pages-image-container">
                    <img src="{{ asset('images/karjeros-kodas-veikla-nuotraukos.png')}}" alt="campImage" class="main-articles-container-image">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12" id="container-with-color">
                    <h2>Akimirkos iš mūsų renginių!</h2>
                    <p>Peržiūrėkite mūsų galeriją ir pajuskite kūrybingos bei entuziastingos bendruomenės dvasią. Čia rasite stovyklų, seminarų ir kitų renginių nuotraukas bei medžiagą. Leiskite šiems įspūdžiams įkvėpti jus ir tapti mūsų bendruomenės dalimi!
                    </p>
                    <div class="titles-left">
                        <a href="{{route('gallery.index')}}" class="btn btn-primary">
                            Peržiūrėti galeriją
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-6 ps-0 pe-0 m-0 w-100 testimonials_container" style="max-width: 100%;" >
        <h2 class="text-center pb-4">Mūsų dalyvių atsiliepimai</h2>
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
        <div class="titles-center">
            <a href="{{ route('feedback.index') }}" class="btn btn-primary">
                Parašyti atsiliepimą
            </a>
        </div>
    </div>

    <div id="partners-section" class="partners-section py-6">
            <div class="row justify-content-center text-center w-100 gap-3">
                <h2 >Mūsų partneriai</h2>
                <img src="{{asset('/images/PLAST.png')}}" class="partners-logo" alt="">
                <img src="{{asset('/images/CRI logo.png')}}" class="partners-logo" alt="">
                <img src="{{asset('/images/Plunges-skautailogo.png')}}" class="partners-logo" alt="">
                <img src="{{asset('/images/start strong logo.png')}}" class="partners-logo" alt="">
                <img src="{{asset('/images/use-vilnius-seal.png')}}" class="partners-logo" alt="">
                <img src="{{asset('/images/vokietijos-ambasada.png')}}" class="partners-logo" alt="">
            </div>
    </div>

        <div class="container py-6" >
            <div class="row justify-content-center " >
                <div class="col-lg-6 col-md-12 col-sm-12" id="pages-image-container">
                    <img src="{{asset('/images/contacts.png')}}" alt="" class="w-100">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 formContainer" id="container-with-color">
                    <h2 class="mb-3">Turite klausimų?</h2>
                    <h6>Užpildykite šią formą ir mes su jumis susisieksime!
                    </h6>
                    <div>
                        <form method="POST" id="form-anchor" class="form" action="{{route('send.email')}}">
                            @csrf
                            @if(Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif

                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    <i class="bi bi-check2-circle" style="font-size: 20px;"></i>
                                    <ul class="d-flex align-items-center mb-0" style="list-style-type: none">
                                        {{ Session::get('success') }}
                                    </ul>
                                </div>
                            @endif
                            <div class="row g-2 formRow">

                                <input type="hidden" name="honeypot" value="">
                                <input type="text" name="fake_field" style="display:none;">


                                <div class="col-md-12">
                                    <label class="form-label" for="name">Vardas ir pavardė</label>
                                    <input class="form-control" id="name" type="text" name="name" placeholder="Jūsų vardas ir pavardė" required value="{{ auth()->check() ? auth()->user()->name . ' ' . auth()->user()->surname : '' }}">
                                    @error('name')
                                    <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="email-input">El. paštas</label>
                                    <input class="form-control" id="email-input" type="text" name="email" required placeholder="Jūsų el. paštas" value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                    @error('email')
                                    <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="subject-input">Tema</label>
                                    <input class="form-control" id="subject-input" type="text" name="subject" required placeholder="Tema"  value="">
                                    @error('subject')
                                    <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="message">Žinutė</label>
                                    <textarea id="message" name="message" class="form-control" required placeholder="Žinutė"></textarea>
                                    @error('message')
                                    <span class="text-danger">
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
                                <div class="col-md-8 d-flex justify-content-start">
                                    <button class="btn btn-primary" type="submit" id="submit">Siųsti</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection
