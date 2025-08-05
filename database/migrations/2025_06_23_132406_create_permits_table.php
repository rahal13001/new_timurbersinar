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
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->string('permit_slug')->unique();
            $table->foreignId('permittype_id');
            $table->string('permit_number');
            $table->date('permit_date');
            $table->date('permit_expiry_date');
            $table->date('sending_date');
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('mode_of_transportation');
            $table->string('hometown');
            $table->string('destination_city');
            $table->string('port_of_departure');
            $table->string('port_of_arrival');
            $table->string('recipient_name');
            $table->text('recipient_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permits');
    }
};
