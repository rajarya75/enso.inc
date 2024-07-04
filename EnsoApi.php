<?php

// API endpoint
$endpoint = 'https://api.enso.inc/api/website/enquiry';

// Data to be sent
$data = array(
    "name" => "John Doe",
    "email" => "john@example.com",
    "mobileCode" => "+971",
    "contactNumber" => "9876879687",
    "message" => "This is a dummy message for testing",
    "typeOfEnquiry" => "Sales",
    "from" => "Contact Us"
);

// Encode data as JSON
$data_string = json_encode($data);
// Initialize cURL session
$ch = curl_init($endpoint);

//echo "<pre>";print_r($data_string);exit;
// Set cURL options
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Origin: enso',
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

// Execute cURL session
$result = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Output the result
echo $result;

?>
