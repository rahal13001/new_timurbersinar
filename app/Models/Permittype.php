<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permittype extends Model
{
    protected $fillable = ['permit_type'];

    public function permit() :HasMany
    {
        return $this->hasMany(Permit::class);
    }
}
