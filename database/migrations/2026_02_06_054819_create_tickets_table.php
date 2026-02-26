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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('low');
        $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
