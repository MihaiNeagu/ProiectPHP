<?php include 'header/header.php'; 
if (isset($_GET) && !empty($_GET))
		{
			if (isset($_GET["failure"]) && $_GET['failure'] == '1')
				put_error ('Username si parola incorecte !');
			if (isset($_GET["delete"]) && $_GET['delete'] == 'successful')
				echo '<label class = "text-success">A fost sters un produs din baza de date !</label>';
			if (isset($_GET["stoc_depasit"]))
				put_error ("Ati depasit stocul !");
		}
			?>
<!-- <center><img src="img/Online-store.jpg" /></center> -->

<div class = "container-fluid">
	<div class = "row-fluid">
		<div class = "span12">
			<?php
		//		$prod = mysql_fetch_assoc(mysql_query("select * from products order by id_product desc limit 3"));
			$prod = mysql_query("select * from products order by id_product desc limit 3");


			//Afisare produse thumbnail
/*			echo '<ul class="thumbnails">
  					<li class="span4">
  						<div class = "thumbnail">
		    				<a href="#" class="thumbnail">
		      				<img src = "img/noImage.jpg" alt = "Imagine Produs" />
		    				</a>
			    			<h3>Nume</h3>
			    			<p>Descriere</p>
			      			<input type = "button" class = "btn btn-primary" value = "Buy">
			      			<input type = "button" class = "btn btn-info" value = "Info">
		      			</div>
  					</li>'; */
	/*		while ($p =  mysql_fetch_assoc($prod))
			echo (logged_in()) ? "<div class = 'span4'>".$p["name"]."<br/><a href = 'cauta.php?buy_id=".$p["id_product"]."'>Buy</a></div>"
							   : "<div class = 'span4'>".$p["name"]."</div>"; */
			while ($p = mysql_fetch_assoc($prod))
				if (logged_in())
					if ($user_data["usertype"] == "administrator")
					render_product_for_admin ($p["id_product"],$p["name"],$p["price"],$p["description"],$p["image"],$p['quantity']);
				else
					render_product ($p["id_product"],$p["name"],$p["price"],$p["description"],$p["image"],$p['quantity']);
				else
					render_product ($p["id_product"],$p["name"],$p["price"],$p["description"],$p["image"],$p['quantity']);

			?>
		</div>
	</div>
</div>
<?php include 'footer/footer.php'; ?>