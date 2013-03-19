<?php
	include "header/header.php";
	if (isset($_GET["product_id"]) && !empty($_GET['product_id']))
	{
		//Un client nu poate achizitiona de doua ori acelasi produs 
		$produs_test = mysql_fetch_assoc(mysql_query("select * from tranzactii where user_id = ".$_SESSION["user_id"]." and product_id = ".$_GET["product_id"]));
		if (!empty($produs_test))
			put_error ("Ati mai achizitionat acest produs !");
		else
		{
			mysql_query("insert into tranzactii (user_id,product_id) values (".$_SESSION["user_id"].",".$_GET["product_id"].")");
			usleep(300000);
			header ("Location: profile_panel.php");
		}
	}
	include "footer/footer.php";
?>