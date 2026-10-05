<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_assignment_id',
        'schedule_date',
        'shift_code',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function assignment()
    {
        return $this->belongsTo(
            ScheduleAssignment::class,
            'schedule_assignment_id'
        );
    }
}