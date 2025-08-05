<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PermitUser extends Pivot
{
    protected $fillable = ['permit_id', 'user_id'];
}
