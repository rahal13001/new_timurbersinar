<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDocument extends Model
{
    protected $fillable =
        [
            // Foreign Keys to Master Tables
            'upt_id',
            'document_type_id',
            'sender_id',
            'recipient_id',
            'origin_city_id',
            'destination_city_id',
            // Document Numbers & Dates
            'letter_number',
            'bap_number',
            'bap_date',
            'permit_number',
            'issued_date',
            // Additional Codes
            'stamp',
            'billing_code'

        ];
}
