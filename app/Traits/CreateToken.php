<?php

namespace App\Traits;

use Laravel\Passport\Client;

trait CreateToken
{

    public function createPasswordGrantToken($username, $password)
    {
        $client = Client::where('name', '=', 'KSS Password Grant Client')->get()->first();

        $http = new \GuzzleHttp\Client;

        $response = $http->post(url('/').'/oauth/token', [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => $client->id,
                'client_secret' => $client->secret,
                'username'      => $username,
                'password'      => $password,
                'scope'         => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

}
