<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\ImportLog;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportController extends Controller
{
    private const REQUIRED_HEADERS = [
        'title',
        'type',
        'address',
        'district',
        'area',
        'price',
        'status',
    ];

    public function index()
    {
        $logs = ImportLog::with('user')->latest()->paginate(10);

        return view('imports.index', compact('logs'));
    }

    public function importProperties(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        if (! $handle) {
            return back()->withErrors([
                'file' => 'Не удалось открыть файл.',
            ]);
        }

        $header = fgetcsv($handle, 1000, ',');

        if (! is_array($header)) {
            fclose($handle);

            return back()->withErrors([
                'file' => 'CSV-файл не содержит корректной строки заголовков.',
            ]);
        }

        $header = array_map(static fn ($value) => trim((string) $value), $header);
        $missingHeaders = array_values(array_diff(self::REQUIRED_HEADERS, $header));

        if ($missingHeaders !== []) {
            fclose($handle);

            return back()->withErrors([
                'file' => 'В CSV отсутствуют обязательные колонки: '.implode(', ', $missingHeaders).'.',
            ]);
        }

        $importedRows = 0;
        $failedRows = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($row) !== count($header)) {
                $failedRows++;
                continue;
            }

            $data = array_combine($header, $row);

            if ($data === false) {
                $failedRows++;
                continue;
            }

            try {
                DB::transaction(function () use ($data): void {
                    $propertyType = PropertyType::firstOrCreate([
                        'title' => trim((string) $data['type']),
                    ]);

                    $district = District::firstOrCreate([
                        'title' => trim((string) $data['district']),
                    ]);

                    $area = (float) $data['area'];
                    $price = (float) $data['price'];

                    Property::create([
                        'title' => trim((string) $data['title']),
                        'property_type_id' => $propertyType->id,
                        'district_id' => $district->id,
                        'segment' => null,
                        'address' => trim((string) $data['address']),
                        'area' => $area,
                        'price' => $price,
                        'price_per_sqm' => $area > 0 ? round($price / $area, 2) : 0,
                        'status' => trim((string) $data['status']),
                        'responsible_user_id' => auth()->id(),
                        'description' => null,
                    ]);
                });

                $importedRows++;
            } catch (Throwable) {
                $failedRows++;
            }
        }

        fclose($handle);

        ImportLog::create([
            'user_id' => auth()->id(),
            'import_type' => 'properties',
            'file_name' => $file->getClientOriginalName(),
            'imported_rows' => $importedRows,
            'failed_rows' => $failedRows,
        ]);

        return redirect()
            ->route('imports.index')
            ->with('success', "Импорт завершён: успешно {$importedRows}, с ошибками {$failedRows}.");
    }
}
