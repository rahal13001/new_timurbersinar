<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['post_id', 'commenter_name', 'comment'];

    public function post() :BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
