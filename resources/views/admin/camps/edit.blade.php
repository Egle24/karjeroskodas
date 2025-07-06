@extends('admin.layouts.appAdmin')

@section('title','Stovyklos redagavimas')
@section('content')
        <div class="image-preview" style="display: none;">
            <i class="bi bi-x-lg close-preview"></i>
            <img src="" alt="Preview Image">
        </div>
        <div class="row justify-content-center">
            <h2 class="text-center pb-3">Stovyklos "{{ $camp->title}}" redagavimas</h2>
            <div class="col-md-12 col-sm-12 col-lg-10">
                <div class="card">
                    <div class="card-body justify-content-center">
                        <form action="{{ route('admin.camps.update', $camp->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-left col-md-6 col-sm-12">
                                    <div class="title mb-3">
                                        <label for="title" class="form-label">{{ __('Pavadinimas') }}</label>
                                        <input id="title" type="text"
                                               class="form-control @error('title') is-invalid @enderror" name="title"
                                               value="{{ old('title', optional($camp ?? null)->title) }}"
                                               autocomplete="title">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="description mb-3">

                                        <label for="description" class="form-label">{{ __('Aprašymas') }}</label>
                                        <textarea id="description" type="text"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  name="description">{{ old('description', optional($camp ?? null)->description) }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>

                                    <div class="type mb-3">
                                        <label for="type">Tipas</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="stovykla" {{ $camp->type == 'stovykla' ? 'selected' : '' }}>Stovykla</option>
                                            <option value="seminaras" {{ $camp->type == 'seminaras' ? 'selected' : '' }}>Seminaras</option>
                                            <option value="projektas" {{ $camp->type == 'projektas' ? 'selected' : '' }}>Projektas</option>
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="address mb-3">
                                        <label for="address" class="form-label">{{ __('Adresas') }}</label>
                                        <input id="address" type="text"
                                               class="form-control @error('address') is-invalid @enderror"
                                               name="address"
                                               value="{{ old('address', optional($camp ?? null)->address) }}"
                                               autocomplete="address">
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="start_date">
                                                <label for="start_date" class="form-label">{{ __('Pradžios data') }}</label>
                                                <input id="start_date" type="datetime-local"
                                                    class="form-control @error('start_date') is-invalid @enderror"
                                                    name="start_date"
                                                    value="{{ old('start_date', $camp->start_date ? \Carbon\Carbon::parse($camp->start_date)->format('Y-m-d\TH:i') : '') }}">
                                                @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="end_date">
                                                <label for="end_date" class="form-label">{{ __('Pabaigos data') }}</label>
                                                <input id="end_date" type="datetime-local"
                                                    class="form-control @error('end_date') is-invalid @enderror"
                                                    name="end_date"
                                                    value="{{ old('end_date', $camp->end_date ? \Carbon\Carbon::parse($camp->end_date)->format('Y-m-d\TH:i') : '') }}">
                                                @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main_image b-3">
                                        <label for="main_image"
                                               class="form-label">{{ __('Pagrindinė nuotrauka') }}</label>
                                        <input id="main_image" type="file"
                                               class="form-control @error('main_image') is-invalid @enderror"
                                               name="main_image" accept="image/*">
                                        @error('main_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="priceForGuests">
                                                <label for="priceForGuests" class="form-label">{{ __('Kaina ne nariams') }}</label>
                                                <input id="priceForGuests" type="text"
                                                    class="form-control @error('priceForGuests') is-invalid @enderror"
                                                    name="priceForGuests"
                                                    value="{{ old('priceForGuests', $camp->priceForGuests) }}"
                                                    autocomplete="priceForGuests">
                                                @error('priceForGuests')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="priceForMembers">
                                                <label for="priceForMembers" class="form-label">{{ __('Kaina nariams') }}</label>
                                                <input id="priceForMembers" type="text"
                                                    class="form-control @error('priceForMembers') is-invalid @enderror"
                                                    name="priceForMembers"
                                                    value="{{ old('priceForMembers', $camp->priceForMembers) }}"
                                                    autocomplete="priceForMembers">
                                                @error('priceForMembers')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="status row g-2">

                                        <label for="status" class="form-label">{{ __('Statusas') }}</label>
                                        <select id="status" class="form-select @error('status') is-invalid @enderror"
                                                name="status">
                                            <option value="0" {{ old('status', $camp->status) == 0 ? 'selected' : '' }}>
                                                Vyksianti
                                            </option>
                                            <option value="1" {{ old('status', $camp->status) == 1 ? 'selected' : '' }}>
                                                Pasibaigusi
                                            </option>
                                        </select>
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="form-right col-md-6">

                                    <div class="foodChoice mb-3">
                                        <label for="foodChoice" class="form-label">{{ __('Maitinimas') }}</label>
                                        <textarea id="foodChoice" type="text"
                                                  class="form-control @error('foodChoice') is-invalid @enderror"
                                                  name="foodChoice">{{ old('foodChoice', $camp->foodChoice) }}</textarea>
                                        @error('foodChoice')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="accomodation mb-3">
                                        <label for="accommodation" class="form-label">{{ __('Apgyvendinimas') }}</label>
                                        <textarea id="accommodation" type="text"
                                                  class="form-control @error('accommodation') is-invalid @enderror"
                                                  name="accommodation">{{ old('accommodation', $camp->accommodation) }}</textarea>
                                        @error('accommodation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="clothing mb-3">
                                        <label for="clothing" class="form-label">{{ __('Apranga') }}</label>
                                        <textarea id="clothing" type="text"
                                                  class="form-control @error('clothing') is-invalid @enderror"
                                                  name="clothing">{{ old('clothing', $camp->clothing) }}</textarea>
                                        @error('clothing')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="worth mb-3">

                                        <label for="worth" class="form-label">{{ __('Kodėl verta?') }}</label>
                                        <textarea id="worth" type="text"
                                                  class="form-control @error('worth') is-invalid @enderror"
                                                  name="worth">{{ old('worth', $camp->worth) }}</textarea>
                                        @error('worth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>

                                    <div class="audience row g-2">

                                        <label for="audience"
                                               class="form-label">{{ __('Kam skirta ši stovykla?') }}</label>
                                        <textarea id="audience" type="text"
                                                  class="form-control @error('audience') is-invalid @enderror"
                                                  name="audience">{{ old('audience', $camp->audience) }}</textarea>
                                        @error('audience')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>

                                    <div class="programme row g-2">

                                        <label for="programme_id" class="form-label">{{ __('Programa') }}</label>
                                        <select id="programme_id" name="programme_id" class="form-control">
                                            @foreach($programmes as $programme)
                                                <option value="{{ $programme->id }}" {{ old('programme_id', $camp->programme_id) == $programme->id ? 'selected' : '' }}>{{ $programme->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('programme_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>

                    
                                </div>
                            </div>

                            <div class="modal-footer gap-2">
                                <button type="button" class="btn btn-outline-primary"
                                        onclick="window.location='{{ route('admin.camps.index') }}'">Atšaukti
                                </button>
                                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
