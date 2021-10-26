<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>

    </style>

</head>

<body>
    <div class="buttons">
        <button class="button is-primary">Primary</button>
        <button class="button is-link">Link</button>
    </div>

    <div class="buttons">
        <button class="button is-info">Info</button>
        <button class="button is-success">Success</button>
        <button class="button is-warning">Warning</button>
        <button class="button is-danger">Danger</button>
    </div>
    <div id="app">

    </div>

</body>

<script src="{{ mix('/js/app.js') }}"></script>

</html>