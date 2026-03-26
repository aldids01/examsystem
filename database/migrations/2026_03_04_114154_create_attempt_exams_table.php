<?php

use App\Models\Exam;
use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attempt_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exam::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();


            $table->unsignedInteger('score')->default(0);
            $table->string('grade')->nullable();
            $table->unsignedInteger('grade_point')->default(0);
            $table->unsignedInteger('credit_unit')->default(0);
            $table->unsignedInteger('credit_point')->default(0);

            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // server-enforced timeout

            $table->timestamps();

            // Disable reattempt (remove if multiple attempts allowed)
            $table->unique(['exam_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_exams');
    }
};
