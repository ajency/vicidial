<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaticController extends Controller
{
    public function __construct()
    {
        $this->params['breadcrumb']         = array();
        $this->params['breadcrumb']['list'] = array();
        setSEO();
    }

    public function index($static_page, Request $request)
    {
        $params          = array();
        $params['page']  = $static_page;
        $params['query'] = $request->all();
        if (view()->exists('shop.' . $params['page'])) {
            return view('shop.' . $params['page'])->with('params', $params);
        } else {
            abort(404);
        }

    }

    public function contact(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Contact Us';
        return view('contact-us')->with('params', $this->params);
    }

    public function contactnew(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Contact Us';
        return view('contact')->with('params', $this->params);
    }

    public function faq(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Faq';
        return view('faq')->with('params', $this->params);
    }

    public function about(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'About Us';
        return view('about-us')->with('params', $this->params);
    }

    public function tc(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Terms and Conditions';
        return view('terms-and-conditions')->with('params', $this->params);
    }

    public function privacy(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Privacy Policy';
        return view('privacy-policy')->with('params', $this->params);
    }

    public function stores(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Stores';
        return view('stores')->with('params', $this->params);
    }

    public function singlestore(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Store';
        return view('store-single')->with('params', $this->params);
    }

    public function activities($storename, Request $request)
    {
        if (!in_array($storename, ["jaipur","surat"])){
            abort(404);
        }
        $this->params['breadcrumb']['current'] = 'Activities Rules';
        return view('activities-rules')->with('params', $this->params)->with('storename', $storename);
    }

    public function gender($gendername, Request $request)
    {
        if (!in_array($gendername, ["boys","girls","infants"])){
            abort(404);
        }
        $this->params['breadcrumb']['current'] = $gendername;
        return view('includes/landingpage/gender')->with('params', $this->params)->with('gendername', $gendername);
    }

    public function productXML(Request $request)
    {
        return response(Storage::disk('s3')->get(config('ajfileupload.doc_base_root_path') . '/products.xml'), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function getVariantDiffFile(Request $request)
    {
        return Variant::updateVariantDiffFile();
    }

    public function saveContactDetails(Request $request){
        $data = $request->all();
        // dd($data);
        sendEmail('contact-us', [
            'from'          => ["name"=>$data["name"],"id"=>$data["email"]],
            'subject'       => 'Contact Form - '.$data["name"],
            'template_data' => [
                'data' => $data,
            ],
            'priority'      => 'default',
        ]);
        return response()->json(["message"=> 'Thank you.. we will get back to you.', 'success'=> true]);
    }

}
