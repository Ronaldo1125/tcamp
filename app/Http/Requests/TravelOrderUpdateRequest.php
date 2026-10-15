<?php

namespace App\Http\Requests;

use App\Rules\ChronologicalItineraryDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TravelOrderUpdateRequest extends FormRequest
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
        $rules = [
            'purpose' => ['required'],
            'purpose_image_filename' => ['sometimes', 'mimes:pdf', 'max:2048'],
            'region_code' => ['required'],
            'province_code' => ['required'],
            'city_code' => ['required'],
            'travel_departure_date' => ['required', 'date', 'after_or_equal:today'],
            'travel_arrival_date' => ['required', 'date', 'after_or_equal:travel_departure_date'],
            'fund_source_id' => ['required'],
            'pap_id' => ['required_unless: fund_source_id, lt:3'],
            'other_pap_name' => ['required_without:pap_id'],
            'is_travel_related_to_training' => ['required'],
            'is_cash_advance' => ['required'],
            //'grand_total' => ['required', 'numeric'],
            'inputs' => ['required', 'array'],
            'inputs.*.itinerary_date' => [
                'required', 
                'date', 
                'after_or_equal:travel_departure_date',
                'before_or_equal:travel_arrival_date',
                new ChronologicalItineraryDate(), // Handled via wildcard for JSValidator compatibility
                ], 
            'inputs.*.place' => ['required', 'string'],
            'inputs.*.transportation_id' => ['required'],
            'inputs.*.estimated_time_of_departure' => ['required', 'date_format:H:i'],
            'inputs.*.estimated_time_of_arrival'   => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    // Pull the exact index (e.g., extracts '0' from 'inputs.0.estimated_time_of_arrival')
                    $index = Str::before(Str::after($attribute, 'inputs.'), '.estimated_time_of_arrival');
                    
                    // Fetch the paired departure time from the request data
                    $departure = $this->input("inputs.{$index}.estimated_time_of_departure");

                    // Validate that arrival is strictly greater than departure
                    if ($departure && $value <= $departure) {
                        $fail('The estimated time of arrival must be a time after the estimated time of departure.');
                    }
                },
            ],

            // Approver Validation
            'immediate_supervisor_id'   => [
                'required', 
                'exists:users,id', 
                'different:management_id', 
                'different:budget_officer_id'
            ],
            'management_id'  => [
                'required', 
                'exists:users,id', 
                'different:immediate_supervisor_id', 
                'different:budget_officer_id'
            ],
            'budget_officer_id'    => [
                'required', 
                'exists:users,id', 
                'different:immediate_supervisor_id', 
                'different:management_id'
            ],
        ];

        // Retrieve the inputs array safely from the request payload
        $inputs = $this->input('inputs', []);

        if (is_array($inputs)) {
            // Loop starting from the second item (index 1) to build sequential comparisons
            for ($i = 1; $i < count($inputs); $i++) {
                $prevIndex = $i - 1;
                
                $rules["inputs.{$i}.itinerary_date"] = [
                    'required',
                    'date',
                    "after_or_equal:inputs.{$prevIndex}.itinerary_date",
                ];
            }
        }

         return $rules;
    }

    public function messages()
    {
        $messages = [
            'different' => 'Each approval stage must be assigned to a different person.',
            'after'     => 'The estimated time of arrival must be after the estimated time of departure.',
            'inputs.0.itinerary_date.required' => 'The first itinerary date is required.',
        ];

        $inputs = $this->input('inputs', []);
    
    // Explicitly generate custom failure messages matching the exact generated index rules
        if (is_array($inputs)) {
            for ($i = 1; $i < count($inputs); $i++) {
                $messages["inputs.{$i}.itinerary_date.after"] = "Itinerary item #".($i + 1)." must be a date after item #{$i}.";
            }
        }

        return $messages;
    }
}
