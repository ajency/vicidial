<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\StaticElement;
use App\Defaults;
use Illuminate\Support\Facades\Input;
use League\Csv\Reader;
use Carbon\Carbon;
use App\EntityCsv;
use App\Jobs\UploadEntityCsv;
use App\EntityData;
use SplTempFileObject;
use League\Csv\Writer;

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
        if (in_array($gendername, ["boys","girls","infants"])){
            $static_elements=StaticElement::fetch($gendername,[], $published=true);
            $this->params['breadcrumb']['current'] = ucwords($gendername);
            return view('includes/landingpage/gender')->with('params', $this->params)->with('gendername', $gendername)->with('static_elements', $static_elements);
        }
        if (in_array($gendername, ["uniforms"])){
            return view('home_new');
        }
        abort(404);
    }

    public function draft($gendername, Request $request)
    {
        if (!in_array($gendername, ["boys","girls","infants"])){
            abort(404);
        }
        $static_elements=StaticElement::fetch($gendername,[], $published=false);
        $this->params['breadcrumb']['current'] = $gendername;
        return view('includes/landingpage/gender')->with('params', $this->params)->with('gendername', $gendername)->with('static_elements', $static_elements);
    }

    public function productXML(Request $request)
    {
        return response(Storage::disk('s3')->get(config('ajfileupload.doc_base_root_path') . '/products.xml'), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function sitemapXML(Request $request)
    {
        $sitemapPath = Defaults::getSitemapPath();
        if($sitemapPath){
            return response(Storage::disk('s3')->get($sitemapPath), 200, [
                'Content-Type' => 'application/xml',
            ]);
        }
        else{
            return response()->json(["message"=> 'Sitemap not generated!!!', 'success'=> false]);
        }
    }

    public function productlistXML(Request $request)
    {
        $sitemapPath = Defaults::getSitemapPath("product_listing");
        if($sitemapPath){
            return response(Storage::disk('s3')->get($sitemapPath), 200, [
                'Content-Type' => 'application/xml',
            ]);
        }
        else{
            return response()->json(["message"=> 'Sitemap not generated!!!', 'success'=> false]);
        }
        
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

    public function saveRankCSV(Request $request){
        $header_column_mapping =  EntityCsv::getHeaderColumnMapping();

        $data = $request->all();
        if (Input::hasFile('csv')){
            $file = Input::file('csv');
            $name = time().'-'.$file->getClientOriginalName();
            $path = storage_path('app/public').'/csv'; 
            $file->move($path, $name);

            //read csv file
            $csv = Reader::createFromPath($path."/".$name, 'r');
            $csv->setHeaderOffset(0); //set the CSV header offset
            $headers = $csv->getHeader();
            $result = array_diff(array_values($header_column_mapping),$headers);

            if(!(count(array_values($header_column_mapping))==count($headers) && count($result)==0)) {
                abort(413,"CSV headers do not match!!");
            }

            Storage::disk('s3')->put(config('ajfileupload.doc_base_root_path') . '/'.$name,$path."/".$name);
            Defaults::addOrUpdateLastUpdatedEntityDataFile($name);
            UploadEntityCsv::dispatch()->onQueue('upload_entity_csv');
            return response()->json(["success"=>true,"message"=>"Rank CSV saved successfully!!"],200);
        } else {
            abort(413,"CSV file not received!!");
        }
        
    }


    public function downloadRankCSV(Request $request){
        $header_column_mapping =  EntityCsv::getHeaderColumnMapping();
        $entity_data = EntityData::where('attribute','product_rank')->get()->pluck('value','entity_id');
        $rows = [];
        array_push($rows, array_values($header_column_mapping));
        foreach($entity_data as $entity_id => $value){
            array_push($rows,[$entity_id,$value]);
        }
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertAll($rows);
        $csv->output('rank_csv.csv');
    }

}
