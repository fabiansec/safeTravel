<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Modificar Trayectos'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

foreach ($filas as $propiedades => $valor) {
    foreach ($valor as $clave => $vl) {
        if (in_array($clave, $cab)) {
            if ($clave === 'paradas') {
                echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                echo CHTML::campoLabel($clave, '', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                echo CHTML::campoTextArea($clave, $vl, ['class' => 'form-control inputCrud', 'disabled' => 'true', 'value' => $vl, 'rows' => '5']); // Estilo de Bootstrap para input
                echo CHTML::dibujaEtiquetaCierre('div');
            } else if ($clave === 'borrado') {
                if ($vl === '0') {
                    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                    echo CHTML::campoLabel($clave, '', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                    echo CHTML::campoText($clave, 'No', ['class' => 'form-control inputCrud', 'disabled' => 'true', 'value' => $vl]); // Estilo de Bootstrap para input
                    echo CHTML::dibujaEtiquetaCierre('div');
                } else {
                    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                    echo CHTML::campoLabel($clave, '', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                    echo CHTML::campoText($clave, 'Si', ['class' => 'form-control inputCrud', 'disabled' => 'true', 'value' => $vl]); // Estilo de Bootstrap para input
                    echo CHTML::dibujaEtiquetaCierre('div');
                }
            } else {
                echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                echo CHTML::campoLabel($clave, '', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                echo CHTML::campoText($clave, $vl, ['class' => 'form-control inputCrud', 'disabled' => 'true', 'value' => $vl]); // Estilo de Bootstrap para input
                echo CHTML::dibujaEtiquetaCierre('div');
            }
        }
    }
}
echo CHTML::finalizarForm();


/* Si tiene paradas */

foreach ($filasParadas as $indice => $valores) {
    echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

    echo CHTML::dibujaEtiqueta('div', ['class' => 'container']); // Contenedor de Bootstrap

    // Contenedor responsivo para la tabla
    echo CHTML::dibujaEtiqueta('div', ['class' => 'table-responsive']);
    echo CHTML::dibujaEtiqueta('table', ['class' => 'table table-striped table-bordered']); // Tabla con clases Bootstrap
    echo CHTML::dibujaEtiqueta('thead');
    echo CHTML::dibujaEtiqueta('tr');

    // Cabecera de la tabla
    foreach ($cabPT as $cabecera) {

        echo CHTML::dibujaEtiqueta('th', [], ucfirst($cabecera));
    }
    echo CHTML::dibujaEtiqueta('th', [], 'Acciones'); // Columna adicional para el botón
    echo CHTML::dibujaEtiquetaCierre('tr');
    echo CHTML::dibujaEtiquetaCierre('thead');

    echo CHTML::dibujaEtiqueta('tbody');
    echo CHTML::dibujaEtiqueta('tr');

    // Cuerpo de la tabla
    foreach ($modeloPT as $propiedad => $val) {
        foreach ($valores as $propiedades => $valor) {
            if ($propiedad === 'cod_parada') {
                if ($val === intval($valores['cod_parada'])) { //si el cod_parada del modelo es igual al de la parada significa que tiene un error
                    if (in_array($propiedades, $cabPT)) {
                        echo CHTML::dibujaEtiqueta('td');
                        if ($propiedades === 'nombre' || $propiedades === 'orden') {
                            echo CHTML::modeloText($modeloPT, $propiedades, ['value' => $valor, 'disabled' => 'true', 'class' => 'form-control']);
                            echo CHTML::modeloError($modeloPT,$propiedades,['class' => 'error invalid-feedback']);
                        } else if ($propiedades === 'precio' || $propiedades === 'kilometros') {
                            echo CHTML::modeloNumber($modeloPT, $propiedades, ['value' => $valor, 'placeholder' => ucfirst($propiedades), 'class' => 'form-control']);
                            echo CHTML::modeloError($modeloPT,$propiedades,['class' => 'error invalid-feedback']);

                        } else if ($propiedades === 'tiempo' || $propiedades === 'tiempo_estacion') {
                            echo CHTML::modeloText($modeloPT, $propiedades, ['value' => $valor, 'class' => 'form-control']);
                            echo CHTML::modeloError($modeloPT,$propiedades,['class' => 'error invalid-feedback']);
                        }


                        echo CHTML::dibujaEtiquetaCierre('td');
                    }
                } else {
                    if (in_array($propiedades, $cabPT)) {
                        echo CHTML::dibujaEtiqueta('td');
                        if ($propiedades === 'nombre' || $propiedades === 'orden') {
                            echo CHTML::modeloText($modeloPT, $propiedades, ['value' => $valor, 'disabled' => 'true', 'class' => 'form-control']);
                        } else if ($propiedades === 'orden' || $propiedades === 'precio' || $propiedades === 'kilometros') {
                            echo CHTML::modeloNumber($modeloPT, $propiedades, ['value' => $valor, 'placeholder' => ucfirst($propiedades), 'class' => 'form-control']);
                        } else if ($propiedades === 'tiempo' || $propiedades === 'tiempo_estacion') {
                            echo CHTML::modeloText($modeloPT, $propiedades, ['value' => $valor, 'class' => 'form-control']);
                        }


                        echo CHTML::dibujaEtiquetaCierre('td');
                    }
                }
            }
        }
    }





    // Columna para el botón de envío
    echo CHTML::dibujaEtiqueta('td');
    echo CHTML::modeloHidden($modeloPT, 'cod_parada', ['class' => 'form-control', 'value' => $valores['cod_parada']]);
    echo CHTML::campoBotonSubmit('Guardar', ['class' => 'btn btn-primary']); // Botón de submit con clase Bootstrap
    echo CHTML::dibujaEtiquetaCierre('td');

    echo CHTML::dibujaEtiquetaCierre('tr');
    echo CHTML::dibujaEtiquetaCierre('tbody');
    echo CHTML::dibujaEtiquetaCierre('table');
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor responsivo

    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor

    echo CHTML::finalizarForm();
    echo CHTML::dibujaEtiqueta('br'); // Espaciado entre formularios
    echo CHTML::dibujaEtiqueta('br');
}


echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior

/**Operaciones borrar/modificar y volver*/
echo CHTML::campoLabel('Operaciones', '', ['class' => 'mt-4']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::link(
    'Borrar',
    Sistema::app()->generaURL(['trayectos', 'borrar/id=' . $modelo->cod_trayecto]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::link(
    'Ver',
    Sistema::app()->generaURL(['trayectos', 'ver/id=' . $modelo->cod_trayecto]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['trayectos', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor
