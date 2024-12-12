<?php
$this->textoHead = CPager::requisitos();

// --------------USANDO DIBUJA APERTURA Y CIERRE----------------------
echo CHTML::iniciarForm("", "post", ["class" => "form-inline"]);

echo CHTML::dibujaEtiqueta('fieldset', ['class' => 'form-group shadow p-3 mb-5 bg-white rounded'], '', false);
echo CHTML::dibujaEtiqueta('legend', [], 'Filtrado', false, false, 'h6');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-2'], '', false); // Agregar margen inferior al campo de entrada
echo CHTML::campoLabel('Nombre:', 'nombre', ['class' => 'formCrud']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::campoText('nombre', '', ['class' => 'form-control-sm', 'style' => 'height: 30px;']);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del div


echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-2'], '', false); // Agregar margen inferior a los botones
echo CHTML::campoBotonReset('Limpiar', ['class' => 'btn btn-secondary mr-2 btnCrud2']);
echo CHTML::campoBotonSubmit('Filtrar', ['class' => 'btn btnCrud2']);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del div

echo CHTML::dibujaEtiquetaCierre('fieldset');

echo CHTML::finalizarForm();

// Generar la tabla con Bootstrap y ocultarla en dispositivos móviles
$tabla = new CGrid($cabecera, $filas, ['class' => 'table table-striped table-bordered d-none d-md-table']);
$tablaHtml = $tabla->dibujate();

echo CHTML::dibujaEtiqueta('div', ['class' => 'p-5 position-relative']);
echo $tablaHtml; // Tabla de tarifas
echo CHTML::dibujaEtiqueta('h1', ['class' => 'position-absolute top-0 translate-middle start-50 text-center textoFondo', 'style' => 'z-index: -1;'], 'TRAYECTOS');
echo CHTML::dibujaEtiquetaCierre('div');

// Crear el contenedor para las tarjetas y ocultarlas en dispositivos grandes
echo CHTML::dibujaEtiqueta('div', ['class' => 'd-md-none'], '', false);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row'], '', false);

foreach ($filas as $tarifa => $prop) {
    echo CHTML::dibujaEtiqueta('div', ['class' => 'col-12 mb-3'], '', false);
    echo CHTML::dibujaEtiqueta('div', ['class' => 'card shadow-sm'], '', false); // Agregar sombra a las cards
    echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body'], '', false);
    foreach ($prop as $ind => $valor) {
        foreach($cabecera as $in => $p){
            if(in_array($ind,$p)){
                echo CHTML::dibujaEtiqueta('h6', ['class' => 'card-title'], $ind, false);
                echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text'], $valor, false);
            }
        }
    }
    echo CHTML::dibujaEtiquetaCierre('div'); // Cerrar card-body
    echo CHTML::dibujaEtiquetaCierre('div'); // Cerrar card
    echo CHTML::dibujaEtiquetaCierre('div'); // Cerrar col-12
}
echo CHTML::dibujaEtiquetaCierre('div'); // Cerrar row
echo CHTML::dibujaEtiquetaCierre('div'); // Cerrar d-md-none

echo CHTML::dibujaEtiqueta('div', ['class' => 'd-flex justify-content-start mt-3'], '', false);
echo CHTML::link(
    'Nuevo trayecto',
    Sistema::app()->generaURL(['trayectos', 'nuevo']),
    ['class' => 'btn btnCrud ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div');

$paginado = new CPager($opcpag);

echo $paginado->dibujate();
