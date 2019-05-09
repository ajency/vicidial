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
    protected $unverified_user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->unverified_user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $verified_user = User::where('phone', $this->unverified_user->phone)->where('verified', true)->first();
        if (is_null($verified_user)) {
            $this->unverified_user->verified = true;
            $this->unverified_user->save();
        } else {
            foreach ($this->unverified_user->carts as $cart) {
                $cart->user_id = $verified_user->id;
                $cart->save();
            }
            foreach ($this->unverified_user->addresses as $address) {
                $address->user_id = $verified_user->id;
                $address->save();
            }
        }
    }
}
