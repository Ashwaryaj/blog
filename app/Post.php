<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use \Conner\Likeable\Likeable;

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
    /**
     * @param $title
     * @param int   $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        if (count($allSlugs)) {
            return $slug . "-" . count($allSlugs);
        }

        return $slug;
    }
    /**
     * Fetch similar slugs
     *
     * @param  String  $slug Accept the slug corresponding to post
     * @param  integer $id   id of the post
     * @return Post object        Returns related slug obk=ject
     */
    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Post::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
    public function likes()
    {
        return $this->morphToMany('App\User', 'likeable')->whereDeletedAt(null);
    }

    public function getIsLikedAttribute()
    {
        $like = $this->likes()->whereUserId(Auth::id())->first();
        return (!is_null($like)) ? true : false;
    }
}
