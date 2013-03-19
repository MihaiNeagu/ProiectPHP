<?php include 'header/header.php'; ?>
<h1>Contact</h1>
	<form method = "POST" action = "contact.php">
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label><br/>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume">
		</div>
		<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("nume"))
					{
						validation_error ("Numele este obligatoriu !");
						$page_valid = false;
					}
			?>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "email">Email</label><br/>
		<div class = "controls">
			<input type = "text" id = "email" name = "email" placeholder = "Email">
		</div>
	</div>
	<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("email"))
					{
						validation_error ("Adresa de email este obligatorie !");
						$page_valid = false;
					}
			?>
	<div class = "control-group">
		<label class = "control-label" for = "sugestii">Sugestii</label><br/>
		<div class = "controls">
			<textarea height = "100" id = "sugestii" name = "sugestii" placeholder = "Sugestii"></textarea>
		</div>
	</div>
	<input type = "submit" value = "Trimite">
</form>

<?php
	if ($page_valid == true)
 		if (isset($_POST) && !empty($_POST))
	//	mail("admin@site.com", "Sugestie de la".$_POST['nume'], $_POST['sugestii']);
 			if (send_email ($_POST['email'],$_POST['nume'],
			 				"hunter_mike16@yahoo.com",
			 				"Sugestii de la " . $_POST['nume'], 
			 				$_POST['sugestii']))
 				echo '<label class = "text-success">Multumim pentru feedback !</label>'; 
 			else
 				put_error ("Mesajul dumneavoastra nu a putut fi trimis, va rugam reveniti !"); 
	 ?>

<?php include 'footer/footer.php'; ?>