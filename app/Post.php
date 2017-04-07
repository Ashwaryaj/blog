<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * This is a post model
 */
class Post extends Model
{
    /**
     * A post can have many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * A post can belong only to a single user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Function to add comments
     *
     * @param string $body Body of the post
     */
    public function addComment($body)
    {
        $post_id= $this->id;
        $user_id= Auth::id();
        //dd($post_id, $user_id);
        $this->comments()->create(compact('body', 'user_id', 'post_id'));
    }

    /**
     * A post can have many tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * Filter month and year
     *
     * @param object $query   Query String for Month and Year
     * @param array  $filters To filter vbased on month and year
     */
    public function scopeFilter($query, $filters)
    {
        if ($month=$filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if ($year=$filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    /**
     * Show Archives posts
     *
     * @return array Array of archives
     */
    public static function archives()
    {
        return static::selectRaw(
            'year(created_at) year, monthname(created_at)
         month, count(*) published'
        )
         ->groupBy('year', 'month')
         ->orderByRaw('min(created_at) desc')
         ->get()
         ->toArray();
    }
}
