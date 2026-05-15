<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Estate Analytics') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="relative min-h-screen overflow-hidden bg-[linear-gradient(180deg,#EDF3F1_0%,#E4ECE9_100%)]">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(15,61,62,0.10),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(31,111,120,0.12),_transparent_30%)]"></div>

        <div class="relative flex min-h-screen flex-col">
            <div class="relative z-[100]">
                @include('layouts.navigation')
            </div>

        <!-- Page Heading -->
        @isset($header)
            <header class="border-b border-white/50 bg-white/55 backdrop-blur-md">
                <div class="mx-auto max-w-[88rem] px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-white/50 bg-white/40 backdrop-blur-md">
            <div class="mx-auto flex max-w-[88rem] flex-col gap-2 px-4 py-4 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <div class="font-medium text-slate-600">
                        Estate Analytics
                    </div>
                    <div>
                        Внутренний сервис аналитики коммерческой недвижимости
                    </div>
                    <div>
                        © 2026
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
