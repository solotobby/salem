<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'end_time'   => 'nullable|date_format:H:i',
            'timezone'   => 'required|string',
        ]);

        // Create a new availability record (single or range)
        
        Availability::create([
            'user_id'    => auth()->user()->id,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date ?? $request->start_date, // Use start_date if no range is selected
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time ?? null, // Allow end time to be nullable
            'timezone'   => $request->timezone,
            'is_booked'  => false, // Default to not booked
        ]);

        return back();

    }
}
