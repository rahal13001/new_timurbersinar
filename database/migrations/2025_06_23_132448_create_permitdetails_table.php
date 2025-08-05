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
        Schema::create('permitdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id');
            $table->foreignId('species_id');
            $table->foreignId('product_id');
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permitdetails');
    }
};
