<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center mb-4 d-none d-md-block'], 'Añadir Paradas');
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');
if($errores != ''){
    echo CHTML::dibujaEtiqueta('div',['class'=> 'error invalid-feedback'],$errores);
}
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

foreach ($filasP as $valor) {

    echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']);
    echo CHTML::dibujaEtiqueta('div', ['class' => 'container']);

    echo CHTML::dibujaEtiqueta('div', ['class' => 'table-responsive']);
    echo CHTML::dibujaEtiqueta('table', ['class' => 'table table-striped table-bordered']);
    echo CHTML::dibujaEtiqueta('thead');
    echo CHTML::dibujaEtiqueta('tr');

    foreach ($cabPT as $cabecera) {
        echo CHTML::dibujaEtiqueta('th', [], ucfirst($cabecera));
    }
    echo CHTML::dibujaEtiqueta('th', [], 'Acciones');
    echo CHTML::dibujaEtiquetaCierre('tr');
    echo CHTML::dibujaEtiquetaCierre('thead');

    echo CHTML::dibujaEtiqueta('tbody');
    echo CHTML::dibujaEtiqueta('tr');
    echo CHTML::dibujaEtiqueta('td');
    echo CHTML::campoText($valor['nombre'], $valor['nombre'], ['disabled' => 'true', 'class' => 'form-control']);
    echo CHTML::dibujaEtiquetaCierre('td');

    foreach ($modeloPT as $prop => $val) {
        if ($modeloAux->cod_parada === intval($valor['cod_parada'])) {
            if (in_array($prop, $cabPT)) {
                echo CHTML::dibujaEtiqueta('td');
                if ($prop === 'orden' || $prop === 'precio' || $prop === 'kilometros') {
                    echo CHTML::modeloNumber($modeloAux, $prop, ['placeholder' => ucfirst($prop), 'class' => 'form-control']);
                    echo CHTML::modeloError($modeloAux, $prop, ['class' => 'error invalid-feedback']);
                } else if ($prop === 'tiempo' || $prop === 'tiempo_estacion') {
                    echo CHTML::modeloText($modeloAux, $prop, ['class' => 'form-control']);
                    echo CHTML::modeloError($modeloAux, $prop, ['class' => 'error invalid-feedback']);
                }
                echo CHTML::dibujaEtiquetaCierre('td');
            }
        } else {
            if (in_array($prop, $cabPT)) {
                echo CHTML::dibujaEtiqueta('td');
                if ($prop === 'orden' || $prop === 'precio' || $prop === 'kilometros') {
                    echo CHTML::modeloNumber($modeloPT, $prop, ['placeholder' => ucfirst($prop), 'class' => 'form-control']);
                } else if ($prop === 'tiempo' || $prop === 'tiempo_estacion') {
                    echo CHTML::modeloText($modeloPT, $prop, ['class' => 'form-control']);
                }
                echo CHTML::dibujaEtiquetaCierre('td');
            }
        }
    }

    echo CHTML::dibujaEtiqueta('td');
    echo CHTML::modeloHidden($modeloPT, 'cod_parada', ['class' => 'form-control', 'value' => $valor['cod_parada']]);
    echo CHTML::campoBotonSubmit('Guardar', ['class' => 'btn btn-primary']);
    echo CHTML::dibujaEtiquetaCierre('td');

    echo CHTML::dibujaEtiquetaCierre('tr');
    echo CHTML::dibujaEtiquetaCierre('tbody');
    echo CHTML::dibujaEtiquetaCierre('table');
    echo CHTML::dibujaEtiquetaCierre('div');

    echo CHTML::dibujaEtiquetaCierre('div');
    echo CHTML::finalizarForm();
    echo CHTML::dibujaEtiqueta('br');
    echo CHTML::dibujaEtiqueta('br');
}


