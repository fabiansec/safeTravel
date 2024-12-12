<?php

class tarifasControlador extends CControlador
{

	function __construct()
	{
	}

	public function accionIndex()
	{


		//Obtengo cada tarifa con sus complementos 
		$modelo = new Tarifas();
		$filas = $modelo->buscarTodos(array(
			'select' =>  't.cod_tarifa, t.nombre AS nombre_tarifa, co.nombre, borrado',
			'from' => ' INNER JOIN tarifa_complemento AS tc ON t.cod_tarifa = tc.cod_tarifa
					   INNER JOIN complemento AS co ON tc.cod_complemento = co.cod_complemento'
		));


		// Array para almacenar los datos nombre_tarifa = [sus complementos]
		$tarifas = array();
		
		// Recorrer resultados y almacenar en el array
		foreach ($filas as $fila) {
			$nombre_tarifa = $fila['nombre_tarifa'];
			$nombre_complemento = $fila['nombre'];
			$borrado = $fila['borrado'];
			// Si la tarifa aún no existe en el array, se crea como un nuevo índice
			if (!isset($tarifas[$nombre_tarifa])) {
				$tarifas[$nombre_tarifa] = array();
			}

			// Se agrega el complemento al array de complementos asociados a la tarifa
			$tarifas[$nombre_tarifa][] = $nombre_complemento;
			$tarifas[$nombre_tarifa]['borrado'] = $borrado;
		}


		$complementos = new Complementos();
		$comp = $complementos->buscarTodos();



		$this->dibujaVista(
			"index",
			['modelo' => $modelo, 'tarifas' => $tarifas, 'complementos' => $comp],
			"Inicio"
		);
	}


	public function accionIndextabla()
	{


		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}


		$modelo = new Tarifas();
		$tarifas = $modelo->buscarTodos();


		$opciones = [];
		$filtrado = [
			"nombre" => "",

		];

		// Llamamos al boton de filtrar

		$where = "";

		// Validamos el nombre de Actividad
		if (isset($_REQUEST["nombre"])) {
			$nombre = $_REQUEST["nombre"];
			$nombre = trim($nombre);
			if (!empty($nombre)) {
				$filtrado["nombre"] = $nombre;
				$nombre = CGeneral::addSlashes($nombre);
				if ($where != "")
					$where .= " and ";
				$where = " nombre regexp '$nombre'";
			}
			$opciones["where"] = $where;

		}


		/* El paginador , calculamos el numero total de registros y el numero de paginas*/
		$tamPagina = 3;

		if (isset($_GET["reg_pag"]))
			$tamPagina = intval($_GET["reg_pag"]);

		$registros = intval($modelo->buscarTodosNRegistros($opciones));
		$numPaginas = ceil($registros / $tamPagina);
		$pag = 1;

		if (isset($_GET["pag"])) {
			$pag = intval($_GET["pag"]);
		}

		if ($pag > $numPaginas)
			$pag = $numPaginas;



		$inicio = $tamPagina * ($pag - 1);
		$opciones["limit"] = "$inicio,$tamPagina";

		if ($opciones === 0) {
			$tarifas = $modelo->buscarTodos();
		} else {
			$tarifas = $modelo->buscarTodos($opciones);
			if ($tarifas === false) {
				Sistema::app()->paginaError(400, "No hay tarifas");
				return;
			}
		}


		$opcPaginador = array(
			"URL" => Sistema::app()->generaURL(array("tarifas", "indexTabla"), $filtrado),
			"TOTAL_REGISTROS" => $registros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $tamPagina,
			"TAMANIOS_PAGINA" => array(
				3 => "3",
				6 => "6",
				9 => "9",
				12 => "12",
				15 => "15",
				18 => "18"
			),
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 4,
		);







		foreach ($tarifas as $clave => $fila) {
			$fila['oper'] =
				CHTML::link(
					CHTML::imagen('/imagenes/24x24/ver.png'),
					Sistema::app()->generaURL(
						['tarifas', 'ver'],
						[
							'id' => $fila['cod_tarifa']
						]
					)
				) .
				CHTML::link(
					CHTML::imagen('/imagenes/24x24/modificar.png'),
					Sistema::app()->generaURL(
						['tarifas', 'modificar'],
						[
							'id' => $fila['cod_tarifa']
						]
					)
				) .
				CHTML::link(
					CHTML::imagen('/imagenes/24x24/borrar.png'),
					Sistema::app()->generaURL(
						['tarifas', 'borrar'],
						[
							'id' => $fila['cod_tarifa']
						]
					)
				);

			if ($fila['borrado'] === '0') {
				$fila['borrado'] = 'No';
			} else {
				$fila['borrado'] = 'Si';
			}

			$tarifas[$clave] = $fila;
		}

		$cabecera = [
			[
				'ETIQUETA' => 'NOMBRE',
				'CAMPO' => 'nombre',
				'ALINEA' => 'cen'
			],
			[
				'ETIQUETA' => 'PRECIO',
				'CAMPO' => 'precio',
				'ALINEA' => 'cen'
			],
			[
				'ETIQUETA' => 'BORRADO',
				'CAMPO' => 'borrado',
				'ALINEA' => 'cen'
			],
			[
				'ETIQUETA' => 'OPERACIONES',
				'CAMPO' => 'oper',
				'ALINEA' => 'cen'
			],

		];



		$this->dibujaVista(
			"indexTabla",
			['modelo' => $modelo, 'tarifas' => $tarifas, 'cabecera' => $cabecera, 'opcpag' => $opcPaginador, 'filtrado' => $filtrado],
			"Crud Tarifas"
		);
	}

	public function accionNuevo()
	{


		
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

		$modelo = new Tarifas();
		$complementos = new Complementos();
		$modeloCompleTar = new TarifasComplementos();
		$complementosPost = array();

		$nombre = $modelo->getNombre();
		$errores = false;
		if (isset($_POST[$nombre])) {
			$modelo->setValores($_POST[$nombre]);

			//sacar complementos y calcular precio para la tarifa
			$nom = $modeloCompleTar->getNombre();
			if (isset($_POST[$nom])) {
				if ($_POST[$nom]['cod_complemento'] !== '') {
					$complementosPost = $_POST[$nom]['cod_complemento'];
				} else {
					$errores = true;
				}


				$precioCom = 0;
				$porcentaje = 0.8;
				foreach ($complementosPost as $clave => $valor) {

					$filas = $complementos->buscarTodos(['where' => 'cod_complemento = ' . $valor]); //recojo el precio de ese complemento

					foreach ($filas as $cl => $vl) {
						$precioCom = $precioCom + $vl['precio'];
					}
				}
				$precioTotalTarifa = $precioCom * $porcentaje; // Aplico el porcentaje a la suma de los precios de los complementos.
				$modelo->precio = floatval($precioTotalTarifa);
				$modelo->borrado = 0; //si se crea una nueva tarifa, por defecto no esta borrada

				if ($modelo->validar()) { //valido los nuevos datos 
					if ($modelo->buscarTodos([
						"where" => "nombre=" . "'$modelo->nombre'" //compruebo si esa actividad ya existe por el nombre , ya que el nombre es unico
					])) {
						Sistema::app()->paginaError(404, 'Esta tarifa ya existe');
					} else {

						$modelo->guardar(); //hago el insert

						$id = $modelo->cod_tarifa;

						//hacer el insert en tarifas_complementos 

						foreach ($complementosPost as $clave => $valor) {
							$modeloCompleTar = new TarifasComplementos();


							$modeloCompleTar->cod_tarifa = $id;
							$modeloCompleTar->cod_complemento = $valor;
							if ($modeloCompleTar->validar()) {
								$modeloCompleTar->guardar();
							} else {
								Sistema::app()->paginaError(404, 'Esta tarifa ya existe');
							}
						}

						Sistema::app()->irAPagina(array("tarifas", 'ver/id=' . $id));
						exit;
					}
				}
			} else {
				$errores = true; //lanzo error de no hay ningún complemento seleccionado
			}
		}
		$cab = ['nombre'];
		$cabecera = ['cod_complemento'];

		$comp = $complementos->buscarTodos();
		$comple = array();
		foreach ($comp as $clave => $valor) {
			$comple[$valor['cod_complemento']] = $valor['nombre'];
		}

		$this->dibujaVista(
			"nuevoTarifa",
			['cabecera' => $cabecera, 'modelo' => $modelo, 'cab' => $cab, 'comp' => $comple, 'modeloComp' => $complementos, 'errores' => $errores, 'modeloComTar' => $modeloCompleTar],
			"Nueva Tarifa"
		);
	}
	public function accionVer()
	{


		
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);

			$modelo = new Tarifas();

			$fil = $modelo->buscarPorId($id); //datos de la tarifa
			$complemento = $modelo->buscarTodos(array(
				'select' =>  't.cod_tarifa, t.nombre AS nombre_tarifa, co.nombre',
				'from' => ' INNER JOIN tarifa_complemento AS tc ON t.cod_tarifa = tc.cod_tarifa
					   INNER JOIN complemento AS co ON tc.cod_complemento = co.cod_complemento',
				"where" => 't.cod_tarifa = ' . $id
			)); 		//complementos de la tarifa
			if ($fil === false) {
				Sistema::app()->paginaError(404, 'Tarifa no encontrada');
				exit;
			} else {
				$cab = ["nombre", "precio", "borrado"];
				$complementos = array();
				// Recorrer resultados y almacenar en el array
				foreach ($complemento as $fila) {
					$nombre_tarifa = $fila['nombre_tarifa'];
					$nombre_complemento = $fila['nombre'];

					// Si la tarifa aún no existe en el array, se crea como un nuevo índice
					if (!isset($complementos[$nombre_tarifa])) {
						$complementos[$nombre_tarifa] = [];
					}

					// Se agrega el complemento al array de complementos asociados a la tarifa
					$complementos[$nombre_tarifa][] = $nombre_complemento;
				}

				$this->dibujaVista('verTarifa', ['cab' => $cab, 'complementos' => $complementos, 'tarifa' => $modelo], 'Ver tarifa');
			}
		} else {
			Sistema::app()->paginaError(404, 'Tarifa no encontrada');
			exit;
		}
	}

	public function accionBorrar()
	{
		
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);

			$modelo = new Tarifas();

			$fil = $modelo->buscarPorId($id); //datos de la tarifa
			$complemento = $modelo->buscarTodos(array(
				'select' =>  't.cod_tarifa, t.nombre AS nombre_tarifa, co.nombre',
				'from' => ' INNER JOIN tarifa_complemento AS tc ON t.cod_tarifa = tc.cod_tarifa
					   INNER JOIN complemento AS co ON tc.cod_complemento = co.cod_complemento',
				"where" => 't.cod_tarifa = ' . $id
			)); //complementos de la tarifa
			if ($fil === false) {
				Sistema::app()->paginaError(404, 'Tarifa no encontrada');
				exit;
			} else {
				$cab = ["nombre", "precio"];
				$complementos = array();

				// Recorrer resultados y almacenar en el array
				foreach ($complemento as $fila) {
					$nombre_tarifa = $fila['nombre_tarifa'];
					$nombre_complemento = $fila['nombre'];

					// Si la tarifa aún no existe en el array, se crea como un nuevo índice
					if (!isset($complementos[$nombre_tarifa])) {
						$complementos[$nombre_tarifa] = [];
					}

					// Se agrega el complemento al array de complementos asociados a la tarifa
					$complementos[$nombre_tarifa][] = $nombre_complemento;
				}

				if (isset($_POST['id_3'])) { // Si pulsa el botón de borrar
					$modelo->borrado = 1; // Modifico el borrado
					if ($modelo->validar()) { // Valido la actividad
						$modelo->guardar(); // Hago update de la actividad

						Sistema::app()->irAPagina(array("tarifas", "indextabla"));
						exit;
					}
				}




				$this->dibujaVista('borrarTarifa', ['cab' => $cab, 'complementos' => $complementos, 'tarifa' => $modelo], 'Borrar tarifa');
			}
		} else {
			Sistema::app()->paginaError(404, 'Tarifa no encontrada');
			exit;
		}
	}

	public function accionModificar()
	{
		
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);

			$modelo = new Tarifas();
			$modeloCom = new Complementos();
			$precioCom = 0;
			$errores = false;


			$fil = $modelo->buscarPorId($id); //datos de la tarifa
			$complemento = $modelo->buscarTodos(array(
				'select' =>  't.cod_tarifa, t.nombre AS nombre_tarifa, co.nombre,tc.cod_complemento',
				'from' => ' INNER JOIN tarifa_complemento AS tc ON t.cod_tarifa = tc.cod_tarifa
					   INNER JOIN complemento AS co ON tc.cod_complemento = co.cod_complemento',
				"where" => 't.cod_tarifa = ' . $id
			)); 		//complementos de la tarifa
			if ($fil === false) {
				Sistema::app()->paginaError(404, 'Tarifa no encontrada');
				exit;
			} else {
				$cab = ["nombre", "precio", "borrado"];
				$complementos = array();
				// Recorrer resultados y almacenar en el array
				foreach ($complemento as $fila) {
					$nombre_tarifa = $fila['nombre_tarifa'];
					$nombre_complemento = $fila['nombre'];
					$id_complemento = $fila['cod_complemento']; // ID del complemento

					// Si la tarifa aún no existe en el array, se crea como un nuevo índice
					if (!isset($complementos[$nombre_tarifa])) {
						$complementos[$nombre_tarifa] = [];
					}

					// Se agrega el complemento al array de complementos asociados a la tarifa
					$complementos[$nombre_tarifa][$id_complemento] = $nombre_complemento;
				}


				$modeloComplementos = new Complementos();
				$todosC = $modeloComplementos->buscarTodos();

				if (isset($_POST['id_3'])) {
					if (isset($_POST['tar']['nombre'])) {
						$modelo->nombre = CGeneral::addSlashes($_POST['tar']['nombre']); //modificar el nombre

					}

					//recojo los complementos seleccionados
					if (isset($_POST['complementos_seleccionados'])) {
						$complementosSelec = $_POST['complementos_seleccionados'];

						$porcentaje = 0.8;
						//recorro los complementosy guardo el precio
						foreach ($complementosSelec as $clave => $valor) {
							$filas = $modeloCom->buscarTodos(['where' => 'cod_complemento = ' . $valor]);

							foreach ($filas as $cl => $vl) {
								$precioCom = $precioCom + $vl['precio'];
							}
						}


						//actualizo precio tarifa
						$precioTotalTarifa = $precioCom * $porcentaje; // Aplico el porcentaje a la suma de los precios de los complementos.
						$modelo->precio = $precioTotalTarifa;

						if ($modelo->validar()) {

							$modelo->guardar(); //hago el update de la tarifa con su precio nuevo

							$id = $modelo->cod_tarifa;

							//hacer el update en tarifas_complementos hacia esa tarifa
							foreach ($complementosSelec as $clave => $valor) {

								$modeloCompleTar = new TarifasComplementos();
								$filas = $modeloCompleTar->buscarPorId($id);

								$modeloCompleTar->cod_tarifa = $id;
								$modeloCompleTar->cod_complemento = $valor;

								//compruebo que esta tarifa no tenga ya ese complemento
								$fi = $modeloCompleTar->buscarPor(array('where' => 'cod_complemento=' . $valor . ' and cod_tarifa=' . $id));

								if ($fi === false) { //es decir no tiene este complemento la tarifa.
									if ($modeloCompleTar->validar()) {
										$modeloCompleTar->guardar();
									} else {
										Sistema::app()->paginaError(404, 'Esta tarifa ya existe');
									}
								}
							}

							// Hacer delete en tarifas_complementos para eliminar el registro si se quitan complementos de una tarifa
							foreach ($complementos as $nombre_tarifa => $complementos_asociados) {
								foreach ($complementos_asociados as $id_complemento => $nombre_complemento) {
									// Verificar si el ID del complemento no está presente en los complementos seleccionados, pero sí estaba previamente asociado
									if (!in_array($id_complemento, $complementosSelec) && !in_array($id_complemento, $complementos)) {
										// Realizar la eliminación en la tabla tarifas_complementos
										$sentenciaEliminar = "DELETE FROM tarifa_complemento WHERE cod_complemento = $id_complemento AND cod_tarifa = $id";
										Sistema::app()->BD()->crearConsulta($sentenciaEliminar);
									}
								}
							}





							Sistema::app()->irAPagina(array("tarifas", 'ver/id=' . $id));
							exit;
						}
					} else {
						$errores = true;
					}
				}

				$this->dibujaVista('modificarTarifa', ['cab' => $cab, 'complementos' => $complementos, 'tarifa' => $modelo, 'todosComplementos' => $todosC, 'errores' => $errores], 'Modificar tarifa');
			}
		} else {
			Sistema::app()->paginaError(404, 'Tarifa no encontrada');
			exit;
		}
	}
}
