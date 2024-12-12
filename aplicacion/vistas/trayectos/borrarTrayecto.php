<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Borrar Trayectos'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

foreach ($filas as $propiedades => $valor) {
    foreach($valor as $clave => $vl){
        if(in_array($clave,$cab)){
            if($clave === 'paradas'){
                echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                echo CHTML::campoLabel($clave,'', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                echo CHTML::campoTextArea($clave,$vl, ['class' => 'form-control inputCrud','disabled'=>'true', 'value' => $vl,'rows' => '5']); // Estilo de Bootstrap para input
                echo CHTML::dibujaEtiquetaCierre('div');
            }else{
                echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
                echo CHTML::campoLabel($clave,'', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
                echo CHTML::campoText($clave,$vl, ['class' => 'form-control inputCrud','disabled'=>'true', 'value' => $vl]); // Estilo de Bootstrap para input
                echo CHTML::dibujaEtiquetaCierre('div');
            }
           
        }
       
    }   
    
}

echo CHTML::campoBotonSubmit('Borrar',['class' => 'btn btnOperaciones ml-2']);

echo CHTML::finalizarForm();
echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior

/**Operaciones borrar/modificar y volver*/
echo CHTML::campoLabel('Operaciones', '',['class' => 'mt-4']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::link(
    'Ver',
    Sistema::app()->generaURL(['trayectos', 'ver/id='.$modelo->cod_trayecto]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::link(
    'Modificar',
    Sistema::app()->generaURL(['trayectos', 'modificar/id='.$modelo->cod_trayecto]),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['trayectos', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor


