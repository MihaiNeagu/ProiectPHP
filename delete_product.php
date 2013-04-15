<?php include "header/header.php"; ?>

<?php 
	if (isset($_GET["product_id"]) && !empty($_GET["product_id"])) 
	{
		
		//Sterg si imaginea asociata acelui produs 
		$result = mysql_query("select image from products where id_product = " . $_GET["product_id"]);
		while ($row = mysql_fetch_assoc($result))
			if ($row['image'] != "img/noImage.jpg")
				unlink ($row['image']);
		
		mysql_query("delete from products where id_product = " . $_GET["product_id"]);
		header ("Location: index.php?delete=successful");
	}
?>

<?php include "footer/footer.php"; ?>