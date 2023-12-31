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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->enum('priority', ['Critical', 'High', 'Low'])->nullable();
            $table->enum('status', ['Completed', 'In Progress', 'Pending'])->nullable();

            $table->foreignId('created_by');
            $table->foreignId('project_id')->nullable();
            $table->foreignId('parent_id')->nullable();

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();

            $table->index('created_by');

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('tasks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
