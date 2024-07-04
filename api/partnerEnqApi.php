<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $token = $_POST['token'];
    
    if ($token) {
        //validate google recaptcha
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LcCTxAeAAAAANrIvIsSfe9EWNlsz65coGQrnSHU';
        $recaptcha_response = $token;

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // $postdata = http_build_query(["secret"=>$recaptcha_secret,"response"=>$recaptcha_response]);
        // $opts = ['http' =>
        //     [
        //         'method'  => 'POST',
        //         'header'  => 'Content-type: application/x-www-form-urlencoded',
        //         'content' => $postdata
        //     ]
        // ];
        // $context  = stream_context_create($opts);
        // $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        // $recaptcha = json_decode($recaptcha);

        // print_r($recaptcha);
        // die();
        
        // Take action based on the score returned:
        if ($recaptcha->success != true || $recaptcha->success != 1) {
            sendResponse(0, "Invalid captcha.");
        }

    } else {

        sendResponse(0, 'Captcha is missing.');

    }
    // sendResponse(0, "done captcha.");

    // Sanitize POST array
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $created_at = date("Y-m-d H:i:s"); //time in 24 hour format
    $date_time_12 = date('Y-m-d h:i:s', strtotime($created_at)); // time in 12 hour format

    $name = inputClean($_POST['name']);
    $company = inputClean($_POST['company']);
    $email = inputClean($_POST['email']);
    $mobile = inputClean($_POST['mobile']);
    $city = inputClean($_POST['city']);
    $segment_preference = $_POST['segment_preference'];
    $area_of_interest = $_POST['area_of_interest'];
    $solar_experience = inputClean($_POST['solar_experience']);


    $uc_comment = isset($_POST['uc_comment']) ? $_POST['uc_comment'] : '';

    // sendResponse(0, $area_of_interest);
    if (empty($name)) {
        sendResponse(0, 'Partner name field is required.');
    }

    if (empty($company)) {
        sendResponse(0, 'Company field is required.');
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
    }
    elseif (!preg_match('/^\d{10}$/', $mobile)) // phone number is valid
    {
        sendResponse(0, 'Mobile number is invalid.');
    }

    if (empty($city)) {
        sendResponse(0, 'City field is required.');
    }

    if (empty($segment_preference)) {
        sendResponse(0, 'Segment preference field is required.');
    }

    if (empty($area_of_interest)) {
        sendResponse(0, 'Area of interest type field is required.');
    }

    if (empty($solar_experience)) {
        sendResponse(0, 'Overall solar experience field is required.');
    }
    // sendResponse(1, 'success');

    try {
        // 8 fields except created_at
        if (!$stmt = $conn->prepare("INSERT INTO partner_with_us (name,company,email,mobile,city,segment_preference,area_of_interest,solar_experience,created_at) VALUES (?,?,?,?,?,?,?,?,?)") ) {

            sendResponse(0, "Some error occured. code : 10");
        }

        if (!$stmt->bind_param("sssssssss", $name, $company, $email, $mobile, $city, $segment_preference, $area_of_interest, $solar_experience, $created_at)) {

            sendResponse(0, "Some error occured. code : 20");
        }

        if ($stmt->execute()) {
            $insert_id = $stmt->insert_id;
            // sendResponse(1, 'success store data'.$insert_id);

            $form_data = "<div id='crmWebToEntityForm' class='zcwf_lblLeft crmWebToEntityForm'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <META HTTP-EQUIV='content-type' CONTENT='text/html;charset=UTF-8'>
                <form action='https://crm.zoho.in/crm/WebForm' name=WebForm198780000001517221 method='POST' id='partners_form' accept-charset='UTF-8'>
                    <input type='text' style='display:none;' name='xnQsjsdp' value='8c5a44735491abde9b3fadbeb4516583e8309c56bc636965e36601c76f328ea2'></input>
                    <input type='hidden' name='zc_gad' id='zc_gad' value=''></input>
                    <input type='text' style='display:none;' name='xmIwtLD' value='1696f0ce59c969734fa945feab49d9efb5d894648fa63a24a51651d8ff763977'></input>
                    <input type='text' style='display:none;' name='actionType' value='Q3VzdG9tTW9kdWxlMQ=='></input>
                    <input type='text' style='display:none;' name='returnURL' value='https&#x3a;&#x2f;&#x2f;www.mahindrasolarize.com&#x2f;thank-you.php'> </input>
                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='NAME'>Partner Name<span style='color:red;'>*</span></label></div>
                        <div class='zcwf_col_fld'><input type='text' id='NAME' name='NAME' class='fieldStyle' value='".$name."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>
                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='COBJ1CF15'>Company</label></div>
                        <div class='zcwf_col_fld'><input type='text' id='COBJ1CF15' name='COBJ1CF15' class='fieldStyle' value='".$company."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>
                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Email'>Email</label></div>
                        <div class='zcwf_col_fld'><input type='text' ftype='email' id='Email' name='Email' class='fieldStyle' value='".$email."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>

                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='COBJ1CF12'>Mobile<span style='color:red;'>*</span></label></div>
                        <div class='zcwf_col_fld'><input type='text' id='COBJ1CF12' name='COBJ1CF12' class='fieldStyle partner_mobile' maxlength='10' value='".$mobile."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>

                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='COBJ1CF8'>City</label></div>
                        <div class='zcwf_col_fld'><input type='text' id='COBJ1CF8' name='COBJ1CF8' class='fieldStyle' value='".$city."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>
                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='COBJ1CF16'>Segment preference</label></div>
                        <div class='zcwf_col_fld'>
                            <input type='text' id='COBJ1CF16' name='COBJ1CF16' class='fieldStyle' value='".$segment_preference."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>
                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='COBJ1CF18'>Area of interest</label></div>
                        <div class='zcwf_col_fld'>
                            <input type='text' id='COBJ1CF18' name='COBJ1CF18' class='fieldStyle' value='".$area_of_interest."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>
                    <div class='zcwf_row'>
                        <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='COBJ1CF17'>Overall solar experience &#x28;KWp&#x29;</label></div>
                        <div class='zcwf_col_fld'><input type='text' id='COBJ1CF17' name='COBJ1CF17' class='fieldStyle' value='".$solar_experience."'></input>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>


                    <div class='zcwf_row zcwf_row_full zcwf_row_btn'>
                        <div class='zcwf_col_lab'></div>
                        <div class='zcwf_col_fld'>
                            <div class='g-recaptcha g-recaptcha-nj' id='partner_captcha' data-sitekey='6LcCTxAeAAAAAP3Phynmzkl5KrF-WcNYeZH4jqsq' data-widget-id='1'></div>
                        </div>
                    </div>

                     <div class='zcwf_row mnop_field'>
                        <div class='zcwf_col_lab' >
                        <label for='COB1CF8'>User Comment<span style='color:red;'>*</span></label></div>
                        <div class='zcwf_col_fld inp_group'>
                            <input type='text' name='uc_comment' class='fieldStyle' value='".$uc_comment."'>
                            <div class='zcwf_col_help'></div>
                        </div>
                    </div>


                    <div class='zcwf_row zcwf_row_full zcwf_row_btn'>
                        <div class='zcwf_col_lab'></div>
                        <div class='zcwf_col_fld'><input type='submit' id='formsubmit' class='formsubmit zcwf_button' value='Submit' title='Submit'><input type='reset' class='zcwf_button' name='reset' value='Reset' title='Reset'></div>
                    </div>
                    
                    <script id='wf_anal' src='https://crm.zohopublic.in/crm/WebFormAnalyticsServeServlet?rid=1696f0ce59c969734fa945feab49d9efb5d894648fa63a24a51651d8ff763977gid8c5a44735491abde9b3fadbeb4516583e8309c56bc636965e36601c76f328ea2gidb1956a2d91447e247afd6fcb2373c0815fb1fe4ba513801c7618ed2ca56ef1efgid4ee3a7e9ace6ab1be7c541b329164307'></script>
                    </form>
                </div>";

            sendResponse(1, 'Thank you for enquiry', $form_data);
        } else {
            sendResponse(0, 'Failed to store data..');
        }
    } catch (PDOException $er) {
        $error = $er->getMessage();
        sendResponse(0, $error);
    }

} else {
    sendResponse(0, "Access Denied");
}
