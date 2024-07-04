<?php


include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$pincode = htmlspecialchars($_POST['pincode']);

	$get_state = $conn->prepare("SELECT * FROM solar_pincode WHERE pincode = ?");
	$get_state->bind_param('s', $pincode);
	$get_state->execute();
	$state_result = $get_state->get_result();

	//print_r($state_result);
	if($state_result->num_rows > 0) {
		echo ' success ';
	}else{
		echo ' failed ';
	}

	die();
}



?>