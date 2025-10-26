<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schools_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schoolID');
            $table->unsignedBigInteger('teacherID');
            $table->unsignedBigInteger('gradeID')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools_teachers');
    }
};
