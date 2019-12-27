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
            $defaults_data->meta_data = ['batch' => config('static.fetch_limit')];
            $defaults_data->save();
        }
        return $defaults_data->meta_data;
    }

    public static function updateLastSync($log_time, $id)
    {
        $defaults_data = self::where('label', 'sync')->first();
        if (!$defaults_data) {
            $defaults_data        = new self;
            $defaults_data->label = 'sync';
        }
        $defaults_data->meta_data = [
            'sync_time' => Carbon::now()->toDateTimeString(),
            'log_time'  => $log_time,
            'id'        => $id,
            'batch'     => $defaults_data->meta_data['batch'],
        ];
        $defaults_data->save();
    }
}
