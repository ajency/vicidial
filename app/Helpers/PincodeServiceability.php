<?php
use GuzzleHttp\Client;

function checkDelhiveryPincodeServiceability($pincode)
{
	$config = config('pincode_serviceability.services.delhivery');
	$api_url = $config["gateway_url"]."/c/api/pin-codes/json/";
	$client = new Client(['http_errors' => false]);
	$options = ['query' => ["token"=>$config["api_key"],"filter_codes"=>$pincode]];
	$response = $client->request('GET', $api_url, $options);
	
	$response_arr = ["response" => json_decode($response->getBody(),true),"status_code" => $response->getStatusCode()];
	$data = [];
	if($response_arr["status_code"] == 401){
		// dd($response_arr);
		$data["success"] = false;
		$data["error"] = "You couldn't be authenticated";
	}
	else if($response_arr["status_code"] == 200){
		if(count($response_arr["response"]["delivery_codes"])<=0){
			$data["success"] = false;
			$data["error"] = "Wrong pincode passed";
		}
		else{
			$data["success"] = true;
			$data["data"] = $response_arr["response"];
		}
	}
	else{
		$data["success"] = false;
		$data["error"] = "Wrong pincode passed";
	}
	return $data;
}

function checkCODServiceable($cod)
{
    if (!$cod) {
        abort(403, "COD not serviceable!!");
    }
}
