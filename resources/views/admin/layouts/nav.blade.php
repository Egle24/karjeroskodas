<nav class="navbar navbar-expand-lg fixed-top" id="navAdmin">
        <a class="navbar-brand" href="{{ route('admin.index') }}">
            <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarAdmin">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('admin/users')) ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Nariai</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(request()->is('admin/camps')) || (request()->is('admin/camps/programmes'))? 'active' : '' }}" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Stovyklos <i class="bi bi-chevron-down rotate-down" id="chevron-icon2"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.camps.index') }}">Visos</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.camps.programmes.index') }}">Programos</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(request()->is('admin/articles')) || (request()->is('admin/categories'))? 'active' : '' }}" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Straipsniai <i class="bi bi-chevron-down rotate-down" id="chevron-icon3"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.articles.index') }}">Visi</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Kategorijos</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{(request()->is('admin/gallery')) ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}">Galerija</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{(request()->is('admin/files')) ? 'active' : '' }}" href="{{ route('admin.files.index') }}">Failai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{(request()->is('admin/feedbacks')) ? 'active' : '' }}" href="{{ route('admin.feedbacks.index') }}">Atsiliepimai</a>
                </li>
            </ul>
        </div>
    <div class="collapse navbar-collapse justify-content-end flex-grow-0" id="navbarAdmin">
        <ul class="navbar-nav">
            @guest
                <div class="d-flex flex-column align-items-center gap-2">
                    @if (Route::has('login'))
                        <li class="w-100">
                            <a class="btn btn-outline-primary w-100" href="{{ route('login') }}">{{ __('Prisijungti') }}</a>
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
