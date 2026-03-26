<?php

use App\Models\Department;
use App\Models\Level;
use App\Models\User;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title')->unique();
            $table->string('description')->nullable();
            $table->integer('units')->nullable();
            $table->foreignIdFor(Level::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Department::class)->constrained()->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
