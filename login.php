<?php
	//Actiunea efectiva de login 
	include 'db/connections.php';
	include 'header/init.php';

	if (isset($_POST) && !empty($_POST))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$login = log_in($username,$password);

		if ($login == false)
			header ('Location: index.php?failure=1');
			//put_error('Username and password do not match');
		else
		{
			echo $login;
			$_SESSION['user_id'] = $login;
			header('Location: index.php');
			exit();
		}
	}
?>