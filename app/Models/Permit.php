<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Permit extends Model
{
    use HasSlug;

    protected $fillable = [
        'permittype_id',
        'permit_slug',
        'permit_number',
        'permit_date',
        'permit_expiry_date',
        'sending_date',
        'applicant_name',
        'applicant_address',
        'mode_of_transportation',
        'hometown',
        'destination_city',
        'port_of_departure',
        'port_of_arrival',
        'recipient_name',
        'recipient_address',
    ];

    public function permittype() :BelongsTo
    {
        return $this->belongsTo(Permittype::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function permitdetail() : HasMany
    {
        return $this->hasMany(Permitdetail::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['permit_number', 'permit_date'])
            ->saveSlugsTo('permit_slug');
    }

    public function getRouteKeyName(){
        return 'permit_slug';
    }
}
