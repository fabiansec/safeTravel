<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Nueva Tarifa'); // Crear el elemento h1 con la clase y el texto deseados

echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation']); // Agregar clase de validación de Bootstrap

foreach ($modelo as $propiedades => $valores) {
    if (in_array($propiedades, $cab)) {
       
            echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
            echo CHTML::modeloLabel($modelo, $propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
            echo CHTML::modeloText($modelo, $propiedades, ['class' => 'form-control col-1 inputCrud', 'value' => $valores]); // Reducir el ancho del input estableciendo col-4 (33.33% del contenedor padre)
            echo CHTML::modeloError($modelo, $propiedades, ['class' => 'invalid-feedback']); // Agregar clase de error de formulario
            echo CHTML::dibujaEtiquetaCierre('div');
        
 
    }
}
echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior

echo CHTML::campoLabel('Complemento','');
echo CHTML::dibujaEtiqueta('br');

// Iterar sobre cada complemento para generar los checkboxes
echo CHTML::modeloListaCheckBox($modeloComTar,'cod_complemento',$comp,'<br>',[]);
if($errores){
    echo CHTML::dibujaEtiqueta('div',['class' => 'error invalid-feedback'],'Debes seleccionar complemento');
}
// Botón de envío
echo "<br>";
echo CHTML::campoBotonSubmit('Guardar', ['class' => 'btn btn-primary mt-3']); // Agregar margen superior al botón

echo CHTML::finalizarForm();
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['tarifas', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor
