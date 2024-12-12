<?php

echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Modificar Viajes'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

foreach ($modelo as $propiedades => $valor) {
    if (in_array($propiedades, $cab)) {

        if($propiedades === 'hora_salida'){
            echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::modeloText($modelo, $propiedades, ['class' => 'form-control inputCrud','value' => $valor]); // Estilo de Bootstrap para input
            echo CHTML::modeloError($modelo,$propiedades,['class' => 'error invalid-feedback inputCrud']);
            echo CHTML::dibujaEtiquetaCierre('div');
        }else if($propiedades === 'fecha'){
            echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::modeloDate($modelo, $propiedades, ['class' => 'form-control inputCrud','value' => $valor]); // Estilo de Bootstrap para input
            echo CHTML::modeloError($modelo,$propiedades,['class' => 'error invalid-feedback inputCrud']);
            echo CHTML::dibujaEtiquetaCierre('div');
        }else{
            echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::campoText($propiedades, $valor, ['class' => 'form-control inputCrud','disabled'=>'true', 'value' => $valor]); // Estilo de Bootstrap para input
            echo CHTML::modeloError($modelo,$propiedades,['class' => 'error invalid-feedback inputCrud']);
            echo CHTML::dibujaEtiquetaCierre('div');
        }
           
        
       
    }
}
echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
echo CHTML::modeloListaDropDown($tren,'cod_tren',$tre, ['class' => 'form-check-select', $nombreTren => 'selected']);
echo CHTML::modeloError($modelo,'cod_tren',['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiquetaCierre('div');

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
echo CHTML::modeloHidden($modelo, 'cod_trayecto', ['class' => 'form-control', 'value' => $modelo->cod_trayecto]);
//echo CHTML::campoBotonSubmit('Guardar', ['class' => 'btn btn-primary']); // Botón de submit con clase Bootstrap
// Botón para abrir el modal
echo CHTML::boton('Modificar', [
    'type' => 'button',
    'class' => 'btn btn-success',
    'data-bs-toggle' => 'modal',
    'data-bs-target' => '#exampleModal'
]);

// Modal
echo CHTML::dibujaEtiqueta('div', ['class' => 'modal fade', 'id' => 'exampleModal', 'tabindex' => '-1', 'aria-labelledby' => 'exampleModalLabel', 'aria-hidden' => 'true']);
    echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-dialog']);
        echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-content']);
            echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-header']);
                echo CHTML::dibujaEtiqueta('h1', ['class' => 'modal-title fs-5', 'id' => 'exampleModalLabel'], 'Modificar viaje');
                echo CHTML::boton('', ['type' => 'button', 'class' => 'btn-close', 'data-bs-dismiss' => 'modal', 'aria-label' => 'Close']);
            echo CHTML::dibujaEtiquetaCierre('div');
            echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-body']);
                        echo CHTML::dibujaEtiqueta('p',[],'¿Estás seguro de modificar el viaje?');
            echo CHTML::dibujaEtiquetaCierre('div');
            echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-footer']);
                echo CHTML::boton('Cerrar', ['type' => 'button', 'class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']);
                echo CHTML::campoBotonSubmit('Confirmar', [ 'class' => 'btn btn-primary']);
            echo CHTML::dibujaEtiquetaCierre('div');
        echo CHTML::dibujaEtiquetaCierre('div');
    echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');

echo CHTML::dibujaEtiquetaCierre('div');


echo CHTML::finalizarForm();

/**Operaciones borrar/modificar y volver*/
echo CHTML::campoLabel('Operaciones', '',['class' => 'mt-4']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::link(
    'Borrar',
    Sistema::app()->generaURL(['viajes', 'borrar/id='.$modelo->cod_viaje]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::link(
    'Ver',
    Sistema::app()->generaURL(['viajes', 'ver/id='.$modelo->cod_viaje]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['viajes', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor


