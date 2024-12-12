<?php
echo CHTML::dibujaEtiqueta('div', ['class' => 'container-fluid mt-5 mb-5']);
echo CHTML::dibujaEtiqueta('h2', [], 'Resumen de la Compra de Billetes');
$val = 0;
if(count($billetes)>0){
    foreach ($billetes as $billete) {
        // Abre el div contenedor del "ticket" con la clase 'ticket'
        $val = $val + 1;
        echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket-container shadow mb-4', 'id' => 'ticket-' . $val]);
        // Cabecera del "ticket" con la información del billete y la clase 'ticket-header'
        echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket-header']);
        echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold display-6'], $billete['origen']. ' <i class="fas fa-arrow-right"></i> ' . $billete['destino']);
        echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold'], '<i class="bi bi-calendar"></i> ' . $billete['fecha_ida'] . ' <i class="bi bi-arrow-right"></i> ' . $billete['fecha_vuelta']);
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket-header
    
        // Detalles del billete
        echo CHTML::dibujaEtiqueta('div', ['class' => 'ticket-details']);
        echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold'], 'Detalles del Pasajero:');
        echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-person"></i> ' . $billete['nombre']);
        echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-card-text"></i> DNI: ' . $billete['dni']);
        echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-calendar3"></i> Fecha de Nacimiento: ' . $billete['fecha_nac']);
        echo CHTML::dibujaEtiqueta('p', [], '<i class="bi bi-telephone"></i> Teléfono: ' . $billete['telefono']);
        echo CHTML::dibujaEtiqueta('p', ['class' => 'fw-bold'], 'Precio: ' . $billete['precio_billete'] . ' €');
    
        // Botón de eliminar billete (opcional)
        echo CHTML::dibujaEtiqueta('div', ['class' => 'text-center mt-3']);
        echo CHTML::iniciarForm('', 'POST', ['class' => 'mb-4']);
        echo CHTML::campoHidden('id',$billete['nombre'],[]);
        echo CHTML::campoBotonSubmit('Eliminar Billete', ['class' => 'btn btn-danger mb-3 boton-eliminar', 'id' => "btn-".$val,'name' => 'id_0']);
        echo CHTML::finalizarForm();
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del div de eliminar
    
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket-details
        echo CHTML::dibujaEtiquetaCierre('div'); // Cierre de div.ticket-container
    }
    
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierra el div.container-fluid
    
    echo CHTML::dibujaEtiqueta('div', ['class' => 'container mt-5 mb-5']);
    echo CHTML::dibujaEtiqueta('h4', [], 'Método de pago');
    
    // Formulario de compra
    echo CHTML::iniciarForm('', 'POST', ['class' => 'mb-4']);
    echo CHTML::campoListaDropDown('metodo_pago','', [
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta de Crédito',
        'transferencia' => 'Transferencia Bancaria'
    ], ['class' => 'form-select mb-3', 'placeholder' => 'Selecciona método de pago']);
    if(!empty($errores)){
        echo CHTML::dibujaEtiqueta('div',  ['class' => 'error invalid-feedback'],$errores);
        echo CHTML::dibujaEtiqueta('br');
    }
    
    echo CHTML::campoBotonSubmit('Comprar', ['class' => 'btn btn-primary boton','name' => 'comprar']);
    echo CHTML::finalizarForm();
    
    echo CHTML::dibujaEtiquetaCierre('div'); // Cierre del div.container
    
}else{
    echo CHTML::dibujaEtiqueta('div',  ['class' => 'error invalid-feedback'],'Has eliminado todos los billetes');

}


echo CHTML::dibujaEtiqueta('script', [], '
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".boton-eliminar").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            let id = this.id.replace("btn-", "ticket-");
            let ticket = document.getElementById(id);
            
            let id_billete = this.closest("form").querySelector("input[name=\'id\']").value;

            if (ticket) {
                fetch("", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "id_billete=" + id_billete,
                })
                .then(response => response.text())
                .then(data => {
                    ticket.remove();
                    console.log("Billete eliminado con ID: " + id);
                })
                .catch(error => console.error("Error al eliminar el billete:", error));
            }
        });
    });
});
');


?>
