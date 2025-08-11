<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FishSpecies extends Model
{
    protected $fillable = ['scientific_name','common_name'];
}
