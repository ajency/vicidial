<?php

namespace App;

use App\Defaults;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SoapBox\Formatter\Formatter;

class Pincode extends Model
{
    protected $casts = [
        'deliverable' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pincode',
    ];

    public static function uploadPincodes()
    {
        if (Storage::disk('s3')->exists('Pincodes/pincodes.csv')) {
            $failed_pincodes = array();

            $pincodes  = Storage::disk('s3')->get('Pincodes/pincodes.csv');
            $formatter = Formatter::make($pincodes, Formatter::CSV);
            $pincodes  = $formatter->toArray();

            $states    = Defaults::where('type', '=', 'state')->get();
            $statesArr = array();
            foreach ($states as $state) {
                $statesArr[strtolower($state->label)] = $state->id;
            }

            if (count($pincodes) == 0) {
                return "pincodes.csv file is empty";
            }

            foreach ($pincodes as $pincode) {
                $statename = strtolower($pincode['state']);
                if (isset($statesArr[$statename])) {
                    $pincodes_entry           = self::firstOrNew(['pincode' => $pincode['pincode']]);
                    $pincodes_entry->district = $pincode['district'];
                    $pincodes_entry->state_id = $statesArr[$statename];
                    $pincodes_entry->save();
                } else {
                    array_push($failed_pincodes, $pincode['pincode']);
                }

            }

            if (count($failed_pincodes) > 0) {
                return $failed_pincodes;
            } else {
                return "Pincodes Updated";
            }
        } else {
            return "pincodes.csv file not found on s3";
        }

    }
}
