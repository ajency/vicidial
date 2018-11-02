<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderDetails extends Controller
{
	public function index(Request $request)
    {
        return view('orderdetails');
    }
}
