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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('number'); // Número/nome da mesa
            $table->integer('capacity'); // Capacidade de pessoas
            $table->integer('min_capacity')->default(1); // Capacidade mínima
            $table->text('description')->nullable();
            $table->enum('location', ['inside', 'outside', 'terrace', 'vip'])->default('inside');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'active']);
            $table->unique(['restaurant_id', 'number']); // Número único por restaurante
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
