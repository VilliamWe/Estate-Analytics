<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="ea-section-title">Профиль</h2>
            <p class="mt-1 text-sm text-slate-500">
                Управление данными учётной записи, паролем и настройками доступа.
            </p>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container space-y-6">
            

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
