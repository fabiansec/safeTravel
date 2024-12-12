<?php
class trayectosControlador extends CControlador
{

    function __construct()
    {
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


		$modelo = new Trayectos();
		$trayectos = $modelo->buscarTodos();


		$opciones = [];
		$filtrado = [
			"nombre" => "",

		];

		// Llamamos al boton de filtrar

		$where = "";

        if (isset($_REQUEST["nombre"])) {
            $nombre=$_REQUEST["nombre"];
            $nombre=trim($nombre);
            if (!empty($nombre)) 
            {
                $filtrado["nombre"]=$nombre;
                $nombre=CGeneral::addSlashes($nombre);
                if ($where!="")
                    $where.=" and ";
                $where = " nombre regexp '$nombre'";
            }
        }

       


		$opciones["where"] = $where;


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
			$trayectos = $modelo->buscarTodos();
		} else {
			$trayectos = $modelo->buscarTodos($opciones);
			if ($trayectos === false) {
				Sistema::app()->paginaError(400, "No hay trayectos");
				return;
			}
		}


		$opcPaginador = array(
			"URL" => Sistema::app()->generaURL(array("trayectos", "indexTabla"), $filtrado),
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







		foreach ($trayectos as $clave => $fila) {
			$fila['oper'] =
				CHTML::link(
					CHTML::imagen('/imagenes/24x24/ver.png'),
					Sistema::app()->generaURL(
						['trayectos', 'ver'],
						[
							'id' => $fila['cod_trayecto']
						]
					)
				) .
				CHTML::link(
					CHTML::imagen('/imagenes/24x24/modificar.png'),
					Sistema::app()->generaURL(
						['trayectos', 'modificar'],
						[
							'id' => $fila['cod_trayecto']
						]
					)
				) .
				CHTML::link(
					CHTML::imagen('/imagenes/24x24/borrar.png'),
					Sistema::app()->generaURL(
						['trayectos', 'borrar'],
						[
							'id' => $fila['cod_trayecto']
						]
					)
				);

			if ($fila['borrado'] === '0') {
				$fila['borrado'] = 'No';
			} else {
				$fila['borrado'] = 'Si';
			}

			$trayectos[$clave] = $fila;
		}

        $cabecera = [
            [
                'ETIQUETA' => 'NOMBRE',
                'CAMPO' => 'nombre',
                'ALINEA' => 'cen'
            ],
            [
                'ETIQUETA' => 'PRECIO',
                'CAMPO' => 'precio_total',
                'ALINEA' => 'cen'
            ],
            [
                'ETIQUETA' => 'TIEMPO',
                'CAMPO' => 'tiempo_total',
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
			['modelo' => $modelo, 'filas' => $trayectos, 'cabecera' => $cabecera, 'opcpag' => $opcPaginador, 'filtrado' => $filtrado],
			"Crud Tarifas"
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

            $modelo = new Trayectos();

            $fil = $modelo->buscarPorId($id); //datos del trayecto
            $filas = $modelo->buscarTodos(array(

                "where" => 't.cod_trayecto = ' . $id,
            ));

            $paradas = $modelo->buscarTodos(array(
                "select" => "*, GROUP_CONCAT(paradas.nombre ORDER BY paradas_trayectos.orden ASC SEPARATOR ' - ') AS paradas",
                "from" => "
                           INNER JOIN paradas_trayectos ON t.cod_trayecto = paradas_trayectos.cod_trayecto
                           INNER JOIN paradas ON paradas_trayectos.cod_parada = paradas.cod_parada",
                "group" => "t.cod_trayecto",
                "where" => "t.cod_trayecto = " . $id
            ));
            
            if(count($paradas) > 0){
                foreach($paradas as $ind => $valores){
                    $par = $valores['paradas'];
                }  

                foreach($filas as $ind => $val){
                    $filas[$ind]['paradas'] = $par;
                }
            }
            

            if ($fil === false) {
                Sistema::app()->paginaError(404, 'Tarifa no encontrada');
                exit;
            } else {


                $cabecera  = ['nombre', 'precio_total', 'tiempo_total', 'hora_salida', 'numero_tren', 'asientos_tren', 'paradas', 'borrado','paradas'];

                $this->dibujaVista(
                    "verTrayecto",
                    ['modelo' => $modelo, 'filas' => $filas, 'cab' => $cabecera],
                    "Ver trayecto"
                );
            }
        } else {
            Sistema::app()->paginaError(404, 'Trayecto no encontrado');
            exit;
        }
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


        $trayecto = new Trayectos();
        $paradas = new Paradas();
        $id = '';
        $filas = $paradas->buscarTodos(); //todas las paradas
        $para = array();
        $errores = [];
        foreach ($filas as $clave => $valor) {
            $para[$valor['nombre']] = $valor['nombre']; //todas las paradas
        }

        if (isset($_POST['id_0'])) {
            if (isset($_POST['origen']) && isset($_POST['destino'])) {
                $origen = CGeneral::addSlashes($_POST['origen']);
                $destino = CGeneral::addSlashes($_POST['destino']);

                if (empty($origen) || empty($destino)) {
                    $errores[] = 'Debes seleccionar origen y destino';
                } else if ($origen === $destino) {
                    $errores[] = 'Debes seleccionar un destino y origen distinto';
                } else {

                    $nombre = $origen . '-' . $destino;

                    $trayecto->nombre = $nombre;
                    $trayecto->precio_total = 0.0;
                    $trayecto->borrado = 0;
                    if ($trayecto->validar()) {

                        $trayecto->guardar();

                        $id = $trayecto->cod_trayecto;
                        $_SESSION['id'] = $id;
                        Sistema::app()->irAPagina(array("trayectos", 'anadir'));
                        exit;
                    } else {
                        Sistema::app()->paginaError(404, 'Error al crear el trayecto');
                        exit;
                    }
                }
            }
        }






        $cab = ['nombre'];

        $this->dibujaVista(
            "nuevoTrayecto",
            ['trayecto' => $trayecto, 'cab' => $cab, 'paradas' => $paradas, 'filas' => $para, 'errores' => $errores],
            "Nuevo trayecto"
        );
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

            $modelo = new Trayectos();
            $fil = $modelo->buscarPorId($id); //datos del trayecto
          


                if ($fil === false) {
                    Sistema::app()->paginaError(404, 'Trayecto no encontrado');
                    exit;
                } else {
                    $modeloParadaTrayecto = new ParadasTrayectos();
                    $filasParadaTrayecto = $modeloParadaTrayecto->buscarTodos(array(
                        'select' => 'p.nombre,t.*',
                        'from' => 'inner join paradas p ON t.cod_parada = p.cod_parada',
                        'where' => 't.cod_trayecto =' . $id,
                    ));

                    if(count($filasParadaTrayecto) <= 0){
                        $_SESSION['id'] = $id;
                        Sistema::app()->irAPagina(array('trayectos', 'anadir'), []);
			            exit;
                    }
        
                   
                        $filas = $modelo->buscarTodos(array(
                            "where" => 't.cod_trayecto = ' . $id,
                        ));

                    $nombre = $modeloParadaTrayecto->getNombre();
                    if (isset($_POST[$nombre])) {
                        //valido los campos , y hago update de esa parada del trayecto.
                        $filaPT = $modeloParadaTrayecto->buscarPor(['where' => 't.cod_trayecto=' . $id]); //busco el registro
                        if ($filaPT) {
                            $modeloParadaTrayecto->setValores($_POST[$nombre]);
                            $modeloParadaTrayecto->cod_trayecto = $id;

                            if ($modeloParadaTrayecto->validar()) {
                                $modeloParadaTrayecto->guardar();
                            }

                            //actualizar el tiempo_total y el precio_total del trayecto
                            $paradasActualizadas = $modeloParadaTrayecto->buscarTodos(array(
                                'select' => 'p.nombre,t.*',
                                'from' => 'inner join paradas p ON t.cod_parada = p.cod_parada',
                                'where' => 't.cod_trayecto =' . $id
                            ));
                        }

                        $totalPrecio = 0;
                        $totalTiempoSegundos = 0;

                        $totalPrecio = 0;
                        $totalTiempoSegundos = 0;

                        foreach ($paradasActualizadas as $val) {
                            if (isset($val['precio'])) {
                                $totalPrecio += $val['precio'];
                            }
                            if (isset($val['tiempo'])) {
                                list($horas, $minutos, $segundos) = explode(':', $val['tiempo']);
                                $totalTiempoSegundos += $horas * 3600 + $minutos * 60 + $segundos;
                            }
                            if (isset($val['tiempo_estacion'])) {
                                list($horas, $minutos, $segundos) = explode(':', $val['tiempo_estacion']);
                                $totalTiempoSegundos += $horas * 3600 + $minutos * 60 + $segundos;
                            }
                        }

                        // Convertir total de segundos de nuevo a "hh:mm:ss"
                        $horas = floor($totalTiempoSegundos / 3600);
                        $totalTiempoSegundos %= 3600;
                        $minutos = floor($totalTiempoSegundos / 60);
                        $segundos = $totalTiempoSegundos % 60;
                        $totalTiempo = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
                        //actualizo el modelo del trayecto , valido y guardo
                        $modelo->tiempo_total = $totalTiempo;
                        $modelo->precio_total = $totalPrecio;
                        foreach ($filas as $indice => $valor) {
                            $modelo->nombre = $valor['nombre'];
                        }
                        if ($modelo->validar()) {
                            $modelo->guardar();
                        }
                    }

                    $cabecera  = ['nombre'];
                    $cabPT = ['nombre', 'orden', 'tiempo', 'tiempo_estacion', 'kilometros', 'precio'];
                    $this->dibujaVista(
                        "modificarTrayecto",
                        [
                            'cabPT' => $cabPT, 'modeloPT' => $modeloParadaTrayecto, 'modelo' => $modelo,
                            'filas' => $filas, 'cab' => $cabecera, 'filasParadas' => $filasParadaTrayecto
                        ],
                        "Modificar trayecto"
                    );
                    
                }
            
        } else {
            Sistema::app()->paginaError(404, 'Trayecto no encontrado');
            exit;
        }
    }



    public function accionAnadir()
    {

        
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

        $errores = '';
        $modelo = new Trayectos();
        $paradas = new Paradas();
        $modeloPT = new ParadasTrayectos();
        $modeloAux = new ParadasTrayectos();
        $filasP = $paradas->buscarTodos();
    
        if(isset($_SESSION['id'])){
            $id = intval($_SESSION['id']);

        }else{
            $id = '';
        }
        $modelo = new Trayectos();
        $modeloParadaTrayecto = new ParadasTrayectos();
        $filasParadaTrayecto = $modeloParadaTrayecto->buscarTodos(array(
            'select' => 'p.nombre, t.*',
            'from' => 'inner join paradas p ON t.cod_parada = p.cod_parada',
            'where' => 't.cod_trayecto =' . $id,
        ));
    
        $fil = $modelo->buscarPorId($id); //datos del trayecto
        $filas = $modelo->buscarTodos(array(
            "where" => 't.cod_trayecto = ' . $id,
        ));
    
        if ($fil === false) {
            Sistema::app()->paginaError(404, 'Trayecto no encontrado');
            exit;
        } else {
            $fil = $modelo->buscarPorId($id); //datos del trayecto
            $nombre = $modeloAux->getNombre();
            if (isset($_POST[$nombre])) {
                $modeloAux->setValores($_POST[$nombre]);
                $modeloAux->cod_trayecto = $id;
                $existeParada = $modeloPT->buscarTodos(array(
                    'where' => 'cod_trayecto = ' . $id . ' AND cod_parada = ' . $modeloAux->cod_parada
                ));
    
                $existeOrden = $modeloPT->buscarTodos(array(
                    'where' => 'cod_trayecto = ' . $id . ' AND orden = ' . $modeloAux->orden
                ));
    
                if (!empty($existeParada)) {
                    // La parada ya existe, muestra un mensaje de error
                    $errores = 'Esa parada ya fue agregada';
                } elseif (!empty($existeOrden)) {
                    // Ya existe una parada con el mismo orden, muestra un mensaje de error
                    $errores = 'Ya existe una parada con el mismo orden en este trayecto';
                } else {
                    if ($modeloAux->validar()) {
                        $modeloAux->guardar();
                    }
                }
            }
    
            //actualizar el trayecto
            //actualizar el tiempo_total y el precio_total del trayecto
            $paradasActualizadas = $modeloPT->buscarTodos(array(
                'select' => 'p.nombre, t.*',
                'from' => 'inner join paradas p ON t.cod_parada = p.cod_parada',
                'where' => 't.cod_trayecto =' . $id
            ));
    
            $totalPrecio = 0;
            $totalTiempoSegundos = 0;
    
            foreach ($paradasActualizadas as $val) {
                if (isset($val['precio'])) {
                    $totalPrecio += $val['precio'];
                }
                if (isset($val['tiempo'])) {
                    list($horas, $minutos, $segundos) = explode(':', $val['tiempo']);
                    $totalTiempoSegundos += $horas * 3600 + $minutos * 60 + $segundos;
                }
                if (isset($val['tiempo_estacion'])) {
                    list($horas, $minutos, $segundos) = explode(':', $val['tiempo_estacion']);
                    $totalTiempoSegundos += $horas * 3600 + $minutos * 60 + $segundos;
                }
            }
    
            // Convertir total de segundos de nuevo a "hh:mm:ss"
            $horas = floor($totalTiempoSegundos / 3600);
            $totalTiempoSegundos %= 3600;
            $minutos = floor($totalTiempoSegundos / 60);
            $segundos = $totalTiempoSegundos % 60;
            $totalTiempo = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
            
            // Actualizo el modelo del trayecto, valido y guardo
            $modelo->tiempo_total = $totalTiempo;
            $modelo->precio_total = $totalPrecio;
            foreach ($filas as $indice => $valor) {
                $modelo->nombre = $valor['nombre'];
            }
            if ($modelo->validar()) {
                $modelo->guardar();
            }
        }
    
        $cabPT = ['nombre', 'orden', 'tiempo', 'tiempo_estacion', 'kilometros', 'precio'];
        $cab = ['nombre'];
        $this->dibujaVista(
            "anadirParadas",
            [
                'errores' => $errores,
                'modelo' => $modelo, 
                'filas' => $filas, 
                'filasP' => $filasP, 
                'cabPT' => $cabPT, 
                'modeloPT' => $modeloPT, 
                'modeloAux' => $modeloAux, 
                'filasParadas' => $filas, 
                'cab' => $cab
            ],
            "Añadir paradas"
        );
    
        
    }
    

    public function accionBorrar(){

        
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

            $modelo = new Trayectos();

            $fil = $modelo->buscarPorId($id); //datos del trayecto
            $filas = $modelo->buscarTodos(array(

                "where" => 't.cod_trayecto = ' . $id,
            ));

            if ($fil === false) {
                Sistema::app()->paginaError(404, 'Tarifa no encontrada');
                exit;
            } else {


                if(isset($_POST['id_0'])){
                    $modelo->setValores($filas[0]);
                    $modelo->borrado = 1; // Modifico el borrado

                    if ($modelo->validar()) { // Valido la actividad
						$modelo->guardar(); // Hago update de la actividad

						Sistema::app()->irAPagina(array("trayectos", "indextabla"));
						exit;
					}
                }

                $cabecera  = ['nombre', 'precio_total', 'tiempo_total', 'hora_salida', 'numero_tren', 'asientos_tren', 'paradas', 'borrado'];

                $this->dibujaVista(
                    "borrartrayecto",
                    ['modelo' => $modelo, 'filas' => $filas, 'cab' => $cabecera],
                    "Borrar trayecto"
                );
            }
        } else {
            Sistema::app()->paginaError(404, 'Trayecto no encontrado');
            exit;
        }




    }
}

