<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Estate Analytics') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#E7EFEC] text-slate-900 antialiased">
    <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-4 py-10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(15,61,62,0.22),_transparent_34%),radial-gradient(circle_at_bottom_right,_rgba(130,166,160,0.32),_transparent_38%),linear-gradient(180deg,_#EDF3F1_0%,_#E3ECE9_100%)]">
        </div>

        <div class="absolute inset-x-0 top-0 h-40 bg-[linear-gradient(180deg,rgba(255,255,255,0.45),rgba(255,255,255,0))]"></div>

        <div class="relative grid w-full max-w-5xl overflow-hidden rounded-[32px] border border-white/60 bg-white/70 shadow-[0_30px_90px_rgba(15,61,62,0.16)] backdrop-blur-xl lg:grid-cols-[1.08fr_0.92fr]">
            <div class="hidden bg-[linear-gradient(160deg,#0F3D3E_0%,#1A5456_55%,#2E706F_100%)] p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <div class="inline-flex items-center rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-white/70">
                        Estate Analytics
                    </div>

                    <h1 class="mt-6 text-4xl font-semibold leading-tight text-white">
                        Внутренняя аналитика коммерческой недвижимости
                    </h1>

                    <p class="mt-6 max-w-md text-sm leading-7 text-white/80">
                        Управление объектами, экспозициями и аналитическими показателями
                        в единой рабочей системе для сотрудников компании.
                    </p>
                </div>

                <div class="mt-6 grid max-w-md gap-4">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <div class="text-xs uppercase tracking-[0.2em] text-white/55">Модули</div>
                        <div class="mt-2 text-sm leading-6 text-white/90">
                            Объекты, экспозиции, аналитика, сравнение, импорт
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#D4B483]/20 bg-[#D4B483]/10 p-4 backdrop-blur-sm">
                        <div class="text-xs uppercase tracking-[0.2em] text-[#F0DEC0]">Назначение</div>
                        <div class="mt-2 text-sm leading-6 text-white/90">
                            Рабочий внутренний сервис для сотрудников брокерской компании
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[linear-gradient(180deg,#FCFEFD_0%,#F4F8F6_100%)] px-6 py-8 sm:px-10 sm:py-10">
                <div class="mb-8">
                    <div class="inline-flex items-center rounded-full bg-[#E6F0EE] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#1F6F78]">
                        Вход в систему
                    </div>
                    <h2 class="mt-4 text-3xl font-semibold text-slate-900">
                        Estate Analytics
                    </h2>
                    <p class="mt-3 max-w-md text-sm leading-6 text-slate-500">
                        Используйте корпоративную учётную запись для входа в рабочую среду.
                    </p>
                </div>

                {{ $slot }}
            </div>
        </div>

        <footer class="relative mt-6 text-center text-sm text-slate-500">
            <div class="font-medium text-slate-600">Estate Analytics</div>
            <div class="mt-1">Внутренний сервис аналитики коммерческой недвижимости</div>
            <div class="mt-1">© 2026</div>
        </footer>
    </div>
</body>

</html>
