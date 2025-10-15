<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Additional meta tags -->
    @yield('meta_description', $page->meta_description ?? '')
    @yield('meta_keywords', $page->meta_keywords ?? '')
    
    <!-- Custom CSS -->
    @yield('custom_css')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @yield('header')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
        
        @yield('footer')
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    
    <!-- Custom JS -->
    @yield('custom_js')
</body>
</html>