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
					$num++;
					echo '<tr>
					<td></td>
					<td>'.$num.'</td>
					<td>'.$row["name"].'</td>
					<td>'.$row["price"].'</td>
					<td><a href = "cauta.php?buy_id='.$row["id_product"].'">Add to cart</a></td>
				  	</tr>';
		}
		echo
			'</table>
		<br/>';
?>