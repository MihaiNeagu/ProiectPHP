<?php if (!logged_in())
echo
'<form class = "form-horizontal" method = "POST" action = "login.php">
	<div class = "control-group">
		<label class = "control-label" for = "username">Username</label>
		<div class = "controls">
			<input type = "text" id = "username" name = "username" placeholder = "username">
		</div>
	</div>
	<div class = "control-group">
		<label class = "control-label" for = "password">Password</label>
		<div class = "controls">
			<input type = "password" id = "password" name = "password" placeholder = "password">
			<a href = "register.php">Register</a>
		</div>
	</div>
	<div class = "control-group">
		<div class = "controls">
			<input type = "submit" class = "btn" value = "Login"> 
		</div>
	</div>
</form>';
else

echo
'<p>Hello, <a href = "profile_panel.php">'. $user_data['username'] .'</a></p>
 <a href = "logout.php">Log out </a>';?>