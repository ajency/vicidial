<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
use Corcel\Model\Page;

class PostController extends Controller {

	public function blog(Request $request)
	{
	    return view('blog.blog');
	}

    public function post($title, Request $request)
    {
        $post = Post::where('post_type','post')->slug($title)->first();
        $page = Post::where('post_type','page')->slug($title)->first();
    	if ($post == null && $page == null) {
    	    abort(404);
    	} elseif ($post != null) {
            if ($request->has('amp')) {
        	   return view('blog.amp-single');
            }
            return view('blog.single');
    	} elseif ($page != null) {
        	return view('blog.page');
    	}
    }

    public function category($category, Request $request)
    {
    	$cat = Taxonomy::where('taxonomy', 'category')->slug($category)->first();
    	if ($category == "all") {
        	return view('blog.category');
    	} elseif ($cat == null) {
    	    abort(404);
    	}
        return view('blog.category');
    }
}