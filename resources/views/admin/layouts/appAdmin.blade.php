<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') | {{ config('app.name', 'Laravel') }} </title>
    @include('admin.layouts.head')
</head>
<body>
    <div class="loading-container">
        <div class="loader"></div>
    </div>

    <main class="py-4">
        @include('admin.layouts.nav')
        <div class="container-fluid" id="main">
            @yield('content')
        </div>
    </main>

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>


    
</body>
</html>
