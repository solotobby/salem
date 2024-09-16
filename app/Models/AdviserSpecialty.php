<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdviserSpecialty extends Model
{
    use HasFactory;

    protected $fillable = ['adviser_id', 'specialty_id'];
}
