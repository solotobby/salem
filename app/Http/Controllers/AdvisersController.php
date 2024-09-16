<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\AdviserSpecialty;
use App\Models\Specialty;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AdvisersController extends Controller
{
    public function show($id){
        // with('specs:id,name')
         $adviserInfo = Adviser::where('unique_id', $id)->get();
        return view('advisers.show', compact('adviserInfo'));
    }

    public function create(){
        $specialities = Specialty::all();
        return view('advisers.create', ['specialties' => $specialities]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'shout_out' => ['required', 'string'],
            'description' => ['required', 'string'],
            'specialties' => ['required', 'array'],
            '_15_min' => ['required', 'numeric'],
            '_30_min' => ['required', 'numeric'],
            '_1_hour' => ['required', 'numeric'],
            '_2_hours' => ['required', 'numeric']
        ]);



        $adviser = Adviser::create(['user_id' => auth()->user()->id, 'name' => $request->name, 'shout_out' => $request->shout_out,
                        'description' => $request->description, 'specialties' => 'fdgdf', '_15_min' => $request->_15_min, 
                        '_30_min' => $request->_30_min, '_1_hour' => $request->_1_hour, '_2_hour' => $request->_2_hours, 
                        'unique_id' => Str::random(16)]);
        if($adviser){
            foreach($request->specialties as $spec){
                AdviserSpecialty::create(['adviser_id' => $adviser->id, 'specialty_id'=>$spec]);
            }
        }
       
        return redirect('home');
        
    }
}
