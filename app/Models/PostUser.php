<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostUser extends Pivot
{
    protected $fillable = ['post_id', 'user_id'];


}
