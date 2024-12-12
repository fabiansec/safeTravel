    <?php
    echo CHTML::dibujaEtiqueta('div', ['class' => 'container w-80 mt-5 mb-5 rounded shadow']);

    echo CHTML::dibujaEtiqueta('div', ['class' => 'row align-items-stretch ']);

    echo CHTML::dibujaEtiqueta('div', ['class' => 'col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded-start']);


    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col

    echo CHTML::dibujaEtiqueta('div', ['class' => 'col p-5 rounded-end fondoLogin']);

    echo CHTML::dibujaEtiqueta('div', ['class' => 'text-end']);
    echo CHTML::imagen('/imagenes/icono.png', '', ['width' => '50', 'alt' => '']);
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.text-end

    echo CHTML::dibujaEtiqueta('h2', ['class' => 'fw-bold text-center py-5 text-white'], 'Bienvenido');

    echo CHTML::iniciarForm('', 'post', []);

    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-4']);
    echo CHTML::campoLabel('Usuario', 'usuario', ['class' => 'form-label text-white ']);
    echo CHTML::modeloText($modelo, 'nick', ['class' => 'form-control']);
    echo CHTML::modeloError($modelo, 'nick', ['class' => 'invalid-feedback']); // Añadir la clase 'invalid-feedback' para mostrar el mensaje de error

    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-4

    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-4']);
    echo CHTML::campoLabel('Contraseña', 'contrasena', ['class' => 'form-label text-white']);
    echo CHTML::modeloPassword($modelo, 'contrasenia', ['class' => 'form-control']);
    echo CHTML::modeloError($modelo, 'contrasenia', ['class' => 'invalid-feedback']); // Añadir la clase 'invalid-feedback' para mostrar el mensaje de error
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-4


        echo CHTML::campoBotonSubmit('Iniciar Sesión', ['class' => 'btn botonInicio d-grid text-white mr-3']); // Agregado mr-3 para espacio a la derecha

    

    echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-3 text-white']); // Agregado contenedor para texto adicional
    echo '¿Aún no tienes cuenta? '; // Texto adicional
    echo CHTML::link('Regístrate aquí', Sistema::app()->generaURL(["registro", 'registrarse']), ['class' => 'text-white']); // Enlace de registro
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-3

    echo CHTML::finalizarForm();


    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col

    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row

    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.container

    

