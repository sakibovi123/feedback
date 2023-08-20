<?php

use App\Models\Qustion;
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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("slug", 255)->unique();
            $table->foreignIdFor(User::class);
            $table->string("share_url", 255)->nullable()->unique();
            $table->string("name", 255)->nullable();
            $table->string("description", 255)->nullable();

            // qustions
            $table->foreignIdFor(Qustion::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
