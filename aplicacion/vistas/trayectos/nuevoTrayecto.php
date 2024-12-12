<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-4 mb-4 ms-4']); // Agregar márgenes superior, inferior e izquierdo al formulario
echo CHTML::dibujaEtiqueta('h2', ['class' => 'position-absolute top-5 translate-middle start-50 text-center  mb-4 d-none d-md-block'], 'Nuevo Trayecto'); // Crear el elemento h1 con la clase y el texto deseados
echo CHTML::iniciarForm('', 'post', ['class' => 'needs-validation mt-5']); // Agregar clase de validación de Bootstrap

echo CHTML::dibujaEtiqueta('br',[]);
echo CHTML::dibujaEtiqueta('br',[]);

foreach($trayecto as $propiedades => $valores){
    if(in_array($propiedades,$cab)){

        
        echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3']); // Agregar margen inferior
        echo CHTML::modeloLabel($trayecto,$propiedades, ['class' => 'form-label']); // Agregar clase de etiqueta de formulario
        echo CHTML::dibujaEtiqueta('br',[]);
       
        echo CHTML::campoListaDropDown('origen','Seleccione una opcion',$filas, ['class' => 'form-check-select']);
        echo CHTML::campoListaDropDown('destino','Seleccione una opcion',$filas, ['class' => 'form-check-select']);
        if(count($errores) > 0){
            foreach($errores as $indice => $mensaje){
                echo CHTML::dibujaEtiqueta('div',['class' => 'error invalid-feedback'],$mensaje);
                echo CHTML::dibujaEtiqueta('br',[]);

            }
        }
        echo CHTML::dibujaEtiquetaCierre('div');

        
    }
}



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
    Sistema::app()->generaURL(['trayectos', 'indextabla']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del contenedor