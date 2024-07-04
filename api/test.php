<?php

	$base_url = 'https://www.mahindrasolarize.com';
	$servername = "solarize.mysql.database.azure.com";
	$username = "dbadmin@solarize";
	$password = 'L1NuX@Un!X123';
	$dbname = "solarize_website";

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		// sendResponse(0,'Connection failed');
		die("Connection failed: " . $conn->connect_error);
	}

echo 'connected';

?>