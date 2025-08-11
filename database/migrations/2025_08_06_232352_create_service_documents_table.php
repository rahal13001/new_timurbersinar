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
        Schema::create('service_documents', function (Blueprint $table) {
            $table->id();

            // Foreign Keys to Master Tables
            $table->foreignId('upt_id')->constrained('upts');
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->foreignId('sender_id')->constrained('partners');
            $table->foreignId('recipient_id')->constrained('partners');
            $table->foreignId('origin_city_id')->constrained('cities');
            $table->foreignId('destination_city_id')->constrained('cities');

            // Document Numbers & Dates
            $table->string('letter_number')->unique();
            $table->string('bap_number')->unique();
            $table->date('bap_date');
            $table->string('permit_number')->unique();
            $table->date('issue_date');

            // Additional Codes
            $table->string('stamp')->nullable();
            $table->string('billing_code')->unique()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_documents');
    }
};
