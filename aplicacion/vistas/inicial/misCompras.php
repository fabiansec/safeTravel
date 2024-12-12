<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container-fluid mt-5 mb-5']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'text-center'], 'Mis Compras');

// Comprobamos si hay compras para mostrar
if (!empty($compras)) {
    echo CHTML::dibujaEtiqueta('div', ['class' => 'table-responsive']);
    echo CHTML::dibujaEtiqueta('table', ['class' => 'table table-bordered table-striped text-center']);
    echo CHTML::dibujaEtiqueta('thead', ['class' => 'thead-dark']);
    echo CHTML::dibujaEtiqueta('tr');
    echo CHTML::dibujaEtiqueta('th', ['scope' => 'col'], 'Fecha de Compra');
    echo CHTML::dibujaEtiqueta('th', ['scope' => 'col'], 'Método de pago');
    echo CHTML::dibujaEtiqueta('th', ['scope' => 'col'], 'Unidades');
    echo CHTML::dibujaEtiqueta('th', ['scope' => 'col'], 'Usuario');
    echo CHTML::dibujaEtiqueta('th', ['scope' => 'col'], 'Operación');
    echo CHTML::dibujaEtiquetaCierre('tr');
    echo CHTML::dibujaEtiquetaCierre('thead');
    echo CHTML::dibujaEtiqueta('tbody');

    foreach ($compras as $compra) {
        // Abrimos una fila de la tabla
        echo CHTML::dibujaEtiqueta('tr');

        // Mostramos la fecha de compra en una celda
        echo CHTML::dibujaEtiqueta('td', [], $compra['fecha']);

        echo CHTML::dibujaEtiqueta('td', [], $compra['forma_pago']);

        echo CHTML::dibujaEtiqueta('td', [], $compra['unidades']);

        // Mostramos el nick del usuario en una celda
        echo CHTML::dibujaEtiqueta('td', [], $nick);

        // Mostramos el enlace para ver la operación en una celda
        echo CHTML::dibujaEtiqueta('td', [], $compra['oper']);

        // Cerramos la fila de la tabla
        echo CHTML::dibujaEtiquetaCierre('tr');
    }

    echo CHTML::dibujaEtiquetaCierre('tbody');
    echo CHTML::dibujaEtiquetaCierre('table');
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.table-responsive
} else {
    // Si no hay compras, mostramos un mensaje centrado
    echo CHTML::dibujaEtiqueta('p', ['class' => 'text-center'], "No se encontraron compras.");
}

echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div.container-fluid
?>
