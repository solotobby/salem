<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View{
        //list of advisers
        $adviders = Adviser::with(['specs:id,name'])->select('id', 'name', 'shout_out', 'avg_rating', 'unique_id')->get();
        return view('dashboard', ['advisers' => $adviders]);
    }



    
}
