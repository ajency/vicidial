<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;

class PostController extends Controller {

	public function blog(Request $request)
	{
	    return view('blog.blog');
	}

    public function post($title, Request $request)
    {
        $post = Post::where('post_name',$title)->get()->first();
    	if ($post == null) {
    	    abort(404);
    	}
        return view('blog.single')->with('post', $post);
    }

    public function category($category, Request $request)
    {
    	$cat = Taxonomy::where('taxonomy', 'category')->slug($category)->first();
    	if ($category == "all") {
        	return view('blog.category')->with('cat', $cat);
    	} else if ($cat == null) {
    	    abort(404);
    	}
        return view('blog.category')->with('cat', $cat);
    }
}