<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\ImportLog;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class ImportController extends Controller
{
     public function index()
    {
        $logs = ImportLog::with('user')->latest()->paginate(10);

        return view('imports.index', compact('logs'));
    }

    public function importProperties(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');

        if (! $handle) {
            return back()->withErrors([
                'file' => 'Не удалось открыть файл.',
            ]);
        }

        $header = fgetcsv($handle, 1000, ',');

        $importedRows = 0;
        $failedRows = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            try {
                $data = array_combine($header, $row);

                if (! $data) {
                    $failedRows++;
                    continue;
                }

                $propertyType = PropertyType::firstOrCreate([
                    'title' => trim($data['type']),
                ]);

                $district = District::firstOrCreate([
                    'title' => trim($data['district']),
                ]);

                $area = (float) $data['area'];
                $price = (float) $data['price'];

                Property::create([
                    'title' => trim($data['title']),
                    'property_type_id' => $propertyType->id,
                    'district_id' => $district->id,
                    'segment' => null,
                    'address' => trim($data['address']),
                    'area' => $area,
                    'price' => $price,
                    'price_per_sqm' => $area > 0 ? round($price / $area, 2) : 0,
                    'status' => trim($data['status']),
                    'responsible_user_id' => auth()->id(),
                    'description' => null,
                ]);

                $importedRows++;
            } catch (\Throwable $e) {
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
            ->with('success', 'Импорт объектов завершён.');
    }
}

