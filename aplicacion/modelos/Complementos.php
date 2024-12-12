<?php
class Complementos extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'com';
    }
    protected function fijarId(): string
    {
        return 'cod_complemento';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_complemento", "nombre", "descripcion", "precio"
        );
    }
    protected function fijarTabla(): string
    {
        return 'complemento';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "nombre" => "Nombre ",
            'precio' => 'Precio ',
            'descripcion' => 'Descripcion '



        );
    }
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nombre,precio,descripcion",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'nombre',
                    'TIPO' => 'CADENA',
                    'TAMANIO' => 30,
                    'MENSAJE' => 'Debes introducir una cadena de longitud maxima 30',
                ),
                array(
                    "ATRI" => "descripcion",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 30
                ),
                array(
                    "ATRI" => "precio",
                    "TIPO" => "REAL",
                    "MIN" => 0
                ),





            );
    }
    protected function afterCreate(): void
    {
        $this->nombre = '';
        $this->precio = '';
        $this->descripcion = '';
    }


    protected function afterBuscar(): void
    {


        $this->cod_complemento = intval($this->cod_complemento);
        $this->precio = intval($this->precio);
        
    }


    function fijarSentenciaInsert(): string
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $descripcion = CGeneral::addSlashes($this->descripcion);
        $precio = intval($this->precio);


        $sentencia = "INSERT INTO `complemento`(`nombre`, `precio`,`descripcion`) 
        VALUES ('$nombre',$precio,'$descripcion')";

        return  $sentencia;
    }



    function fijarSentenciaUpdate(): string
    {

        $nombre = CGeneral::addSlashes($this->nombre);
        $precio = intval($this->precio);
        $descripcion = CGeneral::addSlashes($this->descripcion);

        $sentencia  = "UPDATE `complemento` SET 
                                        `nombre`='$nombre',`precio`=$precio, `descripcion` = '$descripcion' WHERE
                                        `cod_complemento` = {$this->cod_complemento}";
        return $sentencia;
    }


    public static function dameComplemento(?int $cod_complemento = null) {
        $ob = new Complementos();
        $array = [];
        if (!isset($cod_complemento)) {
             $ob = $ob->buscarTodos();
             foreach($ob as $cat => $val){
                    $array[$val['cod_complemento']] = $val['nombre'];
             }

             return $array;
        }

        if ($ob->buscarPorId($cod_complemento)) {
            return $ob->buscarTodos(
                [
                    "select"=>"*",
                    "where"=>"cod_complemento = $cod_complemento"
                ]
            )[0];
        }

        return false;
    }
}
