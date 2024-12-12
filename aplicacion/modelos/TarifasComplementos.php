<?php
class TarifasComplementos extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'tarCom';
    }
    protected function fijarId(): string
    {
        return 'cod_tarifa_complemento';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_tarifa_complemento","cod_tarifa","cod_complemento"
        );
    }
    protected function fijarTabla(): string
    {
        return 'tarifa_complemento';
    }
 
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "cod_tarifa,cod_complemento",
                    "TIPO" => "REQUERIDO",

                ),
               array(
                    "ATRI" => "cod_complemento", 
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Complementos::dameComplemento())
                ),
                array(
                    "ATRI" => "cod_tarifa", 
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Tarifas::dameTarifa())
                ),

               
                


            );
    }


    
    protected function afterBuscar(): void
    {


        $this->cod_tarifa = intval($this->cod_tarifa);
        $this->cod_complemento = intval($this->cod_complemento);
    }


    function fijarSentenciaInsert(): string
    {
        $tarifa = intval($this->cod_tarifa);
        $complemento = intval($this->cod_complemento);


        $sentencia = "INSERT INTO `tarifa_complemento`(`cod_tarifa`, `cod_complemento`) 
        VALUES ('$tarifa',$complemento)";

        return  $sentencia;
    }



    function fijarSentenciaUpdate(): string
    {

        $tarifa = intval($this->cod_tarifa);
        $complemento = intval($this->cod_complemento);
      

        $sentencia  = "UPDATE `tarifa_complemento` SET 
                                        `cod_tarifa`='$tarifa',`cod_complemento`=$complemento WHERE
                                        `cod_tarifa` = {$this->cod_tarifa}";
        return $sentencia;
    }



}
