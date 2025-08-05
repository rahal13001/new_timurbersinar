<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $fillable = ['family_name'];

    public function species() :HasMany
    {
        return $this->hasMany(Species::class);
    }
}
