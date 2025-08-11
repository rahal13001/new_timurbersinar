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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            // The main link to the parent document
            $table->foreignId('service_document_id')->constrained('service_documents')->onDelete('cascade');

            // Foreign Keys to Master Tables
            $table->foreignId('fish_species_id')->constrained('fish_species');
            $table->foreignId('product_type_id')->constrained('product_types');
            $table->foreignId('quota_source_id')->constrained('quota_sources');
            $table->foreignId('unit_id')->constrained('units');

            // Nullable Foreign Keys
            $table->foreignId('sipji_id')->nullable()->constrained('sipjis');
            $table->foreignId('cites_source_id')->nullable()->constrained('cites_sources');

            // Item-specific data
            $table->decimal('quantity', 10, 2); // 10 total digits, 2 after decimal point
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
