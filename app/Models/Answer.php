<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = ['question_id', 'answerer_name', 'answer'];

    public function comment() :BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
