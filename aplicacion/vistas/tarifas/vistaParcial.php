<?php
echo CHTML::dibujaEtiqueta('hr',['class' => 'text-white']);
echo CHTML::dibujaEtiqueta('ul', ['class' => 'fa-ul']);

foreach ($complementos as $complemento) {
    // Verifica si el complemento está presente en la lista de valores de la tarifa
    $complemento_presente = in_array($complemento['nombre'], $valores);

    // Muestra un tick si el complemento está presente, de lo contrario, muestra una cruz
    if ($complemento_presente) {
        echo CHTML::dibujaEtiqueta('li', ['class' => 'mb-5 text-white'], '<span class="fa-li"><img src="imagenes/24x24/si.png"></span>' . $complemento['nombre']);
    } else {
        echo CHTML::dibujaEtiqueta('li', ['class' => ' mb-5 text-white'], '<span class="fa-li"><img src="imagenes/24x24/eliminar.png"/></span>' . $complemento['nombre']);
    }
}

echo CHTML::dibujaEtiquetaCierre('ul');
?>
