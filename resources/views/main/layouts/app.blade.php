<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') | {{ config('app.name', 'Laravel') }} </title>
    @include('main.layouts.head')
</head>
<body>
    <div class="loading-container">
        <div class="loader"></div>
    </div>

    @include('main.layouts.nav')
    <main>
        <div id="main">
            @yield('content')
        </div>
    </main>
    @include('main.layouts.footer')

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3.1.0/build/cookieconsent.min.js"></script>

    <script>
        window.addEventListener("load", function(){
  window.cookieconsent.initialise({
    palette: {
      popup: {
        background: "#000",
        "font-family": "'Poppins', sans-serif",
        width: "80%",
        "border-radius": "24px",
        "box-shadow": "0 0 16px 0 rgba(0, 0, 0, 0.1)"
      },
      button: {
        background: "#110F6F",
        "border-radius": "24px"
      }
    },
    theme: "classic",
    content: {
      title: "Svetainės slapukai",
      message: "<h5>Svetainės slapukai</h5>Mes naudojame slapukus, kad užtikrintume geriausią patirtį mūsų svetainėje.",
      dismiss: "Supratau!",
      link: "Skaityti daugiau",
      href: "/privatumo-politika"
    }
  });
});
    </script>
</body>
</html>
