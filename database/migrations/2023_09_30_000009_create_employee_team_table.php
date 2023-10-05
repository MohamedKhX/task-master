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
        Schema::create('employee_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('team_id');

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->unique(['employee_id', 'team_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_team');
    }
};
