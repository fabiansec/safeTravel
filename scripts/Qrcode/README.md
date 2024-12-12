# QRcode - Rápido y Limpio

Generar codigo QR de forma rápida y limpia, con opciones para usar en PDF con FPDF, PNG y HTML. 
<p>
El objetivo es poder ser usado para altos volúmenes.
</p>

## RÁPIDO Y LIMPIO:

Esta clase permite ser utilizada en proyectos donde se tienen que generar miles de codigos QR en el mejor tiempo
y de la manera más limpia sin perjudicar los recursos.

## OPCIONES DE VISUALIZACIÓN:

   -  Permite visualizar el código QR en un pdf a través de FPDF.
   -  Permite mostrar el código QR en formato HTML, para usar con un estilo CSS.
   -  Permite obtener una imagen PNG con opciones de compresión.
   -  Puede ser llamado desde plantillas HTML con variables GET


<hl>
  <p align="center">
      <h2>Cómo usar QRcode - rápido y limpio</h2>
  </p> 
</hl>
  
<p>
  Generando una tabla HTML, claro respetando formatos CSS
</p>  

Los estilos CSS son como se muestran en el siguiente ejemplo:

<pre>
    
    table.qr
    {
      border-collapse: collapse;
      border: solid 1px black;
      table-layout: fixed;
    }

    table.qr td
    {
      width: 5px;
      height: 5px;
      font-size: 2px;
    }

    table.qr td.on
    {
      background: #000999;
    }
    

</pre>

y simplemente mandar llamar <b>displayHTML()</b>

```
	<?php
		$qrcode = new QRcode(utf8_encode($msg), $err);
		$qrcode->displayHTML();
	?>

```

<p>
Generando una imagen PNG :
</p>

```
<img src="./image.php?msg=<?php echo urlencode($msg); ?>&amp;err=<?php echo urlencode($err); ?>" alt="generation qr-code" style="border: solid 1px black;">
```

Para todos los casos anteriores, el código para correccion de errores son los siguientes:

```
L     M     Q     H
________________________________________
*           *      
*     *            
________________________________________
7%    15%   25%   30%
```

  
 ***NOTA:*** Este código se aplicado en la generación de Facturas en México para el SAT en su representación impresa.  
 Generando más de 1,000 imágenes en segundos.
  
  

  
  ## GNU GENERAL PUBLIC LICENSE
  <p>The GNU General Public License is a free, copyleft license for software and other kinds of works.</p>
  
  <p></p>
  <p></p>
  
  Created by: 	**Hector Manuel Alonso Ortiz**
  <p></p>
  
  eMail: 		**[alonso.hector@gmail.com](mailto:alonso.hector@gmail.com)**
  <p></p>
  

  <p></p>
  









