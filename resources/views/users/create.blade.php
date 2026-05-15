<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="ea-section-title">Создание пользователя</h2>
            <p class="mt-1 text-sm text-slate-500">
                Добавление новой учётной записи сотрудника или администратора.
            </p>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="ea-card">
                <div class="ea-card-body">
                    @if ($errors->any())
                        <div class="ea-alert-error">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="ea-label">Имя</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="ea-input">
                            </div>

                            <div>
                                <label class="ea-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="ea-input">
                            </div>

                            <div>
                                <label class="ea-label">Роль</label>
                                <select name="role" class="ea-input">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" @selected(old('role') === $role)>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="ea-label">Пароль</label>
                                <input type="password" name="password" class="ea-input">
                            </div>

                            <div class="md:col-span-2">
                                <label class="ea-label">Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" class="ea-input">
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="ea-btn">
                                Сохранить
                            </button>

                            <a href="{{ route('users.index') }}" class="ea-btn-secondary">
                                Назад
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>