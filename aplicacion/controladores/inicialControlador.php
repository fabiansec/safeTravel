<?php
//require_once('./scripts/Qrcode/QRCode.php'); // Carga la biblioteca QR Code
require_once('./scripts/phpqrcode/qrlib.php'); // Carga la biblioteca QR Code
use PHPMailer\PHPMailer\PHPMailer;

require './scripts/PHPMailer/src/PHPMailer.php';
require './scripts/PHPMailer/src/SMTP.php';
require './scripts/PHPMailer/src/Exception.php';

class inicialControlador extends CControlador
{

	function __construct()
	{
	}

	public function accionIndex()
	{

		$nick = '';
		if (Sistema::app()->Acceso()->hayUsuario()) {
			$nick = Sistema::app()->Acceso()->getNick();
		}



		$mostrarToast = false;
		if (isset($_SESSION['login_success'])) {
			$mostrarToast = true;
			unset($_SESSION['login_success']); // Eliminar la variable para que el toast no se muestre nuevamente
		}
		$mostrarRegistrar = false;
		if (isset($_SESSION['registrar'])) {
			$mostrarRegistrar = true;
			unset($_SESSION['registrar']); // Eliminar la variable para que el toast no se muestre nuevamente
		}
		//valido formulario y busco los viajes y los muestro en otra accion 
		$tipo = 0;
		$valor = '';
		$erroresOrigen = '';
		$erroresDestino = '';
		$errores = '';
		$codDestino = 0;
		$codOrigen = 0;
		$billete = new Billete();
		$parada = new Paradas();
		$destino = new Paradas();
		$nombre = $billete->getNombre();
		if (isset($_POST['unidades'])) {
			if (intval($_POST['unidades']) === 0) {
				$errores = 'Debes seleccionar una opción';
			} {
				$_SESSION['unidades'] = intval($_POST['unidades']);
			}
		}


		if (isset($_POST[$nombre])) {
			$billete->setValores($_POST[$nombre]);
			//convertir fechas
			if ($billete->fecha_ida != '') {
				$billete->fecha_ida = CGeneral::fechaMysqlANormal($billete->fecha_ida);
			}
			if ($billete->fecha_vuelta != '') {
				$billete->fecha_vuelta = CGeneral::fechaMysqlANormal($billete->fecha_vuelta);
			}

			//si selecciona solo ida , la fecha vuelta es o el mismo dia.
			if (isset($_POST['tipoViaje'])) {
				$tipo = intval($_POST['tipoViaje']);

				if ($tipo === 0) { //si selecciona ida , en la vuelta le pongo la misma fecha
					$billete->fecha_vuelta = '31/12/6000'; //pongo en la vuelta una fecha valida para poder validar
				}
			}



			//recoger nombres de paradas, validar si estan en la bd, recoger el id.
			//valido el origen con el modelo
			$nombreParada = $parada->getNombre();
			if (isset($_POST[$nombreParada])) {
				$parada->setValores($_POST[$nombreParada]);
				$origen = CGeneral::addSlashes($parada->nombre);
				$filaOrigen = $parada->buscarPor(array('where' => "nombre = '$origen'"));

				if ($filaOrigen != false) {
					$codOrigen = $parada->cod_parada;
				} else {
					$erroresOrigen = 'Esta parada no existe';
				}
			}
			//validar destino
			if (isset($_POST['destino'])) {
				$nombreDestino = CGeneral::addSlashes($_POST['destino']);
				$filasDestino = $destino->buscarPor(array('where' => "nombre ='$nombreDestino'"));
				if ($filasDestino != false) {
					$codDestino = $destino->cod_parada;
				} else {
					$erroresDestino = 'Esta parada no existe';
				}

				$valor = $nombreDestino;
			}

			$billete->cod_parada_destino = $codDestino;
			$billete->cod_parada_origen = $codOrigen;
			$billete->cod_tarifa = 32;
			$billete->fecha_nac = '12/01/2000';
			$billete->telefono  = '000000000';
			$billete->dni = '12345678Z';
			if ($billete->validar()) {

				$nuevoBillete = new Billete();

				// Guardar el nuevo modelo de billete en la sesión
				$_SESSION['billete'] = $nuevoBillete;

				// Asignar los valores del billete actual al nuevo billete
				$_SESSION['billete'] = $billete;
				$_SESSION['num'] = $billete->unidades;
				// Continuar con el proceso y redirigir a la página de búsqueda de viaje
				$_SESSION['tipoViaje'] = $tipo;
				if ($errores === '') {
					Sistema::app()->irAPagina(array("inicial", "buscarViaje"));
					exit;
				}
			}
		}



		$this->dibujaVista(
			"index",
			['registrar' => $mostrarRegistrar, 'nick' => $nick, 'mostrarToast' => $mostrarToast, 'destino' => $destino, 'modelo' => $billete, 'parada' => $parada, 'erroresOrigen' => $erroresOrigen, 'erroresDestino' => $erroresDestino, 'valor' => $valor, 'errores' => $errores],
			"Inicio"
		);
	}

	public function accionBuscarViaje()
	{
		$billete = '';
		$tipo = '';
		$tarifas = new Tarifas();
		$complementos = new Complementos();
		$viajesVuelta = [];

		if (isset($_SESSION['billete'])) {
			$billete = $_SESSION['billete'];

			if (isset($_SESSION['tipoViaje'])) {
				$tipo = intval($_SESSION['tipoViaje']);
			}

			// Buscar viajes de ida
			$fechaIda = CGeneral::fechaNormalAMysql($billete->fecha_ida);
			$viaje = new Viajes();
			$viajesIda = $viaje->buscarTodos([
				'select' => 't.cod_viaje,
					t.hora_salida,
					t.fecha,
					tr.cod_trayecto,
					po.nombre AS nombre_origen,
					pd.nombre AS nombre_destino,
					pt.orden AS orden_origen,
					pt2.orden AS orden_destino,
					pt.cod_parada AS origen,
					pt2.cod_parada AS destino,
					GROUP_CONCAT(pi.nombre ORDER BY p_intermedio.orden SEPARATOR " -> ") AS paradas,
					SUM(p_intermedio.precio) AS precio_base,
					SUM(p_intermedio.tiempo + p_intermedio.tiempo_estacion) AS tiempo_total',
				'from' => 'INNER JOIN trayectos tr ON tr.cod_trayecto = t.cod_trayecto
				   INNER JOIN paradas_trayectos pt ON pt.cod_trayecto = tr.cod_trayecto
				   INNER JOIN paradas po ON pt.cod_parada = po.cod_parada
				   INNER JOIN paradas_trayectos pt2 ON pt2.cod_trayecto = tr.cod_trayecto
				   INNER JOIN paradas pd ON pt2.cod_parada = pd.cod_parada
				   INNER JOIN paradas_trayectos p_intermedio ON p_intermedio.cod_trayecto = tr.cod_trayecto
				   INNER JOIN paradas pi ON p_intermedio.cod_parada = pi.cod_parada',
				'where' => 'pt.cod_parada = ' . $billete->cod_parada_origen . '
				AND pt2.cod_parada = ' . $billete->cod_parada_destino . '
				AND pt.orden < pt2.orden
				AND p_intermedio.orden >= pt.orden
				AND p_intermedio.orden <= pt2.orden
				AND t.borrado = 0
				AND t.fecha = "' . $fechaIda . '"',
				'group' => 't.cod_viaje, tr.cod_trayecto, pt.cod_parada, pt.orden, pt2.cod_parada, pt2.orden, po.nombre, pd.nombre',
				'order' => 't.hora_salida ASC'
			]);

			if (count($viajesIda) > 0) {
				$todasTarifas = $tarifas->buscarTodos([
					'select' => 't.cod_tarifa, t.nombre AS nombre_tarifa, t.precio, co.nombre AS nombre_complemento',
					'from' => 'INNER JOIN tarifa_complemento AS tc ON t.cod_tarifa = tc.cod_tarifa
							   INNER JOIN complemento AS co ON tc.cod_complemento = co.cod_complemento',
					'where' => 'borrado = 0'
				
				]);

				$tarifasArray = [];
				foreach ($todasTarifas as $fila) {
					$nombreTarifa = $fila['nombre_tarifa'];
					$nombreComplemento = $fila['nombre_complemento'];
					$precioTarifa = $fila['precio'];
					$codTarifa = $fila['cod_tarifa'];

					if (!isset($tarifasArray[$nombreTarifa])) {
						$tarifasArray[$nombreTarifa] = [
							'precio' => $precioTarifa,
							'complementos' => [],
							'cod_tarifa' => $codTarifa
						];
					}

					if (!in_array($nombreComplemento, $tarifasArray[$nombreTarifa]['complementos'])) {
						$tarifasArray[$nombreTarifa]['complementos'][] = $nombreComplemento;
					}
				}

				// Obtener la fecha y hora actuales
				$fechaActual = new DateTime();
				$horaActual = $fechaActual->format('H:i:s');
				$fechaActualStr = $fechaActual->format('Y-m-d');

				foreach ($viajesIda as $ind => $fila) {
					if ($fila['fecha'] == $fechaActualStr && $fila['hora_salida'] < $horaActual) {
						// Eliminar el viaje del array
						unset($viajesIda[$ind]);
					} else {
						$precioBase = intval($fila['precio_base']) + (intval($fila['precio_base']) * ($billete->iva / 100));
						foreach ($tarifasArray as $nombreTarifa => $datosTarifa) {
							$codTarifa = $datosTarifa['cod_tarifa'];
							$viajesIda[$ind]['tarifas'][$nombreTarifa] = [
								'precio' => $precioBase + $datosTarifa['precio'],
								'complementos' => $datosTarifa['complementos'],
								'cod_tarifa' => $codTarifa
							];
						}

						$billete->precio_base = $precioBase;

						$horaLle = new Viajes();
						$horasL  = $horaLle->buscarTodos(array(
							'select' => 'p.nombre,
                 			(pt.tiempo + pt.tiempo_estacion) AS tiempo_total',
							'from' => 'INNER JOIN trayectos tr ON tr.cod_trayecto = t.cod_trayecto
									INNER JOIN paradas_trayectos pt ON tr.cod_trayecto = pt.cod_trayecto
									INNER JOIN paradas p ON pt.cod_parada = p.cod_parada
									INNER JOIN paradas_trayectos po ON po.cod_trayecto = tr.cod_trayecto AND po.cod_parada = '.$billete->cod_parada_destino,
							'where' => 'cod_viaje = '.$fila['cod_viaje'].'
										AND t.fecha = "'.$fila['fecha'].'"
										AND pt.orden <= po.orden',
							'order' => 'pt.orden ASC;'
						));

						$tiempoL = $horasL;
						$tiempoCalcL = 0;
						foreach($tiempoL as $indiceL => $propL){
							$tiempoCalcL = $tiempoCalcL + floatval($propL['tiempo_total']);

						}

						$tiempoSalidaStringL = "".$tiempoCalcL."";
						if($tiempoSalidaStringL !== '0'){
							if (strlen($tiempoSalidaStringL) === 6) {
								$horasL = intval(substr($tiempoSalidaStringL, 0, 2));
								$minutosL = intval(substr($tiempoSalidaStringL, 2, 2));
								$segundosL = intval(substr($tiempoSalidaStringL, 4, 2));
							} elseif (strlen($tiempoSalidaStringL) === 5) {
								$horasL = 0;
								$minutosL = intval(substr($tiempoSalidaStringL, 0, 1));
								$horasL = intval(substr($tiempoSalidaStringL, 1, 2));
							} elseif (strlen($tiempoSalidaStringL) === 4) {
								$horasL = 0;
								$minutosL = intval(substr($tiempoSalidaStringL, 0, 2));
								$segundosL = intval(substr($tiempoSalidaStringL, 2, 2));
							}
	
							$horaSalidaDateTimeL = new DateTime($fila['hora_salida']);
							$intervaloL = new DateInterval("PT{$horasL}H{$minutosL}M{$segundosL}S");
							$horaSalidaDateTimeL->add($intervaloL);
							$horaLlegada = $horaSalidaDateTimeL->format('H:i:s');
							$viajesIda[$ind]['hora_llegada'] = $horaLlegada;
						}else{
							$viajesIda[$ind]['hora_llegada'] = $fila['hora_salida'];

						}
						


						//Calcular hora_salida 

						$horaSal = new Viajes();
						$horaSa  = $horaSal->buscarTodos(array(
							'select' => 'p.nombre,
                 			(pt.tiempo + pt.tiempo_estacion) AS tiempo_total',
							'from' => 'INNER JOIN trayectos tr ON tr.cod_trayecto = t.cod_trayecto
									INNER JOIN paradas_trayectos pt ON tr.cod_trayecto = pt.cod_trayecto
									INNER JOIN paradas p ON pt.cod_parada = p.cod_parada
									INNER JOIN paradas_trayectos po ON po.cod_trayecto = tr.cod_trayecto AND po.cod_parada = '.$billete->cod_parada_origen,
							'where' => '
										cod_viaje = '.intval($fila['cod_viaje']).'
										AND t.fecha = "'.$fila['fecha'].'"
										AND pt.orden <= po.orden',
							'order' => 'pt.orden ASC;'
						));

						$tiempo = $horaSa;
						$tiempoCalc = 0;
						foreach($tiempo as $indice => $prop){
							$tiempoCalc = $tiempoCalc + floatval($prop['tiempo_total']);

						}

						$tiempoSalidaString = "".$tiempoCalc."";
						if($tiempoSalidaString !== '0'){
							if (strlen($tiempoSalidaString) === 6) {
								$horas = intval(substr($tiempoSalidaString, 0, 2));
								$minutos = intval(substr($tiempoSalidaString, 2, 2));
								$segundos = intval(substr($tiempoSalidaString, 4, 2));
							} elseif (strlen($tiempoSalidaString) === 5) {
								$horas = 0;
								$minutos = intval(substr($tiempoSalidaString, 0, 1));
								$segundos = intval(substr($tiempoSalidaString, 1, 2));
							} elseif (strlen($tiempoSalidaString) === 4) {
								$horas = 0;
								$minutos = intval(substr($tiempoSalidaString, 0, 2));
								$segundos = intval(substr($tiempoSalidaString, 2, 2));
							}
	
							$horaSalidaDateTime = new DateTime($fila['hora_salida']);
							$intervalo = new DateInterval("PT{$horas}H{$minutos}M{$segundos}S");
							$horaSalidaDateTime->add($intervalo);
							$horaSalida = $horaSalidaDateTime->format('H:i:s');
							$viajesIda[$ind]['hora_salida'] = $horaSalida;
						}else{
							$viajesIda[$ind]['hora_salida'] = $fila['hora_salida'];

						}
						

					}
				}

				$filasComp = $complementos->buscarTodos();
				$codTarifaSelect = 0;
				$codViajeSelect = 0;
				$precio = 0;

				if (isset($_POST['id_0'])) {
					if (isset($_POST['cod_tarifa'])) {
						$codTarifaSelect = intval($_POST['cod_tarifa']);
						$billete->cod_tarifa = $codTarifaSelect;
					}
					if (isset($_POST['cod_viaje'])) {
						$codViajeSelect = intval($_POST['cod_viaje']);
						$billete->cod_viaje = $codViajeSelect;
					}
					if (isset($_POST['precio'])) {
						$precioSelect = floatval($_POST['precio']);
						$billete->precio_billete = $precioSelect;
					}

					if ($billete->validar()) {
						$_SESSION['billeteAct'] = $billete;
						if ($tipo === 1) {
							Sistema::app()->irAPagina(array("inicial", "buscarVuelta"));
							exit;
						} else {
							Sistema::app()->irAPagina(array("inicial", "rellenaDatos"));
							exit;
						}
					}
				}


				// Mostrar la vista de selección de viajes de ida
				$this->dibujaVista(
					"buscarIda",
					[
						'viajesIda' => $viajesIda,
						'complementos' => $filasComp
					],
					"Buscar Viaje"
				);
			} else {
				Sistema::app()->paginaError(404, 'No hay viajes disponibles');
				exit;
			}
		} else {
			Sistema::app()->paginaError(404, 'Debes introducir los datos');
			exit;
		}
	}

	public function accionBuscarVuelta()
	{
		$billete = '';
		$tipo = '';
		$tarifas = new Tarifas();
		$complementos = new Complementos();
		$viajesVuelta = [];

		if (isset($_SESSION['billete'])) {
			$billete = clone $_SESSION['billete']; // Clonar el objeto billete de la sesión


			// Buscar viajes de vuelta
			$fechaVuelta = CGeneral::fechaNormalAMysql($billete->fecha_vuelta);
			$viaje = new Viajes();
			$viajesVuelta = $viaje->buscarTodos([
				'select' => 't.cod_viaje,
					t.hora_salida,
					t.fecha,
					tr.cod_trayecto,
					po.nombre AS nombre_origen,
					pd.nombre AS nombre_destino,
					pt.orden AS orden_origen,
					pt2.orden AS orden_destino,
					pt.cod_parada AS origen,
					pt2.cod_parada AS destino,
					GROUP_CONCAT(pi.nombre ORDER BY p_intermedio.orden SEPARATOR " -> ") AS paradas,
					SUM(p_intermedio.precio) AS precio_base,
					SUM(p_intermedio.tiempo + p_intermedio.tiempo_estacion) AS tiempo_total',
				'from' => 'INNER JOIN trayectos tr ON tr.cod_trayecto = t.cod_trayecto
				   INNER JOIN paradas_trayectos pt ON pt.cod_trayecto = tr.cod_trayecto
				   INNER JOIN paradas po ON pt.cod_parada = po.cod_parada
				   INNER JOIN paradas_trayectos pt2 ON pt2.cod_trayecto = tr.cod_trayecto
				   INNER JOIN paradas pd ON pt2.cod_parada = pd.cod_parada
				   INNER JOIN paradas_trayectos p_intermedio ON p_intermedio.cod_trayecto = tr.cod_trayecto
				   INNER JOIN paradas pi ON p_intermedio.cod_parada = pi.cod_parada',
				'where' => 'pt.cod_parada = ' . $billete->cod_parada_destino . '
				AND pt2.cod_parada = ' . $billete->cod_parada_origen . '
				AND pt.orden < pt2.orden
				AND p_intermedio.orden >= pt.orden
				AND p_intermedio.orden <= pt2.orden
				AND t.fecha = "' . $fechaVuelta . '"',
				'group' => 't.cod_viaje, tr.cod_trayecto, pt.cod_parada, pt.orden, pt2.cod_parada, pt2.orden, po.nombre, pd.nombre',
				'order' => 't.hora_salida ASC'
			]);

			if (count($viajesVuelta) > 0) {
				$todasTarifas = $tarifas->buscarTodos([
					'select' => 't.cod_tarifa, t.nombre AS nombre_tarifa, t.precio, co.nombre AS nombre_complemento',
					'from' => 'INNER JOIN tarifa_complemento AS tc ON t.cod_tarifa = tc.cod_tarifa
							   INNER JOIN complemento AS co ON tc.cod_complemento = co.cod_complemento',
					'where' => 'borrado = 0'
				]);
				$tarifasArray = [];
				foreach ($todasTarifas as $fila) {
					$nombreTarifa = $fila['nombre_tarifa'];
					$nombreComplemento = $fila['nombre_complemento'];
					$precioTarifa = $fila['precio'];
					$codTarifa = $fila['cod_tarifa'];

					if (!isset($tarifasArray[$nombreTarifa])) {
						$tarifasArray[$nombreTarifa] = [
							'precio' => $precioTarifa,
							'complementos' => [],
							'cod_tarifa' => $codTarifa
						];
					}

					if (!in_array($nombreComplemento, $tarifasArray[$nombreTarifa]['complementos'])) {
						$tarifasArray[$nombreTarifa]['complementos'][] = $nombreComplemento;
					}
				}
				// Obtener la fecha y hora actuales
				$fechaActual = new DateTime();
				$horaActual = $fechaActual->format('H:i:s');
				$fechaActualStr = $fechaActual->format('Y-m-d');

				foreach ($viajesVuelta as $ind => $fila) {
					if ($fila['fecha'] == $fechaActualStr && $fila['hora_salida'] < $horaActual) {
						// Eliminar el viaje del array
						unset($viajesIda[$ind]);
					} else {
						$precioBase = intval($fila['precio_base']) + (intval($fila['precio_base']) * ($billete->iva / 100));
						foreach ($tarifasArray as $nombreTarifa => $datosTarifa) {
							$codTarifa = $datosTarifa['cod_tarifa'];
							$viajesVuelta[$ind]['tarifas'][$nombreTarifa] = [
								'precio' => $precioBase + $datosTarifa['precio'],
								'complementos' => $datosTarifa['complementos'],
								'cod_tarifa' => $codTarifa
							];
						}

						$billete->precio_base = $precioBase;

						$horaLle = new Viajes();
						$horasL  = $horaLle->buscarTodos(array(
							'select' => 'p.nombre,
                 			(pt.tiempo + pt.tiempo_estacion) AS tiempo_total',
							'from' => 'INNER JOIN trayectos tr ON tr.cod_trayecto = t.cod_trayecto
									INNER JOIN paradas_trayectos pt ON tr.cod_trayecto = pt.cod_trayecto
									INNER JOIN paradas p ON pt.cod_parada = p.cod_parada
									INNER JOIN paradas_trayectos po ON po.cod_trayecto = tr.cod_trayecto AND po.cod_parada = '.$billete->cod_parada_destino,
							'where' => 'cod_viaje = '.$fila['cod_viaje'].'
										AND t.fecha = "'.$fila['fecha'].'"
										AND pt.orden <= po.orden',
							'order' => 'pt.orden ASC;'
						));

						$tiempoL = $horasL;
						$tiempoCalcL = 0;
						foreach($tiempoL as $indiceL => $propL){
							$tiempoCalcL = $tiempoCalcL + floatval($propL['tiempo_total']);

						}

						$tiempoSalidaStringL = "".$tiempoCalcL."";
						if($tiempoSalidaStringL !== '0'){
							if (strlen($tiempoSalidaStringL) === 6) {
								$horasL = intval(substr($tiempoSalidaStringL, 0, 2));
								$minutosL = intval(substr($tiempoSalidaStringL, 2, 2));
								$segundosL = intval(substr($tiempoSalidaStringL, 4, 2));
							} elseif (strlen($tiempoSalidaStringL) === 5) {
								$horasL = 0;
								$minutosL = intval(substr($tiempoSalidaStringL, 0, 1));
								$horasL = intval(substr($tiempoSalidaStringL, 1, 2));
							} elseif (strlen($tiempoSalidaStringL) === 4) {
								$horasL = 0;
								$minutosL = intval(substr($tiempoSalidaStringL, 0, 2));
								$segundosL = intval(substr($tiempoSalidaStringL, 2, 2));
							}
	
							$horaSalidaDateTimeL = new DateTime($fila['hora_salida']);
							$intervaloL = new DateInterval("PT{$horasL}H{$minutosL}M{$segundosL}S");
							$horaSalidaDateTimeL->add($intervaloL);
							$horaLlegada = $horaSalidaDateTimeL->format('H:i:s');
							$viajesVuelta[$ind]['hora_salida'] = $horaLlegada;
						}else{
							$viajesVuelta[$ind]['hora_llegada'] = $fila['hora_salida'];

						}
						


						//Calcular hora_salida 

						$horaSal = new Viajes();
						$horaSa  = $horaSal->buscarTodos(array(
							'select' => 'p.nombre,
                 			(pt.tiempo + pt.tiempo_estacion) AS tiempo_total',
							'from' => 'INNER JOIN trayectos tr ON tr.cod_trayecto = t.cod_trayecto
									INNER JOIN paradas_trayectos pt ON tr.cod_trayecto = pt.cod_trayecto
									INNER JOIN paradas p ON pt.cod_parada = p.cod_parada
									INNER JOIN paradas_trayectos po ON po.cod_trayecto = tr.cod_trayecto AND po.cod_parada = '.$billete->cod_parada_origen,
							'where' => '
										cod_viaje = '.intval($fila['cod_viaje']).'
										AND t.fecha = "'.$fila['fecha'].'"
										AND pt.orden <= po.orden',
							'order' => 'pt.orden ASC;'
						));

						$tiempo = $horaSa;
						$tiempoCalc = 0;
						foreach($tiempo as $indice => $prop){
							$tiempoCalc = $tiempoCalc + floatval($prop['tiempo_total']);

						}

						$tiempoSalidaString = "".$tiempoCalc."";
						if($tiempoSalidaString !== '0'){
							if (strlen($tiempoSalidaString) === 6) {
								$horas = intval(substr($tiempoSalidaString, 0, 2));
								$minutos = intval(substr($tiempoSalidaString, 2, 2));
								$segundos = intval(substr($tiempoSalidaString, 4, 2));
							} elseif (strlen($tiempoSalidaString) === 5) {
								$horas = 0;
								$minutos = intval(substr($tiempoSalidaString, 0, 1));
								$segundos = intval(substr($tiempoSalidaString, 1, 2));
							} elseif (strlen($tiempoSalidaString) === 4) {
								$horas = 0;
								$minutos = intval(substr($tiempoSalidaString, 0, 2));
								$segundos = intval(substr($tiempoSalidaString, 2, 2));
							}
	
							$horaSalidaDateTime = new DateTime($fila['hora_salida']);
							$intervalo = new DateInterval("PT{$horas}H{$minutos}M{$segundos}S");
							$horaSalidaDateTime->add($intervalo);
							$horaSalida = $horaSalidaDateTime->format('H:i:s');
							$viajesVuelta[$ind]['hora_llegada'] = $horaSalida;
						}else{
							$viajesVuelta[$ind]['hora_salida'] = $fila['hora_salida'];

						}
						
						

					}
				}

				// Mostrar la vista de selección de viajes de vuelta
				if (isset($_POST['id_0'])) {
					if (isset($_POST['cod_tarifa'])) {
						$codTarifaSelect = intval($_POST['cod_tarifa']);
						$billete->cod_tarifa = $codTarifaSelect;
					}
					if (isset($_POST['cod_viaje'])) {
						$codViajeSelect = intval($_POST['cod_viaje']);
						$billete->cod_viaje = $codViajeSelect;
					}
					if (isset($_POST['precio'])) {
						$precioSelect = floatval($_POST['precio']);
						$billete->precio_billete = $precioSelect;
					}
					$origen = $billete->cod_parada_destino;
					$destino = $billete->cod_parada_origen;
					$billete->cod_parada_origen = $origen;
					$billete->cod_parada_destino = $destino;
					$billete->guardar();

					if ($billete->validar()) {
						$_SESSION['billeteVuelta'] = $billete;
						Sistema::app()->irAPagina(array("inicial", "rellenaDatos"));
					}
				}


				$filasComp = $complementos->buscarTodos();
				$codTarifaSelect = 0;
				$codViajeSelect = 0;
				$precio = 0;


				$this->dibujaVista(
					"buscarVuelta",
					[
						'viajesIda' => $viajesVuelta,
						'complementos' => $filasComp
					],
					"Buscar Viaje de Vuelta"
				);
				exit;
			} else {
				Sistema::app()->paginaError(404, 'No hay viajes disponibles para la fecha de vuelta');
				exit;
			}
		}
	}

	public function accionRellenaDatos()
	{
		// Revisar si se ha enviado un formulario para reiniciar
		if (isset($_POST['id_1'])) {
			// Resetear datos de la sesión
			unset($_SESSION['billeteAct']);
			unset($_SESSION['billeteIndex']);
			unset($_SESSION['vueltaIndex']);
			unset($_SESSION['todosBilletes']);
			unset($_SESSION['todosBilletesIda']);
			unset($_SESSION['todosBilletesVuelta']);
			unset($_SESSION['billeteVuelta']);
			Sistema::app()->irAPagina(['inicial']);
			exit;
		}

		// Verificar si hay un billete en la sesión
		if (isset($_SESSION['billeteAct'])) {
			$billeteAct = $_SESSION['billeteAct'];
			if(isset($_SESSION['unidades'])){
				if($_SESSION['unidades'] === 0){
					Sistema::app()->paginaError(404, 'Debes realizar todo el proceso anterior');
					exit;
				}else{
					$numBilletes = $_SESSION['unidades'];
				}
			}
			$nombreBillete = $billeteAct->getNombre();

			// Inicializar el índice de billetes si no está definido
			if (!isset($_SESSION['billeteIndex'])) {
				$_SESSION['billeteIndex'] = 0;
			}

			$currentIndex = $_SESSION['billeteIndex'];

			// Clonar el billete actual para uso en ida
			$billeteIda = clone $billeteAct;

			// Procesar el formulario si se ha enviado
			if (isset($_POST[$nombreBillete])) {
				$billeteIda->nombre = CGeneral::addSlashes($_POST[$nombreBillete]['nombre']);
				$billeteIda->dni =CGeneral::addSlashes($_POST[$nombreBillete]['dni']);
				$billeteIda->telefono = CGeneral::addSlashes($_POST[$nombreBillete]['telefono']);
				$billeteIda->fecha_nac = CGeneral::fechaMysqlANormal($_POST[$nombreBillete]['fecha_nac']);

				// Validar el billete de ida
				if ($billeteIda->validar()) {
					$_SESSION['todosBilletesIda'][] = $billeteIda;
					$currentIndex++;
					$_SESSION['billeteIndex'] = $currentIndex;

					// Procesar billete de vuelta si existe
					if (isset($_SESSION['billeteVuelta'])) {
						$billeteVuelta = clone $_SESSION['billeteVuelta']; // Crear una nueva instancia para vuelta
						$billeteVuelta->nombre = $billeteIda->nombre;
						$billeteVuelta->dni = $billeteIda->dni;
						$billeteVuelta->telefono = $billeteIda->telefono;
						$billeteVuelta->fecha_nac = $billeteIda->fecha_nac;

						// Validar el billete de vuelta
						if ($billeteVuelta->validar()) {
							$_SESSION['todosBilletesVuelta'][] = $billeteVuelta;
						}
					}

					// Verificar si se han completado todos los billetes
					if ($currentIndex >= $numBilletes) {
						$_SESSION['todosBilletes'] = $_SESSION['todosBilletesIda'];

						// Agregar billetes de vuelta si existen
						if (isset($_SESSION['todosBilletesVuelta'])) {
							$_SESSION['todosBilletes'] = array_merge($_SESSION['todosBilletes'], $_SESSION['todosBilletesVuelta']);
						}

						// Limpiar los datos de la sesión
						unset($_SESSION['billeteIndex']);
						unset($_SESSION['todosBilletesIda']);
						unset($_SESSION['todosBilletesVuelta']);
						unset($_SESSION['billeteAct']);
						unset($_SESSION['billeteVuelta']);

						Sistema::app()->irAPagina(['inicial', 'comprar']);
						return;
					}

					// Preparar el siguiente billete
					$billeteIda = clone $billeteAct;
				}
			}

			// Mostrar la vista para rellenar datos
			$this->dibujaVista(
				"rellenaDatos",
				['modelo' => $billeteAct, 'index' => $currentIndex, 'total' => $numBilletes, 'billete' => $billeteIda],
				"Rellena Datos"
			);
		} else {
			Sistema::app()->paginaError(404, 'Debes seleccionar un viaje antes');
			exit;
		}
	}

	public function accionComprar()
	{

		$viaje = new Viajes();
		$trayecto = new Trayectos();
		$compra = new Compras();
		$parada = new Paradas();
		$billetes = [];
		$errores = [];
		$ultimo = 0;
		$origenParada = '';
		$destinoParada = '';
		if (isset($_SESSION['todosBilletes'])) {
			$billetes = $_SESSION['todosBilletes'];
			$todosBillete = [];

			// Añadir los nombres de origen y destino a cada billete
			foreach ($billetes as $indice => $billete) {
				foreach ($billete as $propiedad => $valor) {
					if ($propiedad === 'cod_parada_origen') {
						$origen = $parada->buscarTodos([
							'select' => 'nombre, cod_parada',
							'where' => 'cod_parada = ' . $valor
						]);
						$origenParada = $origen[0]['nombre'];
						$todosBillete[$indice]['origen'] = $origenParada;
						$todosBillete[$indice]['cod_parada_origen'] = $origen[0]['cod_parada'];
					} elseif ($propiedad === 'cod_parada_destino') {
						$destino = $parada->buscarTodos([
							'select' => 'nombre, cod_parada',
							'where' => 'cod_parada = ' . $valor
						]);
						$destinoParada = $destino[0]['nombre'];
						$todosBillete[$indice]['destino'] = $destinoParada;
						$todosBillete[$indice]['cod_parada_destino'] = $destino[0]['cod_parada'];
					} else {
						$todosBillete[$indice][$propiedad] = $valor;
					}
				}
			}


			// Actualizar fecha de vuelta si es necesaria
			foreach ($todosBillete as $indice => $propiedad) {
				if (isset($propiedad['fecha_vuelta']) && $propiedad['fecha_vuelta'] === '31/12/6000') {
					$todosBillete[$indice]['fecha_vuelta'] = $propiedad['fecha_ida'];
				}
			}



			// Manejar eliminación de billetes
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_billete'])) {
				$id = $_POST['id_billete'];
				foreach ($todosBillete as $indice => $propiedad) {
					if (isset($propiedad['nombre']) && $propiedad['nombre'] === $id) {
						unset($todosBillete[$indice]);
					}
				}
				$_SESSION['todosBilletes'] = array_values($todosBillete); // Reindexar el array
				$_SESSION['unidades'] = count($_SESSION['todosBilletes']);
				// Si se eliminan todos los billetes, inicializar como array vacío
				if (empty($_SESSION['todosBilletes'])) {
					$_SESSION['todosBilletes'] = [];
					$todosBillete = [];
				}
			}


			// Procesar la compra
			if (isset($_POST['comprar'])) {
				$metodo = '';
				if (isset($_POST['metodo_pago'])) {
					$metodo = CGeneral::addSlashes($_POST['metodo_pago']);
					if (!in_array($metodo, ['efectivo', 'tarjeta', 'transferencia'])) {
						$errores = 'Seleccione una opción correcta';
					} else {
						$_SESSION['accion'] = ["inicial", "comprar"];

						if (!Sistema::app()->Acceso()->hayUsuario()) {
							Sistema::app()->irAPagina(['registro', 'login'], []);
							exit;
						}

						if (!Sistema::app()->Acceso()->puedePermiso(1)) {
							Sistema::app()->paginaError(404, 'No tienes permisos');
							exit;
						}

						$fechaHoy = date('d/m/Y');
						$nick = Sistema::app()->Acceso()->getNick();
						$cod = Sistema::app()->ACL()->getCodUsuario($nick);

						$compra->fecha = $fechaHoy;
						$compra->cod_usuario = $cod;
						$compra->forma_pago = $metodo;
						$compra->unidades = intval($_SESSION['unidades']);
						if ($compra->validar()) {
							$compra->guardar();
							$codCompra = $compra->cod_compra;
							$ultimoIndice = count($todosBillete);

							foreach ($todosBillete as $indice => $propiedad) {
								if (isset($propiedad['nombre_viaje'])) {
									unset($propiedad['nombre_viaje']);
								}
								$ultimo++;
								$billete = new Billete();
								$billete->setValores($propiedad);
								$billete->cod_compra = $codCompra;

								if ($billete->validar()) {
									$billete->guardar();


									if ($ultimo === $ultimoIndice) {
										$_SESSION['accion'] = '';
										$_SESSION['verificacion'] = 0;
										Sistema::app()->irAPagina(['inicial', 'verificacion']);
										exit;
									}
								} else {
									Sistema::app()->paginaError(404, 'Error al realizar la compra');
									exit;
								}
							}
						} else {
							Sistema::app()->paginaError(404, 'Error al realizar la compra');
							exit;
						}
					}
				}
			}

			// Mostrar todos los billetes y la forma de pago
			$this->dibujaVista(
				"compraBillete",
				['billetes' => $todosBillete, 'origen' => $origenParada, 'destino' => $destinoParada, 'compras' => $compra, 'errores' => $errores],
				"Finalizar compra"
			);
		} else {
			Sistema::app()->paginaError(404, 'Debes realizar todos los pasos anteriores');
			exit;
		}
	}


	public function accionMisCompras()
	{

		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(1))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}


		$compras = new Compras();
		$nick = Sistema::app()->Acceso()->getNick();
		$cod = Sistema::app()->ACL()->getCodUsuario($nick);
		$todas = $compras->buscarTodos(array('where' => 'cod_usuario = ' . $cod, 'order' => 'fecha desc'));

		foreach ($todas as $clave => $fila) {

			$fila['oper'] = CHTML::link(
				CHTML::imagen('/imagenes/24x24/ver.png'),
				Sistema::app()->generaURL(
					['inicial', 'verCompras'],
					[
						'id' => $fila['cod_compra']
					]
				)
			);


			$fila['fecha'] = CGeneral::fechaMysqlANormal($fila['fecha']);
			$todas[$clave] = $fila;
		}

		$this->dibujaVista(
			"misCompras",
			['compras' => $todas, 'nick' => $nick],
			"Mis compras"
		);
	}


	public function accionverCompras()
	{
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(1))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

		$parada = new Paradas();
		$viaje = new Viajes();
		$trayecto = new Trayectos();
		$origenParada = '';
		$destinoParada  = '';
		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);
			$billetes = new Billete();
			$filas = $billetes->buscarTodos(array('where' => 'cod_compra = ' . $id));
			if ($filas != false) {


				foreach ($filas as $clave => $fila) {



					$fila['fecha_ida'] = CGeneral::fechaMysqlANormal($fila['fecha_ida']);
					$fila['fecha_nac'] = CGeneral::fechaMysqlANormal($fila['fecha_nac']);
					$fila['fecha_vuelta'] = CGeneral::fechaMysqlANormal($fila['fecha_vuelta']);
					if ($fila['cod_parada_origen']) {
						$origen = $parada->buscarTodos([
							'select' => 'nombre, cod_parada',
							'where' => 'cod_parada = ' . intval($fila['cod_parada_origen'])
						]);
						$origenParada = $origen[0]['nombre'];
						$fila['origen'] = $origenParada;
						$filas[$clave] = $fila;
					}
					if ($fila['cod_parada_destino']) {
						$destino = $parada->buscarTodos([
							'select' => 'nombre, cod_parada',
							'where' => 'cod_parada = ' . intval($fila['cod_parada_destino'])
						]);
						$destinoParada = $destino[0]['nombre'];
						$fila['destino'] = $destinoParada;
						$filas[$clave] = $fila;
					}







					//genero qr con el dni del billete.

					// Suponiendo que $fila['dni'] contiene la información que deseas codificar en el código QR
					$codesDir = "./qr/";
					$codeFile = 'qr_' . $fila['dni'] . '.png';
					QRcode::png($fila['dni'], $codesDir . $codeFile, 5, 7);

					$fila['qr'] = $codesDir . $codeFile;
					$filas[$clave] = $fila;
				}

				if (isset($_POST['descargar'])) {
					//generar pdf, con todos los billetes y mandar al correo los billetes
					// create new PDF document
					// Crear instancia de TCPDF
					$pdf = new miTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

					// Establecer información del documento
					$pdf->SetCreator(PDF_CREATOR);
					$pdf->SetAuthor('Olaf Lederer');
					$pdf->SetTitle('Factura de Billetes');
					$pdf->SetSubject('Factura');
					$pdf->SetKeywords('TCPDF, PDF, factura, billete');

					foreach ($filas as $billete => $fila) {
						// Agregar una nueva página para cada billete
						$pdf->AddPage('P', 'A6');

						// Construir el contenido HTML para este billete
						$html = '
									<div style="border: 2px solid #333; padding: 15px; width: 250px; background-color: #f0f8ff; font-family: Arial, sans-serif; color: #333;">
									<h2 style="margin: 0; padding-bottom: 10px; border-bottom: 1px solid #ccc; color: #0066cc;">' . $fila['origen'] . ' -- ' . $fila['destino'] . '</h2>
									<div style="margin-bottom: 10px;">
										<strong>Nombre:</strong> ' . $fila['nombre'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>DNI:</strong> ' . $fila['dni'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Fecha de ida:</strong> ' . $fila['fecha_ida'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Fecha de vuelta:</strong> ' . $fila['fecha_vuelta'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Teléfono:</strong> ' . $fila['telefono'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Precio del billete:</strong> ' . $fila['precio_billete'] . '
									</div>
									</div>
									';



						// Escribir el HTML en el PDF
						$pdf->writeHTML($html, true, false, true, false, '');

						// Agregar un salto de página después de cada billete, excepto en el último

					}

					// Cerrar y generar el PDF
					$pdf->Output('factura_billetes.pdf', 'D');
				}
				$this->dibujaVista('verCompras', ['compras' => $filas, 'origen' => $origenParada, 'destino' => $destinoParada], 'Ver compra');
			} else {
				Sistema::app()->paginaError(404, 'Compra no encontrada');
				exit;
			}
		} else {
			Sistema::app()->paginaError(404, 'Compra no encontrada');
			exit;
		}
	}


	public function accionVerificacion()
	{

		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(1))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

		if (isset($_SESSION['verificacion'])) {
			$ver = intval($_SESSION['verificacion']);

			if ($ver === 0) {


				if (isset($_POST['id_0'])) {
					$compras = new Compras();
					$nick = Sistema::app()->Acceso()->getNick();
					$cod = Sistema::app()->ACL()->getCodUsuario($nick);
					$parada = new Paradas();
					if (isset($_SESSION['todosBilletes']) && count($_SESSION['todosBilletes']) > 0) {
						$todosBilletes = $_SESSION['todosBilletes'];
						foreach ($todosBilletes as $clave => $fila) {
							foreach ($fila as $prop => $val) {

								$nombre = $parada->buscarTodos(array('select' => 'nombre', 'where' => 'cod_parada = ' . intval($fila->cod_parada_origen)));
								$destino = $parada->buscarTodos(array('select' => 'nombre', 'where' => 'cod_parada = ' . intval($fila->cod_parada_destino)));



								$todosBillete[$clave]['origen'] = $nombre[0]['nombre'];
								$todosBillete[$clave]['destino'] = $destino[0]['nombre'];
								$todosBillete[$clave][$prop] = $val;
							}
						}


						// Crear instancia de TCPDF
						$pdf = new miTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

						// Establecer información del documento
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->SetAuthor('Olaf Lederer');
						$pdf->SetTitle('Factura de Billetes');
						$pdf->SetSubject('Factura');
						$pdf->SetKeywords('TCPDF, PDF, factura, billete');

						foreach ($todosBillete as $billete => $fila) {
							// Agregar una nueva página para cada billete
							$pdf->AddPage('P', 'A6');

							// Construir el contenido HTML para este billete
							$html = '
								<div style="border: 2px solid #333; padding: 15px; width: 250px; background-color: #f0f8ff; font-family: Arial, sans-serif; color: #333;">
									<h2 style="margin: 0; padding-bottom: 10px; border-bottom: 1px solid #ccc; color: #0066cc;">' . $fila['origen'] . ' -- ' . $fila['destino'] . '</h2>
									<div style="margin-bottom: 10px;">
										<strong>Nombre:</strong> ' . $fila['nombre'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>DNI:</strong> ' . $fila['dni'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Fecha de ida:</strong> ' . $fila['fecha_ida'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Fecha de vuelta:</strong> ' . $fila['fecha_vuelta'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Teléfono:</strong> ' . $fila['telefono'] . '
									</div>
									<div style="margin-bottom: 10px;">
										<strong>Precio del billete:</strong> ' . $fila['precio_billete'] . '
									</div>
								</div>
							';



							// Escribir el HTML en el PDF
							$pdf->writeHTML($html, true, false, true, false, '');

							// Agregar un salto de página después de cada billete, excepto en el último

						}

						// Cerrar y generar el PDF
						$pdf->Output('factura_billetes.pdf', 'D');


						unset($_SESSION['todosBilletes']);
						unset($_SESSION['verificacion']);
						Sistema::app()->irAPagina(array("inicial", "verCompras"));
					exit;

					} else {
						Sistema::app()->paginaError(404, 'No es posible acceder a la descarga');
						exit;
					}
				}
			} else {
				Sistema::app()->paginaError(404, 'No es posible acceder a la compra');
				exit;
			}
		} else {
			Sistema::app()->paginaError(404, 'Debes realizar una compra');
			exit;
		}





		$this->dibujaVista(
			"verificacion",
			[],
			"Verificacion"
		);
	}

	public function accionAbout()
	{



		$this->dibujaVista(
			"about",
			[],
			"Sobre nosotros"
		);
	}
}
