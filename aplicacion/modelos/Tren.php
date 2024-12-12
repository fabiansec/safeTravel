<?php
class Tren extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'tre';
    }
    protected function fijarId(): string
    {
        return 'cod_tren';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nombre", "cod_tren", "numero", "asientos"
        );
    }
    protected function fijarTabla(): string
    {
        return 'tren';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "nombre" => "Nombre ",
            "numero" => "Numero ",
            'asientos' => 'Asientos ',


        );
    }
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 30
                ),
                array(
                    "ATRI" => 'numero',
                    'TIPO' => 'ENTERO',
                    'MIN' => 0,
                    'MAX' => 100
                ),
                array(
                    "ATRI" => 'asientos',
                    'TIPO' => 'ENTERO',
                    'MIN' => 0,
                    'MAX' => 100
                ),
            );
    }
    protected function afterCreate(): void
    {
        $this->cod_tren = 0;
        $this->numero = 0;
        $this->asientos = 0;
    }


    protected function afterBuscar(): void
    {


        $this->cod_tren = intval($this->cod_tren);
        $this->asientos = intval($this->asientos);
        $this->numero = intval($this->numero);
        $this->nombre = CGeneral::addSlashes($this->nombre);
    }


    function fijarSentenciaInsert(): string
    {
       
        $numero = intval($this->numero);
        $asientos = intval($this->asientos);
        $nombre = CGeneral::addSlashes($this->nombre);

        $sentencia = "INSERT INTO `tren`(`numero`, `asientos`,`nombre`) 
        VALUES ($numero,$asientos,'$nombre')";

        return  $sentencia;
    }



    function fijarSentenciaUpdate(): string
    {

        $numero = intval($this->numero);
        $asientos = intval($this->asientos);
        $nombre = CGeneral::addSlashes($this->nombre);



        $sentencia  = "UPDATE `tren` SET 
                                        `numero`=$numero,`asientos`=$asientos,`nombre`='$nombre' WHERE
                                        `cod_tren` = {$this->cod_tren}";
        return $sentencia;
    }


    public static function dameTren(?int $cod_tren = null) {
        $ob = new Tren();
        $array = [];
        if (!isset($cod_tren)) {
             $ob = $ob->buscarTodos();
             foreach($ob as $cat => $val){
                    $array[$val['cod_tren']] = $val['nombre'];
             }

             return $array;
        }

        if ($ob->buscarPorId($cod_tren)) {
            return $ob->buscarTodos(
                [
                    "select"=>"*",
                    "where"=>"cod_tren = $cod_tren"
                ]
            )[0];
        }

        return false;
    }
}
