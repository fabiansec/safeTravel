<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-5 mb-5']);

// Mensaje de éxito con ícono de tick
echo CHTML::dibujaEtiqueta('div', ['class' => 'alert alert-success text-center'], 
    CHTML::dibujaEtiqueta('h1', [], '<i class="bi bi-check-circle-fill"></i> Compra realizada con éxito')
);

// Botón para descargar billetes
echo CHTML::iniciarForm('','post',[]);
echo CHTML::dibujaEtiqueta('div', ['class' => 'text-center mt-4']);
echo CHTML::campoBotonSubmit('Descargar Billetes', ['class' => 'btn btn-primary']);
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::finalizarForm();


echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del div.container
?>
