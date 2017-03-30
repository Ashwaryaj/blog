<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\Post;
use DB;
class TagsController extends Controller
{	
    public function index(Tag $tag){
    	$posts=$tag->posts()->latest()->paginate(10);
    	return view('posts.index',compact('posts'));
    }

    public function autocompleteTags(Request $request){
    	$name=$request->query('query');
		$tags=Tag::where('name', 'like', '%' . $name . '%')->get();
		$tagsArray=$tags->toArray();
		$json = [];
		foreach ($tagsArray as $name => $value) 
	 		$json[]=$tagsArray[$name];
		echo json_encode($json);
    }

    public function saveTags(Request $request, $post_id){
        $post=$request->toArray();
        $tags=explode(',', $post["hidden-tags"]);
        foreach ($tags as $tag) {
            $t = Tag::where('name',$tag)->first();
            if (is_null($t)) {
                //Insert into database
                $var=new Tag;
                $var->name=$tag;
                $var->save();
            }

            $post = Post::where('id', $post_id)->firstOrFail();
            $temp= Tag::where('name', $tag)->first();
            $id=$temp->id;
            $post->tags()->attach($id);
        }
    }
}
