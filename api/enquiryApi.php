<?php	
$arr = array('status' => 1, 'message' =>'Success');
	echo json_encode($arr);
	die;

include 'config.php';

// echo "<pre>";
// print_r($_POST);
// die;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	

	$name 			= htmlspecialchars(trim($_POST['Last_Name']));
	$mobile 		= htmlspecialchars(trim($_POST['Mobile']));
	$email 			= htmlspecialchars(trim($_POST['Email']));
	$city 			= htmlspecialchars(trim($_POST['City']));
	$pincode 		= htmlspecialchars(trim($_POST['Zip_Code']));
	$rooftop 		= htmlspecialchars(trim($_POST['LEADCF19']));
	$capacity 		= htmlspecialchars(trim($_POST['LEADCF2']));
	$area 			= htmlspecialchars(trim($_POST['LEADCF17']));
	$month_bill 	= htmlspecialchars(trim($_POST['LEADCF18']));
	$lead_source 	= htmlspecialchars(trim($_POST['Lead_Source']));
	$description 	= htmlspecialchars(trim($_POST['Description']));

	$created_at		= date("Y-m-d H:i:s");

    //START validation
	if($name == '' ){
		sendResponse(0,'Name is required');
	}
	// else if(strlen($pincode) != 6 ){
	// 	sendResponse(0,'Enter 6 digit pincode');
	// }
	else if($mobile != '' && !preg_match('/^\d{10}$/',$mobile))
	{
	    sendResponse(0,'Invalid mobile number');
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  	sendResponse(0,'Invalid email');
	}
    //END validation

    
    // save entries
    $stmt = $conn->prepare("INSERT INTO enquiry ( name, email, mobile, city, pincode, rooftop, capacity, area, month_bill, lead_source, description, created_at) VALUES (?, ?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssssssss", $name, $email, $mobile, $city,  $pincode, $rooftop, $capacity, $area,  $month_bill, $lead_source, $description, $created_at);


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
