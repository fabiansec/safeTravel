<?php

echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario

echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Borrar Tarifas'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

foreach ($tarifa as $propiedades => $valor) {
    if (in_array($propiedades, $cab)) {
        echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
        echo CHTML::modeloLabel($tarifa, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
        echo CHTML::campoText($propiedades, $valor, ['class' => 'form-control inputCrud','disabled'=>'true', 'value' => $valor]); // Estilo de Bootstrap para input
        echo CHTML::dibujaEtiquetaCierre('div');
    }
}

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
echo CHTML::campoLabel('Complementos', '');
echo CHTML::dibujaEtiqueta('br');

// Iterar sobre cada complemento para generar los checkboxes
foreach ($complementos as $indice => $valor) {
    foreach ($valor as $clave => $va) {
        echo CHTML::dibujaEtiqueta('div', ['class' => 'form-check']); // Div para cada checkbox
        echo CHTML::campoCheckBox($va, true, ['class' => 'form-check-input', 'disabled' => 'true']); // Checkbox con estilo de Bootstrap
        echo CHTML::campoLabel($va, '', ['class' => 'form-check-label']); // Etiqueta para el checkbox
        echo CHTML::dibujaEtiquetaCierre('div');
    }
}

echo CHTML::dibujaEtiqueta('br');

// Botón para abrir el modal
echo CHTML::boton('Borrar', [
    'type' => 'button',
    'class' => 'btn btn-danger',
    'data-bs-toggle' => 'modal',
    'data-bs-target' => '#exampleModal'
]);

// Modal
echo CHTML::dibujaEtiqueta('div', ['class' => 'modal fade', 'id' => 'exampleModal', 'tabindex' => '-1', 'aria-labelledby' => 'exampleModalLabel', 'aria-hidden' => 'true']);
    echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-dialog']);
        echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-content']);
            echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-header']);
                echo CHTML::dibujaEtiqueta('h1', ['class' => 'modal-title fs-5', 'id' => 'exampleModalLabel'], 'Borrar tarifa');
                echo CHTML::boton('', ['type' => 'button', 'class' => 'btn-close', 'data-bs-dismiss' => 'modal', 'aria-label' => 'Close']);
            echo CHTML::dibujaEtiquetaCierre('div');
            echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-body']);
                        echo CHTML::dibujaEtiqueta('p',[],'¿Estás seguro de borrar la tarifa?');
            echo CHTML::dibujaEtiquetaCierre('div');
            echo CHTML::dibujaEtiqueta('div', ['class' => 'modal-footer']);
                echo CHTML::boton('Cerrar', ['type' => 'button', 'class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']);
                echo CHTML::campoBotonSubmit('Confirmar', [ 'class' => 'btn btn-primary']);
            echo CHTML::dibujaEtiquetaCierre('div');
        echo CHTML::dibujaEtiquetaCierre('div');
    echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');

echo CHTML::finalizarForm();


/**Operaciones borrar/modificar y volver*/
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');
echo CHTML::campoLabel('Operaciones', '',['class' => 'mt-4']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::link(
    'Modificar',
    Sistema::app()->generaURL(['tarifas', 'modificar/id='.$tarifa->cod_tarifa]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::link(
    'Ver',
    Sistema::app()->generaURL(['tarifas', 'ver/id='.$tarifa->cod_tarifa]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['tarifas', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor
