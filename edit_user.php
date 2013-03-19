<?php include 'header/header.php';
if (!logged_in () || $user_data['usertype'] != 'administrator') header('Location: index.php');
if (!isset($_GET['username'])) $page_valid = false; 
$edit_data = get_user_data ($_GET['user_id'],'last_name','first_name','username','email','password');
?>

<form class = "form-horizontal" method = "GET" action = "edit_user.php">
	<input type = 'hidden' name = 'user_id' value = <?php echo '"'.$_GET['user_id'].'"'; ?>>
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume" value = 
			<?php echo '"'.$edit_data["last_name"].'"'; ?> >
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "prenume">Prenume</label>
		<div class = "controls">
			<input type = "text" id = "prenume" name = "prenume" placeholder = "Prenume" value = 
			<?php echo '"'.$edit_data["first_name"].'"'; ?>>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "email">Email</label>
		<div class = "controls">
			<input type = "text" id = "email" name = "email" placeholder = "Email" value = 
			<?php echo '"'.$edit_data["email"].'"'; ?>>
			<?php
				if (isset($_GET['email']))								
					if (!param_exists_get("email"))
					{
						validation_error ("Email-ul este obligatoriu !");
						$page_valid = false;
					}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "username">Username</label>
		<div class = "controls">
			<input type = "text" id = "username" name = "username" placeholder = "Username" value = 
			<?php echo '"'.$edit_data["username"].'"'; ?> />
			<?php
				if (isset($_GET['username']))	
				{			
					if (!param_exists_get("username"))
					{
						validation_error ("Username-ul este obligatoriu !");
						$page_valid = false;
					}
					else
					if (user_exists($_GET['username']) && $_GET['username'] != $edit_data['username'])
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
			<input type = "password" id = "password" name = "password" placeholder = "Password"/>
			<?php
		/*		if (isset($_GET) && sizeof($_GET) != 0)				
					if (!param_exists_get("password"))
					{
						validation_error ("Parola este obligatorie !");
						$page_valid = false;
					} */
			?> 
		</div>
	</div>
	<div class = "control-group">
		<div class = "controls">
			<input type = "submit" class = "btn" value = "Update">
		</div>
	</div>
</form>

<br/>

<h4>Achizitionari</h4>
<?php 
$result = mysql_query("select * from products join tranzactii on tranzactii.product_id = products.id_product where user_id = ".$_GET['user_id']);
$num = 0;
	echo '<br/>
				<table class = "table table-hover">
					<th class = "success">
						<td><b>#</b></td>
						<td><b>Nume</b></td>
						<td><b>Pret</b></td>
						<td><b>Actiune</b></td>
					</th>';
    	while ($row = mysql_fetch_assoc($result))
		{
					$num++;
					echo '<tr>
					<td></td>
					<td>'.$num.'</td>
					<td>'.$row["name"].'</td>
					<td>'.$row["price"].'</td>
					<td><a href = "edit_user.php?id='.$row["id_tranzactie"].'">Renunta</a></td>
				  	</tr>';
		}
		echo
			'</table>
		<br/>';
 ?>


<?php
	
	if (isset($_GET) && !empty($_GET))
		if (!empty($_GET['id']))
			mysql_query("delete from tranzactii where id_tranzactie = '".$_GET["id"]."'");

	//if (!isset($_GET['id']))
	if ($page_valid == true)
	{
		//Prelucrarea datelor de editare

		//In cazul in care nu se introduc noi date
		$edit_data['password'] = (empty($_GET['password'])) ? $edit_data['password'] : $_GET['password'];
		$edit_data['username'] = (empty($_GET['username'])) ? $edit_data['username'] : $_GET['username'];
		$edit_data['last_name'] = (empty($_GET['nume'])) ? $edit_data['last_name'] : $_GET['nume'];
		$edit_data['first_name'] = (empty($_GET['prenume'])) ? $edit_data['first_name'] : $_GET['prenume'];
		$edit_data['email'] = (empty($_GET['email'])) ? $edit_data['email'] : $_GET['email'];

		if (empty($_GET['password'])) //Daca nu e setat GET-ul, parola e deja critata
			mysql_query("update users set username = '".$edit_data['username']."', last_name='".$edit_data["last_name"]."', first_name='".$edit_data["first_name"]."', email='".$edit_data["email"]."', password='".$edit_data['password']."' where user_id=".$_GET['user_id']);
		else
			mysql_query("update users set username = '".$edit_data['username']."', last_name='".$edit_data["last_name"]."', first_name='".$edit_data["first_name"]."', email='".$edit_data["email"]."', password='".sha1($edit_data['password'])."' where user_id=".$_GET['user_id']);

		echo '<label class = "text-success">A fost introdusa o noua linie in baza de date !</label>';
	}
?>

<?php include 'footer/footer.php' ?>