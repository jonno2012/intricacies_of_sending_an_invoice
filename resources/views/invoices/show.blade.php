<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        <div
            class="grid max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 mt-4 mb-6 rounded-md bg-white shadow-md min-h-screen"
            style="grid-template-columns: 50% 50%">
            <div>
                <h3 class="font-semibold text-lg mb-2">Account</h3>
                <p>{{ $user }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-2">Amount</h3>
                <p>£{{ $invoice->amount }}</p>
            </div>
        </div>
    </main>
</div>
</body>
</html>
