<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->string('rig', 50);

            $table->enum('crew', [
                'RIG_SUPERINTENDENT',
                'A',
                'B',
                'C',
            ]);

            $table->unsignedSmallInteger('year');

            $table->timestamps();

            $table->unique(
                ['employee_id', 'year'],
                'schedule_assignment_employee_year_unique'
            );

            $table->index(['rig', 'year']);
            $table->index(['crew', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_assignments');
    }
};