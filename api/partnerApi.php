<?php	
include 'config.php';

// echo "<pre>";
// print_r($_POST);
// die;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$name 			= htmlspecialchars(trim($_POST['Last_Name']));
	$mobile 		= htmlspecialchars(trim($_POST['Mobile']));
	$email 			= htmlspecialchars(trim($_POST['Email']));
	$city 			= htmlspecialchars(trim($_POST['LEADCF11']));
	$company 		= htmlspecialchars(trim($_POST['Company']));
	$segment 		= htmlspecialchars(trim($_POST['LEADCF14']));
	$interest 		= htmlspecialchars(trim($_POST['LEADCF16']));
	$solar_exp 		= htmlspecialchars(trim($_POST['LEADCF15']));
	$lead_source 	= htmlspecialchars(trim($_POST['Lead_Source']));

	$created_at		= date("Y-m-d H:i:s");

    //START validation
	if($name == '' ){
		sendResponse(0,'Name is required');
	}
	else if($city == '' ){
		sendResponse(0,'City is required');
	}
	else if($mobile != '' && !preg_match('/^\d{10}$/',$mobile))
	{
	    sendResponse(0,'Invalid mobile number');
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  	sendResponse(0,'Invalid email');
	}
    //END validation

    
    // save entries
    $stmt = $conn->prepare("INSERT INTO partner ( name, email, mobile, city, company, segment, interest, solar_exp, lead_source, created_at) VALUES (?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssssss", $name, $email, $mobile, $city,  $company, $segment, $interest, $solar_exp, $lead_source, $created_at);


	if ($stmt->execute()) { 
		
		sendResponse(1,'Success');
	} 
	else {
		sendResponse(0,'Failed to save data');
	}
		
}else{
	header("Location: ".$base_url);
	die;
}		
?>
