<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home-ISFT 225</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/personal.css">
</head>

<body>
  <!--Enlace de conexion, creación de tabla-->
  <?php
  require('./conexion.php');

  // Obtener los datos del formulario
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // isset función que se utiliza para determinar si una variable está definida y no es null
    // Capturar el valor del select
    if (isset($_POST['rol_personal'])) {
      $rol_personal = $_POST['rol_personal'];
      $rol_personal = strtoupper($rol_personal);
      }
    $nombre_usuario = strtoupper($_POST['nombre_usuario']);
    $password_usuario = strtoupper($_POST['password_usuario']);
    $nombre_personal_n = strtoupper($_POST['nombre_personal']);
    $apellido_personal_n = strtoupper($_POST['apellido_personal']);
    $email_personal_n = strtoupper($_POST['email_personal']);
    $tipodoc_personal_n = strtoupper($_POST['tipodoc_personal']);
    $nrodni_personal_n = strtoupper($_POST['nrodni_personal']);
    $nrocuil_personal_n = strtoupper($_POST['nrocuil_personal']);

    if (isset($_POST['sexo_personal'])) {
      $sexo_personal = $_POST['sexo_personal'];
      $sexo_personal = strtoupper($sexo_personal);
      }

    $fechanac_personal_n = strtoupper($_POST['fechanac_personal']);
    $paisnac_personal_n = strtoupper($_POST['paisnac_personal']);
    $lugarnac_personal_n = strtoupper($_POST['lugarnac_personal']);
    $fecha_designacion_n = strtoupper($_POST['fecha_designacion']);
    $paisdomic_personal_n = strtoupper($_POST['paisdomic_personal']);
    $provdomic_personal_n = strtoupper($_POST['provdomic_personal']);
    $calle_personal_n = strtoupper($_POST['calle_personal']);
    $depto_personal_n = strtoupper($_POST['depto_personal']);
    $edificio_personal_n = strtoupper($_POST['edificio_personal']);
    $localidad_personal_n = strtoupper($_POST['localidad_personal']);
    $partido_personal_n = strtoupper($_POST['partido_personal']);
    $titulo_n = strtoupper($_POST['titulo']);
    $titulo_institucion_n = strtoupper($_POST['titulo_institucion']);
    $tipo_titulo_n = strtoupper($_POST['tipo_titulo']);
    $carr1_n = strtoupper($_POST['carr1']);
    $carr1_institucion_n = strtoupper($_POST['carr1_institucion']);
    $carr1_estado_n = strtoupper($_POST['carr1_estado']);
    $carr1_titulo_n = strtoupper($_POST['carr1_titulo']);
    $carr2_n = strtoupper($_POST['carr2']);
    $carr2_institucion_n = strtoupper($_POST['carr2_institucion']);
    $carr2_estado_n = strtoupper($_POST['carr2_estado']);
    $carr2_titulo_n = strtoupper($_POST['carr2_titulo']);
    $estado_personal_n = strtoupper($_POST['estado_personal']);
    $telefono_personal = strtoupper($_POST['telefono_personal']);
    $nro_designacion = strtoupper($_POST['nro_designacion']);
    $nro_personal = strtoupper($_POST['nro_personal']);
    $piso_personal = strtoupper($_POST['piso_personal']);
    $cp_personal = strtoupper($_POST['cp_personal']);
    $anio_egreso = strtoupper($_POST['anio_egreso']);
    $carr1_anioegreso = strtoupper($_POST['carr1_anioegreso']);
    $carr2_anioegreso = strtoupper($_POST['carr2_anioegreso']);

    if (isset($_POST['estado_personal'])) {
      $estado_personal = $_POST['estado_personal'];
      $estado_personal = strtoupper($estado_personal);
      }

    $DNIchecked = isset($_POST['check_lista']) ? 1 : 0;
    $CUILchecked = isset($_POST['check_cuil']) ? 1 : 0;
    $CVchecked = isset($_POST['check_cv']) ? 1 : 0;
    $TITchecked = isset($_POST['check_tit']) ? 1 : 0;

    // //Evitar inyeccion SQL ya que evita XSS al convertir caracteres especiales en entidades HTML.
    
    $rol_personal = htmlspecialchars($rol_personal, ENT_QUOTES, 'UTF-8');
    $nombre_usuario = htmlspecialchars($nombre_usuario, ENT_QUOTES, 'UTF-8');
    $password_usuario = htmlspecialchars($password_usuario, ENT_QUOTES, 'UTF-8');
    $nombre_personal = htmlspecialchars($nombre_personal_n, ENT_QUOTES, 'UTF-8');
    $apellido_personal = htmlspecialchars($apellido_personal_n, ENT_QUOTES, 'UTF-8');
    $email_personal = htmlspecialchars($email_personal_n, ENT_QUOTES, 'UTF-8');
    $tipodoc_personal = htmlspecialchars($tipodoc_personal_n, ENT_QUOTES, 'UTF-8');

    $nrodni_personal = htmlspecialchars($nrodni_personal_n, ENT_QUOTES, 'UTF-8');
    $nrocuil_personal = htmlspecialchars($nrocuil_personal_n, ENT_QUOTES, 'UTF-8');

    $fechanac_personal = htmlspecialchars($fechanac_personal_n, ENT_QUOTES, 'UTF-8');
    $paisnac_personal = htmlspecialchars($paisnac_personal_n, ENT_QUOTES, 'UTF-8');
    $lugarnac_personal = htmlspecialchars($lugarnac_personal_n, ENT_QUOTES, 'UTF-8');

    $fecha_designacion = htmlspecialchars($fecha_designacion_n, ENT_QUOTES, 'UTF-8');
    $paisdomic_personal = htmlspecialchars($paisdomic_personal_n, ENT_QUOTES, 'UTF-8');
    $provdomic_personal = htmlspecialchars($provdomic_personal_n, ENT_QUOTES, 'UTF-8');
    $calle_personal = htmlspecialchars($calle_personal_n, ENT_QUOTES, 'UTF-8');

    $depto_personal = htmlspecialchars($depto_personal_n, ENT_QUOTES, 'UTF-8');
    $edificio_personal = htmlspecialchars($edificio_personal_n, ENT_QUOTES, 'UTF-8');
    $localidad_personal = htmlspecialchars($localidad_personal_n, ENT_QUOTES, 'UTF-8');

    $partido_personal = htmlspecialchars($partido_personal_n, ENT_QUOTES, 'UTF-8');
    $titulo = htmlspecialchars($titulo_n, ENT_QUOTES, 'UTF-8');
    $titulo_institucion = htmlspecialchars($titulo_institucion_n, ENT_QUOTES, 'UTF-8');
    $tipo_titulo = htmlspecialchars($tipo_titulo_n, ENT_QUOTES, 'UTF-8');

    $carr1 = htmlspecialchars($carr1_n, ENT_QUOTES, 'UTF-8');
    $carr1_institucion = htmlspecialchars($carr1_institucion_n, ENT_QUOTES, 'UTF-8');
    $carr1_estado = htmlspecialchars($carr1_estado_n, ENT_QUOTES, 'UTF-8');
    $carr1_titulo = htmlspecialchars($carr1_titulo_n, ENT_QUOTES, 'UTF-8');

    $carr2 = htmlspecialchars($carr2_n, ENT_QUOTES, 'UTF-8');
    $carr2_institucion = htmlspecialchars($carr2_institucion_n, ENT_QUOTES, 'UTF-8');
    $carr2_estado = htmlspecialchars($carr2_estado_n, ENT_QUOTES, 'UTF-8');
    $carr2_titulo = htmlspecialchars($carr2_titulo_n, ENT_QUOTES, 'UTF-8');

    $estado_personal = htmlspecialchars($estado_personal_n, ENT_QUOTES, 'UTF-8');
   // $observaciones = htmlspecialchars($observaciones_n, ENT_QUOTES, 'UTF-8');


    //Sentencia SQL para insertar los datos
    
    $sql = "INSERT INTO personal (
    rol_personal,
    nombre_usuario,
    password_usuario,
    nombre_personal,
    apellido_personal,
    email_personal,
    telefono_personal,
    tipodoc_personal,
    
    nrodni_personal,
    nrocuil_personal,
    sexo_personal,
    fechanac_personal,
    paisnac_personal,
    
    lugarnac_personal,
    fecha_designacion,
    nro_designacion,
    paisdomic_personal,
    provdomic_personal,
    
    calle_personal,
    nro_personal,
    piso_personal,
    depto_personal,
    edificio_personal,
    
    localidad_personal,
    partido_personal,
    cp_personal,
    titulo,
    titulo_institucion ,
    
    anio_egreso,
    tipo_titulo,
    carr1,
    carr1_institucion,
    carr1_estado,
    
    carr1_anioegreso,
    carr1_titulo,
    carr2,
    carr2_institucion,
    carr2_estado,
    
    carr2_anioegreso,
    carr2_titulo,
    estado_personal,
   /*observaciones,*/
    DNIchecked,
    CUILchecked,
    CVchecked,
    TITchecked
    ) 
   
       VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        ? ,?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        ?, ?, ?, ? ,?, 
        ?, ?, ?, ?, ?, 
        ?, ?, ?, /*?,*/ ? ,
        ?, ?, ?)";


    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
      "ssssssissssssssisssiissssississssissssissiiii", //aca tambien borre la "S" correspondiente a "Observaciones"
      $rol_personal,
      $nombre_usuario,
      $password_usuario,
      $nombre_personal,
      $apellido_personal,
      $email_personal,
      $telefono_personal,
      $tipodoc_personal,

      $nrodni_personal,
      $nrocuil_personal,
      $sexo_personal,
      $fechanac_personal,
      $paisnac_personal,

      $lugarnac_personal,
      $fecha_designacion,
      $nro_designacion,
      $paisdomic_personal,
      $provdomic_personal,

      $calle_personal,
      $nro_personal,
      $piso_personal,
      $depto_personal,
      $edificio_personal,

      $localidad_personal,
      $partido_personal,
      $cp_personal,
      $titulo,
      $titulo_institucion,

      $anio_egreso,
      $tipo_titulo,
      $carr1,
      $carr1_institucion,
      $carr1_estado,

      $carr1_anioegreso,
      $carr1_titulo,
      $carr2,
      $carr2_institucion,
      $carr2_estado,

      $carr2_anioegreso,
      $carr2_titulo,
      $estado_personal,
      /*$observaciones,*/
      $DNIchecked,
      $CUILchecked,
      $CVchecked,
      $TITchecked
    );

    if ($stmt->execute()) {
      echo "Registro insertado correctamente";
      if ($stmt->affected_rows > 0) {

        header("Location: ingresarpersonal.php"); //redireccionar pagina
        exit();
      } else {
        echo "Error al insertar el registro";
      }
    } else {
      echo "Error al ejecutar la consulta: " . $stmt->error;
    }
    $stmt->close();
  }
  $conn->close();
  // Header sin buscador
  include 'nuevo-header.php';

  ?>

  <main>
    <!-- Contenedor principal -->
    <div class="container-fluid bg-light-subtle pt-3">
      <!-- Aside/Wardrobe/Sidebar Menu -->
      <?php
      
      ?>
      <!-- Fin de sidebar/aside -->

      <!-- Contenedor de ventana de contenido -->
      
        <div class="d-block p-3 m-2 h-100 ">
        <div class="header">
          <h2>Ingresar Nuevo Personal</h2>
          
        </div>

          <div>
            <h3 class="card-footer-text mt-2 mb-2 p-2 ">Datos personales</h3>
            
            <!--Datos personales-->
            <form class="row g-3 m-4" method="post" action="ingresarpersonal.php" enctype="multipart/form-data">
            <div class="dropdown">
            <label class="form-label text-black-50" for="nombre_personal">Seleccionar Rol Personal*</label>
            <select class="form-select form-select mb-3" name="rol_personal" id="rol_personal">
              <option value="" disabled selected>Seleccionar</option>
              <option value="director">Director</option>
              <option value="administrativo">Administrativo</option>
              <option value="docente">Docente</option>
            </select>

            <div class="row"> <!-- Creamos una fila para contener las dos columnas -->
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="nombre_usuario">Nombre Usuario</label>
                <input class="form-control" type="text" name="nombre_usuario" id="nombre_usuario" required>
              </div>

              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="password_usuario">Contrasena</label>
                <input class="form-control" type="password" name="password_usuario" id="password_usuario" required>
              </div>
            </div>

            <hr class="separador">

            </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="nombre_personal">Nombre completo*</label>
                <input class="form-control" type="text" name="nombre_personal" id="nombre_personal" required>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="apellido_personal">Apellido completo*</label>
                <input class="form-control" type="text" name="apellido_personal" id="apellido_personal" required>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="email_personal">Correo electrónico*</label>
                <input class="form-control" type="text" name="email_personal" id="email_personal"
                  placeholder="ejemplo@ejemplo.com" required>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="telefono_personal">Número de teléfono*</label>
                <input class="form-control" type="text" name="telefono_personal" id="telefono_personal"
                minlength="10" maxlength="10" 
                pattern="\d{10}" 
                title="Debe tener exactamente 10 dígitos" 
                required>

              </div>
              <div class="col-md position-relative">
                <label class="form-label text-black-50 text-nowrap" for="tipodoc_personal">Tipo de documento</label>
                <select class="form-select form-select mb-3" name="tipodoc_personal" id="tipodoc_personal">
                  <option value selected="DNI">DNI</option>
                  <option value="pas">Pasaporte</option>
                </select>
              </div>
              <div class="col-md-4  position-relative">
                <label class="form-label text-black-50" for="nrodni_personal">Número de DNI*</label>
                <input class="form-control" type="number" min="12000000" name="nrodni_personal" id="nrodni_personal"
                  required>
              </div>
              <div class="col-md-4  position-relative">
                <label class="form-label text-black-50" for="nrocuil_personal">Número de CUIL (xx-xxxxxxxx-x)*</label>
                <input class="form-control" type="text" name="nrocuil_personal" id="nrocuil_personal"  required>
              </div>
              <div class="col-md position-relative">
                <label class="form-label text-black-50 text-nowrap" for="sexo_personal">Sexo</label>
                <select class="form-select form-select mb-3" name="sexo_personal" id="sexo_personal" required>
                <option value="" disabled selected>Seleccionar</option>
                  <option value="femenino">Femenino</option>
                  <option value="masculino">Masculino</option>
                  <option value="otro">Otro</option>
                </select>
              </div>

              <div class="col-md-4  position-relative">
                <label class="form-label text-black-50" for="fechanac_personal">Fecha de nacimiento
                  (xx-xx-xxxx)*</label>
                <input class="form-control" type="date" name="fechanac_personal" id="fechanac_personal" required>

              </div>
              <div class="col-md-4  position-relative">
                <label class="form-label text-black-50" for="paisnac_personal">País de nacimiento*</label>
                <input class="form-control" type="text" name="paisnac_personal" id="paisnac_personal" value="Argentina"
                  required>
              </div>
              <div class="col-md-4  position-relative">
                <label class="form-label text-black-50" for="lugarnac_personal">Lugar de nacimiento</label>
                <input class="form-control" type="text" name="lugarnac_personal" id="lugarnac_personal">
              </div>
              <div class="col-md-5  position-relative">
                <label class="form-label text-black-50" for="fecha_designacion">Fecha de designacion
                  (xx-xx-xxxx)*</label>
                <input class="form-control" type="date" min="01-01-2020" name="fecha_designacion" id="fecha_designacion"
                  required>
              </div>
              <div class="col-md-4  position-relative">
                <label class="form-label text-black-50" for="nro_designacion">Número de designacion</label>
                <input class="form-control" type="text" name="nro_designacion" id="nro_designacion">
              </div>
              <!--Fin Datos personales-->

              <!--Domicilio-->
              <h3 class="card-footer-text mt-2 mb-2 p-2 ">Domicilio</h3>

              <div class="col-md-6  position-relative">
                <label class="form-label text-black-50" for="paisdomic_personal">País</label>
                <input class="form-control" type="text" name="paisdomic_personal" id="paisdomic_personal"
                  value="Argentina">
              </div>
              <div class="col-md-6  position-relative">
                <label class="form-label text-black-50" for="provdomic_personal">Provincia</label>
                <input class="form-control" type="text" name="provdomic_personal" id="provdomic_personal">
              </div>

              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="calle_personal">Calle</label>
                <input class="form-control" type="text" name="calle_personal" id="calle_personal">
              </div>
              <div class="col-md position-relative">
                <label class="form-label text-black-50" for="nro_personal">Número</label>
                <input class="form-control" type="text" name="nro_personal" id="nro_personal">
              </div>

              <div class="col-md position-relative">
                <label class="form-label text-black-50" for="piso_personal">Piso</label>
                <input class="form-control" type="text" name="piso_personal" id="piso_personal">
              </div>
              <div class="col-md position-relative">
                <label class="form-label text-black-50" for="depto_personal">Dpto</label>
                <input class="form-control" type="text" name="depto_personal" id="depto_personal">
              </div>
              <div class="col-md position-relative">
                <label class="form-label text-black-50" for="edificio_personal">Edificio</label>
                <input class="form-control" type="text" name="edificio_personal" id="edificio_personal">
              </div>
              <div class="col-md-5 position-relative">
                <label class="form-label text-black-50" for="localidad_personal">Localidad</label>
                <input class="form-control" type="text" name="localidad_personal" id="localidad_personal">
              </div>
              <div class="col-md-5 position-relative">
                <label class="form-label text-black-50" for="partido_personal">Partido</label>
                <input class="form-control" type="text" name="partido_personal" id="partido_personal">
              </div>
              <div class="col-md position-relative">
                <label class="form-label text-black-50" for="cp_personal">C.P.</label>
                <input class="form-control" type="text" name="cp_personal" id="cp_personal">
              </div>
              <!--Fin Domicilio-->

              <!--Titulos académicos-->
              <h3 class="card-footer-text mt-2 mb-2 p-2 ">Títulos</h3>

              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="titulo">Título de grado*</label>
                <input class="form-control" type="text" name="titulo" id="titulo" required>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="titulo_institucion">Nombre de la Institucion*</label>
                <input class="form-control" type="text" name="titulo_institucion" id="titulo_institucion" required>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="anio_egreso">Año de egreso (xxxx) *</label>
                <input class="form-control" type="text" name="anio_egreso" id="anio_egreso" required>
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="tipo_titulo">Tipo de título docente</label>
                <input class="form-control" type="text" name="tipo_titulo" id="tipo_titulo">
              </div>
              <!--Fin Titulos académicos-->

              <!--Otros recorridos académicos-->
              <h3 class="card-footer-text mt-2 mb-2 p-2 ">Otro recorrido académico</h3>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="carr1">Carrera</label>
                <input class="form-control" type="text" name="carr1" id="carr1">
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="carr1_institucion">Institucion</label>
                <input class="form-control" type="text" name="carr1_institucion" id="carr1_institucion">
              </div>
              <div class="col-md-3 position-relative">
                <label class="form-label text-black-50 text-nowrap" for="carr1_estado">Estudio finalizado</label>
                <select class="form-select form-select mb-3" name="carr1_estado" id="carr1_estado">
                  <option selected="Estado">
                  <option value="si">Si</option>
                  <option value="no">No</option>
                </select>
              </div>

              <div class="col-md-3 position-relative">
                <label class="form-label text-black-50" for="carr1_anioegreso">Año de egreso (xxxx)</label>
                <input class="form-control" type="text" name="carr1_anioegreso" id="carr1_anioegreso">
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="carr1_titulo">Titulo académico</label>
                <input class="form-control" type="text" name="carr1_titulo" id="carr1_titulo">
              </div>

              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="carr2">Carrera</label>
                <input class="form-control" type="text" name="carr2" id="carr2">
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="carr2_institucion">Institucion</label>
                <input class="form-control" type="text" name="carr2_institucion" id="carr2_institucion">
              </div>
              <div class="col-md-3 position-relative">
                <label class="form-label text-black-50 text-nowrap" for="carr2_estado">Estudio finalizado</label>
                <select class="form-select form-select mb-3" name="carr2_estado" id="carr2_estado">
                  <option selected="Estado">
                  <option value="si">Si</option>
                  <option value="no">No</option>
                </select>
              </div>

              <div class="col-md-3 position-relative">
                <label class="form-label text-black-50" for="carr2_anioegreso">Año de egreso (xxxx)</label>
                <input class="form-control" type="text" name="carr2_anioegreso" id="carr2_anioegreso">
              </div>
              <div class="col-md-6 position-relative">
                <label class="form-label text-black-50" for="carr2_titulo">Titulo académico</label>
                <input class="form-control" type="text" name="carr2_titulo" id="carr2_titulo">
              </div>
              <!--Otros recorridos académicos-->
              <!--Documentacion-->
              <h3 class="card-footer-text mt-2 mb-2 p-2 ">Documentación requerida</h3>
              <div class="col-md-4  position-relatives checkbox">

                <h6 class="text-black-50">Documentacion requerida</h6><br>

                <label> <input type="checkbox" name="check_lista[]" value="DNI" /> DNI </label><br>
                <label> <input type="checkbox" name="check_cv[]" value="CV" /> CV </label><br>
                <label> <input type="checkbox" name="check_cuil[]" value="CUIL" /> CUIL </label><br>
                <label> <input type="checkbox" name="check_tit[]" value="TIT" /> TITULO </label><br>

              </div>

              <!--Fin Documentacion-->

              <!--Situación laboral-->
              <div class="col-md-4 position-relative">
                <label class="form-label text-black-50 text-nowrap" for="estado_personal">Estado Profesor*:</label>
                <select class="form-select form-select mb-3" name="estado_personal" id="estado_personal" required>>
                  <option value="" disabled selected>Seleccionar</option>
                  <option value="titular">Titular</option>
                  <option value="provisional">Provisional</option>
                  <option value="suplente">Suplente</option>
                  <option value="licencia">Licencia</option>
                  <option value="baja">Baja</option>
                </select>

              </div>
              <div class="col-md-4 position-relative">

                <label class="form-label text-black-50" for="desde">Desde (xx/xx/xxxx)</label>
                <input class="form-control" type="text" name="desde" id="desde">

                <label class="form-label text-black-50" for="hasta">Hasta (xx/xx/xxxx)</label>
                <input class="form-control" type="text" name="hasta" id="hasta">
              </div>

              <!-- Adjuntar archivos -->
              <div class="col-md-12 checks position-relative">
                <div class="d-block mb-5 gap-2 align-content-start">
                  <h6 class="text-black-50">Ingresar archivos</h6><br>
                  <p class="text-black-50 ">Adjuntar documentación del docente</p>

                  <input type="file" class="btn btn-primary px-4 nav-bar border-0 text-wrap" name="archivo[]"
                    multiple="">
                  <br>

                </div>
              </div>
              <!--Fin Situación laboral-->

              <!--Observaciones-->
              <div class="col-md-12 position-relative">
                <label class="form-label text-black-50" for="observaciones">Observaciones</label><br>
                <textarea name="observaciones" rows="2" cols="130" id="observaciones"></textarea>
              </div>

              <!--Fin Observaciones-->

              <div class="col-md-6 offset-3 mb-5">
                <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                  <a href="index.php"><button type="button"
                      class='btn btn-primary menu-icon border-0 px-4 '>Volver</button></a>
                  <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit" value="Guardar">
                </div>
              </div>

            </form>
            <?php

            if ($_FILES) {
              $destino = $_FILES['archivoSubido']['name'];
              move_uploaded_file($_FILES['archivoSubido']['tmp_name'], $destino);

            }


            // $nombre=$_FILES['archivo']['name']; linea de mas
            // $nombre=$_FILES['archivo']['name']; linea de mas
            // $nombre=$_FILES['archivo']['name'];
// $guardado=$_FILES['archivo']['tmp_name'];
            
            // if(!file_exists('archivos')){
// mkdir('archivos',0777);
// if(!file_exists('archivos')){
// if(move_uploaded_file($guardado,'archivos/'. $nombre )){
//   echo'Archivo guardado con exito';
// }else{
            
            //     echo 'Archivo no se puede guardar';
// }
// }
// }else{
//     if(move_uploaded_file($guardado,'archivos/'. $nombre )){
//         echo'Archivo guardado con exito';
//         }else{
            
            //             echo 'Archivo no se puede guardar';
//         } 
            
            // }
            

            // foreach ($_FILES['archivo']['tmp_name'] as $key => $tmp_name) {
            //   if ($_FILES['archivo']['name'][$key]) {
            
            //     $filename = $_FILES['archivo']['name'][$key];
            //     $temporal = $_FILES['archivo']['tmp_name'][$key];
            //     $directorio = "archivos/";
            
            //   }
            //   if (!file_exists($directorio)) {
            //     mkdir($directorio, 0777);
            //   }
            //   $dir = opendir($directorio);
            //   $ruta = $directorio . "/" . $filename;
            
            //   if (move_uploaded_file($temporal, $ruta)) {
            //     echo 'Archivo guardado con exito';
            //   } else {
            
            //     echo 'Archivo no se puede guardar';
            //   }
            //   closedir($dir);
            // }
            ?>

          </div>
        </div>
      </div>
      <!-- Fin de contenido -->
    </div>
    <!-- Fin de contenedor principal -->
  </main>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      const rolPersonal = document.getElementById('rol_personal');
      const submitButton = document.querySelector('input[type="submit"]');

      // Desactiva el botón de envío al principio
      submitButton.disabled = true;

      // Función para habilitar el botón de envío si se selecciona un rol
      function checkRolSelection() {
        submitButton.disabled = rolPersonal.value === '';
      }

      // Añadir un evento para cuando cambie el valor del select
      rolPersonal.addEventListener('change', checkRolSelection);

      
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

</body>

</html>