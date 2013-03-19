<?php 
	session_start();	
	
	$page_valid = true;
	require 'PHPMailer/class.phpmailer.php';
	require 'PHPMailer/class.pop3.php';
	require 'PHPMailer/class.smtp.php';
	require 'mail/config.php';
	require 'header/functions.php';
    require 'db/connections.php'; 

		if (logged_in ())
		$user_data = get_user_data($_SESSION['user_id'],'user_id','username','email','last_name','first_name','usertype');
	
?>