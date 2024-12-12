<?php

echo CHTML::dibujaEtiqueta('section', ['class' => 'container py-5']);

echo CHTML::dibujaEtiqueta('h2',['class'=> 'text-center mb-5'],'Tipos de billetes');

    // Price Table
    echo CHTML::dibujaEtiqueta('div', ['class' => 'row justify-content-center']);

        // Start Up Tier
        
        foreach ($tarifas as $propiedades => $clave) {
            if ($clave['borrado'] !== '1') {
                echo CHTML::dibujaEtiqueta('div', ['class' => 'col-lg-3 col-md-6 mb-4']);
                echo CHTML::dibujaEtiqueta('div', ['class' => 'card shadow borde zoom']); // Añadido 'shadow-sm' para un efecto de sombra suave
        
                echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body card-blur borde zoom ']);
                echo CHTML::dibujaEtiqueta('h5', ['class' => 'card-title text-center text-uppercase  mb-3 text-white'], $propiedades); // Agregado 'mb-3' para margen inferior
                $this->dibujaVistaParcial('vistaParcial', ['valores' => $clave, 'modelo' => $modelo, 'complementos' => $complementos]);
        
                echo CHTML::dibujaEtiquetaCierre('div');
        
                echo CHTML::dibujaEtiquetaCierre('div');
                echo CHTML::dibujaEtiquetaCierre('div');
            }
        }
        

    echo CHTML::dibujaEtiquetaCierre('div');

echo CHTML::dibujaEtiquetaCierre('section');
