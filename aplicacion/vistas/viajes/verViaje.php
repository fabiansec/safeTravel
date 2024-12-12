<?php

echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Ver Viajes'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

foreach ($modelo as $propiedades => $valor) {
    if (in_array($propiedades, $cab)) {

        if($propiedades === 'borrado'){
                if($valor === 0){
                    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                    echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                    echo CHTML::dibujaEtiqueta('p',[],'No');
                    echo CHTML::dibujaEtiquetaCierre('div');

    
                }else{
                    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                    echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                    echo CHTML::dibujaEtiqueta('p',[],'Si');
                    echo CHTML::dibujaEtiquetaCierre('div');
                }
        }else{
            echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::campoText($propiedades, $valor, ['class' => 'form-control inputCrud','disabled'=>'true', 'value' => $valor]); // Estilo de Bootstrap para input
            echo CHTML::dibujaEtiquetaCierre('div');
        }
       
    }
}
echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::campoLabel('Tren','', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::campoText('tren',$nombreTren, ['class' => 'form-control inputCrud','disabled'=>'true']); // Estilo de Bootstrap para input
            echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior




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
    'Modificar',
    Sistema::app()->generaURL(['viajes', 'modificar/id='.$modelo->cod_viaje]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['viajes', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor


