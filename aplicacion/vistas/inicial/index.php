<?php



// Sección del carrusel
echo CHTML::dibujaEtiqueta('div', ['class' => 'row']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-12 d-none d-md-block carruselMargen']);

/*------------------ CARRUSEL --------------------------*/
echo CHTML::dibujaEtiqueta('div', ['id' => 'carouselExampleInterval', 'class' => 'carousel slide', 'data-bs-ride' => 'carousel']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-inner']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item active', 'data-bs-interval' => '4000']);
echo CHTML::dibujaEtiqueta('img', ['src' => '/imagenes/carrusel/carrusel1.1.png', 'class' => 'd-block w-100', 'alt' => '...']);
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item', 'data-bs-interval' => '4000']);
echo CHTML::dibujaEtiqueta('img', ['src' => '/imagenes/carrusel/carrusel2.1.png', 'class' => 'd-block w-100', 'alt' => '...']);
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item', 'data-bs-interval' => '4000']);
echo CHTML::dibujaEtiqueta('img', ['src' => '/imagenes/carrusel/carrusel3.2.png', 'class' => 'd-block w-100', 'alt' => '...']);
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiqueta('button', ['class' => 'carousel-control-prev', 'type' => 'button', 'data-bs-target' => '#carouselExampleInterval', 'data-bs-slide' => 'prev']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'carousel-control-prev-icon', 'aria-hidden' => 'true']);
echo CHTML::dibujaEtiquetaCierre('span');
echo CHTML::dibujaEtiqueta('span', ['class' => 'visually-hidden'], 'Previous');
echo CHTML::dibujaEtiquetaCierre('span');
echo CHTML::dibujaEtiquetaCierre('button');
echo CHTML::dibujaEtiqueta('button', ['class' => 'carousel-control-next', 'type' => 'button', 'data-bs-target' => '#carouselExampleInterval', 'data-bs-slide' => 'next']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'carousel-control-next-icon', 'aria-hidden' => 'true']);
echo CHTML::dibujaEtiquetaCierre('span');
echo CHTML::dibujaEtiqueta('span', ['class' => 'visually-hidden'], 'Next');
echo CHTML::dibujaEtiquetaCierre('span');
echo CHTML::dibujaEtiquetaCierre('button');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-md-12
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row

/*-----------------------------VENTA DE BILLETES ------------------------------ */
echo CHTML::iniciarForm('', 'post', []); // Agregar clase 'row g-3' para usar las clases de Bootstrap
echo CHTML::dibujaEtiqueta('div', ['class' => 'row justify-content-center my-5']); // Clase 'my-4' añadida para margen
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-6  acordeonCierre']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion accordion-flush rounded shadow', 'id' => 'accordionFlushExample']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-item']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'accordion-header']);
echo CHTML::dibujaEtiqueta('button', ['class' => 'accordion-button', 'type' => 'button', 'data-bs-toggle' => 'collapse', 'data-bs-target' => '#flush-collapseOne', 'aria-expanded' => 'false', 'aria-controls' => 'flush-collapseOne', 'id' => 'collapseButton']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-lg-6']);
if(!empty($erroresOrigen)){
    echo CHTML::dibujaEtiqueta('div',['class'=> 'error invalid-feedback'],$erroresOrigen);
}
echo CHTML::dibujaEtiqueta('div', ['class' => 'input-group flex-nowrap']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'input-group-text bg-transparent border-end border-secondary', 'id' => 'addon-wrapping'], 'Desde');
echo CHTML::modeloText($parada, 'nombre', ['placeholder' => 'Estación de origen', 'class' => 'form-control border-2 border-dark bg-white', 'aria-label' => 'origen', 'aria-describedby' => 'addon-wrapping', 'style' => 'outline: none;']); // Quitamos el borde azul con 'outline: none;'

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.input-group
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-lg-6
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-lg-6 mt-3 mt-lg-0']);
if(!empty($erroresDestino)){
    echo CHTML::dibujaEtiqueta('div',['class'=> 'error invalid-feedback'],$erroresDestino);
}
echo CHTML::dibujaEtiqueta('div', ['class' => 'input-group flex-nowrap']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'input-group-text bg-transparent border-end border-secondary', 'id' => 'addon-wrapping'], 'Hasta');
echo CHTML::campoText('destino',$valor, ['value'=> $valor,'placeholder' => 'Estación de destino', 'class' => 'form-control border-2 border-dark', 'aria-label' => 'destino', 'aria-describedby' => 'addon-wrapping', 'style' => 'outline: none;']); // Quitamos el borde azul con 'outline: none;'
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.input-group
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-lg-6
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row
echo CHTML::dibujaEtiquetaCierre('button'); // Cierre de button.accordion-button
echo CHTML::dibujaEtiquetaCierre('h2'); // Cierre de h2.accordion-header
echo CHTML::dibujaEtiqueta('div', ['id' => 'flush-collapseOne', 'class' => 'accordion-collapse collapse', 'aria-labelledby' => 'headingOne', 'data-bs-parent' => '#accordionFlushExample']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-body']);


echo CHTML::dibujaEtiqueta('div',['class' => 'row g-3']);


/*------------------ NUMERO DE PASAJEROS -----------------------*/
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-4']); // Usar col-md-4 para dispositivos medianos
echo CHTML::campoLabel('Pasajeros', 'pasajero', ['class' => 'form-label']);
echo CHTML::campoListaDropDown('unidades','',['1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5], [
    'class' => 'form-select form-select-sm',
    'aria-label' => 'Número de Pasajeros',
    
    
]);
if($errores != ''){
    echo CHTML::dibujaEtiqueta('div',['class' => 'invalid-feedback error'],$errores); 

}
echo CHTML::dibujaEtiquetaCierre('div');
/*------------------ FIN NUMERO DE PASAJEROS -----------------------*/

/*------------ IDA Y VUELTA -----------------*/
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-4']); // Usar col-md-4 para dispositivos medianos
echo CHTML::campoLabel('Tipo de Viaje', 'tipoViajeSelect', ['class' => 'form-label']);
echo CHTML::dibujaEtiqueta('select', [
    'id' => 'tipoViajeSelect',
    'class' => 'form-select form-select-sm',
    'aria-label' => 'Tipo de Viaje',
    'name' => 'tipoViaje'
]);
echo CHTML::dibujaEtiqueta('option', ['selected' => true, 'value' => '1'], 'Ida y vuelta');
echo CHTML::dibujaEtiqueta('option', ['value' => '0'], 'Sólo Ida');
echo CHTML::dibujaEtiquetaCierre('select');
echo CHTML::dibujaEtiquetaCierre('div');
/*------------ FIN IDA Y VUELTA -----------------*/

/*------------ Inputs de fecha -----------------*/
echo CHTML::dibujaEtiqueta('div', ['id' => 'fechas', 'class' => 'col-md-4']); // Usar col-md-4 para dispositivos medianos

// Input de fecha para ida
echo CHTML::dibujaEtiqueta('div', ['id' => 'fechaIdaDiv', 'class' => 'mb-3 d-none']);
echo CHTML::campoLabel('Fecha de Ida', 'fechaIda', ['class' => 'form-label']);
echo CHTML::modeloDate($modelo,'fecha_ida', ['class' => 'form-control']);
echo CHTML::modeloError($modelo,'fecha_ida', ['class' => 'invalid-feedback']); // Agregar clase de error de formulario
echo CHTML::dibujaEtiquetaCierre('div');

// Input de fecha para vuelta
echo CHTML::dibujaEtiqueta('div', ['id' => 'fechaVueltaDiv', 'class' => 'mb-3 d-none']);
echo CHTML::campoLabel('Fecha de Vuelta', 'fechaVuelta', ['class' => 'form-label']);
echo CHTML::modeloDate($modelo,'fecha_vuelta', ['class' => 'form-control']);
echo CHTML::modeloError($modelo,'fecha_vuelta', ['class' => 'invalid-feedback']); // Agregar clase de error de formulario
echo CHTML::dibujaEtiquetaCierre('div');

/*------------ FIN Inputs de fecha -----------------*/

echo CHTML::dibujaEtiqueta('div', ['class' => 'col-12 text-center']); // Centrar el botón en todas las pantallas
echo CHTML::campoBotonSubmit('Buscar', ['class' => 'btn bg-primary text-white']);
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-12
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::finalizarForm();



echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.accordion-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div#flush-collapseOne
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.accordion-item
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.accordion






echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.container

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-md-6

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row


/**----------------------------CARDS--------------------------- */


echo CHTML::dibujaEtiqueta('div', ['class' => 'card col-8 col-sm-6 col-md-4 col-lg-3 mt-5 mx-auto mb-5 shadow', 'style' => 'padding: 0;']);
echo CHTML::imagen('/imagenes/card/card1.png', '', ['class' => 'card-img-top', 'alt' => '...']); // Establecer un tamaño fijo para la imagen
echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body']);
echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text'], 'Viaja con comodidad y seguridad. Descubre nuestras ofertas en billetes de tren para tus destinos favoritos.');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card

echo CHTML::dibujaEtiqueta('div', ['class' => 'card col-8 col-sm-6 col-md-4 col-lg-3 mt-5 mx-auto mb-5 shadow', 'style' => 'padding: 0;']);
echo CHTML::imagen('/imagenes/card/card2.png', '', ['class' => 'card-img-top', 'alt' => '...']); // Establecer el mismo tamaño para la imagen
echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body']);
echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text'], 'Explora el mundo sobre rieles. Encuentra los mejores precios en billetes de tren para tus aventuras.');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card

echo CHTML::dibujaEtiqueta('div', ['class' => 'card col-8 col-sm-6 col-md-4 col-lg-3 mt-5 mx-auto mb-5 shadow', 'style' => 'padding: 0;']);
echo CHTML::imagen('/imagenes/card/card3.png', '', ['class' => 'card-img-top', 'alt' => '...']); // Establecer el mismo tamaño para la imagen
echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body']);
echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text'], 'Conectando ciudades, creando recuerdos. Encuentra tus billetes de tren ideales y prepara tu próxima escapada.');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card




/**-------------------------¿Porqué usar Safetravel?---------------------------- */


// Abre el div contenedor
echo CHTML::dibujaEtiqueta('div', ['class' => 'container-fluid sombra mt-5 mb-5 d-none d-md-block']);

// Primera fila con el título centrado
echo CHTML::dibujaEtiqueta('div', ['class' => 'row text-center mb-5 mt-6']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'col']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'mt-5'], '¿Por qué elegir SafeTravel?');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');

// Segunda fila con el carrusel
echo CHTML::dibujaEtiqueta('div', ['class' => 'row ']);
echo CHTML::dibujaEtiqueta('div', ['id' => 'carouselExampleControlsNoTouching', 'class' => 'carousel slide text-justify mb-5 mt-3 container-fluid rounded ', 'data-bs-touch' => 'false']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-inner']);

/**----------------------------------------- PRIMERO ----------------------------- */
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item active']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row justify-content-center']);

// Columna 1 de la fila dentro del primer testamento

echo CHTML::dibujaEtiqueta('div', ['class' => 'col-3 text-justify']);
echo CHTML::dibujaEtiqueta('h5',['class' => 'fw-bold mb-3'], '<i class="bi bi-clock text-black "></i> Compromiso de puntualidad');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-justify'], "Llegar a tiempo es una de tus prioridades, por eso mantenemos nuestros esfuerzos por conseguirlo.");
echo CHTML::dibujaEtiquetaCierre('div');

// Columna 2 de la fila dentro del primer testamento
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-3 text-justify']);
echo CHTML::dibujaEtiqueta('h5',['class' => 'fw-bold mb-3 '],'<i class="fa fa-location-arrow " aria-hidden="true"></i> Más trenes y destinos que nadie');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-justify'], "Más de 300 servicios diarios de larga 
                                                              distancia para viajar por toda España en tren.");
echo CHTML::dibujaEtiquetaCierre('div');

// Columna 3 de la fila dentro del primer testamento
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-3 text-justify']);
echo CHTML::dibujaEtiqueta('h5',['class' => 'fw-bold mb-3'],'<i class="fa fa-eur " aria-hidden="true"></i> Mejor precio disponible');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-justify'], "Solo nuestra web disfruta del precio más 
                                                              bajo, sin comisiones ni gastos de gestión.");
echo CHTML::dibujaEtiquetaCierre('div');


// Cierra la fila dentro del primer testamento
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');
/**----------------------------------------- SEGUNDO ----------------------------- */
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item ']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row justify-content-center']);

// Columna 1 de la fila dentro del primer testamento

echo CHTML::dibujaEtiqueta('div', ['class' => 'col-3 text-justify']);
echo CHTML::dibujaEtiqueta('h5',['class' => 'fw-bold mb-3'], '<i class="fa fa-leaf text-black "></i> Compromiso con el medio');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-justify'], "Somos el medio de transporte más ecológico 
                                                              y sostenible, porque cuidar de nuestro platena 
                                                              es importante.");
echo CHTML::dibujaEtiquetaCierre('div');

// Columna 2 de la fila dentro del primer testamento
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-3 text-justify']);
echo CHTML::dibujaEtiqueta('h5',['class' => 'fw-bold mb-3 '],'<i class="bi bi-star " aria-hidden="true"></i> Personaliza tu viaje');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-justify'], "Configura tu billete de tren según tus necesidades 
                                                              y paga solo por lo que te interese.");
echo CHTML::dibujaEtiquetaCierre('div');

// Columna 3 de la fila dentro del primer testamento
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-3 text-justify']);
echo CHTML::dibujaEtiqueta('h5',['class' => 'fw-bold mb-3'],'<i class="bi bi-building " aria-hidden="true"></i> De centro a centro');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-justify'], "Te llevamos de centro a centro de la 
                                                              ciudad, para que llegues a tu destino rápida y cómodamente.");
echo CHTML::dibujaEtiquetaCierre('div');


// Cierra la fila dentro del primer testamento
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');


/**--------------------------------------------------------------------------------------- */
// Flecha izquierda
echo CHTML::dibujaEtiqueta('button', ['class' => 'carousel-control-prev', 'type' => 'button', 'data-bs-target' => '#carouselExampleControlsNoTouching', 'data-bs-slide' => 'prev']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'bi bi-arrow-left-circle-fill colorFlecha fs-3', 'aria-hidden' => 'true']);
echo CHTML::dibujaEtiquetaCierre('span');
echo CHTML::dibujaEtiqueta('span', ['class' => 'visually-hidden'], 'Previous');
echo CHTML::dibujaEtiquetaCierre('button');

// Flecha derecha
echo CHTML::dibujaEtiqueta('button', ['class' => 'carousel-control-next', 'type' => 'button', 'data-bs-target' => '#carouselExampleControlsNoTouching', 'data-bs-slide' => 'next']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'bi bi-arrow-right-circle-fill  colorFlecha fs-3', 'aria-hidden' => 'true']);
echo CHTML::dibujaEtiquetaCierre('span');
echo CHTML::dibujaEtiqueta('span', ['class' => 'visually-hidden'], 'Next');
echo CHTML::dibujaEtiquetaCierre('button');

echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div del carrusel

echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div con clase 'carousel slide'
echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div con clase 'row'

// Cierra el div contenedor
echo CHTML::dibujaEtiquetaCierre('div');




/**----------------------------------------------------------------------------- */
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.container-fluid






echo CHTML::script(
    "

    var collapseButton = document.getElementById('collapseButton');
    var collapseOne = document.getElementById('flush-collapseOne');
    
    // Evitar que el acordeón se cierre una vez que se abre
    collapseButton.addEventListener('click', function() {
        // Verificar si el acordeón ya está abierto
        var isOpen = collapseOne.classList.contains('show');
    
        // Si el acordeón no está abierto, entonces lo abrimos
        if (!isOpen) {
            collapseOne.classList.add('show');
            collapseButton.setAttribute('aria-expanded', 'true');
        }
    });
    
    var tipoViajeSelect = document.getElementById('tipoViajeSelect');
    var fechaIdaDiv = document.getElementById('fechaIdaDiv');
    var fechaVueltaDiv = document.getElementById('fechaVueltaDiv');
    
   
            function updateFechaInputs() {
                if (tipoViajeSelect.value === '1') { // Ida y vuelta
                    fechaIdaDiv.classList.remove('d-none'); // Mostrar input de fecha para ida
                    fechaVueltaDiv.classList.remove('d-none'); // Mostrar input de fecha para vuelta
                } else { // Sólo ida
                    fechaIdaDiv.classList.remove('d-none'); // Mostrar solo input de fecha para ida
                    fechaVueltaDiv.classList.add('d-none'); // Ocultar input de fecha para vuelta
                }
            }

            // Ejecutar al cargar la página
            updateFechaInputs();

            // Ejecutar al cambiar la selección
            tipoViajeSelect.addEventListener('change', updateFechaInputs);
    
    const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementById('liveToast')

if (toastTrigger) {
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
  toastTrigger.addEventListener('click', () => {
    toastBootstrap.show()
  })
}



"

);

if ($mostrarToast) {
    echo '
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="./imagenes/icono.png" class="rounded me-2" alt="Icono" style="width: 35px; height: 30px;">
            <strong class="me-auto">Safetravel</strong>
                <small>Hace 1 seg</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                    ¡Hola de nuevo , '.$nick.' !
            </div>
        </div>
    </div>';
}

if ($registrar) {
    echo '
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="./imagenes/icono.png" class="rounded me-2" alt="Icono" style="width: 35px; height: 30px;">
            <strong class="me-auto">Safetravel</strong>
                <small>Hace 1 seg</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                    ¡Hola bienvenido , '.$nick.' !
            </div>
        </div>
    </div>';
}