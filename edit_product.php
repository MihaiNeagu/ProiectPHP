 <?php include "header/header.php";
if (!logged_in () || $user_data['usertype'] != 'administrator') header('Location: index.php');
if (!isset($_POST) || sizeof($_POST) == 0) $page_valid = false;

//Din moment ce pagina primeste si prin GET si prin POSt
//Trebuie sa verific metoda 
if (isset($_GET["product_id"]))
$edit_data = mysql_fetch_assoc(mysql_query("select * from products where id_product = ".$_GET['product_id']));
else
if (isset($_POST["product_id"]))
	$edit_data = mysql_fetch_assoc(mysql_query("select * from products where id_product = ".$_POST['product_id']));
?>

<form class = "form-horizontal" method = "POST" action = "edit_product.php" enctype="multipart/form-data">
	<input type = "hidden" name = "product_id" value = <?php echo '"'.$edit_data["id_product"].'"';?> >
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume"
			value = <?php echo '"'.$edit_data["name"].'"'; ?>>
			<?php
				if (isset($_POST))				
					//Daca este setat si este empty
					if (isset ($_POST["nume"]) && empty($_POST["nume"]))
					{
						validation_error ("Numele este obligatoriu !");
						$page_valid = false;
					}
			?>
		</div>
	</div>

	<div class = "control-group">
		<label class = "control-label" for = "pret">Pret</label>
		<div class = "controls">
			<input type = "text" id = "pret" name = "pret" placeholder = "Pret"
			value = <?php echo '"'.$edit_data["price"].'"'; ?>>
			<?php
				if (isset($_POST))				
					//Daca este setat si este empty
					if (isset ($_POST["pret"]) && empty($_POST['pret']))
					{
						validation_error('Pretul este obligatoriu !');
						$page_valid = false;
					}
			?>
		</div>
	</div>

	<div class = "control-group">
		<label class = "control-label" for = "descriere">Descriere</label>
		<div class = "controls">
			<textarea height = "200" id = "descriere" name = "descriere" placeholder = "Descriere"><?php echo $edit_data["description"]; ?></textarea>
		</div>
	</div>

	<div class = "control-group">
		<label class = "control-label" for="file">Imagine</label>
		<div class = "controls">
			<input type="file" name="file" id="file">
		</div>
	</div>

	<div class = "control-group">
		<div class = "controls">
			<input type = "submit" class = "btn" value = "Modifica">
		</div>
	</div>
</form>

<?php
	if ($page_valid == true)
	{
		//mysql_query("insert into products(name,price,description,image) values('".$_POST["nume"]."',".$_POST["pret"].",'".$_POST["descriere"]."','".upload_image()."')");


	//	echo $edit_data["image"];
		//In cazul in care nu se introduc noi date
		$edit_data['name'] = (empty($_POST['nume'])) ? $edit_data['name'] : $_POST['nume'];
		$edit_data['price'] = (empty($_POST['pret'])) ? $edit_data['price'] : $_POST['pret'];
		$edit_data['description'] = (empty($_POST['descriere'])) ? $edit_data['description'] : $_POST['descriere'];

		//Tin minte ce returneaza upload_image pentru ca
		//din varii motive nu pot sa verific conditia
		//$edit_data['image'] = (!isset($_FILES)) ? $edit_data["image"] : upload_image();
		$upload_image_success = upload_image();
		$edit_data['image'] = ($upload_image_success != false) ? $upload_image_success : $edit_data['image'];
	

//		echo "update products set name = '".$edit_data["name"]."',price = ".$edit_data["price"].",description = '".$edit_data["description"]."', image = '".$edit_data["image"]."'";
		mysql_query("update products set name = '".$edit_data["name"]."',price = ".$edit_data["price"].",description = '".$edit_data["description"]."', image = '".$edit_data["image"]."'
					where id_product = " . $edit_data['id_product']);
//echo "insert into products(name,price,image) values('".$_POST["nume"]."',".$_POST["pret"].",'".upload_image()."')";
		
		echo '<label class = "text-success">Produsul a fost modificat cu succes !</label>';
	} 

//	echo '<label class = "text-success">Am uploadat fisierul '. upload_image() .' !</label>';
?>


<?php include "footer/footer.php"; ?>