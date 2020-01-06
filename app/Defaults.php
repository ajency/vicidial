<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Defaults extends Model
{

    protected $fillable = ['label'];

    protected $dates = [];

    protected $casts = [
        "meta_data" => 'array',
    ];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

    //Methods
    public static function getLastSync()
    {
        $defaults_data = self::where('label', 'sync')->first();
        if ($defaults_data == null) {
            $defaults_data            = new self;
            $defaults_data->label     = 'sync';
            $defaults_data->meta_data = ['run_cron' => 0];
            $defaults_data->save();
        }
        return $defaults_data->meta_data;
    }

    public static function updateLastSync($log_time, $id, $start_time)
    {
        $defaults_data             = self::where(['label' => 'sync'])->first();
        $meta_data                 = $defaults_data->meta_data;
        $meta_data['sync_time']    = Carbon::now()->toDateTimeString();
        $meta_data['log_time']     = $log_time;
        $meta_data['id']           = $id;
        $meta_data['fetch_time'][] = Carbon::now()->diffInSeconds($start_time);
        $defaults_data->meta_data  = $meta_data;
        $defaults_data->save();
    }

    public static function getCronStatus()
    {
        $defaults_data = self::where('label', 'cron')->first();
        if ($defaults_data == null) {
            $defaults_data            = new self;
            $defaults_data->label     = 'cron';
            $defaults_data->meta_data = ['run_cron' => 0];
            $defaults_data->save();
        }
        return $defaults_data->meta_data;
    }
}
