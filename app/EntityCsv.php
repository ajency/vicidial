<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Defaults;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Carbon\Carbon;

class EntityCsv extends Model
{
    protected $table = 'entity_csv';
    public static $header_column_mapping =  ["entity_id" => "Product ID","value" => "Rank"];

    public static function readRankCSV(){
    	$filename = Defaults::getLastUpdatedEntityDataFile();
    	$file = Storage::disk('s3')->get(config('ajfileupload.doc_base_root_path') . '/'.$filename);
    	$csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0); //set the CSV header offset
        $records = $csv->getRecords();
        $headers = $csv->getHeader();
        $header_columns = array_flip(EntityCsv::$header_column_mapping);
        $insertList =[];
        foreach ($records as $offset => $record) {
            // print_r($record);
            $row_data = [];
            foreach($record as $record_key => $record_value){
                $row_data[$header_columns[$record_key]] = $record_value;
                $row_data["created_at"] = Carbon::now()->toDateTimeString();
                $row_data["updated_at"] = Carbon::now()->toDateTimeString();
            }
            array_push($insertList, $row_data);
        }
        // dd($insertList);
        EntityCsv::insert($insertList);
    }

    public static function getHeaderColumnMapping(){
    	return static::$header_column_mapping;
    }

}
