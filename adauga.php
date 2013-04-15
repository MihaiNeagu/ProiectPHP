 <?php include "header/header.php";
 redirect_if_logged_out();
if (!isset($_POST) || sizeof($_POST) == 0) $page_valid = false;?>

<form class = "form-horizontal" method = "POST" action = "adauga.php" enctype="multipart/form-data">
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume">
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("nume"))
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
			<input type = "text" id = "pret" name = "pret" placeholder = "Pret">
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("pret"))
					{
						validation_error('Pretul este obligatoriu !');
						$page_valid = false;
					}
			?>
		</div>
	</div>

	<div class = "control-group">
		<label class = "control-label" for = "quantity">Cantitate</label>
		<div class = "controls">
			<input type = "text" id = "quantity" name = "quantity" placeholder = "Cantitate">
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("quantity"))
					{
						validation_error('Este obligatoriu sa fixati o cantitate !');
						$page_valid = false;
					}
			?>
		</div>
	</div>

	<div class = "control-group">
		<label class = "control-label" for = "descriere">Descriere</label>
		<div class = "controls">
			<textarea height = "200" id = "descriere" name = "descriere" placeholder = "Descriere"></textarea>
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
			<input type = "submit" class = "btn" value = "Adauga">
		</div>
	</div>
</form>

<?php
	if ($page_valid == true)
	{
		mysql_query("insert into products(name,price,description,image,quantity) values('".$_POST["nume"]."',".$_POST["pret"].",'".$_POST["descriere"]."','".upload_image()."','".$_POST["quantity"]."')");

//echo "insert into products(name,price,image) values('".$_POST["nume"]."',".$_POST["pret"].",'".upload_image()."')";
		
		echo '<label class = "text-success">A fost introdusa o noua linie in baza de date !</label>';
	} 

//	echo '<label class = "text-success">Am uploadat fisierul '. upload_image() .' !</label>';
?>


<?php include "footer/footer.php"; ?>