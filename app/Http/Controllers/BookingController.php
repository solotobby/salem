<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function bookSession($id, $duration){
        $adviser = Adviser::where('unique_id', $id)->first();
        //duratiion - time
        $amount = '';
        if($duration == '15'){
            $amount = $adviser->_15_min;
        }
        $amount;

        $availability = Availability::where('user_id', $adviser->user_id)->get();
        return view('bookings.book', ['availabilities' => $availability]);
    }

    public function setupAvailability(){
        $availability = Availability::where('user_id', auth()->user()->id)->get();
        return view('bookings.create', ['availabilities' => $availability]);
    }
}
