<?php include 'header/header.php'; ?>
<?php if (send_email("neagu.mihai91@gmail.com","Email test","Congratulations, you have succesfully sent an email !"))
		echo 'Email sent succesfuly!';
		else
		put_error ('Email not sent !');
	//	echo "Eroare !"; ?>
<?php include 'footer/footer.php'; ?>