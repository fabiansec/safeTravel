<?php

class viajesControlador extends CControlador
{

    function __construct()
    {
    }

    public function accionIndexTabla()
    {
        
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array('registro', 'login'), []);
			exit;
		}

		if (!(Sistema::app()->Acceso()->puedePermiso(10))) {
			Sistema::app()->paginaError(404, 'No tienes permisos');
			exit;
		}

        $viaje = new Viajes();
        $filas = $viaje->buscarTodos(array());

        $opciones = [];
		$filtrado = [
			"precio" => "",
            "fecha" => ""

		];

		// Llamamos al boton de filtrar

		$where = "";

		// Validamos el precio
		if (isset($_REQUEST["precio"])) {
			$precio = $_REQUEST["precio"];
			$precio = trim($precio);
			if (!empty($precio)) {
				$filtrado["precio"] = $precio;
				$precio = floatval($precio);
				if ($where != "")
					$where .= " and ";
				$where = " precio_viaje  = $precio";
			}
		}


          // Validamos la fecha
			if (isset($_REQUEST["fecha"])) {
				$fecha=CGeneral::addSlashes($_REQUEST["fecha"]);
				if (!empty($fecha)) {
					$filtrado["fecha"]=$fecha; 
					if ($where!="")
							$where.=" and ";
						$where .= " fecha = '$fecha' ";			 
				}

			}


		$opciones["where"] = $where;


		$tamPagina = 3;

		if (isset($_GET["reg_pag"]))
			$tamPagina = intval($_GET["reg_pag"]);

		$registros = intval($viaje->buscarTodosNRegistros($opciones));
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
			$filas = $viaje->buscarTodos();
		} else {
			$filas = $viaje->buscarTodos($opciones);
			if ($filas === false) {
				Sistema::app()->paginaError(400, "No hay viajes");
				return;
			}
		}


		$opcPaginador = array(
			"URL" => Sistema::app()->generaURL(array("viajes", "indexTabla"), $filtrado),
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



        foreach ($filas as $clave => $fila) {
            $fila['oper'] =
                CHTML::link(
                    CHTML::imagen('/imagenes/24x24/ver.png'),
                    Sistema::app()->generaURL(
                        ['viajes', 'ver'],
                        [
                            'id' => $fila['cod_viaje']
                        ]
                    )
                ) .
                CHTML::link(
                    CHTML::imagen('/imagenes/24x24/modificar.png'),
                    Sistema::app()->generaURL(
                        ['viajes', 'modificar'],
                        [
                            'id' => $fila['cod_viaje']
                        ]
                    )
                ) .
                CHTML::link(
                    CHTML::imagen('/imagenes/24x24/borrar.png'),
                    Sistema::app()->generaURL(
                        ['viajes', 'borrar'],
                        [
                            'id' => $fila['cod_viaje']
                        ]
                    )
                );

            $fila['fecha'] = CGeneral::fechaMysqlANormal($fila['fecha']);
            if ($fila['borrado'] === '0') {
				$fila['borrado'] = 'No';
			} else {
				$fila['borrado'] = 'Si';
			}

            $filas[$clave] = $fila;
        }

        $cabecera = [
            [
                'ETIQUETA' => 'NOMBRE',
                'CAMPO' => 'nombre',
                'ALINEA' => 'cen'
            ],
            [
                'ETIQUETA' => 'PRECIO VIAJE',
                'CAMPO' => 'precio_viaje',
                'ALINEA' => 'cen'
            ],
            [
                'ETIQUETA' => 'HORA SALIDA',
                'CAMPO' => 'hora_salida',
                'ALINEA' => 'cen'
            ],
            [
                'ETIQUETA' => 'FECHA',
                'CAMPO' => 'fecha',
                'ALINEA' => 'cen'
            ],
            [
                'ETIQUETA' => 'TREN',
                'CAMPO' => 'tren',
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


        $this->dibujaVista('indexTabla', ['viaje' => $viaje, 'cabecera' => $cabecera, 'filas' => $filas, 'opcpag' => $opcPaginador, 'filtrado' => $filtrado], 'Crud Viajes');
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

            $nombreTren = '';
            $tren = new Tren();
            $viaje = new Viajes();
            $filas  = $viaje->buscarPor(array('where' => 't.cod_viaje=' . $id));

            if ($filas === false) {
                Sistema::app()->paginaError(404, 'Viaje no encontrado');
                exit;
            } else {

                $trenes = $tren->buscarPor(array(
                    'select' => 't.nombre',
                    'from' => 'inner join viajes v on v.cod_tren = t.cod_tren',
                    'where' => 'v.cod_viaje=' . $id
                ));
                $nombreTren = $tren->nombre;
                $cabecera  = ['nombre', 'precio_viaje', 'hora_salida', 'fecha', 'tren','borrado'];

                $this->dibujaVista(
                    "verViaje",
                    ['modelo' => $viaje, 'filas' => $filas, 'cab' => $cabecera, 'nombreTren' => $nombreTren],
                    "Ver viaje"
                );
            }
        } else {
            Sistema::app()->paginaError(404, 'Viaje no encontrado');
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

        $trayectos = new Trayectos();
        $tren = new Tren();
        $trayect = $trayectos->buscarTodos(array('select' => 'nombre,cod_trayecto','where' => 'borrado='. 0));
        $filas = array();
        foreach ($trayect as $ind => $prop) {
            $filas[$prop['cod_trayecto']] = $prop['nombre'];
        }

        $trenes = $tren->buscarTodos(array('select' => 'nombre,cod_tren'));
        $tre = array();
        foreach ($trenes as $ind => $val) {
            $tre[$val['cod_tren']] = $val['nombre'];
        }


        $viaje = new Viajes();

        //asignar al viaje el trayecto
        $nombreTra = $trayectos->getNombre();
        if (isset($_POST[$nombreTra])) {
            $trayectos->setValores($_POST[$nombreTra]);
            $codTra = $trayectos->cod_trayecto;

            //precio_viaje es el precio del trayecto
            if ($codTra != '') {
                $p = $trayectos->buscarTodos(array('select' => 'precio_total', 'where' => 'cod_trayecto = ' . $codTra));
                $precio = 0;
                foreach ($p as $ind => $val) {
                    $precio = $val['precio_total'];
                }
                $viaje->precio_viaje = $precio;
            }
        }

        //asignar al viaje el tren 
        $nombreTre = $tren->getNombre();
        if (isset($_POST[$nombreTre])) {
            $idTren = intval($_POST[$nombreTre]['cod_tren']);
            $viaje->cod_tren = $idTren;
        }

        $nombreVia = $viaje->getNombre();
        if (isset($_POST[$nombreVia])) {
            $viaje->setValores($_POST[$nombreVia]);
            $viaje->cod_trayecto = $codTra;



            //si ya existe un viaje con el mismo tren , mismo dia y misma hora, error.
            $compr = $viaje->buscarTodos(array('select' => 'count(*)', 'where ' =>
            'cod_tren=' . $idTren . 'fecha=' . $viaje->fecha . 'hora_salida' . $viaje->hora_salida));
            $viaje->borrado = 0;
            if ($viaje->validar()) {



                $viaje->guardar();
                $id = $viaje->cod_viaje;
                Sistema::app()->irAPagina(array("viajes", 'ver/id=' . $id));
                exit;
            }
        }



        $cab = ['hora_salida', 'fecha'];
        $this->dibujaVista(
            "nuevoViaje",
            ['trayectos' => $filas, 'modelo' => $trayectos, 'cab' => $cab, 'viaje' => $viaje, 'tren' => $tren, 'tre' => $tre],
            "Nuevo viaje"
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

            $tren = new Tren();
            $viaje = new Viajes();
            $filas  = $viaje->buscarPor(array('where' => 't.cod_viaje=' . $id));

            if ($filas === false) {
                Sistema::app()->paginaError(404, 'Viaje no encontrado');
                exit;
            } else {

                $trenes = $tren->buscarPor(array(
                    'select' => 't.nombre , t.cod_tren',
                    'from' => 'inner join viajes v on v.cod_tren = t.cod_tren',
                    'where' => 'v.cod_viaje=' . $id
                ));
                $cod = $tren->cod_tren;


                $trenes = $tren->buscarTodos(array('select' => 'nombre,cod_tren'));
                $tre = array();
                foreach ($trenes as $ind => $val) {
                    $tre[$val['cod_tren']] = $val['nombre'];
                }


                $nombreTre = $tren->getNombre();
                if(isset($_POST[$nombreTre])){
                    $idTren = $_POST[$nombreTre]['cod_tren'];
                }

                $nombreVia = $viaje->getNombre();
                if(isset($_POST[$nombreVia])){
                    $viaje->setValores($_POST[$nombreVia]);

                    $viaje->cod_tren = intval($idTren);

                    if($viaje->validar()){
                        $viaje->guardar();
                        Sistema::app()->irAPagina(array("viajes", 'ver/id=' . $id));
                        exit;

                    }
                }

                $cabecera  = ['nombre', 'precio_viaje', 'hora_salida', 'fecha', 'tren'];

                $this->dibujaVista(
                    "modificarViaje",
                    ['modelo' => $viaje, 'filas' => $filas, 'cab' => $cabecera, 'nombreTren' => $cod, 'tren' => $tren,'tre'=>$tre],
                    "Modificar viaje"
                );
            }
        } else {
            Sistema::app()->paginaError(404, 'Viaje no encontrado');
            exit;
        }
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

            $nombreTren = '';
            $tren = new Tren();
            $viaje = new Viajes();
            $filas  = $viaje->buscarPor(array('where' => 't.cod_viaje=' . $id));

            if ($filas === false) {
                Sistema::app()->paginaError(404, 'Viaje no encontrado');
                exit;
            } else {

                $trenes = $tren->buscarPor(array(
                    'select' => 't.nombre',
                    'from' => 'inner join viajes v on v.cod_tren = t.cod_tren',
                    'where' => 'v.cod_viaje=' . $id
                ));
                $nombreTren = $tren->nombre;
                $cabecera  = ['nombre', 'precio_viaje', 'hora_salida', 'fecha', 'tren'];

                $nombreViaje = $viaje->getNombre();
                if(isset($_POST[$nombreViaje])){
                    $viaje->setValores($_POST[$nombreViaje]);
                    $viaje->borrado = 1;
                    if($viaje->validar()){
                        $viaje->guardar();
                        Sistema::app()->irAPagina(array("viajes", 'ver/id=' . $id));
                        exit;
                    }
                }


                $this->dibujaVista(
                    "borrarViaje",
                    ['modelo' => $viaje, 'filas' => $filas, 'cab' => $cabecera, 'nombreTren' => $nombreTren],
                    "Borrar viaje"
                );
            }
        } else {
            Sistema::app()->paginaError(404, 'Viaje no encontrado');
            exit;
        }





    }

}
