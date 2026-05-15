<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="ea-section-title">Пользователи</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Административный список сотрудников и учётных записей системы.
                </p>
            </div>

            <a href="{{ route('users.create') }}" class="ea-btn">
                Добавить пользователя
            </a>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Users
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl text-white/80">
                            Управление пользователями системы
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Просматривайте список сотрудников, роли и создавайте новые учётные записи.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Раздел</div>
                            <div class="mt-2 text-lg font-semibold">Администрирование</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Фокус</div>
                            <div class="mt-2 text-lg font-semibold">Роли и доступ</div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ea-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-slate-900">Список пользователей</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Все пользователи, имеющие доступ к внутренней системе.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="ea-table">
                            <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Роль</th>
                                    <th>Дата создания</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="font-semibold text-slate-900">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->created_at?->format('d.m.Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500">
                                            Пользователи не найдены.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
