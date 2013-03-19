</div> <!-- span10 -->
<div class = "span2" >
	
	<?php echo 'Vizitatori: '.online_visitors().'<br/>';
		  echo 'Useri inregistrati: '.users_no().'<br/>';
		  echo 'Useri online: ' . online_users() . '</br>';
		  if (connection_aborted())
		  	mysql_query("update users set online = 0 where user_id = " . $user_data["user_id"]);
	?>
</div>
</div> <!-- row-fluid -->
</div> <!-- container-fluid -->
<!-- <center><footer>Copyright Mike	</footer></center> -->
</div>
</div>
</div>
</body>
</html>