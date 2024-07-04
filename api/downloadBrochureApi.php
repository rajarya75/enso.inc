<?php
require_once "config.php";
ini_set('display_errors',1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // sendResponse(0, $_POST);

    // Sanitize POST array
    $_POST = preg_replace('/\x00|<[^>]*>?/', '', $_POST);
    $_POST = str_replace(["'", '"'], ['&#39;', '&#34;'], $_POST);

    $created_at = date("Y-m-d H:i:s"); //time in 24 hour format

    $full_name = inputClean(ucwords($_POST['full_name']));
    $contact_no = inputClean($_POST['contact_no']);
    $email = inputClean($_POST['email']);

    $token = $_POST['token'];

    if (empty($full_name)) {
        sendResponse(0, 'Full Name field is required.');
    }
    if (empty($email)) {
        sendResponse(0, 'Email field is required.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // email is valid
    {
        sendResponse(0, 'Email is invalid.');
    }
    if (empty($contact_no)) {
        sendResponse(0, 'Mobile Number field is required.');
    } elseif (!preg_match('/^\d{10}$/', $contact_no)) // phone number is valid
    {
        sendResponse(0, 'Mobile number is invalid.');
    }

    if ($token) {
        //validate google recaptcha
        $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
        $recaptcha_secret = '6LcCTxAeAAAAANrIvIsSfe9EWNlsz65coGQrnSHU';
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
        if (!$stmt = $conn->prepare("INSERT INTO `download_brochure`(`name`, `mobile`, `email`,`created_at`) VALUES (?,?,?,?)")) {

            sendResponse(0, "Some error occured. code : 10");
        }

        if (!$stmt->bind_param("ssss", $full_name, $contact_no,  $email, $created_at)) {

            sendResponse(0, "Some error occured. code : 20");
        }

        if ($stmt->execute()) {
            // start Admin email
            $subject = "Download Brochure";
            $message = "Hello Team ,<br ><br>

                        Download Brochure form has been filled by below user. <br />

                        <br ><br >
                        Full Name : " . $full_name . " <br>
                        Mobile. : " . $contact_no . " <br>
                        Email : " . $email . " <br>
                        <br><br><br>

                        Thank you, <br>
                        Team Mahindra Solarize";

            $admin_email = "rooftopsales@mahindra.com";

            if ($current_enviromment == 'server') {
                $mail_resp_2 = sendmail($admin_email, $subject, $message);
            }

            sendResponse(1, "Thank you for downloading brochure!");
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
