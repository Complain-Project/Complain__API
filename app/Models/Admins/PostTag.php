<?php

namespace App\Models\Admins;

use Jenssegers\Mongodb\Eloquent\Model;

class PostTag extends Model
{
    protected $table = "post_tags";

    protected $fillable = [
        'name',
        'post_ids'
    ];
}
