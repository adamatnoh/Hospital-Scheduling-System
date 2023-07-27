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
        Schema::create('on_call_applications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('user_id');
            $table->string('department');
            $table->string('reason');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status');
            $table->string('rejection');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('on_call_applications');
    }
};
