<div class="container-fluid m-0 footer">
    <footer class="row justify-content-center py-5">
        <div class="col-md-3 col-sm-3 col-lg-2 mb-3">
            <a href="/" class="d-flex w-50 align-items-center mb-2 ms-2 link-body-emphasis text-decoration-none">
                <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="img-fluid">
            </a>
            <div class="d-flex">
                <a href="https://www.facebook.com/karjeros" target="_blank" class="btn btn-default">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://www.instagram.com/karjeroskodas/" target="_blank" class="btn btn-default">
                    <i class="bi bi-instagram"></i>
                </a>
            </div>
            <p class="ms-2">© {{ date('Y') }}</p>

        </div>

        <div class="col-md-6 col-sm-9 col-lg-3 mb-3">
            <p>
                Karjeros kodas - Kūrybingų ir entuziastingai nusiteikusių
                bendraminčių asociacija, kurios tikslas - didinti narių sąmoningumą
                asmeninių kompetencijų tobulinimo ir karjeros ugdymo srityse.
            </p>
        </div>
        <div class="col-md-0 col-sm-0 col-lg-1 mb-3">
        </div>

        <div class="col-md-3 col-sm-6 col-lg-3 mb-3">
            <h5>Nuorodos</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="{{route('camps.index')}}" class="nav-link p-0 ">Stovyklos</a></li>
                <li class="nav-item mb-2"><a href="{{route('articles.index')}}" class="nav-link p-0 ">Straipsniai</a></li>
                <li class="nav-item mb-2"><a href="{{route('gallery.index')}}" class="nav-link p-0">Galerija</a></li>
                <li class="nav-item mb-2"><a href="{{route('feedback.index')}}" class="nav-link p-0 ">Atsiliepimai</a></li>
                <li class="nav-item mb-2"><a href="{{route('contactForm')}}" class="nav-link p-0 ">Kontaktai</a></li>
            </ul>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-3 mb-3">
            <h5>Informacija</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="{{route('privacy')}}" class="nav-link p-0 ">Privatumo politika</a></li>
            </ul>
        </div>


    </footer>

</div>
