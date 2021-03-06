<?php include 'header/header.php';
redirect_if_logged_out();
if (!logged_in () || $user_data['usertype'] != 'administrator') header('Location: index.php');
if (!isset($_POST['username'])) $page_valid = false; 

//Pentru a sterge un utilizator
if (!empty($_GET['delete_user_id']))
{
	mysql_query("delete from users where user_id = " . $_GET['delete_user_id']);
	header ("Location: admin_panel.php");
}

if (isset($_GET['user_id']))
$edit_data = get_user_data ($_GET['user_id'],'user_id','last_name','first_name','username','email','password','usertype');
else
$edit_data = get_user_data ($_POST['user_id'],'user_id','last_name','first_name','username','email','password','usertype');
?>

<form class = "form-horizontal" method = "POST" action = "edit_user.php">
	<input type = 'hidden' name = 'user_id' value = <?php echo '"'.$edit_data['user_id'].'"'; ?>>
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
				if (isset($_POST['email']))								
					if (!param_exists_post("email"))
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
				if (isset($_POST['username']))	
				{			
					if (!param_exists_post("username"))
					{
						validation_error ("Username-ul este obligatoriu !");
						$page_valid = false;
					}
					else
					if (user_exists($_POST['username']) && $_POST['username'] != $edit_data['username'])
					{
						validation_error("Username-ul este deja folosit !");
						$page_valid = false;
					}
				}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "usertype">Tip de utilizator</label>
		<div class = "controls">
			<select name = "usertype">
				<option value = "user" <?php echo ($edit_data['usertype'] == 'user') ? 'selected' : ''; ?>>Utilizator normal</option>
				<option value = "administrator" <?php echo ($edit_data['usertype'] == 'administrator') ? 'selected' : ''; ?>>Administrator</option>
			</select>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "password">Password</label>
		<div class = "controls">
			<input type = "password" id = "password" name = "password" placeholder = "Password"/>
			<?php
		/*		if (isset($_POST) && sizeof($_POST) != 0)				
					if (!param_exists_post("password"))
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
$result = mysql_query("select * from products join tranzactii on tranzactii.product_id = products.id_product where user_id = ".$edit_data['user_id']);
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
					<td><a href = "edit_user.php?user_id = '.$edit_data['user_id'].'id='.$row["id_tranzactie"].'">Renunta</a></td>
				  	</tr>';
		}
		echo
			'</table>
		<br/>';
 ?>


<?php
	
	if (isset($_POST) && !empty($_POST))
		{
			if (!empty($_POST['id']))
			{
					$tranzactie = mysql_fetch_assoc(mysql_query("select * from tranzactii where id_tranzactie = " . $_POST["id"]));
					$new_quantity = mysql_fetch_assoc(mysql_query("select * from products where id_product = ". $tranzactie["product_id"]))["quantity"] + $tranzactie["quantity"];
					mysql_query("update products set quantity = ".$new_quantity." where id_product = ".$tranzactie["product_id"]);
					mysql_query("delete from tranzactii where id_tranzactie = '".$_POST["id"]."'");
				
			}

		}

	//if (!isset($_POST['id']))
	if ($page_valid == true)
	{
		//Prelucrarea datelor de editare

		//In cazul in care nu se introduc noi date
		$edit_data['password'] = (empty($_POST['password'])) ? $edit_data['password'] : $_POST['password'];
		$edit_data['username'] = (empty($_POST['username'])) ? $edit_data['username'] : $_POST['username'];
		$edit_data['last_name'] = (empty($_POST['nume'])) ? $edit_data['last_name'] : $_POST['nume'];
		$edit_data['first_name'] = (empty($_POST['prenume'])) ? $edit_data['first_name'] : $_POST['prenume'];
		$edit_data['email'] = (empty($_POST['email'])) ? $edit_data['email'] : $_POST['email'];

		if (empty($_POST['password'])) //Daca nu e setat POST-ul, parola e deja criptata
			mysql_query("update users set username = '".$edit_data['username']."', last_name='".$edit_data["last_name"]."', first_name='".$edit_data["first_name"]."', email='".$edit_data["email"]."', usertype = '". $_POST['usertype'] ."', password='".$edit_data['password']."' where user_id=".$_POST['user_id']);
		else
			mysql_query("update users set username = '".$edit_data['username']."', last_name='".$edit_data["last_name"]."', first_name='".$edit_data["first_name"]."', email='".$edit_data["email"]."', usertype = '". $_POST['usertype'] ."', password='".sha1($edit_data['password'])."' where user_id=".$_POST['user_id']);

		echo '<label class = "text-success">A fost introdusa o noua linie in baza de date !</label>';
	}
?>

<?php include 'footer/footer.php' ?>