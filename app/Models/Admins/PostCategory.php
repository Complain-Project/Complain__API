<?php

namespace App\Models\Admins;

use Jenssegers\Mongodb\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = "post_categories";

    protected $fillable = [
        'name',
        'slug'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postPublishedAt()
    {
        return $this->posts()->whereNotNull("published_at");
    }
}
