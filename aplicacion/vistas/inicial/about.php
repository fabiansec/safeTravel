<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container  mt-5 mb-5 rounded shadow']);

echo CHTML::dibujaEtiqueta('div', ['class' => 'row align-items-stretch']);

echo CHTML::dibujaEtiqueta('div', ['class' => 'col bgNosotros d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded-start']);

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col

echo CHTML::dibujaEtiqueta('div', ['class' => 'col p-5 pt-1 rounded-end fondoLogin']);


echo CHTML::dibujaEtiqueta('h2', ['class' => 'fw-bold text-center py-5 text-white'], 'Sobre nosotros');

// Texto sobre la aplicación web
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-left text-white fs-10 text-justify'], "En nuestro sitio, 
        nos especializamos en facilitar la reserva de tus viajes en tren.
        Nuestro compromiso es ofrecerte una experiencia de compra online simple y segura, 
        donde puedas encontrar las mejores opciones de viaje para tus necesidades. ");


// Tarjetas de "más de no se cuántos" clientes, estaciones y trayectos
echo CHTML::dibujaEtiqueta('div', ['class' => 'row mt-4']);

// Card "Más de no se cuántos clientes"
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-4 mb-3']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'card']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body text-center']);
echo CHTML::imagen('/imagenes/personas.png', '', ['width' => '40', 'height' => '40']);
echo CHTML::dibujaEtiquetaCierre('h5');
echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text p-2'], '+1000');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-md-4

// Card "Más de no se cuántas estaciones"
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-4 mb-3']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'card']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body text-center']);
echo CHTML::imagen('/imagenes/estacionTren.png', '', ['width' => '40', 'height' => '40']);

echo CHTML::dibujaEtiquetaCierre('h5');
echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text p-2'], '+50');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-md-4

// Card "Más de no se cuántos trayectos"
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-4 mb-3']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'card']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'card-body text-center']);
echo CHTML::imagen('/imagenes/euro.png', '', ['width' => '40', 'height' => '40']);
echo CHTML::dibujaEtiquetaCierre('h5');
echo CHTML::dibujaEtiqueta('p', ['class' => 'card-text p-2'], '600K');
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card-body
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.card
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col-md-4

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.container

//------------------ PREGUNTAS FRECUENTES --------------------------------

echo CHTML::dibujaEtiqueta('main', ['class' => 'bg-white d-flex  container  mt-5 mb-5']);
echo CHTML::dibujaEtiqueta('section', ['class' => ' container-sm mx-auto fondoLogin  shadow rounded p-4']);
echo CHTML::dibujaEtiqueta('h1', ['class' => 'fs-2 fw-bold  text-white text-center py-3'], 'Preguntas frecuentes');

// Primer ítem del acordeón
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion accordion-flush rounded shadow', 'id' => 'accordionFlushExample']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-item ']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'accordion-header ']);
echo CHTML::dibujaEtiqueta('button', ['class' => 'accordion-button collapsed ', 'type' => 'button', 'data-bs-toggle' => 'collapse', 'data-bs-target' => '#flush-collapseOne', 'aria-expanded' => 'false', 'aria-controls' => 'flush-collapseOne']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'px-3 text-primary'], '<em>¿Cómo puedo comprar un billete?</em>');
echo CHTML::dibujaEtiquetaCierre('button');
echo CHTML::dibujaEtiquetaCierre('h2');
echo CHTML::dibujaEtiqueta('div', ['id' => 'flush-collapseOne', 'class' => 'accordion-collapse collapse', 'data-bs-parent' => '#accordionFlushExample']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-body']);
echo CHTML::dibujaEtiqueta('p', [], 'Deberás rellenar el formulario de la ventana principal.');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');

// Segundo ítem del acordeón
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-item accordion-flush']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'accordion-header']);
echo CHTML::dibujaEtiqueta('button', ['class' => 'accordion-button collapsed', 'type' => 'button', 'data-bs-toggle' => 'collapse', 'data-bs-target' => '#flush-collapseTwo', 'aria-expanded' => 'false', 'aria-controls' => 'flush-collapseTwo']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'px-3 text-primary'], '<em>¿Cuáles son los métodos de pago aceptados?</em>');
echo CHTML::dibujaEtiquetaCierre('button');
echo CHTML::dibujaEtiquetaCierre('h2');
echo CHTML::dibujaEtiqueta('div', ['id' => 'flush-collapseTwo', 'class' => 'accordion-collapse collapse', 'data-bs-parent' => '#accordionFlushExample']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-body']);
echo CHTML::dibujaEtiqueta('div', [], 'Aceptamos pagos con tarjeta de crédito/débito Visa, Mastercard y American Express, así como PayPal y transferencia bancaria.');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');

// Tercer ítem del acordeón
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-item accordion-flush']);
echo CHTML::dibujaEtiqueta('h2', ['class' => 'accordion-header']);
echo CHTML::dibujaEtiqueta('button', ['class' => 'accordion-button collapsed', 'type' => 'button', 'data-bs-toggle' => 'collapse', 'data-bs-target' => '#flush-collapseThree', 'aria-expanded' => 'false', 'aria-controls' => 'flush-collapseThree']);
echo CHTML::dibujaEtiqueta('span', ['class' => 'px-3 text-primary'], '<em>¿Cómo puedo cancelar o cambiar mi billete de tren?</em>');
echo CHTML::dibujaEtiquetaCierre('button');
echo CHTML::dibujaEtiquetaCierre('h2');
echo CHTML::dibujaEtiqueta('div', ['id' => 'flush-collapseThree', 'class' => 'accordion-collapse collapse', 'data-bs-parent' => '#accordionFlushExample']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'accordion-body']);
echo CHTML::dibujaEtiqueta('div', [], 'Solo podrá cancelarlo con la tarifa Premium');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');

// Cierre de la sección y el main
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.accordion





echo CHTML::dibujaEtiquetaCierre('section'); // Cierre de section
echo CHTML::dibujaEtiquetaCierre('main'); // Cierre de main


/**--------------------------- CARRUSEL Testimonios -------------------------------- */
echo CHTML::dibujaEtiqueta('div', [
        'id' => 'carouselExampleControlsNoTouching',
        'class' => 'carousel slide text-center mb-5 mt-6 container-fluid  rounded shadow',
        'data-bs-touch' => 'false'
]);
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-inner']);

/**----------------------------------------- TESTAMENTO 1 ----------------------------- */
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item active ']);
echo CHTML::imagen('https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).webp', '', [
        'class' => 'rounded-circle shadow-1-strong mb-4 mt-4',
        'style' => 'width: 150px;',
        'alt' => 'avatar'
]);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row d-flex justify-content-center']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-lg-8']);
echo CHTML::dibujaEtiqueta('h5', ['class' => 'mb-3'], 'Judith Pérez');
echo CHTML::dibujaEtiqueta('p', [], 'Agente de Ventas');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-muted']);
echo '"¡Increíble experiencia con esta aplicación! Comprar billetes de tren nunca ha sido tan fácil y conveniente. La interfaz intuitiva y amigable me permitió reservar mi viaje en cuestión de minutos."';
echo CHTML::dibujaEtiquetaCierre('p');


echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');


/**----------------------------------------- TESTAMENTO 2 ----------------------------- */
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item']);
echo CHTML::imagen('https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(9).webp', '', [
        'class' => 'rounded-circle shadow-1-strong mb-4 mt-4',
        'style' => 'width: 150px;',
        'alt' => 'avatar'
]);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row d-flex justify-content-center']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-lg-8']);
echo CHTML::dibujaEtiqueta('h5', ['class' => 'mb-3'], 'Paco Martínez');
echo CHTML::dibujaEtiqueta('p', [], 'Cliente');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-muted']);
echo 'Estoy muy impresionado con la atención al cliente de esta aplicación. Tuve un problema con mi reserva y su equipo de soporte lo resolvió rápidamente y con profesionalismo. ¡Gracias por hacer que mi viaje en tren sea sin problemas!';
echo CHTML::dibujaEtiquetaCierre('p');

echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');
echo CHTML::dibujaEtiquetaCierre('div');


/**----------------------------------------- TESTAMENTO 3 --------------------------- */
echo CHTML::dibujaEtiqueta('div', ['class' => 'carousel-item']);
echo CHTML::imagen('https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(18).webp', '', [
        'class' => 'rounded-circle shadow-1-strong mb-4 mt-4',
        'style' => 'width: 150px;',
        'alt' => 'avatar'
]);
echo CHTML::dibujaEtiqueta('div', ['class' => 'row d-flex justify-content-center']);
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-lg-8']);
echo CHTML::dibujaEtiqueta('h5', ['class' => 'mb-3'], 'Chloe Figueroa');
echo CHTML::dibujaEtiqueta('p', [], 'Asistente de Reservas');
echo CHTML::dibujaEtiqueta('p', ['class' => 'text-muted']);
echo '¡La mejor decisión que he tomado! Esta aplicación ha simplificado por completo mi proceso de compra de billetes de tren. Con solo unos pocos clics, pude encontrar las mejores opciones de viaje y asegurar mis boletos.';
echo CHTML::dibujaEtiquetaCierre('p');
echo CHTML::dibujaEtiquetaCierre('div');
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

echo CHTML::dibujaEtiquetaCierre('div');
