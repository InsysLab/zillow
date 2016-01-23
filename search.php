<?php
$result = "";

if( isset($_POST["search_submit"]) ){
	
	require("app/search.php");
	
	$address = $_POST["address"];
	@list($city, $state, $zip) = explode(",", $_POST["city_state_zip"]);
	
	if( ! empty($address) && ! empty($city) && ! empty($state) ){
		$zSearch = new Zillow_API_Search();
		$result = $zSearch->execute_search($address, $city, $state, $zip);
	} 
}
