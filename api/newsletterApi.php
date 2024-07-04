<?php	
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$email 			= htmlspecialchars(trim($_POST['email']));
	$created_at		= date("Y-m-d H:i:s");

    //START validation
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  	sendResponse(0,'Invalid email');
	}
    //END validation

   
    // save entries
    $stmt = $conn->prepare("INSERT IGNORE INTO newsletter ( email,created_at) VALUES (?,?)");
	$stmt->bind_param("ss", $email, $created_at);

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
