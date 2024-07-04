<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

date_default_timezone_set('Asia/Calcutta');

// site key = 6LcCTxAeAAAAAP3Phynmzkl5KrF-WcNYeZH4jqsq
// secret key = 6LcCTxAeAAAAANrIvIsSfe9EWNlsz65coGQrnSHU

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $base_url = 'http://localhost/mahindrasolarize/wwwroot/';
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "mahindra_solarize";
    $current_enviromment = 'local';

    //email settings
    $from = 'utkarsh.agency09@gmail.com';
    $from_name =  'Utkarsh';
    $email_user = 'utkarsh.agency09@gmail.com';
    $email_password = 'xoabrexhwlqysoqz';
} else {
    $base_url = 'https://www.mahindrasolarize.com/';
    $servername = "solarize.mysql.database.azure.com";
    $username = "dbadmin@solarize";
    $password = 'L1NuX@Un!X123';
    $dbname = "solarize_website";
    $current_enviromment = 'server';

    //email settings
    $from = '23220997@MAHINDRA.COM';
    $from_name =  'Mahindra Solarize';
    $email_user = 'mahindrasolarize@gmail.com';
    $email_password = 'wrmhlcbpoqyzbzkg';
}

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    sendResponse(0, 'Connection failed');
    // die("Connection failed: " . $conn->connect_error);
}


function d($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function dd($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

function sendResponse($status, $message, $data = '')
{
    $arr = array('status' => $status, 'message' => $message, 'data' => $data);
    echo json_encode($arr);
    die;
}

function fetchAssocStatement($stmt)
{
    if ($stmt->num_rows > 0) {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while ($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if ($stmt->fetch())
            return $result;
    }

    return null;
}

function sendmail($to, $subject, $message, $attachment=NULL,$size=NULL,$type=NULL)
{
    $sender_email = "rooftopsales@mahindra.com";
    $sender_name = "Mahindra Solarize";

    // Always set content-type when sending HTML email
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . $sender_name . ' <' . $sender_email . '>' . "\r\n";

    if(!empty($attachment)){
        //read from the uploaded file & base64_encode content
        $handle = fopen($attachment, "r");  // set the file handle only for reading the file
        $content = fread($handle, $size); // reading the file
        fclose($handle);                  // close upon completion

        $encoded_content = chunk_split(base64_encode($content));

        $message .="Content-Type: $type; name=".$attachment."\r\n";
        $message .="Content-Disposition: attachment; filename=".$attachment."\r\n";
        $message .="Content-Transfer-Encoding: base64\r\n";
        $message .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
        $message .= $encoded_content; // Attaching the encoded file with email
    }

    $result = mail($to, $subject, $message, $headers);
    return $result;
}

function inputClean($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}
?>