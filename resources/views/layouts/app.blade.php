<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    @auth
        <header class="shadow-sm fixed-top">
            <nav class="app-navbar pl-4 d-flex align-items-stretch">
                <h1 class="h5 mb-0 d-flex align-items-center">@yield('title')</h1>
                <div class="ml-auto d-flex align-items-stretch">
                    <div class="dropdown d-flex align-items-stretch">
                        <a class="d-flex align-items-center text-decoration-none text-muted px-4" href="#"
                            id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right border-0 shadow animated fadeInDown" aria-labelledby="navbarDropdown" style="animation-duration: 0.25s">
                            @stack('menu')
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            @stack('header')
        </header>
    @endauth

    <main>
        @yield('content')
    </main>

    @auth
    <footer>
        <nav class="bottom-nav fixed-bottom bg-white">
            <div class="container-fluid">
                <div class="row text-center">
                    <a class="col{{ url()->current() == url('/classes') ? ' active' : '' }}" href="/classes">
                        <div class="icon">
                            <i class="fas fa-fw fa-cubes"></i>
                        </div>
                        <div class="small">
                            Kelas
                        </div>
                    </a>
                    <a class="col{{ url()->current() == url('/schedules') ? ' active' : '' }}" href="/schedules">
                        <div class="icon">
                            <i class="far fa-fw fa-calendar-alt"></i>
                        </div>
                        <div class="small">
                            Jadwal
                        </div>
                    </a>
                    <a class="col{{ url()->current() == url('/tasks') ? ' active' : '' }}" href="/tasks">
                        <div class="icon">
                            <i class="fas fa-fw fa-tasks"></i>
                        </div>
                        <div class="small">
                            Tugas
                        </div>
                    </a>
                    <a class="col{{ url()->current() == url('/bills') ? ' active' : '' }}" href="/bills">
                        <div class="icon">
                            <i class="fas fa-fw fa-money-bill"></i>
                        </div>
                        <div class="small">
                            Tagihan
                        </div>
                    </a>
                </div>
            </div>
        </nav>
    </footer>
    @endauth

    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
