@props([
    'title' => config('app.name', 'Estate Analytics'),
    'subtitle' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif;
            color: #0f172a;
            background: #f8fafc;
        }

        .print-shell {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }

        .print-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px 18px;
            border: 1px solid #dbe4e7;
            border-radius: 16px;
            background: #ffffff;
        }

        .print-title {
            margin: 0;
            font-size: 28px;
            line-height: 1.2;
        }

        .print-subtitle {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        .print-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .print-btn {
            appearance: none;
            -webkit-appearance: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border-radius: 12px;
            border: 1px solid #d8e2e5;
            background: #ffffff;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .print-btn::-moz-focus-inner {
            border: 0;
        }

        .print-btn:-moz-focusring,
        .print-btn:focus,
        .print-btn:focus-visible,
        .print-btn:active {
            outline: none !important;
            box-shadow: none !important;
        }

        .print-btn-primary {
            border-color: #0f3d3e;
            background: #0f3d3e;
            color: #ffffff;
        }

        .print-card {
            border: 1px solid #dbe4e7;
            border-radius: 20px;
            background: #ffffff;
            overflow: hidden;
        }

        .print-card-body {
            padding: 24px;
        }

        .meta-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .meta-item {
            border: 1px solid #e5ecef;
            border-radius: 14px;
            background: #f8fbfb;
            padding: 14px 16px;
        }

        .meta-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
        }

        .meta-value {
            margin-top: 6px;
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .print-table th,
        .print-table td {
            border: 1px solid #dbe4e7;
            padding: 10px 12px;
            vertical-align: top;
            text-align: left;
        }

        .print-table thead th {
            background: #f2f7f7;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
        }

        .print-section-title {
            margin: 0 0 14px;
            font-size: 20px;
        }

        .print-note {
            margin-top: 18px;
            font-size: 13px;
            color: #64748b;
        }

        .print-block {
            margin-top: 24px;
        }

        @media print {
            @page {
                margin: 14mm;
                size: auto;
            }

            body {
                background: #ffffff;
            }

            .print-shell {
                max-width: none;
                padding: 0;
            }

            .print-toolbar {
                display: none;
            }

            .print-card {
                border: none;
                border-radius: 0;
            }

            .print-card-body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="print-shell">
        <div class="print-toolbar">
            <div>
                <h1 class="print-title">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="print-subtitle">{{ $subtitle }}</p>
                @endif
            </div>

            <div class="print-actions">
                <button
                    type="button"
                    class="print-btn print-btn-primary"
                    tabindex="-1"
                    onmousedown="event.preventDefault()"
                    onclick="this.blur(); window.print()"
                >
                    Печать / Сохранить в PDF
                </button>
                <button
                    type="button"
                    class="print-btn"
                    tabindex="-1"
                    onmousedown="event.preventDefault()"
                    onclick="this.blur(); window.close()"
                >
                    Закрыть
                </button>
            </div>
        </div>

        {{ $slot }}
    </div>
</body>
</html>
