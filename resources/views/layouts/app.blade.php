<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Lora font -->
        <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
        <!-- Plus Jakarta Sans font -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="min-h-screen bg-base-200">
        @include('components.alert')
        @php
            $hideLayout = request()->routeIs('login', 'register', 'password.request');
        @endphp
         @unless($hideLayout)
            @include('layouts.header')
        @endunless
            <main class="w-full flex-grow">
                @yield('content')
            </main>
        @unless($hideLayout)
            @include('layouts.footer')
        @endunless
        @stack('scripts')
    </body>
</html>
