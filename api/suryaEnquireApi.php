<?php	

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// $arr = array('status' => 1, 'message' =>'Success');
// 	echo json_encode($arr);
// 	die;

include_once 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$full_name 			= htmlspecialchars(trim($_POST['full_name']));
	$mobile 		= htmlspecialchars(trim($_POST['mobile']));
	$email 			= htmlspecialchars(trim($_POST['email']));
	$city_id 			= htmlspecialchars(trim($_POST['city']));
	$pin_code 			= htmlspecialchars(trim($_POST['pin_code']));
	$description 			= htmlspecialchars(trim($_POST['description']));
  $kilowatts      = htmlspecialchars(trim($_POST['kilowatts']));
	
    $utm_source 			= htmlspecialchars(trim($_POST['utm_source']));
    $utm_medium 			= htmlspecialchars(trim($_POST['utm_medium']));
    $utm_campaign 			= htmlspecialchars(trim($_POST['utm_campaign']));

    $token = $_POST['token'];
    
   /* if ($token) {
        //validate google recaptcha
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LcCTxAeAAAAANrIvIsSfe9EWNlsz65coGQrnSHU';
        $recaptcha_response = $token;

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // Take action based on the score returned:
        if ($recaptcha->success != 1) {            
            sendResponse(0,'Invalid captcha '.$recaptcha);
        }
    } else {
        sendResponse(0,'Captcha is missing');
    }*/

	$created_at		= date("Y-m-d H:i:s");

    //START validation
    if($city_id == '' ){
        sendResponse(0,'City is required');
    }

    //validate city id
    $stmt_2 = $conn->prepare("SELECT * FROM state_city where id = ?");
    $stmt_2->bind_param('i', $city_id);
    $stmt_2->execute();
    $result_2 = $stmt_2->get_result();

    $result_2 = $result_2->fetch_assoc();

    if( empty($result_2) ) {
        $stmt_2->close();
        sendResponse(0,'Invalid City');
    }

    $city = $result_2['city'];

	if($full_name == '' ){
		sendResponse(0,'Name is required');
	} else if($mobile == '')
	{
	    sendResponse(0,'Mobile is required');
	} else if (!preg_match('/^\d{10}$/',$mobile))
    {
        sendResponse(0,'Invalid mobile number');
    }
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  	sendResponse(0,'Invalid email');
	}  else if(strlen($pin_code) != 6 ){
		sendResponse(0,'Pin code must be 6 digit required');
	} else if (!preg_match('/^\d{6}$/',$pin_code))
    {
        sendResponse(0,'Invalid pincode');
    }
    //END validation

    
    // save entries
    $new_stmt = $conn->prepare("INSERT INTO surya_enquiry ( full_name, mobile, email, city, pincode, description, kilowatts, utm_source, utm_medium, utm_campaign, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

	$new_stmt->bind_param("sssssssssss", $full_name, $mobile, $email, $city,  $pin_code, $description, $kilowatts, $utm_source, $utm_medium, $utm_campaign, $created_at);

	if ($new_stmt->execute()) { 
		$new_stmt->close();
        // start client email
        $subject = "Thank You for enquiry.";
        $message = " Dear " . ucfirst($full_name) . ",
                    <br><br>
                    We have received your enquiry. <br><br>

                    Our representative will get in touch with you shortly for further assistance. <br><br><br>

                    Thank you,<br>
                    Mahindra Solarize Team<br>";
        if($current_enviromment == 'server'){
            $mail_1 = sendmail($email, $subject, $message); //email doesnt work on this sv
        }

        // start admin email
        $subject2 = "New Enquiry";
        $message2 = "
                    Dear Team ,<br ><br>

                    Congratulations, you have a new lead <br />

                    Below are the details.
                    <br ><br >
                    Name : ".$full_name." <br />
                    Email : ".$email." <br>
                    Mobile No. : ".$mobile."<br>";

        $admin_email = "nilesh@agency09.in";
        if($current_enviromment == 'server'){
            $mail_2 = sendmail($admin_email, $subject2, $message2); //email doesnt work on this sv
        }

		sendResponse(1,'Thank you for the enquiry. Our representative will get in touch with you soon.');
	} 
	else {
		sendResponse(0,'Failed to save data');
	}
		
}else{
	header("Location: ".$base_url);
	die;
}		
?>
