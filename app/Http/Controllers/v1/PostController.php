<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;

class PostController extends Controller {

	public function blog(Request $request)
	{
	    return view('blog');
	}

    public function post($title, Request $request)
    {
        $post = Post::where('post_name',$title)->get()->first();
        // dd($post);
    	if ($post == null) {
    	    abort(404);
    	}
        return view('single')->with('post', $post);
    }

    public function category($category, Request $request)
    {
    	$cat = Taxonomy::where('taxonomy', 'category')->slug($category)->first();
        // dd($cat);
    	if ($category == "all") {
        	return view('category')->with('cat', $cat);
    	} else if ($cat == null) {
    	    abort(404);
    	}
        return view('category')->with('cat', $cat);
    }
}