<?php
class Compras extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'comp';
    }
    protected function fijarId(): string
    {
        return 'cod_compra';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_compra", "cod_usuario", "fecha", "forma_pago", "unidades"
        );
    }
    protected function fijarTabla(): string
    {
        return 'compras';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "fecha" => "Fecha ",
            'forma_pago' => 'Forma pago ',
            "unidades" => 'Unidades '



        );
    }
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "cod_usuario,fecha,forma_pago",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'fecha',
                    'TIPO' => 'FECHA',
                ),
                array(
                    "ATRI" => 'forma_pago',
                    'TIPO' => 'CADENA',
                ),
                array(
                    "ATRI" => 'unidades',
                    'TIPO' => 'ENTERO',
                ),
            
            );
    }
    protected function afterCreate(): void
    {
        $this->fecha = '';
        $this->forma_pago = '';
        $this->unidades = '';
    }


    protected function afterBuscar(): void
    {


        $this->cod_compra = intval($this->cod_compra);
        $this->cod_usuario = intval($this->cod_usuario);
        $this->fecha = CGeneral::fechaMysqlANormal($this->fecha);
        $this->unidades = intval($this->unidades);

    }


    function fijarSentenciaInsert(): string
    {
        $forma = CGeneral::addSlashes($this->forma_pago);
        $codUsuario = intval($this->cod_usuario);
        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $unidades = intval($this->unidades);


        $sentencia = "INSERT INTO `compras`(`cod_usuario`, `fecha`,`forma_pago`,`unidades`) 
        VALUES ('$codUsuario','$fecha','$forma',$unidades)";

        return  $sentencia;
    }



    function fijarSentenciaUpdate(): string
    {

        $forma = CGeneral::addSlashes($this->forma_pago);
        $codUsuario = intval($this->cod_usuario);
        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $unidades = intval($this->unidades);

        $sentencia  = "UPDATE `compras` SET 
                                        `cod_usuario`='$codUsuario',`fecha`=$fecha, `forma` = '$forma',`unidades` = $unidades WHERE
                                        `cod_compra` = {$this->cod_compra}";
        return $sentencia;
    }


    
}
