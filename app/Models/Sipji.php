<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sipji extends Model
{
    protected $fillable = ['partner_id', 'permit_number', 'issue_date', 'expiry_date'];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
