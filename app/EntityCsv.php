<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Defaults;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Carbon\Carbon;
use App\EntityData;
use DB;
use App\Jobs\UpdateProductRank;
use SoapBox\Formatter\Formatter;

class EntityCsv extends Model
{
    protected $table = 'entity_csv';
    public static $header_column_mapping =  ["entity_id" => "Product ID","value" => "Rank"];

    public static function readRankCSV(){
    	$filename = Defaults::getLastUpdatedEntityDataFile();
    	$file = Storage::disk('s3')->get(config('ajfileupload.doc_base_root_path') . '/'.$filename);
        $formatter = Formatter::make($file, Formatter::CSV);
        $records = $formatter->toArray();
        $header_columns = array_flip(EntityCsv::$header_column_mapping);
        $insertList =[];
        EntityCsv::truncate();
        foreach ($records as $offset => $record) {
            $row_data = [];
            foreach($record as $record_key => $record_value){
                $row_data[$header_columns[$record_key]] = $record_value;
                $row_data["created_at"] = Carbon::now()->toDateTimeString();
                $row_data["updated_at"] = Carbon::now()->toDateTimeString();
            }
            array_push($insertList, $row_data);
        }
        EntityCsv::insert($insertList);
    }

    public static function getHeaderColumnMapping(){
    	return static::$header_column_mapping;
    }

    public static function updateEntityData(){
    	$entity_data_columns =  ["entity" => "product","entity_origin" => "odoo","attribute"=>"product_rank","active"=>1];
    	$enity_csv = DB::select( DB::raw("SELECT * FROM entity_csv WHERE id NOT IN (SELECT entity_csv.id FROM entity_csv JOIN entity_data ON entity_data.entity_id = entity_csv.entity_id WHERE entity_data.attribute = 'product_rank')") );
    	
    	$insertList=[];
    	foreach($enity_csv as $csv_data){
    		$row=array_merge($entity_data_columns,["entity_id"=>$csv_data->entity_id,"value"=>$csv_data->value,"created_at"=>Carbon::now()->toDateTimeString(),"updated_at"=>Carbon::now()->toDateTimeString()]);
    		array_push($insertList,$row);
    	}

    	if(count($insertList)>0)
    		EntityData::insert($insertList);
    	// dd($insertList);
    	$enity_data = DB::select( DB::raw("SELECT id FROM entity_data WHERE entity_data.attribute = 'product_rank' AND entity_data.id NOT IN (SELECT entity_data.id FROM entity_data JOIN entity_csv ON entity_data.entity_id = entity_csv.entity_id WHERE entity_data.attribute = 'product_rank')") );
    	$entity_data_ids = array_column($enity_data, "id");
    	EntityData::whereIn('id',$entity_data_ids)->update(['value' => config('product.static_fields.product.product_rank')]);


    	$entity_csv_update_data = DB::table("entity_data")->join('entity_csv', function ($join) {
            $join->on('entity_data.entity_id', '=', 'entity_csv.entity_id');
            $join->where([['entity_data.attribute', '=', "product_rank"]]);
        })->whereColumn([['entity_data.value',"!=", 'entity_csv.value']])->select('entity_data.*','entity_csv.value as csv_value')->get();

        foreach($entity_csv_update_data as $entity_csv_update_entry){
        	$entity_data = EntityData::find($entity_csv_update_entry->id);
        	$entity_data->value = $entity_csv_update_entry->csv_value;
        	$entity_data->save();
        }

    }

    public static function updateProductRankJob(){
    	$last_updated_date = Defaults::getLastUpdatedEntityData();
    	$entity_data = EntityData::where([['attribute', '=', "product_rank"],['updated_at','>',$last_updated_date]])->get();
    	foreach ($entity_data as $entity) {
    		UpdateProductRank::dispatch($entity->entity_id)->onQueue('update_product_rank');
    	}
    	Defaults::setLastUpdatedEntityData();
    }

}
