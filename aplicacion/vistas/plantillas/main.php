<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $titulo; ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/estilos/principal.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <link rel="icon" type="image/png" href="/imagenes/favicon.png" />

  <?php
  if (isset($this->textoHead)) {
    echo $this->textoHead;
  }


  ?>

</head>

<body>

  <header>

    <!--      BARRA DE NAVEGACION    -->
    <nav class="navbar navbar-expand-lg ">
      <div class="container-fluid">
        <a class="navbar-brand text-light me-auto fw-bold fs-3" href="/index.php">SafeTravel</a>

        <div class="offcanvas offcanvas-end  gradient-background transparencia-item" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-white  h3 " id="offcanvasNavbarLabel">Opciones</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>

          </div>
          <div class="offcanvas-body ">
            <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
              <li class="nav-item">
                <?php
                echo CHTML::link(
                  "Inicio",
                  Sistema::app()->generaURL(["inicial"]),
                  ['class' => 'nav-link mx-lg-2 text-white active fs-5', 'aria-current' => 'page']
                );
                ?>
              </li>
              <li class="nav-item">
                <?php
                echo CHTML::link(
                  "Sobre nosotros",
                  Sistema::app()->generaURL(["inicial", "about"]),
                  ['class' => 'nav-link mx-lg-2 text-white fs-5']
                );
                ?>
              </li>
              <li class="nav-item">
                <?php
                echo CHTML::link(
                  "Ofertas",
                  Sistema::app()->generaURL(["tarifas"]),
                  ['class' => 'nav-link mx-lg-2 text-white fs-5']
                );
                ?>
              </li>
              <?php if ((Sistema::app()->Acceso()->puedePermiso(1))) { ?>
                <li class="nav-item">
                  <?php
                  echo CHTML::link(
                    "Mis compras",
                    Sistema::app()->generaURL(["inicial", "misCompras"]),
                    ['class' => 'nav-link mx-lg-2 text-white fs-5']
                  );
                  ?>
                </li>
              <?php } ?>
              <?php if ((Sistema::app()->Acceso()->puedePermiso(10))) { ?>
                <li class="nav-item">
                  <?php
                  echo CHTML::link(
                    "CRUD Tarifas",
                    Sistema::app()->generaURL(["tarifas", "indexTabla"]),
                    ['class' => 'nav-link mx-lg-2 text-white fs-5']
                  );
                  ?>
                </li>
                <li class="nav-item">
                  <?php
                  echo CHTML::link(
                    "CRUD Trayectos",
                    Sistema::app()->generaURL(["trayectos", "indexTabla"]),
                    ['class' => 'nav-link mx-lg-2 text-white fs-5']
                  );
                  ?>
                </li>
                <li class="nav-item">
                  <?php
                  echo CHTML::link(
                    "CRUD Viajes",
                    Sistema::app()->generaURL(["viajes", "indexTabla"]),
                    ['class' => 'nav-link mx-lg-2 text-white fs-5']
                  );
                  ?>
                </li>
              <?php
              } ?>
            </ul>
            <!-- LOGIN -->
            <div class="d-flex justify-content-center align-items-center gap-4 m-4"> <!-- Cambiado gap-3 a gap-4 para aumentar el espacio -->
              <?php
              if (Sistema::app()->Acceso()->hayUsuario()) {
                echo  CHTML::link('Cerrar sesión', Sistema::app()->generaURL(["registro", 'cerrar']), ['class' => 'nav-link text-white  fs-5']);
              } else {
                echo  CHTML::link('Iniciar sesión', Sistema::app()->generaURL(["registro", 'login']), ['class' => 'nav-link text-white fs-5']);
                echo  CHTML::link('Registrarse', Sistema::app()->generaURL(["registro", 'registrarse']), ['class' => 'nav-link text-white   fs-5 d-lg-none']);
              }


              ?>
            </div>

            <!-- FIN LOGIN -->

          </div>
        </div>




        <button class="navbar-toggler nav-toggle-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <img src="/imagenes/menu.png" alt="Icono" width="30" height="30">
        </button>
      </div>
    </nav>
    <!-- FIN BARRA NAVEGACIÓN -->


    <!--  CONTENIDO   -->
    <div class="contenido container-fluid" id="content">
      <article>
        <?php echo $contenido; ?>
      </article><!-- #content -->
    </div>
    <!--  FIN CONTENIDO   -->

    <!-- FOOTER -->
    <div class="container-fluid text-white p-3" style="background: linear-gradient(to right, #57436C,#2F4A79,#57436C);">
      <div class="mt-3">
        <h3 class="text-center fw-bold">¿Listo para viajar?</h3>
        <p class="text-center">Descubre una experiencia única al viajar en tren, con nuestras tarifas flexibles y rutas emocionantes.<br> No te pierdas la oportunidad de explorar nuevos destinos de una manera cómoda y segura.</p>
        <center>
          <a href="/index.php/#content" class="btn btn-block btn-outline-light">¡Compra ahora!</a>
        </center>
        <hr>
      </div>

      <div class="row justify-content-around text-center text-md-start">
        <div class="col-md-2 text-center">
          <!-- <h1 class="fw-bold mt-3">SF</h1> -->
          <img src="/imagenes/icono.png" width="120px" height="85px" class="d-none d-md-block mx-auto">
        </div>

        <div class="col-md-2">
          <ul class="list-unstyled">
            <li class="fw-bold my-2">Parters</li> <!-- Modificado -->
            <li><a href="#" class="text-decoration-none text-white">Sitio Web</a></li>
            <li><a href="#" class="text-decoration-none text-white">Redes Sociales</a></li>
            <li><a href="#" class="text-decoration-none text-white">Marca</a></li>
          </ul>
        </div>
        <div class="col-md-2">
          <ul class="list-unstyled">
            <li class="fw-bold my-2">Acerca de</li> <!-- Modificado -->
            <li> <?php
                  echo CHTML::link(
                    "Sobre nosotros",
                    Sistema::app()->generaURL(["inicial", "about"]),
                    ['class' => 'text-decoration-none text-white']
                  );
                  ?></li>

          </ul>
        </div>

        <div class="col-md-2">
          <li class="fw-bold my-2 list-unstyled">Redes Sociales</li> <!-- Modificado -->

          <ul class="list-unstyled d-flex justify-content-center justify-content-md-start"> <!-- Agregado d-flex flex-row align-items-center para mostrar los íconos y las imágenes horizontalmente -->
            <li><a href="#" class="text-white"><img src="/imagenes/twitter.png" width="30" height="30" class="me-2"></a></li>
            <li><a href="#" class="text-white"><img src="/imagenes/instagram.png" width="30" height="30" class="me-2"></a></li>
            <li><a href="#" class="text-white"><img src="/imagenes/whatsapp.png" width="30" height="30" class="me-2"></a></li>

          </ul>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12 text-center pt-2">
          <p>&copy; 2024 Copyright <a href="#" class="text-white  ">SafeTravel</a></p>
        </div>
      </div>

    </div>
    <a id="top"></a> <!-- Ancla agregada -->
    <!-- FIN DE FOOTER -->
    
</body>

</html>