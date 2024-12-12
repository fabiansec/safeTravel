<?php

/*
/*
 * Faster and clean QRcode
 * 
 * Generar codigo QR de forma rapida y limpia, con opciones para usar en PDF con FPDF, PNG y HTML.
 * 
 * RÁPIDO Y LIMPIO:
 * 
 * Esta clase permite ser utilizada en proyectos donde se tienen que generar miles de codigos QR en el mejor tiempo
 * y de la manera más limpia sin perjudicar los recursos.
 * 
 * OPCIONES DE VISUALIZACIÓN:
 * 
 *    -  Permite visualizar el código QR en un pdf a través de FPDF.
 *    -  Permite mostrar el código QR en formato HTML, para usar con un estilo CSS.
 *    -  Permite obtener una imagen PNG con opciones de compresión.
 *    -  Puede ser llamado desde plantillas HTML con variables GET
 * 
 * GNU GENERAL PUBLIC LICENSE
 * 
 * Created by: 	Hector Manuel Alonso Ortiz
 * eMail: 		alonso.hector@gmail.com
 * Github: 		https://github.com/alonsohector/
 * 
 */
 
/* Faster and clean QRcode  */

	$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
	if (!$msg) $msg = "Github de Hector Alonso \r\nhttps://github.com/alonsohector/";

	$err = isset($_GET['err']) ? $_GET['err'] : '';
	if (!in_array($err, array('L', 'M', 'Q', 'H'))) $err = 'L';

	require_once('qrcode.class.php');
?>

<html>
	<head>
		<title>Faster and clean QRcode <?php echo __CLASS_QRCODE__; ?></title>
		<meta name="Title"			content="Faster and clean QRcode <?php echo __CLASS_QRCODE__; ?>" > 
		<meta name="Description"	content="Faster and clean QRcode <?php echo __CLASS_QRCODE__; ?>" >
		<meta name="Keywords"		content="Faster and clean QRcode">
		<meta name="Author"			content="Hector Alonso" >
		<meta name="Reply-to"		content="alonso.hector@gmail.com" >
		<meta http-equiv="Content-Type"	content="text/html; charset=windows-1252" >
		<style type="text/css">
<!--
table.qr
{
	border-collapse: collapse;
	border: solid 1px black;
	table-layout: fixed;
}

table.qr td
{
	width: 5px;
	height: 5px;
	font-size: 2px;
}

table.qr td.on
{
	background: #000999;
}
-->
		</style>	
	</head>
	<body>
		<center>
			<b1>Faster and clean QRcode</b1>
			<form method="GET" action="">
				<textarea name="msg" cols="40" rows="7"><?php echo htmlentities($msg); ?></textarea><br>
				Correcci&oacute;n de errores : 
				<select name="err">
					<option value="L" <?php echo $err=='L' ? 'selected' : ''; ?>>L</option>
					<option value="M" <?php echo $err=='M' ? 'selected' : ''; ?>>M</option>
					<option value="Q" <?php echo $err=='Q' ? 'selected' : ''; ?>>Q</option>
					<option value="H" <?php echo $err=='H' ? 'selected' : ''; ?>>H</option>
				</select> | 
				<input type="submit" value="Enviar">
			</form>
			<hr>
			<br>
			Generando una tabla HTML :<br> 
			<?php
				$qrcode = new QRcode(utf8_encode($msg), $err);
				$qrcode->displayHTML();
			?>
			<br>
			Generando una imagen PNG : <br>
			<img src="./image.php?msg=<?php echo urlencode($msg); ?>&amp;err=<?php echo urlencode($err); ?>" alt="generation qr-code" style="border: solid 1px black;">
		</center>
	</body>
</html>
