<?php include 'header/header.php';
redirect_if_logged_out();
if (!logged_in () || $user_data['usertype'] != 'administrator') header('Location: index.php');
$useri = mysql_query("select * from users");

echo '<br/>
				<table class = "table table-hover">
					<th class = "success">
						<td><b>Nume</b></td>
						<td><b>Actiune</b></td>
					</th>';

while ($row = mysql_fetch_assoc($useri))
		{
					echo '<tr>
					<td></td>
					<td>'.$row["username"].'</td>
					<td><a href = "edit_user.php?user_id='.$row["user_id"].'"><input type = "button" class = "btn btn-info" value = "Editeaza"/></a>&nbsp;
					<a href = "edit_user.php?delete_user_id='.$row["user_id"].'"><input type = "button" class = "btn btn-danger" value = "Sterge"/></a></td>
				  	</tr>';
		}
		echo
			'</table>
		<br/>';

if (isset($_GET['user_id']) && !empty($_GET['user_id']))
{
}

?>
<?php include 'footer/footer.php';?>