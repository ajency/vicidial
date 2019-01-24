<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Corcel\Model\Post as Corcel;

class Post extends Corcel
{
    protected $connection = 'wordpress';
}

class PostController extends Controller {

	public function blog(Request $request)
	{
	    // $posts = Post::published()->get();
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

    public function category(Request $request)
    {
        $post = Post::all();
        // dd($post);
    	if ($post == null) {
    	    abort(404);
    	}
        return view('category')->with('post', $post);
    }
}