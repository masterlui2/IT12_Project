{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Techne Fixer') }}</title>

{{-- Fallback styling for environments without an active Vite dev server --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Primary bundled assets (served by Vite when available) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50 dark:bg-neutral-900">
    {{-- If you want a public navbar or header, include it here --}}
    <div class="min-h-screen">
        @yield('content')
    </div>
</body>
</html>
