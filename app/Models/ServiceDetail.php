<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $fillable = [
        // The main link to the parent document
        'service_document_id',

        // Foreign Keys to Master Tables
        'fish_species_id',
        'product_type_id',
        'quota_source_id',
        'unit_id',

        // Nullable Foreign Keys
        'sipji_id',
        'cites_source_id',

        // Item-specific data
        'quantity'
    ];
}
