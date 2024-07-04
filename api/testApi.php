<?php
require_once "config.php";


// start Admin email
$subject2 = "Enquiry - Exports test";
$message2 = "Hello Team ,<br ><br>

            ";


$admin_email = "utkarsh.agency09@gmail.com";

if ($current_enviromment == 'server') {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . $sender_name . ' <' . $sender_email . '>' . "\r\n";
    $mail_resp_2 = mail($to, $subject, $message, $headers);

    echo "<pre>";
    var_dump($mail_resp_2);
    echo "</pre>";
    echo "<pre>";
    print_r(error_get_last());
    echo "</pre>";
}else{
    echo "here";
}
?>