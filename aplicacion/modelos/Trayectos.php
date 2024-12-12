<?php
class Trayectos extends CActiveRecord
{


    protected function fijarNombre(): string
    {
        return 'tra';
    }
    protected function fijarId(): string
    {
        return 'cod_trayecto';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_trayecto", "precio_total", "tiempo_total", "nombre","borrado"
        );
    }

    protected function fijarTabla(): string
    {
        return 'trayectos';
    }
    
    protected function fijarDescripciones(): array
    {
        return array(
            "precio_total" => "Precio total ",
            'tiempo_total' => 'Tiempo total ',
            'borrado' => 'Borrado ',
            'nombre ' => 'Nombre '



        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nombre,tiempo_total",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'precio_total',
                    'TIPO' => 'REAL',
                    'MIN' => 0
                ),
                
               array(
                    "ATRI" => "tiempo_total", 
                    "TIPO" => "HORA",
                    'DEFECTO' => '00:40:00'
                ),
                array(
                    "ATRI" => "nombre", 
                    "TIPO" => "CADENA",
                    'TAMANIO' => 50,
                    'MENSAJE' => 'Debes introducir una cadena de máximo 30 caracteres'
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
        $this->precio_total = 0;
        $this->tiempo_total = '00:40:00';
        $this->cod_trayecto = 0;
        $this->borrado = 0;
        $this->nombre = '';

    }

    
    protected function afterBuscar(): void
    {


        $this->nombre = CGeneral::addSlashes($this->getNombre());
        $this->cod_trayecto = intval($this->cod_trayecto);
        $this->borrado = intval($this->borrado);
        $this->precio_total = floatval($this->precio_total);
        $this->tiempo_total = floatval($this->tiempo_total);

    }

    function fijarSentenciaInsert(): string
    {

        $precioTotal = floatval($this->precio_total);
        $tiempoTotal = CGeneral::addSlashes($this->tiempo_total);
        $nombre = CGeneral::addSlashes($this->nombre);
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

        $sentencia = "INSERT INTO `trayectos`(`precio_total`, `tiempo_total`,`nombre`,`borrado`) 
        VALUES ($precioTotal,'$tiempoTotal','$nombre',$borrado)";

        return  $sentencia;
    }

    function fijarSentenciaUpdate(): string
    {

        $precioTotal = floatval($this->precio_total);
        $tiempoTotal = CGeneral::addSlashes($this->tiempo_total);
            $nombre = CGeneral::addSlashes($this->nombre);
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

       
        $sentencia  = "UPDATE `trayectos` SET 
                                        `precio_total`='$precioTotal',`tiempo_total`='$tiempoTotal',`borrado`=$borrado, `nombre`='$nombre' WHERE
                                        `cod_trayecto` = {$this->cod_trayecto}";
        return $sentencia;
    }


    public static function dameTrayecto(?int $cod_trayecto = null) {
        $ob = new Trayectos();
        $array = [];
        if (!isset($cod_trayecto)) {
             $ob = $ob->buscarTodos();
             foreach($ob as $cat => $val){
                    $array[$val['cod_trayecto']] = $val['nombre'];
             }

             return $array;
        }

        if ($ob->buscarPorId($cod_trayecto)) {
            return $ob->buscarTodos(
                [
                    "select"=>"*",
                    "where"=>"cod_trayecto = $cod_trayecto"
                ]
            )[0];
        }

        return false;
    }


}
