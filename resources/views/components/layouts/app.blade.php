<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Your App' }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/css/customer/hero.css'])
    
    <!-- Any other head elements -->
</head>
<body class="bg-gray-900">
    <x-layouts.app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts.app.sidebar>

    <!-- Vite JS -->
    @vite(['resources/js/app.js', 'resources/js/customer/hero.js'])
</body>
</html>