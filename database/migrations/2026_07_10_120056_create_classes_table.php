<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('classes', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('classes');
    // }

    public function up(): void
{
    Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->cascadeOnDelete();
        $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
        $table->string('room')->nullable();
        $table->enum('day_of_week', ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
        $table->time('start_time');
        $table->time('end_time');
        $table->unsignedInteger('capacity')->default(30);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('classes');
}
};
