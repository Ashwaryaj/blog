<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This is a tag model
 */
class Tag extends Model
{
    /**
     * Get the posts associated with each tag
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Use name instead of id for getting tags
     *
     * @return String Return name string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
