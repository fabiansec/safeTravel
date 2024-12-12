<?php
class Paradas extends CActiveRecord{

    protected function fijarNombre(): string
    {
        return 'par';
    }
    protected function fijarId(): string
    {
        return 'cod_parada';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_parada","nombre","poblacion","provincia"
        );
    }
    protected function fijarTabla(): string
    {
        return 'paradas';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "nombre" => "Nombre ",
            'poblacion' => 'Poblacion ',
            "provincia" => 'Provincia '
            


        );

    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nombre,poblacion,provincia",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'nombre',
                    'TIPO' => 'CADENA',
                    'TAMANIO' => 50,
                    'MENSAJE' => 'Debes introducir una cadena de longitud maxima 50',
                ),
                array(
                    "ATRI" => 'poblacion',
                    'TIPO' => 'CADENA',
                    'TAMANIO' => 30,
                ),
                array(
                    "ATRI" => 'provincia',
                    'TIPO' => 'CADENA',
                    'TAMANIO' => 30,
                ),



            );
    }

    protected function afterCreate(): void
    {
        $this->nombre = '';
        $this->poblacion = '';
        $this->provincia = '';
    }

    
    protected function afterBuscar(): void
    {


        $this->cod_parada = intval($this->cod_parada);
  

    }

    function fijarSentenciaInsert(): string
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $provincia = CGeneral::addSlashes($this->provincia);

      
        $sentencia = "INSERT INTO `paradas`(`nombre`, `poblacion`,`provincia`) 
        VALUES ('$nombre',$poblacion,$provincia)";

        return  $sentencia;
    }

    function fijarSentenciaUpdate(): string
    {

        $nombre = CGeneral::addSlashes($this->nombre);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $provincia = CGeneral::addSlashes($this->provincia);


       

        $sentencia  = "UPDATE `paradas` SET 
                                        `nombre`='$nombre',`poblacion`=$poblacion, `provincia`=$provincia WHERE
                                        `cod_parada` = {$this->cod_parada}";
        return $sentencia;
    }

    public static function dameParada(?int $cod_parada = null) {
        $ob = new Paradas();
        $array = [];
        if (!isset($cod_parada)) {
             $ob = $ob->buscarTodos();
             foreach($ob as $cat => $val){
                    $array[$val['cod_parada']] = $val['nombre'];
             }

             return $array;
        }

        if ($ob->buscarPorId($cod_parada)) {
            return $ob->buscarTodos(
                [
                    "select"=>"*",
                    "where"=>"cod_parada = $cod_parada"
                ]
            )[0];
        }

        return false;
    }


}