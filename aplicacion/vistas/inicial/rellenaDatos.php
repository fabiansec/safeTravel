<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container-fluid mt-5 mb-5']);
echo CHTML::dibujaEtiqueta('h2', [], 'Formulario de Datos Personales');
echo CHTML::dibujaEtiqueta('h3', [], "Billete " . ($index + 1) . " de $total");

echo CHTML::iniciarForm('', 'POST', ['class' => 'row g-3']);

// Campo de nombre
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-6']);
echo CHTML::dibujaEtiqueta('label', ['for' => 'nombre', 'class' => 'form-label'], 'Nombre');
echo CHTML::modeloText($billete, 'nombre', ['id' => 'nombre', 'class' => 'form-control', 'required' => true]);
echo CHTML::modeloError($billete, 'nombre', ['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiquetaCierre('div');

// Campo de DNI
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-6']);
echo CHTML::dibujaEtiqueta('label', ['for' => 'dni', 'class' => 'form-label'], 'DNI');
echo CHTML::modeloText($billete, 'dni', ['id' => 'dni', 'class' => 'form-control', 'required' => true]);
echo CHTML::modeloError($billete, 'dni', ['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiquetaCierre('div');

// Campo de fecha de nacimiento
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-6']);
echo CHTML::dibujaEtiqueta('label', ['for' => 'fecha_nac', 'class' => 'form-label'], 'Fecha de Nacimiento');
echo CHTML::modeloDate($billete, 'fecha_nac', ['id' => 'fecha_nac', 'class' => 'form-control', 'required' => true]);
echo CHTML::modeloError($billete, 'fecha_nac', ['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiquetaCierre('div');

// Campo de teléfono
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-md-6']);
echo CHTML::dibujaEtiqueta('label', ['for' => 'telefono', 'class' => 'form-label'], 'Teléfono');
echo CHTML::modeloNumber($billete, 'telefono', ['id' => 'telefono', 'class' => 'form-control', 'required' => true]);
echo CHTML::modeloError($billete, 'telefono', ['class' => 'error invalid-feedback inputCrud']);
echo CHTML::dibujaEtiquetaCierre('div');

// Botón de envío
echo CHTML::dibujaEtiqueta('div', ['class' => 'col-12']);
echo CHTML::campoBotonSubmit('Siguiente', ['class' => 'btn btn-primary']);
echo CHTML::dibujaEtiqueta('br');
echo CHTML::dibujaEtiqueta('br');


echo CHTML::dibujaEtiquetaCierre('div');

echo CHTML::finalizarForm();
echo CHTML::iniciarForm('', 'POST', ['class' => '']);

echo CHTML::campoBotonSubmit('Cancelar todo', ['class' => 'btn btn-warning ml-4']);
echo CHTML::finalizarForm();


echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div.container-fluid
?>
