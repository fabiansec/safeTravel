<?php

$config = array(
	"CONTROLADOR" => array("inicial"),
	"RUTAS_INCLUDE" => array("aplicacion/modelos","aplicacion/clases"),
	"URL_AMIGABLES" => true,
	"VARIABLES" => array(
		"autor" => " Fabián España ",
		"direccion" => " Madrid, Madrid ",
		"cookie" => '',
		'sesion' => ''
	
	),
	"BD" => array(
		"hay" => true,
		"servidor" => "tusdatos",
		"usuario" => "tusdatos",
		"contra" => "tusdatos",
		"basedatos" => "tusdatos"
	),
	"sesion" => array(
		"controlAutomatico" => true,
	),
	"ACL"=>array("controlAutomatico"=>true)
);
