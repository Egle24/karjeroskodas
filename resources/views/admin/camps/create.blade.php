<form>
    @csrf
        <div class="row">
            <div class="form-left col-md-6">
                <div class="row g-2">
                    <label for="title" class="form-label">{{ __('Pavadinimas') }}</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="description" class="form-label">{{ __('Aprašymas') }}</label>
                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="type" class="form-label">Tipas</label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                        <option value="stovykla" {{ old('type') == 'stovykla' ? 'selected' : '' }}>Stovykla</option>
                        <option value="seminaras" {{ old('type') == 'seminaras' ? 'selected' : '' }}>Seminaras</option>
                        <option value="projektas" {{ old('type') == 'projektas' ? 'selected' : '' }}>Projektas</option>
                    </select>
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="address" class="form-label">{{ __('Adresas') }}</label>
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                
                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-2">
                            <label for="start_date" class="form-label">{{ __('Pradžios data') }}</label>
                            <input id="start_date" type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}">
                            @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2">
                            <label for="end_date" class="form-label">{{ __('Pabaigos data') }}</label>
                            <input id="end_date" type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                            <label for="main_image" class="form-label">{{ __('Pagrindinė nuotrauka') }}</label>
                            <input id="main_image" type="file" class="form-control @error('main_image') is-invalid @enderror" name="main_image" accept="image/*" required>
                            @error('main_image')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-2">
                            <label for="priceForGuests" class="form-label">{{ __('Kaina ne nariams') }}</label>
                            <input id="priceForGuests" type="text" class="form-control @error('priceForGuests') is-invalid @enderror" name="priceForGuests" value="{{ old('priceForGuests') }}"  autocomplete="priceForGuests">
                            @error('priceForGuests')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2">
                            <label for="priceForMembers" class="form-label">{{ __('Kaina nariams') }}</label>
                            <input id="priceForMembers" type="text" class="form-control @error('priceForMembers') is-invalid @enderror" name="priceForMembers" value="{{ old('priceForMembers') }}"  autocomplete="priceForMembers">
                            @error('priceForMembers')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <label for="status" class="form-label">{{ __('Statusas') }}</label>
                    <select id="status" class="form-select @error('status') is-invalid @enderror" name="status">
                        <option value="0">Vyksianti</option>
                        <option value="1">Praėjusi</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>

            <div class="form-right col-md-6">

                <div class="row g-2">
                    <label for="foodChoice" class="form-label">{{ __('Maitinimas') }}</label>
                    <textarea id="foodChoice" type="text" class="form-control @error('foodChoice') is-invalid @enderror" name="foodChoice" >{{ old('foodChoice') }}</textarea>
                    @error('foodChoice')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="accommodation" class="form-label">{{ __('Apgyvendinimas') }}</label>
                    <textarea id="accommodation" type="text" class="form-control @error('accommodation') is-invalid @enderror" name="accommodation" ></textarea>
                    @error('accommodation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="clothing" class="form-label">{{ __('Apranga') }}</label>
                    <textarea id="clothing" type="text" class="form-control @error('clothing') is-invalid @enderror" name="clothing" ></textarea>
                    @error('clothing')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="worth" class="form-label">{{ __('Kodėl verta?') }}</label>
                    <textarea id="worth" type="text" class="form-control @error('worth') is-invalid @enderror" name="worth" ></textarea>
                    @error('worth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row g-2">
                    <label for="audience" class="form-label">{{ __('Kam skirta ši stovykla?') }}</label>
                    <textarea id="audience" type="text" class="form-control @error('audience') is-invalid @enderror" name="audience" ></textarea>
                    @error('audience')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row g-2">
                    <label for="programme_id" class="form-label">{{ __('Programa') }}</label>
                    <select id="programme_id" name="programme_id" class="form-control">
                        <option value="">-</option>
                        @foreach($programmes as $programme)
                            <option value="{{ $programme->id }}">{{ $programme->title }}</option>
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

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                    Atšaukti
                </button>
                <button type="submit" class="btn btn-secondary">Patvirtinti</button>
            </div>
</form>
