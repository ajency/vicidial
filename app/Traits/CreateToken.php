<?php

namespace App\Traits;

use Carbon\Carbon;
use Laravel\Passport\Client;

trait CreateToken
{

    public function createPasswordGrantToken($password)
    {
        $username = $this->email;

        $client = Client::where('name', '=', 'KSS Password Grant Client')->get()->first();

        $http = new \GuzzleHttp\Client;

        $response = $http->post(url('/') . '/oauth/token', [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => $client->id,
                'client_secret' => $client->secret,
                'username'      => $username,
                'password'      => $password,
                'scope'         => '',
            ],
        ]);

        $responseBody = json_decode((string) $response->getBody(), true);

        return ['expires_at' => Carbon::now()->addSeconds($responseBody['expires_in'])->toDateTimeString(), 'access_token' => $responseBody['access_token']];
    }

    public function createPersonalAccessToken()
    {
        $responseBody = $this->createToken('KSS_USER');
        return ['expires_at' => $responseBody->token->expires_at->toDateTimeString(), 'access_token' => $responseBody->accessToken];
    }

}
