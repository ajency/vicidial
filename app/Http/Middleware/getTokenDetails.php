<?php

namespace App\Http\Middleware;

use Closure;

class getTokenDetails
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = explode('Bearer ', $request->header('Authorization'))[1];

        $token_parts        = explode('.', $token);
        $token_header       = $token_parts[0];
        $token_header_json  = base64_decode($token_header);
        $token_header_array = json_decode($token_header_json, true);
        $user_token         = $token_header_array['jti'];

        $tokenData = \DB::table('oauth_access_tokens')->where('id', $user_token)->first(['id', 'verified', 'cart_id']);

        $request->merge(['token_id' => $tokenData->id, 'token_verified' => ($tokenData->verified) ? true : false, 'active_cart' => $tokenData->cart_id]);

        return $next($request);
    }
}
