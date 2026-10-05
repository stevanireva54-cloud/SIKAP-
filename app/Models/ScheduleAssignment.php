<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'rig',
        'crew',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function schedules()
    {
        return $this->hasMany(
            EmployeeSchedule::class,
            'schedule_assignment_id'
        );
    }
}