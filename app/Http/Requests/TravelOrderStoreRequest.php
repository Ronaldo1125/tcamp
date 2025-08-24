<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'purpose' => ['required'],
            'purpose_image_filename' => ['required', 'mimes:pdf', 'max:2048'],
            'destination' => ['required'],
            'travel_departure_date' => ['required', 'date', 'after_or_equal:today'],
            'travel_arrival_date' => ['required', 'date', 'after_or_equal:travel_departure_date'],
            'fund_source_id' => ['required'],
            'is_travel_related_to_training' => ['required'],
            'is_cash_advance' => ['required'],
            //'grand_total' => ['required', 'numeric'],
            'inputs.*.itinerary_date' => ['required', 'date', 'after_or_equal:travel_departure_date','before_or_equal:travel_arrival_date'], 
            'inputs.*.transportation_id' => ['required'],
            'inputs.*.estimated_time_of_departure' => ['required', 'date_format:H:i'],
            'inputs.*.estimated_time_of_arrival' => ['required', 'date_format:H:i'],
            'inputs.*.region_code' => ['required'],
            'inputs.*.province_code' => ['required'],
            'inputs.*.city_code' => ['required'],
        ];
    }
}
