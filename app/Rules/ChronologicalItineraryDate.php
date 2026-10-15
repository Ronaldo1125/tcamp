<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ChronologicalItineraryDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract the current index from the attribute string (e.g., "inputs.2.itinerary_date")
        preg_match('/inputs\.(\d+)\.itinerary_date/', $attribute, $matches);
        
        if (isset($matches[1])) {
            $currentIndex = (int) $matches[1];

            // If it is the first item, skip comparison
            if ($currentIndex === 0) {
                return;
            }

            // Fetch all inputs sent in the request payload
            $inputs = request()->input('inputs', []);
            $previousIndex = $currentIndex - 1;

            // Check if the previous index exists and contains a date
            if (isset($inputs[$previousIndex]['itinerary_date'])) {
                $currentDate = strtotime($value);
                $previousDate = strtotime($inputs[$previousIndex]['itinerary_date']);

                // Validate that the current date is strictly after the previous date
                if ($currentDate && $previousDate && $currentDate <= $previousDate) {
                    $fail("This itinerary date must be set chronologically after item #{$currentIndex}.");
                }
            }
        }
    }
}
