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
    </style>
</head>
<body>
    <nav>
        <a href="/login">Masuk</a>
        <a href="/register">Daftar</a>
    </nav>
    <h1>{{ config('app.name') }}</h1>
    <p>Homepage</p>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
