<?php

namespace App\Http\Requests;

use App\Models\Exposure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExposureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'channel_id' => ['required', 'exists:exposure_channels,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'publication_price' => ['nullable', 'numeric', 'min:0'],
            'views_count' => ['required', 'integer', 'min:0'],
            'leads_count' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(Exposure::STATUSES)],
            'source_url' => ['nullable', 'url'],
            'comment' => ['nullable', 'string', 'max:200'],
        ];
    }
}
