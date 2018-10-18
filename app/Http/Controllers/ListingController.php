<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index($category_type, $gender, $age_group, $category_subtype, Request $request)
    {
        return view('productlisting');
    }
}
