@extends('main.layouts.app')

@section('title','Kontaktai')
@section('content')
    <div class="container py-6">
        <div class="row justify-content-center contacts">
            <div class="col-lg-5">
                <img src="{{asset('/images/contacts.png')}}" alt="" class="w-100">
            </div>
            <div class="col-lg-6">
                <h1>Turite klausimų?</h1>
                <h4>Ieškote įsimintinų renginių bei norite susirasti bendraminčių?</h4>
                <p>Nedvejokite ir kreipkitės! Atsakysime į visus jums iškilusius klausimus</p>
                <div class="contactIconRow">
                    <a href="tel:+370564662626" class="contactIcon">
                        <i class="fi fi-rr-phone-call"></i>
                        <div>
                            <p class="m-0">+370564662626</p>
                        </div>
                    </a>
                    <a href="mailto:manokarjeroskodas@gmail.com" class="contactIcon">
                        <i class="fi fi-rr-envelope"></i>
                        <div>
                            <p class="m-0">manokarjeroskodas@gmail.com</p>
                        </div>
                    </a>
                </div>
                <div class="contactIconRow-2">
                    <a href="https://www.facebook.com/karjeros" target="_blank" class="contactIcon-2">
                        <i class="fi fi-brands-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/karjeroskodas/" target="_blank" class="contactIcon-2">
                        <i class="fi fi-brands-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-6">
        <div class="row justify-content-center gap-2">
            <div class="col-lg-5">
                <form method="POST" class="form" id="form-anchor" action="{{route('send.email')}}">
                    <h1>Arba užpildykite susisiekimo formą</h1>
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
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
    </span>
                    @endif
                    <div class="row g-2 formRow">
                        <!-- Hidden fields for bot prevention -->
                        <input type="hidden" name="honeypot" value="">
                        <input type="text" name="fake_field" style="display:none;">
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        <script>
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ config('captcha.sitekey') }}', { action: 'submit' }).then(function(token) {
                                    document.getElementById('g-recaptcha-response').value = token;
                                });
                            });
                        </script>

                        <div class="col-md-12">
                            <label class="form-label" for="name">Vardas ir pavardė</label>
                            <input class="form-control" id="name" type="text" name="name" required placeholder="Jūsų vardas" value="{{ auth()->check() ? auth()->user()->name . ' ' . auth()->user()->surname : '' }}">
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
                        <div class="col-md-8 d-flex justify-content-start">
                            <button class="btn btn-primary" type="submit" id="submit">Siųsti</button>
                        </div>
                    </div>
                    {!! NoCaptcha::renderJs() !!}

                </form>
            </div>
            <div class="col-lg-6 map">
                <img src="{{asset('/images/map.png')}}" alt="">
            </div>
        </div>
    </div>
@endsection
