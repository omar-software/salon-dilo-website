<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Vue Projekt</title>

    <!-- Laravel Vite lädt CSS und JavaScript -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Hier wird die Vue-App angezeigt -->
    <div id="app"></div>
</body>
</html>