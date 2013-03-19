<html>
<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
</head>
<body style = "padding: 10 10 10 10;">
	<?php require 'init.php' ?>
	<div class = "container">
			<div class = "row">
				<div class = "span12">
					<div class="page-header">
	  					<h1>
	  						<div class = "row">
		  						<div class = "span7">Magazin on-line</div>
		  						<div class = "span5"><h5>
		  						<?php include 'login_form.php'; ?>
		  						</h5></div>
	  						</div>	  					
	  						<hr/><small>Cumperi, imi esti ca un frate, nu cumperi, imi esti ca doi !</small></h1>
					</div>
					<div class = "navbar">
						<div class = "navbar-inner">
							<ul class = "nav">
								<li><a href="index.php">Acasa</a></li>
   <?php if (logged_in()) echo '<li><a href="cauta.php">Cauta</a></li>';?>
								<?php if (logged_in() && $user_data['usertype'] == 'administrator')
						  echo '<li><a href="adauga.php">Adauga produse</a></li>'; ?>
								<?php if (logged_in())
								{
										echo '<li><a href="profile_panel.php">Profile</a></li>';
										if ($user_data['usertype'] == 'administrator')
											echo '<li><a href="admin_panel.php">Admin panel</a></li>';
									}
											?>
					<!--			<li><a href="mailtest.php">Mail Test</a></li>  -->
								<li><a href="despre.php">Despre</a></li>
								<li><a href="contact.php">Contacteaza-ne</a></li>
							</ul>
						</div>
						
					</div>
					<div class = "container-fluid">
						<div class = "row-fluid">
							<div class = "span10">
		