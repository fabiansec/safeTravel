<?php

use PHPMailer\PHPMailer\PHPMailer;

require './scripts/PHPMailer/src/PHPMailer.php';
require './scripts/PHPMailer/src/SMTP.php';
require './scripts/PHPMailer/src/Exception.php';


class registroControlador extends CControlador
{


	public function accionLogin()
	{
		

		$registro = new Login();
		$nombre = $registro->getNombre();

		// if(isset($_POST['id_1'])){
		// 	if(isset($_SESSION['accion'])){
		// 		Sistema::app()->irAPagina($_SESSION['accion'],[]);
		// 		exit;

		// 	}else{
		// 		Sistema::app()->irAPagina(array('inicial'),[]);
		// 		exit;

		// 	}
		// }

		if (isset($_POST['id_0'])) {
			if (isset($_POST[$nombre])) {
				$registro->setValores($_POST[$nombre]);

				if ($registro->validar()) {

						
					

					$nick = CGeneral::addSlashes($_POST['log']['nick']);
					$cod = Sistema::app()->ACL()->getCodUsuario($nick);
					$nombre = Sistema::app()->ACL()->getNombre($cod);
					$permisos = Sistema::app()->ACL()->getPermisos($cod);
					$borrado = Sistema::app()->ACL()->getBorrado($cod);
					$acceso =  Sistema::app()->Acceso();

					if ($borrado === true) {
						Sistema::app()->paginaError(404, 'El usuario esta borrado');
						exit;
					}

					$aceptado = $acceso->registrarUsuario($nick, $nombre, $permisos);

					if ($aceptado === true) {
						$_SESSION['login_success'] = true;
						if(isset($_SESSION['accion'])){
							Sistema::app()->irAPagina($_SESSION['accion'],[]);
							exit;
						}
						Sistema::app()->irAPagina(array('inicial'), []);
						exit;
					} else {
						Sistema::app()->paginaError(404, 'No se ha podido registrar el usuario');
						exit;
					}
				}
			}
		}

		$this->dibujaVista(
			"login",
			['modelo' => $registro],
			"Login"
		);
	}

	public function accionCerrar()
	{

		if (Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->Acceso()->quitarRegistroUsuario();
			Sistema::app()->irAPagina(array('registro', 'login'));
		}
	}


	public function accionRegistrarse()
	{



		$registro = new Registro();
		$nombre = $registro->getNombre();
		$aceptado = false;
		$acceso =  Sistema::app()->Acceso();



		if (isset($_POST['id_0'])) {
			if (isset($_POST[$nombre])) {
				$registro->setValores($_POST[$nombre]);
				$nick = CGeneral::addSlashes($_POST['reg']['nick']);
				$contrasena = CGeneral::addSlashes($_POST['reg']['contrasenia']);


				if ($registro->validar()) { //valido

					//Valido que no hay ningun usuario con ese nick o con ese email
					if ($registro->validaUsuario()) {
						$registro->guardar(); //inserto en la tabla usuarios

						$aceptado = Sistema::app()->ACL()->anadirUsuario($nick, $contrasena, 1);
						$nick = CGeneral::addSlashes($_POST['reg']['nick']);
						$cod = Sistema::app()->ACL()->getCodUsuario($nick);
						$nombre = Sistema::app()->ACL()->getNombre($cod);
						$permisos = Sistema::app()->ACL()->getPermisos($cod);
						$acceso->registrarUsuario($nick, $nombre, $permisos);


						//-------------MANDAR CORREO--------------------
						$email = CGeneral::addSlashes($_POST['reg']['email']);

						$mail = new PHPMailer();
						$mail->isSMTP();
						$mail->SMTPAuth = true;

						//$mail->SMTPDebug = 2;
						$mail->Host = 'smtp.gmail.com';
						$mail->Port = 587;
						$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
						$mail->CharSet = 'UTF-8';
						$mail->Username = 'billetesseguros@gmail.com';
						$mail->Password   = 'fufc ddrc yore hoas';                               //SMTP password
						$mail->setFrom('billetesseguros@gmail.com', 'SafeTravel');
						$mail->addAddress($email, 'Safetravel');
						$mail->Subject = '¡Bienvenido a SaveTravel!';
						$mail->Body = '
										<html>
											<head>
											<h1>¡Hola '.$nick.'!</h1></head>
											<body>
											<p><strong>¡Es un placer darte la bienvenida a SaveTravel, tu nuevo compañero de viajes en línea!</strong> Estamos emocionados de tenerte a bordo y de que comiences a explorar todas las emocionantes opciones que tenemos para ofrecerte.</p>
											<p>En SaveTravel, nos esforzamos por brindarte una experiencia de viaje sin complicaciones y llena de comodidad. Ya sea que estés planeando un viaje de negocios rápido o una aventura relajante de fin de semana, estamos aquí para hacer que tu experiencia de reserva de billetes de tren sea lo más fluida y placentera posible.</p>
											<p><strong>¡No dudes en explorar nuestra amplia selección de destinos y horarios de tren, y descubre cómo podemos hacer que tus viajes sean aún más increíbles!</strong> Además, recuerda que estamos aquí para ayudarte en cada paso del camino. Si tienes alguna pregunta o necesitas asistencia, nuestro equipo de atención al cliente estará encantado de ayudarte en todo lo que necesites.</p>
											<p>¡Gracias por confiar en SaveTravel para tus necesidades de viaje! Estamos ansiosos por acompañarte en tus próximas aventuras.</p>
											<h2>Saludos cordiales.</h2>
											<h2>El equipo de <strong>SaveTravel.</strong></h2>
                                        
										</body>
				
										</html>';
						$mail->IsHTML(true);


						$mail->send();




						if ($aceptado === true) {
							$_SESSION['registrar'] = true;

							Sistema::app()->irAPagina(array('inicial'), []);
							exit;
						} else {
							Sistema::app()->paginaError(404, 'No se ha podido registrar el usuario');
							exit;
						}

						
					}
				}
			}
		}

		$this->dibujaVista(
			"registrarse",
			['modelo' => $registro],
			"Registrarse"
		);
	}
}
