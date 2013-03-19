<?php
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
			if (isset($_GET["update_id"]) && $_GET["update_id"] != "")
				if ($_GET["update_id"] != $row["id_product"])
				{
					$num++;
					echo '<tr>
					<td></td>
					<td>'.$num.'</td>
					<td>'.$row["name"].'</td>
					<td>'.$row["price"].'</td>
					<td><a href = "cauta.php?nume='.$_GET["nume"].'&pret='.$_GET["pret"].'&id_product='.$row["id_product"].'">Sterge</a> &nbsp;
						<a href = "cauta.php?nume='.$_GET["nume"].'&pret='.$_GET["pret"].'&update_id='.$row["id_product"].'">Update</a></td>
				  	</tr>';
				}
				else
				{
					$num++;
					echo '<form method = "GET" action = "cauta.php"><tr>
					<td></td>
					<td>'.$num.'
						<input type = "hidden" name = "confirmation_id" value = "'.$row["id_product"].'">
					</td>
					<td><input type = "text" name = "nume" value = "'.$row["name"].'" /></td>
					<td><input type = "text" name = "pret" value = "'.$row["price"].'" /></td>
					<td><a href = "cauta.php?nume='.$_GET["nume"].'&pret='.$_GET["pret"].'&id_product='.$row["id_product"].'">Sterge</a> &nbsp;
						<input type = "submit" class = "btn" value = "Confirma" /></td>
				  	</tr></form>';
				}
				else
					{
						$num++;
					echo '<tr>
					<td></td>
					<td>'.$num.'</td>
					<td>'.$row["name"].'</td>
					<td>'.$row["price"].'</td>
					<td><a href = "cauta.php?nume='.$_GET["nume"].'&pret='.$_GET["pret"].'&id_product='.$row["id_product"].'">Sterge</a> &nbsp;
						<a href = "cauta.php?nume='.$_GET["nume"].'&pret='.$_GET["pret"].'&update_id='.$row["id_product"].'">Update</a></td>
				  	</tr>';}
			
		}
			
		echo
			'</table>
		<br/>';
?>