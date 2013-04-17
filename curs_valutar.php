<?php include 'header/header.php'; 
	$UserAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.7 (KHTML, like Gecko) RockMelt/0.16.91.483 Chrome/16.0.912.77 Safari/535.7";
	$opts = array ('http' => array ('header' => $UserAgent));
	$context = stream_context_create($opts);

	$header = file_get_contents("http://www.cursbnr.ro/",false,$context);
	$oferta = explode('<table width="100%" border="0" cellspacing="1" cellpadding="0" id="tabel_valute">', $header)[1];
	$oferta = explode('</table>', $oferta)[0];

	echo '<h3>Curs valutar</h3><br/>';
	echo '<table width="100%" border="0" cellspacing="1" cellpadding="0" id="tabel_valute">' . $oferta . '</table>';
	echo '<label>Sursa: <a href = "http://www.cursbnr.ro/">BNR</a></label>';

?>
<?php include 'footer/footer.php'; ?>