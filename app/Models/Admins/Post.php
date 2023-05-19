<?php

namespace App\Models\Admins;

use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = [
        'post_category_id',
        'title',
        'slug',
        'banner_path',
        'short_content',
        'content',
        'post_tag_ids',
        'created_by',
        'status'
    ];

    const STATUS = [
        "DEACTIVATE" => 0,
        "ACTIVE" => 1
    ];

    protected $appends = ['banner_src'];

    public function getBannerSrcAttribute()
    {
        return $this->banner_path ? url(Storage::url($this->banner_path)) : null;
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id', '_id');
    }

    public function tags()
    {
        return $this->belongsToMany(PostTag::class);
    }

    public function author()
    {
        return $this->belongsTo(Employee::class, 'created_by', '_id');
    }
}
