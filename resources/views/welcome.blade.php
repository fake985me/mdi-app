<!DOCTYPE html>
<html lang="{{ $currentLocale ?? str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Vue App</title>
    @vite(['resources/css/app.css', 'resources/js/main.js'])
    <script>
        // Pass the current locale to the frontend
        window.Laravel = {
            locale: '{{ $currentLocale ?? app()->getLocale() }}'
        };
    </script>
</head>
<body>
    <div id="app"></div>
</body>
</html>