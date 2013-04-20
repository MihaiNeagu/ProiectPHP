<?php
	include "header/header.php";
//	print_r($_POST);
	redirect_if_logged_out();
	if (isset($_POST["product_id"]) && !empty($_POST['product_id']))
	{
		//Un client nu poate achizitiona de doua ori acelasi produs 
		$produs_test = mysql_fetch_assoc(mysql_query("select * from tranzactii where user_id = ".$_SESSION["user_id"]." and product_id = ".$_POST["product_id"]));
		if (!empty($produs_test))
			put_error ("Ati mai achizitionat acest produs !");
		else
		{

			mysql_query("SET AUTOCOMMIT=0");
			mysql_query("START TRANSACTION");

			//Verific daca cantitatea ceruta este mai mare decat stocul
			$stoc = mysql_fetch_assoc(mysql_query("select quantity from products where id_product = " . $_POST["product_id"]))["quantity"];
			if ($_POST["quantity"] > $stoc)
				header ("Location: index.php?stoc_depasit");
			else
			{
				//Adaug produsul in tabelul transazctii 
				mysql_query("insert into tranzactii (user_id,product_id,quantity) values (".$_SESSION["user_id"].",".$_POST["product_id"].",".$_POST["quantity"].")");

				//Updatez tabelul produse
				$old_quantity = mysql_fetch_assoc(mysql_query("select quantity from products where id_product = " . $_POST['product_id']))['quantity'];
				$new_quantity = $old_quantity - $_POST['quantity'];
				mysql_query("update products set quantity = " . $new_quantity . " where id_product = " . $_POST['product_id']);

				mysql_query("COMMIT");
				mysql_query("SET AUTOCOMMIT=1");

				usleep(300000);
				header ("Location: profile_panel.php");
			}
			
		}
	}
	include "footer/footer.php";
?>