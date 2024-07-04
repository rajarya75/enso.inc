<?php	


include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$name 			= htmlspecialchars($_POST['name']);
	$email 			= htmlspecialchars($_POST['email']);
	$mobile 		= htmlspecialchars($_POST['mobile']);

	$utm_source 	= $_POST['utm_source'];
	$utm_medium 	= $_POST['utm_medium'];
	$utm_campaign	= $_POST['utm_campaign'];

	$created_at		= date("Y-m-d H:i:s");

	if(strlen($name) < 1 || strlen($email) < 1 || strlen($mobile) < 9){
		die(" failed : validation failed");
	}


	$stmt = $conn->prepare("INSERT IGNORE INTO solar_users ( name, mobile, email, utm_source, utm_medium, utm_campaign, created_at) VALUES (?, ?, ?, ?,?, ?, ?)");
	$stmt->bind_param("sssssss", $name, $mobile, $email, $utm_source,$utm_medium,$utm_campaign, $created_at);

	if ($stmt->execute()) { 
	  	
	  	echo "success";
	  	die();

	} else {
		die("failed : success");
	}

		
}else{
	die("Access Denied");
}		
?>
