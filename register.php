<?php include 'header/header.php';
if (logged_in ()) header('Location: index.php');
if (!isset($_GET) || sizeof($_GET) == 0) $page_valid = false; ?>

<form class = "form-horizontal" method = "GET" action = "register.php">
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume" value = <?php if (param_exists_get("nume")) echo $_GET['nume']; else echo ""; ?> >
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "prenume">Prenume</label>
		<div class = "controls">
			<input type = "text" id = "prenume" name = "prenume" placeholder = "Prenume" value = <?php if (param_exists_get("prenume")) echo $_GET['prenume']; else echo ""; ?>>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "email">Email</label>
		<div class = "controls">
			<input type = "text" id = "email" name = "email" placeholder = "Email" value = <?php if (param_exists_get("email")) echo $_GET['email']; else echo ""; ?>>
			<?php
				if (isset($_GET) && sizeof($_GET) != 0)								
					if (!param_exists_get("email"))
					{
						validation_error ("Email-ul este obligatoriu !");
						$page_valid = false;
					}
					else
						if (!valid_email ($_GET['email']))
						{
							validation_error("Emailul nu este valid !");
							$page_valid = false;
						}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "username">Username</label>
		<div class = "controls">
			<input type = "text" id = "username" name = "username" placeholder = "Username" value = <?php if (param_exists_get("username")) echo $_GET['username']; else echo ""; ?>>
			<?php
				if (isset($_GET) && sizeof($_GET) != 0)	
				{			
					if (!param_exists_get("username"))
					{
						validation_error ("Username-ul este obligatoriu !");
						$page_valid = false;
					}
					if (user_exists($_GET['username']))
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
				if (isset($_GET) && sizeof($_GET) != 0)				
					if (!param_exists_get("password"))
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
				if (isset($_GET) && sizeof($_GET) != 0)				
					if (!param_exists_get("password2"))
					{
						validation_error ("Reintroducerea parolei este obligatorie !");
						$page_valid = false;
					}
					else
						if ($_GET['password'] != $_GET['password2'])
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
		 values ('".$_GET["username"]."' , '".sha1($_GET["password"])."' , '".$_GET["email"]."' , '".$_GET["prenume"]."'
		 	 , '".$_GET["nume"]."')"); 
		echo '<label class = "text-success">A fost introdusa o noua linie in baza de date !</label>';
		header('Location: login.php?username=' . $_GET['username'] . '&password='.$_GET['password']);
		//echo 'Location: login.php?username=' . $_GET['username'] . '&password='.$_GET['password'];
	}
?>

<?php include 'footer/footer.php' ?>