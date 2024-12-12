<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container-fluid mt-5 mb-5']);
echo CHTML::dibujaEtiqueta('h2', [], 'Resumen de la Compra de Billetes');
$val = 0;
foreach ($compras as $billete) {
    echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket-container shadow mb-4 p-3 row align-items-center']);
    $val = $val + 1;

    // Contenedor de los detalles del pasajero
    echo CHTML::dibujaEtiqueta('div', ['class' => 'col-12 col-md-6']);
    echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold display-6'], $billete['origen'] . ' <i class="fas fa-arrow-right"></i> ' . $billete['destino']);
    echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold'], '<i class="bi bi-calendar"></i> ' . $billete['fecha_ida'] . ' <i class="bi bi-arrow-right"></i> ' . $billete['fecha_vuelta']);
    echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold'], 'Detalles del Pasajero:');
    echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-person"></i> ' . $billete['nombre']);
    echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-calendar3"></i> Fecha de Nacimiento: ' . $billete['fecha_nac']);
    echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-telephone"></i> Teléfono: ' . $billete['telefono']);
    echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold'], 'Precio: ' . $billete['precio_billete'] . ' €');
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-12 col-md-6

    // Contenedor del QR
    echo CHTML::dibujaEtiqueta('div', ['class' => 'col-12 col-md-6 text-center']);
    echo CHTML::imagen('../.'.$billete['qr'],'', ['class' => 'img-fluid qr-code']);
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-12 col-md-6

    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket-container
}

echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div.container-fluid

// Formulario de descargar
echo CHTML::iniciarForm('', 'POST', ['class' => 'mb-4']);
echo CHTML::campoBotonSubmit('Descargar billetes', ['class' => 'btn btn-primary ml-2','name' => 'descargar']);
echo CHTML::finalizarForm();
echo CHTML::link(
    'Volver',
    Sistema::app()->generaURL(['inicial', 'misCompras']),
    ['class' => 'btn btnOperaciones ml-2', 'id' => 'nuevo']
);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del div.container
?>
