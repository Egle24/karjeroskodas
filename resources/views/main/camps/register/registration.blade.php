@extends('main.layouts.authApp')


@section('title','Registracija į stovyklas')
@section('content')
    <div class="container py-6">
        <h1 class="text-center mb-5">Registracija į renginį "{{ $camp->title }}"</h1>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('camp.register', $camp) }}" method="post">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <!-- Name and Surname -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">{{ __('Vardas') }}</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? (auth()->check() ? auth()->user()->name : '') }}" autocomplete="name" autofocus>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="surname" class="form-label">{{ __('Pavardė') }}</label>
                                            <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') ?? (auth()->check() ? auth()->user()->surname : '') }}">
                                            @error('surname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for="phone_number" class="form-label">{{ __('Tel. nr.') }}</label>
                                            <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}"  autocomplete="tel">
                                            @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for="email" class="form-label">{{ __('El. paštas') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? (auth()->check() ? auth()->user()->email : '') }}"  autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Workplace -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for="workplace" class="form-label">{{ __('Ugdymo institucija/darbovietė') }}</label>
                                            <input id="workplace" type="text" class="form-control @error('workplace') is-invalid @enderror" name="workplace" value="{{ old('workplace') }}"  autocomplete="workplace">
                                            @error('workplace')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Payment -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Dalyvio/-ės mokestis') }}</label>
                                            <div class="form-check @error('payment') is-invalid @enderror">
                                                <input class="form-check-input" type="radio" name="payment" id="manualPayment" value="manual" {{ old('payment') === 'manual' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="manualPayment">
                                                    Mokėsiu pats/pati
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment" id="schoolPayment" value="school" {{ old('payment') === 'school' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="schoolPayment">
                                                    Mokės mano mokykla
                                                </label>
                                            </div>
                                            @error('payment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Invoice -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Sąskaita išankstiniam apmokėjimui') }}</label>
                                            <div class="form-check @error('invoice') is-invalid @enderror">
                                                <input class="form-check-input" type="radio" name="invoice" id="preInvoice" value="pre_invoice" {{ old('invoice') === 'pre_invoice' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="preInvoice">
                                                    Man reikės sąskaitos išankstiniam apmokėjimui
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="invoice" id="noInvoice" value="no" {{ old('invoice') === 'no' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="noInvoice">
                                                    Man nereikės sąskaitos išankstiniam apmokėjimui
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="invoice" id="postInvoice" value="post_invoice" {{ old('invoice') === 'post_invoice' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="postInvoice">
                                                    Man reikės sąskaitos-faktūros
                                                </label>
                                            </div>
                                            @error('invoice')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Maitinimas') }}</label>
                                            <div class="form-check @error('food_choice') is-invalid @enderror">
                                                <input class="form-check-input" type="radio" name="food_choice" id="everything" value="everything" {{ old('food_choice') === 'everything' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="everything">
                                                    Valgau viską
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="food_choice" id="vegetarianNoMeat" value="vegetarian_no_meat" {{ old('food_choice') === 'vegetarian_no_meat' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vegetarianNoMeat">
                                                    Esu vegetaras/-ė (nevalgau jokios mėsos)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="food_choice" id="vegetarianFishOnly" value="vegetarian_fish_only" {{ old('food_choice') === 'vegetarian_fish_only' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vegetarianFishOnly">
                                                    Esu vegetaras/-ė (valgau žuvį)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="food_choice" id="vegan" value="vegan" {{ old('food_choice') === 'vegan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vegan">
                                                    Esu veganas/-ė
                                                </label>
                                            </div>
                                            @error('food_choice')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Special Needs -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for="special_needs" class="form-label">{{ __('Specialūs poreikiai') }}</label>
                                            <textarea id="special_needs" class="form-control @error('special_needs') is-invalid @enderror" name="special_needs" rows="4">{{ old('special_needs') }}</textarea>
                                            @error('special_needs')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                <script>
                                    grecaptcha.ready(function() {
                                        grecaptcha.execute('{{ config('captcha.sitekey') }}', { action: 'submit' }).then(function(token) {
                                            document.getElementById('g-recaptcha-response').value = token;
                                        });
                                    });
                                </script>

                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-secondary mt-3">
                                        {{ __('Registruotis') }}
                                    </button>
                                </div>
                            </div>
                            {!! NoCaptcha::renderJs() !!}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
