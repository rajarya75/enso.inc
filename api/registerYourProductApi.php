<?php
require_once "config.php";
require_once "../mail.php";
ini_set('display_errors',1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // sendResponse(0, $_POST);

    // Sanitize POST array
    $_POST = preg_replace('/\x00|<[^>]*>?/', '', $_POST);
    $_POST = str_replace(["'", '"'], ['&#39;', '&#34;'], $_POST);

    $created_at = date("Y-m-d H:i:s"); //time in 24 hour format

    $name = inputClean(ucwords($_POST['name']));
    $email = inputClean($_POST['email']);
    $mobile = inputClean($_POST['mobile']);
    $system_size = inputClean($_POST['system_size']);
    $invoice_no = inputClean($_POST['invoice_no']);
    $date_of_invoice = inputClean($_POST['date_of_invoice']);
    $channel_partner_name = inputClean($_POST['channel_partner_name']);
    $query = inputClean($_POST['query']);
    $invoice_copy_type = $_FILES["invoice_copy"]["type"];
    $invoice_copy_size = $_FILES["invoice_copy"]["size"];
    $invoice_copy_extension = strtolower(pathinfo($_FILES["invoice_copy"]['name'],PATHINFO_EXTENSION));

    $token = $_POST['token'];

    if (empty($name)) {
        sendResponse(0, 'Name field is required.');
    }
    if (empty($email)) {
        sendResponse(0, 'Email field is required.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // email is valid
    {
        sendResponse(0, 'Email is invalid.');
    }
    if (empty($mobile)) {
        sendResponse(0, 'Mobile field is required.');
    } elseif (!preg_match('/^\d{10}$/', $mobile)) // phone number is valid
    {
        sendResponse(0, 'Mobile number is invalid.');
    }
    if (empty($system_size)) {
        sendResponse(0, 'System Size field is required.');
    }
    if (empty($invoice_no)) {
        sendResponse(0, 'Invoice No. is required.');
    }
    if (empty($date_of_invoice)) {
        sendResponse(0, 'Date of Invoice is required.');
    }
    if (empty($channel_partner_name)) {
        sendResponse(0, 'Channel Partner Name is required.');
    }
    /*if (empty($query)) {
        sendResponse(0, 'Query is required.');
    }*/
    if (empty($_FILES['invoice_copy'])) {
        sendResponse(0, 'invoice_copy field is required.');
    }
    if ($invoice_copy_size > 3000000) {
        sendResponse(0, 'invoice_copy must be less than 3 mb.');
    }
    if ( !in_array($invoice_copy_extension, array('pdf','jpg','jpeg')) ) {
        sendResponse(0, 'Invoice copy must be jpg, jpeg or in pdf format.');
    }

    $target_dir = "../register_invoice/";
    $invoice_copy_name = strtotime("now").mt_rand(10,99).'.'.$invoice_copy_extension;
    $target_file = $target_dir . $invoice_copy_name;

    if (!move_uploaded_file($_FILES["invoice_copy"]["tmp_name"], $target_file)) {
        sendResponse(0, 'Invoice Copy upload Error.');
    }else{

    }
    /*if (empty($query)) {
        sendResponse(0, 'Type Your Query Here field is required.');
    }*/

    if ($token) {
        //validate google recaptcha
        $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
        $recaptcha_secret = "6LcCTxAeAAAAANrIvIsSfe9EWNlsz65coGQrnSHU";
        $recaptcha_response = $token;
        
        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        
        
        // print_r($recaptcha);
        // Take action based on the score returned:
        if ($recaptcha->success != true || $recaptcha->success != 1) {
            sendResponse(0, "Invalid captcha.");
        }

    } 
    else {

        sendResponse(0, 'Captcha is missing.');

    }

    // sendResponse(0, "cap done");

    try {
        if (!$stmt = $conn->prepare("INSERT INTO `product_registration`(`name`, `mobile`, `email`, `system_size`, `invoice_no`, `date_of_invoice`, `invoice_copy`, `channel_partner_name`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?)")) {

            sendResponse(0, "Some error occured. code : 10");
        }

        if (!$stmt->bind_param("sssssssss", $name, $mobile,  $email, $system_size, $invoice_no, $date_of_invoice, $invoice_copy_name, $channel_partner_name, $created_at)) {

            sendResponse(0, "Some error occured. code : 20");
        }

        if ($stmt->execute()) {

            //  start client email
            $subject = "Thank you for enquiry";
            $message = " Hi ".$name.", <br><br>

                        Thank you for contacting us.<br>
                        We have recorded your details for further process! <br><br>


                        Thank you! <br>
                        Team Mahindra Solarize";
            
            if ($current_enviromment == 'server') {
                $mail_resp_1 = sendAuthenticMail($from,$from_name,$email,$name,$subject,$message);
            }

            // start Admin email
            $subject2 = "Register Your Product";
            $message2 = "Hello Team ,<br ><br>

                        You have received a new Enquiry via the website. Below are the recorded details. <br />

                        <br ><br >
                        Name : " . $name . " <br>
                        Contact No. : " . $mobile . " <br>
                        Email : " . $email . " <br>
                        System Size : " . $system_size . " <br>
                        Invoice  No. : " . $invoice_no . " <br>
                        Date of Invoice : " . $date_of_invoice . " <br>
                        Channel Partner Name : " . $channel_partner_name . " <br>
                        Query : " . $query . " <br>
                        
                        <br><br>

                        Do get in touch with the enquirer in the next 48 working hours.<br><br><br>
                        
                        Thank you, <br>
                        Team Mahindra Solarize";

            $admin_email = "23220997@MAHINDRA.COM";

            if ($current_enviromment == 'server') {
                $mail_resp_2 = sendAuthenticMail($from,$from_name,$admin_email,$name,$subject2,$message2,$target_file);
            }

            sendResponse(1, "Thank you for enquiry!");
        } else {
            sendResponse(0, 'Failed to insert data');
        }
    } catch (PDOException $er) {
        $error[] = $er->getMessage();
        echo json_encode(["status" => 0, "message" => $error]);
        die();
    }
    exit();
} else {
    die("Access Denied");
}
