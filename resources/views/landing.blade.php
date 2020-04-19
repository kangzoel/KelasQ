<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        body {
            padding: 0
        }
        #app {
            height: 100vh
        }
        p {
            line-height: 1.60em!important
        }
        h1 {
            font-size: 43px;
        }
    </style>
</head>
<body>
    <div id="app" class="d-flex flex-column align-items-center justify-content-center">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo KelasQ">
        <h1 class="font-weight-bold mb-1">{{ config('app.name') }}</h1>
        <p class="h5 px-5 text-center mb-3">Aplikasi manajemen kelas mahasiswa</p>
        <nav>
            <a href="/login" class="btn btn-dark mr-2">Masuk</a>
            <a href="/register" class="btn btn-outline-dark">Daftar</a>
        </nav>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
