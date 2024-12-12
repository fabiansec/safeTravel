<?php

echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Ver Tarifas'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

foreach ($tarifa as $propiedades => $valor) {
    if (in_array($propiedades, $cab)) {

        if($propiedades === 'borrado'){
                if($valor === 0){
                    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                    echo CHTML::modeloLabel($tarifa, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                    echo CHTML::dibujaEtiqueta('p',[],'No');
                    echo CHTML::dibujaEtiquetaCierre('div');

    
                }else{
                    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                    echo CHTML::modeloLabel($tarifa, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                    echo CHTML::dibujaEtiqueta('p',[],'Si');
                    echo CHTML::dibujaEtiquetaCierre('div');
                }
        }else{
            echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::modeloLabel($tarifa, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::campoText($propiedades, $valor, ['class' => 'form-control inputCrud','disabled'=>'true', 'value' => $valor]); // Estilo de Bootstrap para input
            echo CHTML::dibujaEtiquetaCierre('div');
        }
       
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

echo CHTML::finalizarForm();

/**Operaciones borrar/modificar y volver*/
echo CHTML::campoLabel('Operaciones', '',['class' => 'mt-4']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::link(
    'Borrar',
    Sistema::app()->generaURL(['tarifas', 'borrar/id='.$tarifa->cod_tarifa]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::link(
    'Modificar',
    Sistema::app()->generaURL(['tarifas', 'modificar/id='.$tarifa->cod_tarifa]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['tarifas', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor


