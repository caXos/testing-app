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
            $table->string('name')->default('New task');
            $table->text('description')->nullable()->default(null);
            $table->integer('status')->default(1);
            $table->date('deadline')->nullable()->default(null);
            $table->integer('priority')->default(1);
            $table->json('workers')->nullable()->default(null);
            $table->boolean('active')->default(true);
            $table->timestamps();
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
/**
 * Status values:
 * 1 -> Not started/pending
 * 2 -> In progress
 * 3 -> Halted/suspended
 * 4 -> Done/finished
 */