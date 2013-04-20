<?php
include 'header/init.php';
redirect_if_logged_out();
if (empty($tranzactii_user)) header("Location: index.php");
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Magazin Online');
$pdf->SetTitle('Factura client <Nume client>');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('Factura, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

//Informatiile utilizatorului care vor aparea pe factura

//Generez numarul de factura
$id_factura = 0;
foreach ($tranzactii_user as $tranzactie)
	$id_factura += $tranzactie;
$id_factura *= $user_data['user_id'];


$produse_tabel = '';
$nr = 0;
$pret_total = 0;
$result = mysql_query("select products.id_product from products 
		join tranzactii on tranzactii.product_id = products.id_product
        join users on tranzactii.user_id = users.user_id
where users.user_id = " . $user_data['user_id']);
$produse_user_id = array();
while ($produse_user_id = mysql_fetch_array($result)){

	//Populez tabelul cu produse
	$produs_user = mysql_fetch_assoc(mysql_query("select * from products where id_product = " . $produse_user_id[0]));

	$produs_user['quantity'] = mysql_fetch_assoc(mysql_query("select tranzactii.quantity from products 
		join tranzactii on tranzactii.product_id = products.id_product
        join users on tranzactii.user_id = users.user_id
		where users.user_id = " . $user_data['user_id'] . " and product_id = " . $produs_user['id_product']))['quantity'];

		$pret_total += $produs_user['quantity'] * $produs_user['price'];
		$nr++;
		$produse_tabel .= 
		'<tr>
			<td>'.$nr.'</td>
			<td colspan = "3">'.$produs_user['name'].'</td>
			<td>'.$produs_user['quantity'].'</td>
			<td>'.$produs_user['price'].'</td>
		</tr>';
}

// create some HTML content
$html = '<h1>Factura Online Store</h1></br><h4>Nr. '. $id_factura .'</h4>';
$html .= '<table>
			<tr>
				<td><b>Cumparator:</b></td>
				<td>'.$user_data['last_name'].' '.$user_data['first_name'].'</td>
			</tr>
			<tr>
				<td><b>Email:</b></td>
				<td>'.$user_data['email'].'</td>
			</tr>
		 </table><br/><br/>';
$html .= '<table border = "1" cellspacing="3" cellpadding="4">
			<tr>
				<th>Nr.crt.</th>
				<th colspan = "3">Denumire produs</th>
				<th>Cantitate</th>
				<th>Pret unitar</th>
			</tr>'
			.$produse_tabel.
		'</table></br></br></br>	Intocmit de: <br/>Garantie:<br/>';
$html .= '<table>
			<tr>
				<th>Semnatura si stampila furnizorului</th>
				<th>Semnatura de primire</th>
				<th>Total de plata</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>'.$pret_total.' RON</td>
			</tr>
		</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



//Close and output PDF document
$pdf->Output('factura_magazin_online.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
