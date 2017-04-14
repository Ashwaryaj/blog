<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;

class LikeController extends Controller
{
    public function likePost($slug)
    {
        // here you can check if post exists or is valid Z
        $this->handleLike('App\Post', $slug);
        return redirect()->back();
    }

    public function handleLike($type, $id)
    {
        $existing_like = Like::withTrashed()->whereLikeableType($type)->whereLikeableId($id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            Like::create([
                'user_id'       => Auth::id(),
                'likeable_id'   => $id,
                'likeable_type' => $type,
            ]);
        }
        else {
                $existing_like->restore();
            }
    }
    public function deleteLike($id) {
        $existing_like = Like::withTrashed()->whereLikeableId($id)->whereUserId(Auth::id())->first();
        if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            }
        return redirect()->back();
    }
}
