<?php

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
	
	$qrcode = new QRcode(utf8_encode($msg), $err);
	$qrcode->disableBorder();
	$qrcode->displayPNG(200);
