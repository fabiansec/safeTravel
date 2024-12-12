<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Nuevo Viaje'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

echo CHTML::dibujaEtiqueta('br',[]);
echo CHTML::dibujaEtiqueta('br',[]);

echo CHTML::campoLabel('Trayecto','', ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
echo CHTML::dibujaEtiqueta('br',[]);
echo CHTML::modeloListaDropDown($modelo,'cod_trayecto',$trayectos, ['class' => 'form-check-select']);
echo CHTML::modeloError($viaje,'cod_trayecto',['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiqueta('br',[]);
echo CHTML::dibujaEtiqueta('br',[]);

foreach($viaje as $propiedades => $valor){
    if(in_array($propiedades,$cab)){
        echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior

        if($propiedades === 'fecha'){
            echo CHTML::modeloDate($viaje,$propiedades,['class' => 'form-control inputCrud']);
            echo CHTML::modeloError($viaje,$propiedades,['class ' => 'error invalid-feedback ']);
        }else if($propiedades === 'hora_salida'){
            echo CHTML::modeloText($viaje,$propiedades,['class' => 'form-control inputCrud','placeholder' => 'Hora salida']);
            echo CHTML::modeloError($viaje,$propiedades,['class' => 'error invalid-feedback inputCrud']);
        }
        echo CHTML::dibujaEtiquetaCierre('div');

    }
}

echo CHTML::modeloListaDropDown($tren,'cod_tren',$tre, ['class' => 'form-check-select']);
echo CHTML::modeloError($viaje,'cod_tren',['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiqueta('br',[]);
echo CHTML::dibujaEtiqueta('br',[]);
echo CHTML::campoBotonSubmit('Guardar', ['class' => 'btn btn-primary mt-5']); // Se mantiene la clase del botón
echo CHTML::dibujaEtiqueta('br',[]);

echo CHTML::finalizarForm();
echo CHTML::dibujaEtiqueta('br',[]);

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior

/**Operaciones borrar/modificar y volver*/
echo CHTML::campoLabel('Operaciones', '',['class' => 'mt-4']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');


echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['viajes', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor