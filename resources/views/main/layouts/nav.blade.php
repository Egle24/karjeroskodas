<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="navUsers">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="img-fluid">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}">Pagrindinis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('articles.index')) ? 'active' : '' }}" href="{{ route('articles.index') }}">Straipsniai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('camps.index')) ? 'active' : '' }}" href="{{ route('camps.index') }}">Renginiai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('gallery.index')) ? 'active' : '' }}" href="{{ route('gallery.index') }}">Galerija</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('feedback.index')) ? 'active' : '' }}" href="{{ route('feedback.index') }}">Atsiliepimai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('contactForm')) ? 'active' : '' }}" href="{{ route('contactForm') }}">Kontaktai</a>
            </ul>
        </div>
        <div class="collapse navbar-collapse justify-content-end flex-grow-0" id="navbarNav">
            <ul class="navbar-nav">
                    @guest
                        <div class="d-flex flex-column align-items-center gap-2">
                            @if (Route::has('login'))
                                <li class="w-100">
                                    <a class="btn btn-secondary w-100" href="{{ route('login') }}">{{ __('Prisijungti') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register.step1'))
                                <li class="w-100">
                                    <a class="btn btn-outline-info w-100" href="{{ route('register.step1') }}">
                                        {{ __('Registruotis') }}</a>
                                </li>
                            @endif
                        </div>
                    @else
                        <li class="nav-item">
                            <div class="dropdown d-flex align-items-center">
                                <div class="smallCircle">
                                    @if (auth()->user()->profile_image)
                                        <img class="avatar" src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </div>
                                {{ auth()->user()->name }} {{ auth()->user()->surname }}
                                <button id="user-dropdown" class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-chevron-down rotate-down" id="chevron-icon"></i>
                                </button>
                                <div class="dropdown-menu" style="right: 0;" aria-labelledby="user-dropdown">
                                    @if(auth()->check() && auth()->user()->isUserAdmin())
                                        <a class="dropdown-item" href="{{route('admin.index')}}">Admin
                                            <i class="bi bi-person-gear"></i>
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('profile.show')}}">Profilis
                                    <i class="bi bi-person"></i>
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Atsijungti
                                        <i class="bi bi-door-open"></i>
                                    </a>
                                </div>
                            </div>
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
</nav>
