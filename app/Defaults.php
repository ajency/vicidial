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
            $defaults_data->save();
        }
        return $defaults_data->meta_data;
    }

    public static function updateLastSync($log_time, $id, $start_time)
    {
        $defaults_data = self::firstOrNew(['label' => 'sync']);
        $defaults_data->meta_data = [
            'sync_time' => Carbon::now()->toDateTimeString(),
            'log_time'  => $log_time,
            'id'        => $id,
            'fetch_time'=> Carbon::now()->diffInSeconds($start_time)
        ];
        $defaults_data->save();
    }
}
