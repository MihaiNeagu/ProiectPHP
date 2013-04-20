<?php include 'header/header.php'; 
if (!logged_in ()) header('Location: index.php');?>

<form class = "form-horizontal" method = "GET" action = "cauta.php">
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume">
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "pret">Pret</label>
		<div class = "controls">
			<input type = "text" id = "pret" name = "pret" placeholder = "Pret">
		</div>
	</div>
	<div class = "control-group">
		<div class = "controls">
			<input type = "submit" class = "btn" value = "Cauta">
		</div>
	</div>
</form>

<?php
if (isset($_GET) && sizeof($_GET) != 0)
{
	
	echo '<ul class="thumbnails">';
	if (isset($_GET["id_product"]) && $_GET["id_product"] != "")
		mysql_query("delete from products where id_product='".$_GET["id_product"]."'");

	if (isset($_GET["confirmation_id"]) && $_GET["confirmation_id"] != "")
		mysql_query("update products set name = '".$_GET["nume"]."', price = ".$_GET["pret"]." where id_product=".$_GET["confirmation_id"]);

	if (isset($_GET["buy_id"]) && $_GET["buy_id"] != "")
	{
		mysql_query("insert into tranzactii (user_id,product_id) values ('".$_SESSION["user_id"]."', '".$_GET["buy_id"]."')");
		header("Location: profile_panel.php");
	}
	echo '</ul>';
//	echo "insert into tranzactii (user_id,product_id) values ('".$_SESSION["user_id"]."', '".$_GET["buy_id"]."')";


	$nume = (!isset($_GET["nume"]) || $_GET["nume"] == "") ? "" : $_GET["nume"];
	$pret = (!isset($_GET["pret"]) || $_GET["pret"] == "") ? "" : $_GET["pret"];

	if ($nume == "")
		$conditie1 = "";
	else
		$conditie1 = "where name like '%" . $nume . "%' ";

	if ($conditie1 == "")
		if ($pret == "")
			$conditie2 = "";
		else
			$conditie2 = "where price = " . $pret . " ";
	else
		if ($pret == "")
			$conditie2 = "";
		else
			$conditie2 = "and price = " . $pret . " ";

	$num = 0;
    $result = mysql_query("select * from products ".$conditie1.$conditie2);
    if (mysql_num_rows($result) == 0)
    {
    	put_error('Niciun rezultat !');
    }
    else
    {
	/*	if ($user_data['usertype'] == 'administrator')
			require 'admin_table.php';
		else
			require 'user_table.php'; */
			while ($p = mysql_fetch_assoc($result))
				if ($user_data["usertype"] == "administrator")
					render_product_for_admin ($p["id_product"],$p["name"],$p["price"],$p["description"],$p["image"],$p["quantity"]);
				else
					render_product ($p["id_product"],$p["name"],$p["price"],$p["description"],$p["image"],$p["quantity"]);
    }
	
}
?>
<?php include 'footer/footer.php'; ?>