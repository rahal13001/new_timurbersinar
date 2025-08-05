<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    protected $fillable = [
        'post_title',
        'post_slug',
        'post_content',
        'post_image',
        'post_author',
        'post_views',
        'is_publish',
        'post_date',
        ];

    public function category() :BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('post_title')
            ->saveSlugsTo('post_slug');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getRouteKeyName(){
        return 'post_slug';
    }


}
