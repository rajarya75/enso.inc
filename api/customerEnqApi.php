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

    $last_name = inputClean($_POST['last_name']);
    $email = inputClean($_POST['email']);
    $mobile = inputClean($_POST['mobile']);
    $city = inputClean($_POST['city']);
    $state = inputClean($_POST['state']);
    $zip_code = inputClean($_POST['zip_code']);
    $customer_type = $_POST['customer_type'] ? inputClean($_POST['customer_type']) : "";
    $size = $_POST['size'] ? inputClean($_POST['size']) : "";
    $area_in_sq_ft = $_POST['area_in_sq_ft'] ? inputClean($_POST['area_in_sq_ft']) : "";
    $lead_source = $_POST['lead_source'] ? inputClean($_POST['lead_source']) : "";
    $avg_monthly_bill = inputClean($_POST['avg_monthly_bill']);
    $description = $_POST['description'] ? inputClean($_POST['description']) : "";

    $uc_comment = isset($_POST['uc_comment']) ? $_POST['uc_comment'] : '';
    
    if (empty($last_name)) {
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
    }
    elseif (!preg_match('/^\d{10}$/', $mobile)) // phone number is valid
    {
        sendResponse(0, 'Mobile number is invalid.');
    }

    if (empty($city)) {
        sendResponse(0, 'City field is required.');
    }

    if (empty($state)) {
        sendResponse(0, 'State field is required.');
    }

    if (empty($zip_code)) {
        sendResponse(0, 'Zip Code field is required.');
    }

    if (empty($customer_type)) {
        sendResponse(0, 'Customer type field is required.');
    }

    if (empty($size)) {
        sendResponse(0, 'Size field is required.');
    }

    if (empty($area_in_sq_ft)) {
        sendResponse(0, 'Area size field is required.');
    }

    if (empty($lead_source)) {
        sendResponse(0, 'Lead source field is required.');
    }

    if (empty($avg_monthly_bill)) {
        sendResponse(0, 'Average monthly bill field is required.');
    }

    if (empty($description)) {
        sendResponse(0, 'Description field is required.');
    }

    
    // sendResponse(1, $_POST);

    try {
        // 12 fields except created_at
        if (!$stmt = $conn->prepare("INSERT INTO customer_enquiry (name,email,mobile,city,state,zip_code,customer_type,size,area_in_sq_ft,lead_source,avg_monthly_bill,description,created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)") ) {

            sendResponse(0, "Some error occured. code : 10");
        }

        if (!$stmt->bind_param("sssssssssssss", $last_name, $email, $mobile, $city, $state, $zip_code, $customer_type, $size, $area_in_sq_ft, $lead_source, $avg_monthly_bill, $description, $created_at)) {

            sendResponse(0, "Some error occured. code : 20");
        }

        if ($stmt->execute()) {
            $insert_id = $stmt->insert_id;
            // sendResponse(1, 'success store data'.$insert_id);

            if( $customer_type == '-None-' ){
                $customer_type = "<option selected value='-None-'>-None-</option>";
            } elseif( $customer_type == 'Commercial' ){
                $customer_type = "<option selected value='Commercial'>Commercial</option>";
            } elseif( $customer_type == 'Residential' ){
                $customer_type = "<option selected value='Residential'>Residential</option>";
            } elseif( $customer_type == 'Industrial' ){
                $customer_type = "<option selected value='Industrial'>Industrial</option>";
            }
        
            if( $lead_source == '-None-' ){
                $lead_source = "<option selected value='-None-'>-None-</option>";
            } elseif( $lead_source == 'BDA' ){
                $lead_source = "<option selected value='BDA'>BDA</option>";
            } elseif( $lead_source == 'Reference/Repeat' ){
                $lead_source = "<option selected value='Reference/Repeat'>Reference/Repeat</option>";
            } elseif( $lead_source == 'Website' ){
                $lead_source = "<option selected value='Website'>Website</option>";
            } elseif( $lead_source == 'Channel Partner' ){
                $lead_source = "<option selected value='Channel Partner'>Channel Partner</option>";
            } elseif( $lead_source == 'Master Distributor' ){
                $lead_source = "<option selected value='Master Distributor'>Master Distributor</option>";
            }

            $form_data = "<div id='crmWebToEntityForm' class='zcwf_lblLeft crmWebToEntityForm'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <META HTTP-EQUIV='content-type' CONTENT='text/html;charset=UTF-8'>
            
                <form action='https://asia-south1-solarladder-3e352.cloudfunctions.net/webToLeadForm' name=WebToLeads198780000000268016 method='POST' id='crm_form' accept-charset='UTF-8'>
                    <input type='text' style='display:none;' name='xnQsjsdp' value='8c5a44735491abde9b3fadbeb4516583e8309c56bc636965e36601c76f328ea2'></input>
                    <input type='hidden' name='zc_gad' id='zc_gad' value=''></input>
                    <input type='text' style='display:none;' name='xmIwtLD' value='1696f0ce59c969734fa945feab49d9ef19949aac55c214db971589c5217e9b6f'></input>
                    <input type='text' style='display:none;' name='actionType' value='TGVhZHM='></input>
                    <input type='text' style='display:none;' name='returnURL' value='https&#x3a;&#x2f;&#x2f;www.mahindrasolarize.com&#x2f;thank-you.php'> </input>

                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Last_Name'>Name<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' id='Last_Name' name='Last Name' maxlength='80' class='fieldStyle' value='".$last_name."' ></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Email'>Email<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' ftype='email' id='Email' name='Email' maxlength='100' class='fieldStyle' value='".$email."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Mobile'>Mobile<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' id='Mobile' name='Mobile' maxlength='10' class='fieldStyle customer_mobile' value='".$mobile."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>

                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='City'>City<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' id='City' name='City' maxlength='100' class='fieldStyle' value='".$city."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>

                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='State'>State<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' id='State' name='State' maxlength='100' class='fieldStyle' value='".$state."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>


                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Zip_Code'>Pin Code<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' id='Zip_Code' name='Zip Code' maxlength='6' class='fieldStyle customer_pincode' value='".$zip_code."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='CustomerType'>Type of Installation</label></div>
                    <div class='zcwf_col_fld'><select class='zcwf_col_fld_slt fieldStyle' id='CustomerType' name='CustomerType'>
                        '".$customer_type."'
                        </select>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Size'>Capacity&#x28;KWp&#x29;</label></div>
                    <div class='zcwf_col_fld'><input type='text' id='Size' name='Size' maxlength='255' class='fieldStyle' value='".$size."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Area_in_Sq_Ft'>Area in Sq.Ft</label></div>
                    <div class='zcwf_col_fld'><input type='text' id='Area_in_Sq_Ft' name='Area_in_Sq_Ft' maxlength='255' class='fieldStyle' value='".$area_in_sq_ft."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row wfrm_fld_dpNn'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Lead_Source'>Lead Source</label></div>
                    <div class='zcwf_col_fld'><select class='zcwf_col_fld_slt fieldStyle' id='Lead_Source' name='Lead Source'>
                            '".$lead_source."'
                        </select>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Avg_Monthly_Bill'>Avg Monthly Bill* (INR)<span style='color:red;'>*</span></label></div>
                    <div class='zcwf_col_fld'><input type='text' id='Avg_Monthly_Bill' name='Avg_Monthly_Bill' maxlength='255' class='fieldStyle' value='".$avg_monthly_bill."'></input>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>
                <div class='zcwf_row'>
                    <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Description'>Description</label></div>
                    <div class='zcwf_col_fld'><textarea id='Description' name='Description' class='fieldStyle'> value='".$description."'</textarea>
                        <div class='zcwf_col_help'></div>
                    </div>
                </div>


                <div class='zcwf_row zcwf_row_full zcwf_row_btn'>
                    <div class='zcwf_col_lab'></div>
                    <div class='zcwf_col_fld'>
                        <div class='g-recaptcha g-recaptcha-nj' id='customer_captcha' data-sitekey='6LcCTxAeAAAAAP3Phynmzkl5KrF-WcNYeZH4jqsq' data-widget-id='0'></div>
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
                    <div class='zcwf_col_fld'>
                        <input type='submit' id='formsubmit' class='formsubmit zcwf_button' value='Submit' title='Submit'><input type='reset' class='zcwf_button' name='reset' value='Reset' title='Reset'>
                    </div>
                </div>
                
                <script id='wf_anal' src='https://crm.zohopublic.in/crm/WebFormAnalyticsServeServlet?rid=1696f0ce59c969734fa945feab49d9ef19949aac55c214db971589c5217e9b6fgid8c5a44735491abde9b3fadbeb4516583e8309c56bc636965e36601c76f328ea2gid534cb20477b1d28b5f45f7cc241888c5gid4ee3a7e9ace6ab1be7c541b329164307'></script>
                
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
