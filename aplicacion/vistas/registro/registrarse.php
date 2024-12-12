<?php


echo CHTML::dibujaEtiqueta('div', ['class' => 'container w-80 mt-5 mb-5 rounded shadow']);

echo CHTML::dibujaEtiqueta('div', ['class' => 'row align-items-stretch ']);

echo CHTML::dibujaEtiqueta('div', ['class' => 'col bgRegistro d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded-start']);


echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col

echo CHTML::dibujaEtiqueta('div', ['class' => 'col p-5 rounded-end fondoLogin']);



echo CHTML::dibujaEtiqueta('h2', ['class' => 'fw-bold text-center py-1 text-white'], 'Registrarse');

echo CHTML::iniciarForm('', 'post', []);

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-4']);
echo CHTML::campoLabel('Usuario', 'usuario', ['class' => 'form-label text-white']);
echo CHTML::modeloText($modelo, 'nick', ['class' => 'form-control']);
echo CHTML::modeloError($modelo, 'nick', ['class' => 'invalid-feedback']); // Añadir la clase 'invalid-feedback' para mostrar el mensaje de error
echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-4

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-4']);
echo CHTML::campoLabel('Contraseña', 'contrasena', ['class' => 'form-label text-white']);
echo CHTML::modeloPassword($modelo, 'contrasenia', ['class' => 'form-control']);
echo CHTML::modeloError($modelo, 'contrasenia', ['class' => 'invalid-feedback']); // Añadir la clase 'invalid-feedback' para mostrar el mensaje de error

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-4


echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-4']);
echo CHTML::campoLabel('Repite contraseña', 'repiteContrasena', ['class' => 'form-label text-white']);
echo CHTML::modeloPassword($modelo, 'repite', ['class' => 'form-control']);
echo CHTML::modeloError($modelo, 'repite', ['class' => 'invalid-feedback']); // Añadir la clase 'invalid-feedback' para mostrar el mensaje de error

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-4

echo CHTML::dibujaEtiqueta('div', ['class' => 'mb-4']);
echo CHTML::campoLabel('Correo electrónico', 'email', ['class' => 'form-label text-white']);
echo CHTML::modeloEmail($modelo, 'email', ['class' => 'form-control']);
echo CHTML::modeloError($modelo, 'email', ['class' => 'invalid-feedback']); // Añadir la clase 'invalid-feedback' para mostrar el mensaje de error

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.mb-4



echo CHTML::campoBotonSubmit('Registrarse', ['class' => 'btn botonInicio d-grid text-white']);



echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.col

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.row

echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.container
