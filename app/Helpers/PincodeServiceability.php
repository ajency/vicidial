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

function checkPincodeServiceableHelper($pincode)
{
    $default_shipment_service = config('pincode_serviceability.default_shipment_service');
    switch ($default_shipment_service) {
        case 'Delhivery':
            $pincode_data = checkDelhiveryPincodeServiceability($pincode);
            if ($pincode_data["success"]) {
                $postal_code_data = $pincode_data['data']['delivery_codes'][0]['postal_code'];
                $pre_paid         = ($postal_code_data['pre_paid'] == 'Y') ? true : false;
                $cod              = ($postal_code_data['cod'] == 'Y') ? true : false;
                if ($postal_code_data['pre_paid'] == 'N' && $postal_code_data['cod'] == 'N') {
                    abort(403, "Pincode not serviceable!!");
                } else {
                    return ["pre_paid" => $pre_paid, "cod" => $cod];
                }

            } else {
                abort(403, $pincode_data["error"]);
            }
            break;

        default:
            break;
    }
    abort(403, "Delivery service not configured!!");
}
