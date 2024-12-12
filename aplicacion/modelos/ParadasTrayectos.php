<?php
class ParadasTrayectos extends CActiveRecord
{


    protected function fijarNombre(): string
    {
        return 'parTar';
    }
    protected function fijarId(): string
    {
        return 'cod_parada_trayecto';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_parada", "cod_trayecto", "orden", "tiempo", "tiempo_estacion", "kilometros", "precio"
        );
    }
    protected function fijarTabla(): string
    {
        return 'paradas_trayectos';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "orden" => "Orden ",
            'tiempo' => 'Tiempo ',
            "tiempo_estacion" => 'Tiempo en la estacion ',
            "kilometros" => 'Kilometros ',
            "precio" => 'Precio '



        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "cod_parada,cod_trayecto,tiempo,tiempo_estacion",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'cod_parada',
                    'TIPO' => 'ENTERO',
                    'MIN' => 0,
                ),
                array(
                    "ATRI" => "cod_parada",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Paradas::dameParada())
                ),
                array(
                    "ATRI" => "cod_trayecto",
                    "TIPO" => "ENTERO",
                    'MIN' => 0
                ),
                array(
                    "ATRI" => "cod_trayecto",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Trayectos::dameTrayecto())
                ),
                array(
                    "ATRI" => "orden",
                    "TIPO" => "ENTERO",
                    'MIN' => 0
                ),
                array(
                    "ATRI" => "tiempo",
                    "TIPO" => "CADENA",
                    'TAMANIO' => 8
                ),
                array(
                    "ATRI" => "tiempo",
                    "TIPO" => "FUNCION",
                    'FUNCION' => 'validarTiempo'

                ),
                array(
                    "ATRI" => "tiempo_estacion",
                    "TIPO" => "CADENA",
                    'TAMANIO' => 8


                ),
                array(
                    "ATRI" => "tiempo_estacion",
                    "TIPO" => "FUNCION",
                    'FUNCION' => 'validarTiempoEstacion'

                ),
                array(
                    "ATRI" => "kilometros",
                    "TIPO" => "REAL",
                    'MIN' => 0
                ),
                array(
                    "ATRI" => "precio",
                    "TIPO" => "REAL",
                    'MIN' => 0
                ),

            );
    }




    protected function afterCreate(): void
    {
        $this->orden = '';
        $this->tiempo = '';
        $this->tiempo_estacion = '';
        $this->kilometros = '';
        $this->precio = '';
    }


    protected function afterBuscar(): void
    {


        $this->cod_parada = intval($this->cod_parada);
        $this->cod_trayecto = intval($this->cod_trayecto);
        $this->orden = intval($this->orden);
        $this->kilometros = floatval($this->kilometros);
        $this->precio = floatval($this->precio);
    }


    function fijarSentenciaInsert(): string
    {

        $codParada = intval($this->cod_parada);
        $codTrayecto = intval($this->cod_trayecto);
        $orden = intval($this->orden);
        $kilometros = floatval($this->kilometros);
        $precio = floatval($this->precio);
        $tiempo = CGeneral::addSlashes($this->tiempo);
        $tiempoEstacion = CGeneral::addSlashes($this->tiempo_estacion);

        $sentencia = "INSERT INTO `paradas_trayectos`(`cod_parada`, `cod_trayecto`,`orden`,`kilometros`,`precio`,`tiempo`,`tiempo_estacion`) 
        VALUES ('$codParada','$codTrayecto',$orden,$kilometros,$precio,'$tiempo','$tiempoEstacion')";

        return  $sentencia;
    }

    
    function fijarSentenciaUpdate(): string
    {

        $codParada = intval($this->cod_parada);
        $codTrayecto = intval($this->cod_trayecto);
        $orden = intval($this->orden);
        $kilometros = floatval($this->kilometros);
        $precio = floatval($this->precio);
        $tiempo = CGeneral::addSlashes($this->tiempo);
        $tiempoEstacion = CGeneral::addSlashes($this->tiempo_estacion);
        

        $sentencia  = "UPDATE `paradas_trayectos` SET 
                                        `cod_parada`='$codParada',`cod_trayecto`=$codTrayecto, `orden`=$orden
                                        ,`kilometros`=$kilometros,`precio`=$precio,`tiempo` ='$tiempo',`tiempo_estacion` = '$tiempoEstacion' WHERE
                                        `cod_trayecto` = {$this->cod_trayecto} and `cod_parada` = {$this->cod_parada}";
        return $sentencia;
    }

    function validarTiempo(){

        $regex = '/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/';

        if (!preg_match($regex, $this->tiempo)) {
            $this->setError('tiempo', 'El formato de tiempo no es válido. Debe ser hh:mm:ss.');

        }

    }

    function validarTiempoEstacion(){

        $regex = '/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/';

        if (!preg_match($regex, $this->tiempo_estacion)) {
            $this->setError('tiempo_estacion', 'El formato de tiempo no es válido. Debe ser hh:mm:ss.');
        }

    }

}
