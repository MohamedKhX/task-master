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
        Schema::create('tag_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id');
            $table->foreignId('assignment_id');
            $table->enum('assignment_type', ['Task', 'Project']);
            $table->timestamps();

            $table->foreign('tag_id')->references('id')->on('tags');

            $table->unique(['tag_id', 'assignment_id', 'assignment_type']);

            $table->index(['assignment_id', 'assignment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_assignments');
    }
};
