<?php
class Registro extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'reg';
    }
    protected function fijarAtributos(): array
    {
        return array(
            "nick","contrasenia","email","repite",
        );
    }
    protected function fijarTabla(): string
    {
        return 'usuarios';
    }
    protected function fijarDescripciones(): array
    {
        return array(
            "nick" => "Nick ",
            'contrasenia' => 'Contraseña ',
            'email' => 'Correo Electronico ',
            'repite' => 'Confirma contraseña'


        );

    }
    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nick,contrasenia,repite,email",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => 'nick',
                    'TIPO' => 'CADENA',
                    'TAMANIO' => 20,
                    'MENSAJE' => 'Debes introducir una cadena de longitud maxima 20',
                ),
               array(
                    "ATRI" => "contrasenia", 
                    "TIPO" => "CADENA",
                    "TAMANIO" => 20,
                )
                ,
                array(
                    "ATRI" => "contrasenia", 
                    "TIPO" => "FUNCION",
                    "FUNCION" => 'validarPass',
               )
                


            );
    }
    protected function afterCreate(): void
    {
        $this->nick = '';
        $this->contrasenia = '';
    }


    public function validarPass():void{

        if($this->repite !==  $this->contrasenia ){
                $this->setError('repite','Las contraseñas no coinciden');
            
        }


    }

    public function validaUsuario() :bool{

        $usuarios = $this->buscarTodos();
        $errores = array();
        foreach($usuarios as $clave => $valor){
            if($valor['nick'] === $this->nick){
                $this->setError('nick','Nick ya usado');
                $errores['nick'] = 'Nick usado';
            }
            if($valor['email'] == $this->email){
                $this->setError('email','Email ya usado');
                $errores['email'] = 'Email usado';
            }
        }

        

        return (count($errores) === 0);


    }

    function fijarSentenciaInsert(): string
    {
        $nombre = CGeneral::addSlashes($this->nick);
        $email = CGeneral::addSlashes($this->email);


        $sentencia = "INSERT INTO `usuarios`(`nick`, `email`) 
        VALUES ('$nombre','$email')";

        return  $sentencia;
    }


}
