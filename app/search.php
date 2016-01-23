<?php

class Zillow_API_Search{
	
	private $api_url = "http://www.zillow.com/webservice/GetSearchResults.htm";
	private $api_key = "X1-ZWz1dyb53fdhjf_6jziz";
	
	public function execute_search($address, $city, $state, $zip, $rent_estimate = false){
		if( empty($address) || empty($city) || empty($state) ) return false;
			
		$url = $this->api_url . "?zws-id=" . $this->api_key;
		$url .= "&address=" . urlencode($address);
		$url .= "&citystatezip=" . urlencode($city."+".$state."+".$zip);
		$url .= ($rent_estimate)? "&rentzestimate=true" : "";
		
		$xml = simplexml_load_string(file_get_contents($url));
		
		$result = array( "code"     => $xml->message->code,
						 "message"  => $xml->message->text);
						 
		if( $xml->message->code == 0 ){				 
			$result["address"]  = $this->property_address($xml);
			$result["estimate"] = $xml->response->results->result->zestimate->amount;
			$result["details"]  = $xml->response->results->result->links->homedetails;
			$result["photo"]    = $this->property_photo($xml);
		}
		
		return $result;
	}

	private function property_address($xml){
		$address = array();
		$address[] = $xml->response->results->result->address->street;
		$address[] = $xml->response->results->result->address->city;
		$address[] = $xml->response->results->result->address->state;
		
		$address = implode(",", $address);
		$address .= $xml->response->results->result->address->zip;
		
		return $address;
	}
	
	private function property_photo($xml){
		$url = $xml->response->results->result->links->homedetails;
		if( empty($url) ) return false;
		
		$html = file_get_contents($url);
		
		$dom = new DOMDocument('1.0');
		@$dom->loadHTML($html);

		$domxpath = new DOMXPath($dom);
		$nodes = $domxpath->query("//img [@class=\"hip-photo\"]");
		if( $nodes->length > 0 ){
			return $nodes->item(0)->getAttribute("src");
		} else {
			return false;
		}
	}
}