<include 'header/header.php';>

<?php  
	$users = mysql_fetch_array(mysql_query("select user_id from users"));
	foreach ($users as $user) {

	}
?>

<include 'footer/footer.php';>