<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'shout_out', 'specialties', 'avg_rating', '_15_min', '_30_min', '_1_hour', '_2_hour', 'status', 'unique_id'];

    public function specs(){
        return $this->belongsToMany(Specialty::class, 'adviser_specialties', 'adviser_id');
    }
}
