<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') | {{ config('app.name', 'Laravel') }} </title>
    @include('main.layouts.head')
</head>
<body class="vh-100">

    <div class="loading-container">
        <div class="loader"></div>
    </div>

    @include('main.layouts.nav')
    <main class="py-4" id="reg">
        <div id="main">
            @yield('content')
        </div>
    </main>
    @include('main.layouts.footer')

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>
