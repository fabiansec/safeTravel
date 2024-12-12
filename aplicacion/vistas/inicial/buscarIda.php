<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container-fluid mt-5 mb-5']);
echo CHTML::dibujaEtiqueta('h2', [], 'Viaje para la Ida');
if (count($viajesIda) > 0) {
    foreach ($viajesIda as $viaje) {
        // Abre el div contenedor del "ticket" con la clase 'ticket'
        echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket shadow mb-4']);
        // Cabecera del "ticket" con la información del viaje y la clase 'ticket-header'
        echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket-header']);
        echo CHTML::dibujaEtiqueta('h4', [], $viaje['nombre_origen'] . ' <i class="bi bi-arrow-right"></i> ' . $viaje['nombre_destino']);
        echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold display-6'], '<i class="bi bi-clock"></i> ' . $viaje['hora_salida'] . ' <i class="bi bi-dash"></i> ' . $viaje['hora_llegada']);
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket-header

        // Paradas del viaje y otros detalles
        echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket-details']);
        echo CHTML::dibujaEtiqueta('h4', [], 'Paradas:');
        echo CHTML::dibujaEtiqueta('p', ['class' => 'display-7 mb-3'], $viaje['paradas'] . ' <i class="bi bi-arrow-right"></i>');

        // Tabla de precios con botón de selección para pantallas grandes
        echo CHTML::dibujaEtiqueta('div', ['class' => 'd-none d-lg-block table-responsive']); // Mostrar tabla solo en pantallas grandes
        echo CHTML::dibujaEtiqueta('table', ['class' => 'table table-bordered table-striped mb-4 w-100']); // Agregar clase w-100 para ancho completo
        echo CHTML::dibujaEtiqueta('thead', ['class' => 'table-dark']);
        echo CHTML::dibujaEtiqueta('tr');
        echo CHTML::dibujaEtiqueta('th', [], 'Tarifa');
        echo CHTML::dibujaEtiqueta('th', [], 'Precio Total');

        // Agregar columnas para cada complemento
        foreach ($complementos as $complemento) {
            echo CHTML::dibujaEtiqueta('th', [], $complemento['nombre']);
        }
        echo CHTML::dibujaEtiqueta('th', [], 'Operación'); // Encabezado para el botón de selección
        echo CHTML::dibujaEtiquetaCierre('tr');
        echo CHTML::dibujaEtiquetaCierre('thead');
        echo CHTML::dibujaEtiqueta('tbody');

        // Iterar sobre las tarifas disponibles
        foreach ($viaje['tarifas'] as $nombreTarifa => $datosTarifa) {
            echo CHTML::dibujaEtiqueta('tr');
            echo CHTML::dibujaEtiqueta('td', [], $nombreTarifa);
            echo CHTML::dibujaEtiqueta('td', ['class' => 'fw-bold text-primary'], $datosTarifa['precio'] . ' €'); // Precio Total destacado

            // Verificar cada complemento
            foreach ($complementos as $complemento) {
                $tieneComplemento = in_array($complemento['nombre'], $datosTarifa['complementos']);
                $icono = $tieneComplemento ? 'si.png' : 'eliminar.png';
                echo CHTML::dibujaEtiqueta('td', [], '<img src="../imagenes/24x24/' . $icono . '"/>');
            }

            // Botón de selección
            echo CHTML::dibujaEtiqueta('td', ['class' => 'text-center']);
            echo CHTML::iniciarForm('', 'POST', []);
            echo CHTML::campoHidden('precio', $datosTarifa['precio'], []);
            echo CHTML::campoHidden('cod_viaje', $viaje['cod_viaje'], []);
            echo CHTML::campoHidden('cod_tarifa', $datosTarifa['cod_tarifa'], []);
            echo CHTML::campoBotonSubmit('Seleccionar', ['class' => 'btn btn-primary', 'name' => 'id_0']);
            echo CHTML::finalizarForm();
            echo CHTML::dibujaEtiquetaCierre('td');
            echo CHTML::dibujaEtiquetaCierre('tr');
        }

        echo CHTML::dibujaEtiquetaCierre('tbody');
        echo CHTML::dibujaEtiquetaCierre('table');
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.table-responsive

        // Tarjetas para pantallas pequeñas
        echo CHTML::dibujaEtiqueta('div', ['class' => 'd-lg-none']); // Mostrar tarjetas solo en pantallas pequeñas
        foreach ($viaje['tarifas'] as $nombreTarifa => $datosTarifa) {
            echo CHTML::dibujaEtiqueta('div', ['class' => 'card mb-4']);
            echo CHTML::dibujaEtiqueta('div', ['class' => 'card-header']);
            echo CHTML::dibujaEtiqueta('h5', [], $nombreTarifa);
            echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-header

            echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body']);
            echo CHTML::dibujaEtiqueta('h6', ['class' => 'fw-bold text-primary'], $datosTarifa['precio'] . ' €'); // Precio Total destacado

            // Lista de complementos
            echo CHTML::dibujaEtiqueta('ul', ['class' => 'list-group list-group-flush']);
            foreach ($complementos as $complemento) {
                $tieneComplemento = in_array($complemento['nombre'], $datosTarifa['complementos']);
                $icono = $tieneComplemento ? 'si.png' : 'eliminar.png';
                echo CHTML::dibujaEtiqueta('li', ['class' => 'list-group-item']);
                echo $complemento['nombre'] . ' <img src="../imagenes/24x24/' . $icono . '"/>';
                echo CHTML::dibujaEtiquetaCierre('li');
            }
            echo CHTML::dibujaEtiquetaCierre('ul');

            // Botón de selección
            echo CHTML::iniciarForm('', 'POST', []);
            echo CHTML::campoHidden('precio', $datosTarifa['precio'], []);
            echo CHTML::campoHidden('cod_viaje', $viaje['cod_viaje'], []);
            echo CHTML::campoHidden('cod_tarifa', $datosTarifa['cod_tarifa'], []);
            echo CHTML::campoBotonSubmit('Seleccionar', ['class' => 'btn btn-primary', 'name' => 'id_0']);
            echo CHTML::finalizarForm();
            echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body

            echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card
        }
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.d-lg-none

        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket-details
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket
    }
} else {
    echo CHTML::dibujaEtiqueta('p', ['class' => 'display-7 mb-3'], 'Ya se pasaron la hora de los viajes');
}
echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div.container-fluid
?>
