<?php include 'header/header.php';
redirect_if_logged_out();
if (!isset($_GET) || sizeof($_GET) == 0) $page_valid = false; 
$edit_data = get_user_data ($_SESSION['user_id'],'last_name','first_name','email','password'); ?>

<form class = "form-horizontal" method = "GET" action = "profile_panel.php">
	<div class = "control-group">
		<label class = "control-label" for = "nume">Nume</label>
		<div class = "controls">
			<input type = "text" id = "nume" name = "nume" placeholder = "Nume" value = <?php echo $edit_data["last_name"]; ?> >
			<?php
				if (isset($_GET) && sizeof($_GET) != 0)				
					if (isset ($_GET['nume']))
						if (empty($_GET["nume"]))
					{
						validation_error ("Numele este obligatoriu !");
						$page_valid = false;
					}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "prenume">Prenume</label>
		<div class = "controls">
			<input type = "text" id = "prenume" name = "prenume" placeholder = "Prenume" value = <?php echo $edit_data["first_name"]; ?>>
			<?php
				if (isset($_GET) && sizeof($_GET) != 0)				
					if (isset ($_GET['prenume']))
						if (empty($_GET["prenume"]))
					{
						validation_error ("Prenumele este obligatoriu !");
						$page_valid = false;
					}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "email">Email</label>
		<div class = "controls">
			<input type = "text" id = "email" name = "email" placeholder = "Email" value = <?php echo $user_data["email"]; ?>>
			<?php
				if (isset($_GET) && sizeof($_GET) != 0)				
					if (isset ($_GET['email']))
						if (empty($_GET["email"]))
					{
						validation_error ("Email-ul este obligatoriu !");
						$page_valid = false;
					}
			?>
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "password">Password</label>
		<div class = "controls">
			<input type = "password" id = "password" name = "password" placeholder = "Password">
		</div>
	</div>
	<div class = "control-group">
		<div class = "controls">
			<input type = "submit" class = "btn" value = "Update">
		</div>
	</div>
</form>
<br/>
<!--  Afisez achizitionarile-->
<h4>Achizitionari</h4>
<?php 
$result = mysql_query("select * from products join tranzactii on tranzactii.product_id = products.id_product where user_id = ".$_SESSION['user_id']);
$num = 0;
	echo '<br/>
				<table class = "table table-hover">
					<th class = "success">
						<td><b>#</b></td>
						<td><b>Nume</b></td>
						<td><b>Pret</b></td>
						<td><b>Cantitate</b></td>
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
					<td>'.$row["quantity"].'</td>
					<td><a href = "profile_panel.php?id='.$row["id_tranzactie"].'">Renunta</a></td>
				  	</tr>';
		}
		echo
			'</table>
		<br/>';
 ?>

<?php
	if (isset($_GET) && !empty($_GET))
		if (!empty($_GET['id']))
		{
			$tranzactie = mysql_fetch_assoc(mysql_query("select * from tranzactii where id_tranzactie = " . $_GET["id"]));
			$new_quantity = mysql_fetch_assoc(mysql_query("select * from products where id_product = ".  $tranzactie["product_id"]))["quantity"] + $tranzactie["quantity"];
			mysql_query("update products set quantity = ".$new_quantity." where id_product = ".$tranzactie["product_id"]);
			mysql_query("delete from tranzactii where id_tranzactie = '".$_GET["id"]."'");
			header ("Location: profile_panel.php");
		}
			
	if (!isset($_GET['id']))
	if ($page_valid == true)
	{
		//In cazul in care nu se introduc noi date
		$edit_data['password'] = (empty($_GET['password'])) ? $edit_data['password'] : $_GET['password'];
		$edit_data['last_name'] = (empty($_GET['nume'])) ? $edit_data['last_name'] : $_GET['nume'];
		$edit_data['first_name'] = (empty($_GET['prenume'])) ? $edit_data['first_name'] : $_GET['prenume'];
		$edit_data['email'] = (empty($_GET['email'])) ? $edit_data['email'] : $_GET['email'];
//		$password_value = (empty($_GET['password'])) ? sha1("") : sha1($_GET['password']);
		if (empty($_GET['password'])) //Daca nu e setat GET-ul, parola e deja critata
			mysql_query("update users set last_name='".$edit_data["last_name"]."', first_name='".$edit_data["first_name"]."', email='".$edit_data["email"]."', password='".$edit_data['password']."' where user_id=".$_SESSION['user_id']);
		else
			mysql_query("update users set last_name='".$edit_data["last_name"]."', first_name='".$edit_data["first_name"]."', email='".$edit_data["email"]."', password='".sha1($edit_data['password'])."' where user_id=".$_SESSION['user_id']);			


//		echo "update users set last_name='".$_GET["nume"]."', first_name='".$_GET["prenume"]."', email='".$_GET["email"]."', password='".$password_value."' where user_id=".$_SESSION['user_id'];		

		
//		$user_data = get_user_data($_SESSION['user_id'],'username','email','last_name','first_name','usertype');
		echo '<label class = "text-success">Pagina de profil a fost actualizata !</label>';
	}
		
?>

<?php include 'footer/footer.php' ?>