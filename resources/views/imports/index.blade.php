<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="ea-section-title">Импорт данных</h2>
            <p class="mt-1 text-sm text-slate-500">
                Загрузка объектов из CSV и просмотр истории импортов.
            </p>
        </div>
    </x-slot>

    <div class="ea-page">
        <div class="ea-container">
            <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#0F3D3E_0%,#14585A_58%,#1F6F78_100%)] p-6 text-white shadow-[0_24px_60px_rgba(15,61,62,0.18)] sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-white/60">
                            Import
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl text-white/80">
                            Загрузка данных и история импортов
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/80">
                            Импортируйте объекты из CSV и отслеживайте результаты загрузок в журнале.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Формат</div>
                            <div class="mt-2 text-lg font-semibold">CSV</div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="text-xs uppercase tracking-[0.2em] text-white/60">Контроль</div>
                            <div class="mt-2 text-lg font-semibold">История загрузок</div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ea-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="ea-alert-error">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="ea-card mb-6">
                <div class="ea-card-body">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-slate-900">Импорт объектов из CSV</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Ожидаемые колонки: <code>title,type,address,district,area,price,status</code>
                        </p>
                    </div>

                    <form action="{{ route('imports.properties') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div x-data="{ fileName: '' }">
                            <label class="ea-label">CSV-файл</label>

                            <div class="rounded-2xl border border-dashed border-slate-300 bg-[#FAFCFC] p-4">
                                <input
                                    id="import-file"
                                    type="file"
                                    name="file"
                                    class="hidden"
                                    @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''"
                                >

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label
                                            for="import-file"
                                            class="inline-flex cursor-pointer items-center justify-center rounded-xl bg-[#0F3D3E] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#14585A]"
                                        >
                                            Выбрать файл
                                        </label>

                                        <button
                                            type="button"
                                            @click="fileName = ''; document.getElementById('import-file').value = ''"
                                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                                        >
                                            Очистить
                                        </button>
                                    </div>

                                    <span class="text-sm text-slate-500" x-text="fileName || 'Файл не выбран'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="ea-btn">
                                Загрузить
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ea-card">
                <div class="ea-card-body">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-slate-900">История импортов</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Последние операции загрузки файлов и их результаты.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="ea-table">
                            <thead>
                                <tr>
                                    <th>Тип</th>
                                    <th>Файл</th>
                                    <th>Импортировано</th>
                                    <th>Ошибок</th>
                                    <th>Пользователь</th>
                                    <th>Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $log->import_type }}</td>
                                        <td>{{ $log->file_name }}</td>
                                        <td>{{ $log->imported_rows }}</td>
                                        <td>{{ $log->failed_rows }}</td>
                                        <td>{{ $log->user?->name }}</td>
                                        <td>{{ $log->created_at?->format('d.m.Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-slate-500">
                                            Импортов пока не было.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
