<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['product_name'];

    public function permitdetail() :HasMany
    {
        return $this->hasMany(Permitdetail::class);
    }
}
