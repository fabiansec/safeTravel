<?php
class Tarifas extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'tar';
    }
    protected function fijarId(): string
    {
        return 'cod_tarifa';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_tarifa","nombre","precio","borrado"
        );
    }
    protected function fijarTabla(): string
    {
        return 'tarifas';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "nombre" => "Nombre ",
            'precio' => 'Precio ',
            "borrado" => 'Borrado '
            


        );

    }
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nombre,precio",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'nombre',
                    'TIPO' => 'CADENA',
                    'TAMANIO' => 30,
                    'MENSAJE' => 'Debes introducir una cadena de longitud maxima 30',
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
        $this->borrado = '';
    }

    
    protected function afterBuscar(): void
    {


        $this->cod_tarifa = intval($this->cod_tarifa);
        $this->precio = floatval($this->precio);
        $this->borrado = intval($this->borrado);

    }


    function fijarSentenciaInsert(): string
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $precio = floatval($this->precio);
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

        $sentencia = "INSERT INTO `tarifas`(`nombre`, `precio`,`borrado`) 
        VALUES ('$nombre',$precio,$borrado)";

        return  $sentencia;
    }



    function fijarSentenciaUpdate(): string
    {

        $nombre = CGeneral::addSlashes($this->nombre);
        $precio = floatval($this->precio);
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

        $sentencia  = "UPDATE `tarifas` SET 
                                        `nombre`='$nombre',`precio`=$precio, `borrado`=$borrado WHERE
                                        `cod_tarifa` = {$this->cod_tarifa}";
        return $sentencia;
    }


    public static function dameTarifa(?int $cod_tarifa = null) {
        $ob = new Tarifas();
        $array = [];
        if (!isset($cod_tarifa)) {
             $ob = $ob->buscarTodos();
             foreach($ob as $cat => $val){
                    $array[$val['cod_tarifa']] = $val['nombre'];
             }

             return $array;
        }

        if ($ob->buscarPorId($cod_tarifa)) {
            return $ob->buscarTodos(
                [
                    "select"=>"*",
                    "where"=>"cod_tarifa = $cod_tarifa"
                ]
            )[0];
        }

        return false;
    }


}
