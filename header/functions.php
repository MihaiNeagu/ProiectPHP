<?php	
	
	function redirect_if_logged_out ()
	{
		if (!logged_in ()) header('Location: index.php');
	}
	
	function render_product_for_admin ($id,$name,$price,$description,$image,$quantity)
	{
			$quantity_display = ($quantity > 0) ? "<h5 class = 'text-success'>Exista in stoc ".$quantity. " produse !</h5>"
												: "<h5 class = 'text-error'>Nu mai exista in stoc !</h5>";
			echo'<ul class="thumbnails">
  					<li style = "padding-right:10;"  class="span4">
  						<div class = "thumbnail">
		    				<a href="#" class="thumbnail">
		      				<img width = "360" height ="270" src = "'.$image.'" alt = "Imagine Produs" />
		    				</a>
			    			<h3>'.$name.'</h3> <h4>'.$price.' RON</h4></br>
			    			'.$quantity_display.'</br>
			    			<p>'.$description.'</p>
			      			<a href = "edit_product.php?product_id='.$id.'"><input type = "button" class = "btn btn-info" value = "Edit"></a>
			      			<a href = "delete_product.php?product_id='.$id.'"><input type = "button" class = "btn btn-danger" value = "Delete"></a>
		      			</div>
  					</li>';
  	}
	function render_product ($id,$name,$price,$description,$image,$quantity)
	{
		$quantity_display = ($quantity > 0) ? "<h5 class = 'text-success'>Exista in stoc ".$quantity. " produse !</h5>"
												: "<h5 class = 'text-error'>Nu mai exista in stoc !</h5>";
		echo (logged_in()) ? 
				'<form action = "buy.php" method = "POST">
				<ul class="thumbnails">
  					<li style = "padding-right:10;"  class="span4">
  						<div class = "thumbnail">
		    				<a href="#" class="thumbnail">
		      				<img width = "360" height ="270" src = "'.$image.'" alt = "Imagine Produs" />
		    				</a>
		    				<input type = "hidden" name = "product_id" value = "'.$id.'" />
			    			<h3>'.$name.'</h3> <h4>'.$price.' RON</h4></br>
			    			'.$quantity_display.'</br>
			    			<p>'.$description.'</p>
			    			<input type = "text" name = "quantity" />
			    			<input type = "submit" class = "btn btn-primary" value = "Buy" />
			      			<!-- <a href = "buy.php?product_id='.$id.'"><input type = "button" class = "btn btn-primary" value = "Buy"></a> -->
			      			<input type = "button" class = "btn btn-info" value = "Info">
		      			</div>
  					</li>' : 
  					'<ul class="thumbnails">
  					<li style = "padding-right:10;" class="span4">
  						<div class = "thumbnail">
		    				<a href="#" class="thumbnail">
		      				<img src = "'.$image.'" alt = "Imagine Produs" />
		    				</a>
			    			<h3>'.$name.'</h3> <h4>'.$price.' RON</h4></br>
			    			<p>'.$description.'</p>
			      			<input type = "button" class = "btn btn-info" value = "Info">
		      			</div>
  					</li>';
	}

	//Returneaza calea catre imagine si, daca e cazul, uploadeaza imaginea in folderul img
	function upload_image ()
	{
		if (!isset($_FILES) || empty($_FILES))
			return "img/noImage.jpg";

		$extentions = array("jpg","jpeg","gif","png");
		$filetypes = array("image/gif","image/jpeg","image/png","image/pjpeg");

		$extracted_ext = explode(".",$_FILES["file"]["name"]);
		$extracted_ext = end($extracted_ext);

		if (!in_array($_FILES["file"]["type"], $filetypes) || !in_array($extracted_ext, $extentions))
			return "img/noImage.jpg";

		if (file_exists("img/".$_FILES["file"]["name"]))
			return "img/" . $_FILES["file"]["name"];

		move_uploaded_file($_FILES["file"]["tmp_name"], "img/".$_FILES["file"]["name"]);

		return "img/" . $_FILES["file"]["name"];
	}
	function valid_email ($email)
	{
		return filter_var ($email, FILTER_VALIDATE_EMAIL);
	}
	function send_email ($from, $from_name="", $to, $subject, $body)
	{
		$mail = get_email_object();
		$mail->Subject = $subject;
		$mail->MsgHTML($body);
		$mail->AddAddress($to);
		$mail->SetFrom ($from,$from_name);
		return $mail->Send();

	}
	function users_no ()
	{
		return mysql_num_rows(mysql_query("select * from users"));
	}
	function online_visitors ()
	{
		$time=time();
		$ip=$_SERVER['REMOTE_ADDR'];
		$timeout=$time-300;
		$query1=mysql_query("delete from online where ip='$ip'")or die (mysql_error());
		$query2=mysql_query("delete from online where time<$timeout")or die (mysql_error());
		$query3=mysql_query("insert into online values('','$ip','$time')")or die (mysql_error());
		$query4=mysql_query("select * from online ")or die (mysql_error());
		//echo $num=mysql_num_rows($query4);
		return mysql_num_rows($query4);
	}
	function online_users ()
	{
		return mysql_num_rows(mysql_query("select * from users where online = 1"));
	}
	function set_user_role ($user_id)
	{
		mysql_query("update users set usertype = 'user' where user_id = '".$user_id."'");
	}

	function set_admin_role ($user_id)
	{
		mysql_query("update users set usertype = 'admin' where user_id = '".$user_id."'");
	}
	function get_user_data ($user_id)
	{
		$user_id = (int)$user_id;
		$data = array();
		$func_get_args = func_get_args();

		if (func_num_args() > 1)
		{
			unset($func_get_args[0]);
			$fields = implode(', ', $func_get_args);
			$data = mysql_query("select $fields from users where user_id = $user_id");
			return mysql_fetch_assoc($data);

		} 
	}
	function param_exists_get ($param)
	{
		return (!isset($_GET[$param]) || $_GET[$param] == "") ? false : true;
	}

	function param_exists_post ($param)
	{
		return (!isset($_POST[$param]) || $_POST[$param] == "") ? false : true;
	}

	function validation_error ($message)
	{
		echo '<label id = "numeRequired" class = "pull-right text-error">'.$message.'</label>';
	}

	function put_error ($message)
	{
		echo '<center><label class = "alert alert-error">'.$message.'</label></center>';
	}

	function logged_in ()
	{
		return (isset($_SESSION) && !empty($_SESSION)) ? true : false;
	}

	function user_exists ($username)
	{
		$username = htmlentities(mysql_real_escape_string($username));
		return (mysql_result(mysql_query("select count(username) from users where username = '".$username."'"), 0) == 1) ? true : false;
	}
	function log_in ($username, $password)
	{
		$username = htmlentities(mysql_real_escape_string($username));
		$password = sha1(htmlentities(mysql_real_escape_string($password)));		
		
		$mfa = mysql_fetch_assoc(mysql_query("select user_id from users where username = '$username' and password = '$password'"));

		if (!empty($mfa))
		{
			mysql_query("update users set online = 1 where user_id = " . $mfa["user_id"]);
			return $mfa['user_id'];
		}
		else 
			return false;
	}

	function log_in_with_SHA1 ($username, $password)
	{
		$username = htmlentities(mysql_real_escape_string($username));
		$password = htmlentities(mysql_real_escape_string($password));
		
		$mfa = mysql_fetch_assoc(mysql_query("select user_id from users where username = '$username' and password = '$password'"));

		if (!empty($mfa))
		{
			mysql_query("update users set online = 1 where user_id = " . $mfa["user_id"]);
			return $mfa['user_id'];
		}
		else 
			return false;
	}

	function log_out ()
	{
		mysql_query("update users set online = 0 where user_id = " . $_SESSION["user_id"]);

		session_destroy();
	}
?>