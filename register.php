<?php include 'header/header.php';
if (logged_in ()) header('Location: index.php');
if (!isset($_POST) || sizeof($_POST) == 0) $page_valid = false; ?>

<form class = "form-horizontal" method = "POST" action = "register.php">
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume" value = <?php if (param_exists_POST("nume")) echo $_POST['nume']; else echo ""; ?> >
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "prenume">Prenume</label>
		<div class = "controls">
			<input type = "text" id = "prenume" name = "prenume" placeholder = "Prenume" value = <?php if (param_exists_POST("prenume")) echo $_POST['prenume']; else echo ""; ?>>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "email">Email</label>
		<div class = "controls">
			<input type = "text" id = "email" name = "email" placeholder = "Email" value = <?php if (param_exists_POST("email")) echo $_POST['email']; else echo ""; ?>>
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)								
					if (!param_exists_post("email"))
					{
						validation_error ("Email-ul este obligatoriu !");
						$page_valid = false;
					}
					else
						if (!valid_email ($_POST['email']))
						{
							validation_error("Emailul nu este valid !");
							$page_valid = false;
						}
						else
						{
							$picked_email = mysql_fetch_assoc(mysql_query("select * from users where email = '" . $_POST['email'] . "'"));
							if (!empty($picked_email))
								{
									validation_error('Adresa ' . $_POST['email'] . ' este folosita deja');
									$page_valid = false;
								}
							//echo "select * from users where email = '" . $_POST['email'] . "'";
						}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "username">Username</label>
		<div class = "controls">
			<input type = "text" id = "username" name = "username" placeholder = "Username" value = <?php if (param_exists_POST("username")) echo $_POST['username']; else echo ""; ?>>
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)	
				{			
					if (!param_exists_post("username"))
					{
						validation_error ("Username-ul este obligatoriu !");
						$page_valid = false;
					}
					if (user_exists($_POST['username']))
					{
						validation_error("Username-ul este deja folosit !");
						$page_valid = false;
					}
				}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "password">Password</label>
		<div class = "controls">
			<input type = "password" id = "password" name = "password" placeholder = "Password">
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("password"))
					{
						validation_error ("Parola este obligatorie !");
						$page_valid = false;
					}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "password2">Password</label>
		<div class = "controls">
			<input type = "password" id = "password2" name = "password2" placeholder = "Password">
			<?php
				if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("password2"))
					{
						validation_error ("Reintroducerea parolei este obligatorie !");
						$page_valid = false;
					}
					else
						if ($_POST['password'] != $_POST['password2'])
						{
							validation_error ("Ati reintrodus gresit parola !");
							$page_valid = false;
						}
			?>
		</div>
	</div>
	<div class = "control-group">
		<div class = "controls">
			<input type = "submit" class = "btn" value = "Register">
		</div>
	</div>
</form>

<?php
	if ($page_valid == true)
	{
		mysql_query("insert into users (username, password, email, first_name, last_name)
		 values ('".$_POST["username"]."' , '".sha1($_POST["password"])."' , '".$_POST["email"]."' , '".$_POST["prenume"]."'
		 	 , '".$_POST["nume"]."')"); 
		echo '<label class = "text-success">A fost introdusa o noua linie in baza de date !</label>';
		usleep(300000);
		header('Location: login.php?username=' . $_POST['username'] . '&password='.$_POST['password']);
		//echo 'Location: login.php?username=' . $_POST['username'] . '&password='.$_POST['password'];
	}
?>

<?php include 'footer/footer.php' ?>