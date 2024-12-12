<?php
class Billete extends CActiveRecord
{


    protected function fijarNombre(): string
    {
        return 'bi';
    }
    protected function fijarId(): string
    {
        return 'cod_billete';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_viaje", "cod_parada_origen", "cod_parada_destino", "cod_tarifa", "cod_compra",
            "fecha_ida", "fecha_vuelta", "precio_base", "iva", "precio_billete", "nombre", "dni", "fecha_nac", "telefono"
        );
    }

    protected function fijarTabla(): string
    {
        return 'billete';
    }


    protected function fijarDescripciones(): array
    {
        return array(


            'precio_base' => 'Precio base ',
            'iva ' => 'Iva ',
            'precio_billete' => 'Precio billete ',
            'nombre' => 'Nombre ',
            'dni' => 'DNI ',
            'fech_nac' => 'Fecha de nacimiento ',
            'telefono' => 'Telefono ',
            'fecha_ida' => 'Fecha ida ',
            'fecha_vuelta' => 'Fecha vuelta',



        );
    }


    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "cod_billete", "cod_viaje", "cod_parada_origen", "cod_parada_destino", "cod_tarifa", "cod_compra",
                    "fecha_ida", "fecha_vuelta", "precio_base", "iva", "precio_billete", "nombre",
                    "dni", "fecha_nac", "telefono",
                    "TIPO" => "REQUERIDO",

                ),
                array(
                    "ATRI" => "cod_parada_origen",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Paradas::dameParada())
                ),
                array(
                    "ATRI" => "cod_parada_destino",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Paradas::dameParada())
                ),
                array(
                    "ATRI" => "cod_tarifa",
                    "TIPO" => "RANGO",
                    "RANGO" => array_keys(Tarifas::dameTarifa())
                ),
                array(
                    "ATRI" => "precio_base",
                    "TIPO" => "REAL",
                    'MIN' => 0
                ),
                array(
                    "ATRI" => "iva",
                    "TIPO" => "ENTERO",
                    "DEFECTO" => 21
                ),
                array(
                    "ATRI" => "precio_billete",
                    "TIPO" => "REAL",
                    'MIN' => 0
                ),
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "CADENA",
                    'TAMANIO' => 30
                ),
                array(
                    "ATRI" => "dni",
                    "TIPO" => "CADENA",
                    'TAMANIO' => 9
                ),
                array(
                    "ATRI" => "dni",
                    "TIPO" => "FUNCION",
                    'FUNCION' => 'validaDNI'
                ),
                array(
                    "ATRI" => "fecha_nac",
                    "TIPO" => "FECHA",
                ),
                array(
                    "ATRI" => "fecha_nac",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaFecha"
                ),
                array(
                    "ATRI" => "telefono",
                    "TIPO" => "CADENA",
                    'TAMANIO' => 9
                ),
                array(
                    "ATRI" => 'fecha_ida',
                    'TIPO' => 'FECHA',
                ),
                array(
                    "ATRI" => "fecha_ida",
                    "TIPO" => "FUNCION",
                    'FUNCION' => 'validaFechaIda'

                ),
                array(
                    "ATRI" => 'fecha_vuelta',
                    'TIPO' => 'FECHA',
                ),
                array(
                    "ATRI" => "fecha_vuelta",
                    "TIPO" => "FUNCION",
                    'FUNCION' => 'validaFechaVuelta'

                ),

            );
    }

    protected function afterCreate(): void
    {
        $this->cod_billete = 0;
        $this->cod_viaje = 0;
        $this->cod_parada_origen = '';
        $this->cod_parada_destino = '';
        $this->cod_tarifa = 0;
        $this->cod_compra = 0;

        $this->precio_base = 0;
        $this->iva = 21;
        $this->precio_billete = 0;
        $this->nombre = '';
        $this->dni = '';
        $this->fecha_nac = '';
        $this->fecha_ida = '';
        $this->fecha_vuelta = '';
        $this->telefono = 0;
    }

    protected function afterBuscar(): void
    {

        $this->cod_billete = intval($this->cod_billete);
        $this->cod_viaje = intval($this->cod_viaje);
        $this->cod_parada_origen = intval($this->cod_parada_origen);
        $this->cod_parada_destino = intval($this->cod_parada_destino);
        $this->cod_tarifa = intval($this->cod_tarifa);
        $this->cod_compra = intval($this->cod_compra);

        $this->precio_base = floatval($this->precio_base);
        $this->iva = 21;
        $this->precio_billete = floatval($this->precio_billete);
        $this->nombre = CGeneral::addSlashes($this->nombre);
        $this->dni = CGeneral::addSlashes($this->dni);
        $this->fecha_nac = CGeneral::fechaMysqlANormal($this->fecha_nac);
        $this->fecha_ida = CGeneral::fechaMysqlANormal($this->fecha_ida);
        $this->fecha_vuelta = CGeneral::fechaMysqlANormal($this->fecha_vuelta);
        $this->telefono = floatval($this->telefono);
    }


    function fijarSentenciaInsert(): string
    {


        $codViaje = intval($this->cod_viaje);
        $codCompra = intval($this->cod_compra);
        $codOrigen = intval($this->cod_parada_origen);
        $codDestino = intval($this->cod_parada_destino);
        $codTarifa = intval($this->cod_tarifa);
        $precioBase = floatval($this->precio_base);
        $iva = floatval($this->iva);
        $precioBillete = floatval($this->precio_billete);
        $nombre = CGeneral::addSlashes($this->nombre);
        $dni = CGeneral::addSlashes($this->dni);
        $fechaIda = CGeneral::fechaNormalAMysql($this->fecha_ida);
        $fechaNac = CGeneral::fechaNormalAMysql($this->fecha_nac);
        $fechaVuelta = CGeneral::fechaNormalAMysql($this->fecha_vuelta);
        $telefono  = floatval($this->telefono);

        $sentencia = "INSERT INTO `billete`(`cod_viaje`, `cod_parada_origen`,`cod_parada_destino`,`cod_tarifa`,`iva`,`precio_billete`,`nombre`,
                                            `dni`,`cod_compra`,`precio_base`,
                                            `fecha_nac`,`fecha_ida`,`fecha_vuelta`,`telefono`) 
        VALUES ($codViaje,$codOrigen,$codDestino,$codTarifa,$iva,$precioBillete,'$nombre','$dni',
                $codCompra,$precioBase,'$fechaNac','$fechaIda','$fechaVuelta',$telefono)";


        return  $sentencia;
    }


    function fijarSentenciaUpdate(): string
    {

        $codViaje = intval($this->cod_viaje);
        $codCompra = intval($this->cod_compra);
        $codOrigen = intval($this->cod_parada_origen);
        $codDestino = intval($this->cod_parada_destino);
        $codTarifa = intval($this->cod_tarifa);
        $precioBase = floatval($this->precio_base);
        $iva = floatval($this->iva);
        $precioBillete = floatval($this->precio_billete);
        $nombre = CGeneral::addSlashes($this->nombre);
        $dni = CGeneral::addSlashes($this->dni);
        $fechaIda = CGeneral::fechaNormalAMysql($this->fecha_ida);
        $fechaNac = CGeneral::fechaNormalAMysql($this->fecha_nac);
        $fechaVuelta = CGeneral::fechaNormalAMysql($this->fecha_vuelta);
        $telefono  = floatval($this->telefono);



        $sentencia  = "UPDATE `billete` SET 
                                        `cod_viaje`='$codViaje',`cod_parada_origen`='$codOrigen',`cod_parada_destino`=$codDestino, `cod_tarifa`=$codTarifa,
                                        `iva`=$iva,`precio_billete`=$precioBillete,`nombre`='$nombre',`dni`='$dni',
                                        `cod_compra`=$codCompra,`precio_base`=$precioBase,
                                        `fecha_nac` = '$fechaNac',`fecha_ida` ='$fechaIda',`fecha_vuelta`='$fechaVuelta',`telefono` = $telefono
                                         WHERE
                                        `cod_billete` = {$this->cod_billete}";
        return $sentencia;
    }


    function validaFechaIda()
    {


        $fechaInt = CGeneral::addSlashes($this->fecha_ida);
        // Convierte la fecha al formato 'dd/mm/yyyy' a 'DateTime'

        if ($fechaInt === '') {
            // Si la fecha proporcionada no es válida
            $this->setError('fecha_ida', 'El formato de la fecha no es válido. Debe ser dd/mm/yyyy.');
        } else {
            $fecha = CGeneral::fechaMysqlANormal($fechaInt);

            // Obtiene la fecha actual en el formato 'd/m/Y'
            $fechaAct = date('d/m/Y');
            $fechaActObjeto = DateTime::createFromFormat('d/m/Y', $fechaAct);
            $fechaIntro = DateTime::createFromFormat('d/m/Y', $fecha);
            $fechaVuelta = DateTime::createFromFormat('d/m/Y', $this->fecha_vuelta);


            if ($fechaIntro < $fechaActObjeto) {
                $this->setError('fecha_ida', 'La fecha no puede ser menor al día actual.');
            }

            if ($fechaVuelta) {
                if ($fechaIntro > $fechaVuelta) {
                    $this->setError('fecha_ida', 'La fecha de ida no puede ser superior a la fecha de vuelta.');
                }
            }
        }
    }

    function validaFechaVuelta()
    {


        $fechaInt = CGeneral::addSlashes($this->fecha_vuelta);
        // Convierte la fecha al formato 'dd/mm/yyyy' a 'DateTime'

        if ($fechaInt === '') {
            // Si la fecha proporcionada no es válida
            $this->setError('fecha_vuelta', 'El formato de la fecha no es válido. Debe ser dd/mm/yyyy.');
        } else {
            $fecha = CGeneral::fechaMysqlANormal($fechaInt);

            // Obtiene la fecha actual en el formato 'd/m/Y'
            $fechaAct = date('d/m/Y');
            $fechaActObjeto = DateTime::createFromFormat('d/m/Y', $fechaAct);
            $fechaIntro = DateTime::createFromFormat('d/m/Y', $fecha);
            $fechaVuelta = DateTime::createFromFormat('d/m/Y', $this->fecha_vuelta);


            if ($fechaVuelta < $fechaActObjeto) {
                $this->setError('fecha_vuelta', 'La fecha de vuelta no puede ser menor al día actual.');
            }

            if ($fechaVuelta) {
                if ($fechaVuelta < $fechaIntro) {
                    $this->setError('fecha_vuelta', 'La fecha de vuelta no puede ser inferior a la fecha de ida.');
                }
            }
        }
    }

    function validaDNI()
    {

        $dni = CGeneral::addSlashes($this->dni);
        if (strlen($dni) !== 9) {
            $this->setError('dni', 'Debe tener una logitud de 9 caracteres');
        }

        // Separar la parte numérica de la letra
        $numero = substr($dni, 0, -1);
        $letra = substr($dni, -1);

        // Validar que la parte numérica es realmente numérica
        if (!is_numeric($numero)) {
            return false;
        }

        // Letras válidas para cada número
        $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";

        // Calcular la letra correcta
        $letraCorrecta = $letrasValidas[intval($numero) % 23];

        // Comparar la letra proporcionada con la letra calculada
        if (strtoupper($letra) !== $letraCorrecta) {
            $this->setError('dni', 'No es correcto');
        }
    }

    function validaFecha()
    {
        $fechaFormat = CGeneral::fechaNormalAMysql($this->fecha_nac);
        $fecha = DateTime::createFromFormat('Y-m-d', $fechaFormat);
        // Obtener la fecha actual
        $fechaActual = new DateTime();

        // Comparar las fechas
        if ($fecha > $fechaActual) {
            $this->setError('fecha_nac', 'Debe ser anterior al día actual');
        }
    }
}
