<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MapUnverifiedUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $userId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $unverified_user = User::find($this->userId);
        $verified_user   = User::where('phone', $unverified_user->phone)->where('verified', true)->first();
        if (!$verified_user) {
            $unverified_user->verified = true;
            $unverified_user->save();
        } 
        else {
            foreach ($unverified_user->carts as $cart) {            
                $cart->user_id = $verified_user->id;
                $cart->save();
            }
            foreach ($unverified_user->addresses as $address) {
                $address->user_id = $verified_user->id;
                $address->save();
            }
        }
    }
}
