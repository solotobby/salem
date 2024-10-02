<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'type', 'start_date', 'end_date', 'start_time', 'end_time', 'timezone', 'is_booked'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedStartAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', "{$this->start_date} {$this->start_time}", $this->timezone)
            ->setTimezone(config('app.timezone'))
            ->format('Y-m-d H:i');
    }

    public function getFormattedEndAttribute()
    {
        if ($this->end_time) {
            
            return Carbon::createFromFormat('Y-m-d H:i:s', "{$this->start_date} {$this->end_time}", $this->timezone)
                ->setTimezone(config('app.timezone'))
                ->format('Y-m-d H:i');
        }
        return null;
    }
}
