<?php 

include 'config.php';



//echo "<pre>";print_r($_FILES);exit;

if ($_SERVER["REQUEST_METHOD"] == "POST") {



  $name     = htmlspecialchars(trim($_POST['name']));

  $email    = htmlspecialchars(trim($_POST['email']));

  $mobile    = htmlspecialchars(trim($_POST['mobile']));

  //$code   = htmlspecialchars(trim($_POST['code']));

  $position   = htmlspecialchars(trim($_POST['position']));

  $utm_source   = isset($_POST['utm_source']) ? $_POST['utm_source'] : '';

  $utm_medium   = isset($_POST['utm_medium']) ? $_POST['utm_medium'] : '';

  $utm_campaign   = isset($_POST['utm_campaign']) ? $_POST['utm_campaign'] : '';

  $token = $_POST['g-recaptcha-response'];



  $created_at   = date("Y-m-d H:i:s");



  //START validation

  $required_fields = [

    'name' => 'Name',

    'email' => 'Email',

    'mobile' => 'Mobile',

    //'code' => 'code',

  ];

    

    foreach ($required_fields as $key => $value) {

      if(isset($_POST[$key]) )

      {

        if( trim($_POST[$key]) == '' ){

          sendResponse(0,$value.' is required');

        }

      }else{

        sendResponse(0,$value.' is missing');

      }

    }



  if($mobile != '' && !preg_match('/^\d{10}$/',$mobile))

  {

      sendResponse(0,'Invalid mobile number');

  }

  

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

      sendResponse(0,'Invalid email');

  }



  if ($_FILES['file']['name'] != '') {

    // Get Image Dimension

    $fileinfo = @getimagesize($_FILES["file"]["tmp_name"]);

    

    $allowed_image_extension = array(

        "jpeg",

        "jpg",

        "png",

        "pdf",

        "docx",

    );

    

    // Get file extension

    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    

    // Validate file input to check if is not empty

    if (! file_exists($_FILES["file"]["tmp_name"])) {

        $response = array(

            "type" => "error",

            "message" => "Choose file to upload."

        );

    }    // Validate file input to check if is with valid extension

    else if (! in_array($file_extension, $allowed_image_extension)) {

        $response = array(

            "type" => "error",

            "message" => "Upload valid Files. Only PNG, JPEG, JPG, PDF AND DOCX are allowed."

        );

        sendResponse(0, 'Upload valid Files. Only PNG, JPEG, JPG, PDF AND DOCX are allowed.');

    }    // Validate file size

    else if (($_FILES["file"]["size"] > 2097152)) {

        $response = array(

            "type" => "error",

            "message" => "File size exceeds 2MB"

        );

        sendResponse(0, 'File size exceeds 2MB.');

    }    // Validate file dimension

    else {

        $temp = explode(".", $_FILES["file"]["name"]);

        $newfilename = round(microtime(true)) . '.' . end($temp);

        $target = "/website/ensoweb/assets/images/resume/" . basename($newfilename);

        $target1 = "assets/images/resume/" . basename($newfilename);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
          //echo $target;exit;

            $response = array(

                "type" => "success",

                "message" => "File uploaded successfully."

            );

        } else {
          //echo "else";exit;
            $response = array(

                "type" => "error",

                "message" => "Problem in uploading files."

            );

            sendResponse(0, 'Problem in uploading files.');

        }

    }

  }


  if ($token) {
      //validate google recaptcha
      $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
      $recaptcha_secret = '6LdKt3opAAAAAKuwrFa2-nCJfjlMmZTbLPBt6mo7';
      $recaptcha_response = $token;

      // Make and decode POST request:
      $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
      $recaptcha = json_decode($recaptcha);

      // Take action based on the score returned:
      if ($recaptcha->success != true || $recaptcha->success != 1) {
          sendResponse(0, "Invalid captcha.");
      }

  }
  else {
      sendResponse(0, 'Captcha is missing.');
  }



  // save entries

  $stmt = $conn->prepare("INSERT INTO `career` ( `name`, `email`, `mobile`, `resume`, `position`, `utm_source` ,`utm_medium` , `utm_campaign`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?)");

  $stmt->bind_param("sssssssss", $name, $email, $mobile, $target1, $position, $utm_source, $utm_medium, $utm_campaign, $created_at);





 if ($stmt->execute()) {
    //Admin email
    $admin_subject = "You have a new registration!";
    $admin_message = "Hello Team, <br><br>

    You have received a new registration via the website. Below are the details recorded of the user.<br><br>

    Name : ".ucwords($name)."<br>
    Email :".$email." <br>
    Mobile :".$mobile." <br>

    Thank you,<br>
    ENSO team";

    sendMail($admin_email, $admin_subject, $admin_message);

    //User email
    $subject = "Thank you for Enquiry";
    $message = "Dear ".ucwords($name).",<br><br>

    Thank you for contacting ENSO. Your enquiry has been successfully registered. Our team will be in touch with you soon.<br><br>

    Thank you,<br>
    ENSO Team.";

    sendMail($email, $subject, $message);

    sendResponse(1, 'Thank you for enquiry.');
  } 
  else {

    sendResponse(0,'Failed to save data');

  }

    

}else{

  header("Location: ".$base_url);

  die;

}   

?>