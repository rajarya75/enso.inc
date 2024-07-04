<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "ensoweb";
    $base_url = "http://localhost/enso/admin/";
    $admin_url = "http://localhost/enso/admin/";
    $environment = 'localhost';

} else {

    $servername = "localhost";
    $username = "root";
    $password = "D311#2024";
    $dbname = "ensoweb";
    $base_url = "https://www.enso.inc/";
    $admin_url = "https://www.enso.inc/admin/";
    $environment = 'server';
}



// Create connection

date_default_timezone_set('Asia/Calcutta');



$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {

	// die("Connection failed: " . $conn->connect_error);

	die("Connection failed: ");

}


function inputClean($data)

{

    $data = htmlspecialchars($data);

    $data = stripslashes($data);

    $data = trim($data);

    return $data;

}


$admin_list = array(

    'admin' =>['password' => 'ENSO@Admin123',],

);
