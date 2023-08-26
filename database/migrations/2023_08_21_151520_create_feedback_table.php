<?php

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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name", 255)->nullable();
            $table->string("email", 255)->nullable();
            $table->foreignIdFor(\App\Models\Form::class);
            $table->foreignIdFor(\App\Models\Question::class);
            $table->string("answer", 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
