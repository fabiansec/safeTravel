<?php
class Viajes extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'via';
    }
    protected function fijarId(): string
    {
        return 'cod_viaje';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nombre", "cod_viaje", "cod_trayecto", "hora_salida", "fecha", "precio_viaje", "cod_tren","borrado"
        );
    }
    protected function fijarTabla(): string
    {
        return 'cons_viajes';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "nombre" => "Nombre ",
            "hora_salida" => "Hora salida ",
            'fecha' => 'Fecha ',
            "precio_viaje" => 'Precio viaje ',
            'borrado' => 'Borrado '



        );
    }
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "cod_trayecto,fecha,hora_salida,precio_viaje,cod_tren",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => "cod_trayecto",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Trayectos::dameTrayecto())
                ),
                array(
                    "ATRI" => "cod_tren",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Tren::dameTren())
                ),
                array(
                    "ATRI" => 'fecha',
                    'TIPO' => 'CADENA',
                ),
                array(
                    "ATRI" => 'fecha',
                    'TIPO' => 'FUNCION',
                    'FUNCION' => 'validarFecha'
                ),
                array(
                    "ATRI" => "hora_salida",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 8,
                    'DEFECTO' => '00:00:00'
                ),
                array(
                    "ATRI" => "hora_salida",
                    "TIPO" => "FUNCION",
                    'FUNCION' => 'validarTiempo'

                ),
                array(
                    "ATRI" => "precio_viaje",
                    "TIPO" => "REAL",
                    "MIN" => 0
                ),
                array(
                    "ATRI" => "borrado", 
                    "TIPO" => "ENTERO",
                    'DEFECTO' => 0
                
                )

            );
    }
    protected function afterCreate(): void
    {
        $this->cod_viaje = 0;
        $this->precio_viaje = 0;
        $this->fecha = date('d/m/Y');
        $this->cod_trayecto = 0;
        $this->cod_tren = 0;
        $this->hora_salida = '00:00:00';
        $this->borrado = 0;

    }


    protected function afterBuscar(): void
    {


        $this->cod_viaje = intval($this->cod_viaje);
        $this->cod_trayecto = intval($this->cod_trayecto);
        $this->precio_viaje = floatval($this->precio_viaje);
        $fecha = $this->fecha;
        $fecha = CGeneral::fechaMysqlANormal($fecha);
        $this->fecha = $fecha;
        $this->cod_tren = intval($this->cod_tren);
        $this->borrado = intval($this->borrado);

    }


    function fijarSentenciaInsert(): string
    {
        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $codTrayecto = intval($this->cod_trayecto);
        $precio = floatval($this->precio_viaje);
        $hora = CGeneral::addSlashes($this->hora_salida);
        $codTren = intval($this->cod_tren);
        $borrado = trim($this->borrado);
        if ($borrado === 'Si') {
            $borrado = mb_strtolower($borrado);
            $this->borrado = 1;
            $borrado = intval($this->borrado);
        } else if ($borrado === 'No') {
            $borrado = mb_strtolower($borrado);
            $this->borrado = 0;
            $borrado = intval($this->borrado);
        }



        $sentencia = "INSERT INTO `viajes`(`cod_trayecto`, `precio_viaje`,`fecha`,`hora_salida`,`cod_tren`,`borrado`) 
        VALUES ($codTrayecto,$precio,'$fecha','$hora',$codTren,$borrado)";

        return  $sentencia;
    }



    function fijarSentenciaUpdate(): string
    {

        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $codTrayecto = intval($this->cod_trayecto);
        $precio = floatval($this->precio_viaje);
        $hora = CGeneral::addSlashes($this->hora_salida);
        $codTren = intval($this->cod_tren);
        $borrado = trim($this->borrado);
        if ($borrado === 'Si') {
            $borrado = mb_strtolower($borrado);
            $this->borrado = 1;
            $borrado = intval($this->borrado);
        } else if ($borrado === 'No') {
            $borrado = mb_strtolower($borrado);
            $this->borrado = 0;
            $borrado = intval($this->borrado);
        }

        $sentencia  = "UPDATE `viajes` SET 
                                        `cod_trayecto`='$codTrayecto',`precio_viaje`=$precio,`cod_tren`=$codTren,`fecha`='$fecha',`hora_salida`='$hora',`borrado`=$borrado WHERE
                                        `cod_viaje` = {$this->cod_viaje}";
        return $sentencia;
    }


    function validarTiempo()
    {

        $regex = '/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/';

        if (!preg_match($regex, $this->hora_salida)) {
            $this->setError('hora_salida', 'El formato de hora no es válido. Debe ser hh:mm:ss.');
        }
    }


    function validarFecha()
    {

        $fechaInt = CGeneral::addSlashes($this->fecha);
        // Convierte la fecha al formato 'dd/mm/yyyy' a 'DateTime'

        if ($fechaInt === '') {
            // Si la fecha proporcionada no es válida
            $this->setError('fecha', 'El formato de la fecha no es válido. Debe ser dd/mm/yyyy.');
        } else {
            $fecha = CGeneral::fechaMysqlANormal($fechaInt);

            // Obtiene la fecha actual en el formato 'd/m/Y'
            $fechaAct = date('d/m/Y');
            $fechaActObjeto = DateTime::createFromFormat('d/m/Y', $fechaAct);
            $fechaIntro = DateTime::createFromFormat('d/m/Y',$fecha);

            if ($fechaIntro < $fechaActObjeto) {
                $this->setError('fecha', 'La fecha no puede ser menor al día actual.');
            }
        }
    }

    public static function dameViaje(?int $cod_viaje = null) {
        $ob = new Viajes();
        $array = [];
        if (!isset($cod_viaje)) {
             $ob = $ob->buscarTodos();
             foreach($ob as $cat => $val){
                    $array[$val['cod_viaje']] = $val['nombre'];
             }

             return $array;
        }

        if ($ob->buscarPorId($cod_viaje)) {
            return $ob->buscarTodos(
                [
                    "select"=>"*",
                    "where"=>"cod_viaje = $cod_viaje"
                ]
            )[0];
        }

        return false;
    }



}
