<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('schedule_assignment_id')
                ->constrained('schedule_assignments')
                ->cascadeOnDelete();

            $table->date('schedule_date');

            $table->enum('shift_code', [
                'S',
                'M',
                'ON',
                'OFF',
            ]);

            $table->timestamps();

            $table->unique(
                ['schedule_assignment_id', 'schedule_date'],
                'employee_schedule_assignment_date_unique'
            );

            $table->index('schedule_date');
            $table->index('shift_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_schedules');
    }
};