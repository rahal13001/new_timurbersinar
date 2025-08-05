<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Species extends Model
{
    protected $fillable = [
        'genus_name',
        'group_id',
        'family_id',
        'species_name',
        'common_name',
        'appendix',
        'appendix_grade',
    ];

    public function permitdetails() :HasMany
    {
        return $this->hasMany(Permitdetail::class);
    }

    public function family() :BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function group() :BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
