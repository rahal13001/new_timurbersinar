<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permitdetail extends Model
{
    protected $fillable = [
        'permit_id',
        'permit_detail',
        'species_id',
        'product_id',
        'quantity',
        'unit',
        ];

    public function permit() :BelongsTo
    {
        return $this->belongsTo(Permit::class);
    }

    public function species() :BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
