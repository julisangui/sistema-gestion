<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles/styletablas.css" type="text/css">
  <link rel="stylesheet" href="styles/estudiantes.css" type="text/css">
  <title>Formulario estudiante</title>
</head>
<body>
  <?php
      
      include "variablesPath.php";
      require(rutas::$pathConection);
      include(rutas::$pathNuevoHeader);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $email = $_POST['email'];
      $telefono = $_POST['telefono'];
      $tipo_documento = $_POST['tipo_documento'];
      $dni_estudiante = $_POST['dni_estudiante'];
      $nro_legajo = $_POST['nro_legajo'];
      $genero = $_POST['genero'];
      $fecha_nacimiento = $_POST['fecha_nacimiento'];
      $pais_nacimiento = $_POST['pais_nacimiento'];
      $lugar_nacimiento = $_POST['lugar_nacimiento'];
      $familia_a_cargo = $_POST['familia_a_cargo'];
      $hijos = $_POST['hijos'];
      $trabaja = $_POST['trabaja'];
      $pais_dom = $_POST['pais_dom'];
      $provincia = $_POST['provincia'];
      $partido = $_POST['partido'];
      $localidad = $_POST['localidad'];
      $calle = $_POST['calle'];
      $numero = $_POST['numero'];
      $piso = $_POST['piso'];
      $departamento = $_POST['departamento'];
      $edificio = $_POST['edificio'];
      $codigo_postal = $_POST['codigo_postal'];
      $nombre_escuela = $_POST['nombre_escuela'];
      $titulo_secundario = $_POST['titulo_secundario'];
      $anio_de_egreso = $_POST['anio_de_egreso'];
      $titulo_certificado = $_POST['titulo_certificado'];
      $titulo_tecnico = $_POST['titulo_tecnico'];
      $titulo_hab = $_POST['titulo_hab'];
      $doc_dni = isset($_POST['doc_dni']) ? 'Sí' : 'No';
      $doc_medico = isset($_POST['doc_medico']) ? 'Sí' : 'No';
      $analitico = isset($_POST['analitico']) ? 'Sí' : 'No';
      $doc_nacimiento = isset($_POST['doc_nacimiento']) ? 'Sí' : 'No';
      $documentacion_completa = $_POST['documentacion_completa'];
      $repositorio_documentacion = $_POST['repositorio_documentacion'];
      $plan_carrera = $_POST['plan_carrera'];
      $estado_inscripcion = $_POST['estado_inscripcion'];
      $estado_estudiante = $_POST['estado_estudiante'];
      $observaciones = $_POST['observaciones'];

      $sql = "INSERT INTO estudiantes (nro_legajo, tipo_documento, dni_estudiante, nombre, apellido, email, telefono, genero, fecha_nacimiento, pais_nacimiento, lugar_nacimiento, familia_a_cargo, hijos, trabaja, pais_dom, provincia, calle, numero, piso, departamento, edificio, localidad, partido, codigo_postal, nombre_escuela, titulo_secundario, anio_de_egreso, titulo_certificado, titulo_tecnico, titulo_hab, doc_dni, doc_medico, analitico, doc_nacimiento, documentacion_completa, repositorio_documentacion, plan_carrera, estado_inscripcion, estado_estudiante, observaciones) VALUES ('$nro_legajo', '$tipo_documento', '$dni_estudiante', '$nombre', '$apellido', '$email', '$telefono', '$genero', '$fecha_nacimiento', '$pais_nacimiento', '$lugar_nacimiento', '$familia_a_cargo', '$hijos', '$trabaja', '$pais_dom', '$provincia', '$calle', '$numero', '$piso', '$departamento', '$edificio', '$localidad', '$partido', '$codigo_postal', '$nombre_escuela', '$titulo_secundario', '$anio_de_egreso', '$titulo_certificado', '$titulo_tecnico', '$titulo_hab', '$doc_dni', '$doc_medico', '$analitico', '$doc_nacimiento', '$documentacion_completa', '$repositorio_documentacion', '$plan_carrera', '$estado_inscripcion', '$estado_estudiante', '$observaciones')";
          
      // Ejecutar la consulta
      if ($conn->query($sql) === TRUE) {
        echo "
        <div class='container mt-4 style= 'Margin: 0 auto';'>
            <div class='alert alert-success text-center' style='max-width: 95%;'>
                <h4 class='alert-heading'>¡Datos actualizados correctamente!</h4>
                <p>El registro se ha actualizado exitosamente en la base de datos.</p>
                <hr>
                <a href='tablaestudiantes.php' class='btn btn-primary'>Ver lista de estudiantes</a>
            </div>
        </div>";
      } else {
          echo "
          <div class='container mt-4 style= 'Margin: 0 auto';'>
              <div class='alert alert-danger text-center' style='max-width: 95%;'>
                  <h4 class='alert-heading'>Error al actualizar el registro</h4>
                  <p>Hubo un problema al guardar los datos: " . $conn->error . "</p>
              </div>
          </div>";
      }
    }
  ?>

  <form class="d-block p-3 m-4 h-100" class="formulario" name="formulario" method="POST" enctype="multipart/form-data" autocomplete="on">

    <div class="filas">
      <div class="titulo">
        <h5 style="margin-bottom: 0px">Datos Personales</h5>
      </div>
  
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="nombre">Nombre completo *</label>
          <input type="text" class="form-control upLetra" id="nombre" name="nombre" placeholder="Nombre" required pattern="^[a-zA-Z\s]{3,}$" />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="apellido">Apellido completo *</label>
          <input type="text" class="form-control upLetra" id="apellido" name="apellido" placeholder="Apellido" required pattern="^[a-zA-Z\s]{3,}$" />
        </div>
      </div>
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="email">Email electrónico *</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="juan@ejemplo.com" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="telefono">Número de teléfono *</label>
          <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required pattern="\d{8,15}$" />
        </div>
      </div>
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="tipo_documento">Tipo documento *</label>
          <select class="form-control select" id="tipo_documento" name="tipo_documento" required>
            <option hidden>seleccionar</option>
            <option value="DNI">DNI</option>
          </select>
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="dni_estudiante">Número de documento *</label>
          <input type="number" class="form-control" id="dni_estudiante" name="dni_estudiante" placeholder="12345678" required/>
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="nro_legajo">Número de legajo *</label>
          <input type="text" class="form-control" id="nro_legajo" name="nro_legajo" required/>
        </div>
      </div>
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="genero">Género *</label>
          <select class="form-control select" id="genero" name="genero" required>
            <option hidden>seleccionar</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
          </select>
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="fecha_nacimiento">Fecha Nacimiento *</label>
          <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required/>
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="pais_nacimiento">País de nacimiento *</label>
          <input type="text" class="form-control upLetra" id="pais_nacimiento" name="pais_nacimiento" placeholder="País de nacimiento" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="lugar_nacimiento">Lugar de nacimiento *</label>
          <input type="text" class="form-control upLetra" id="lugar_nacimiento" name="lugar_nacimiento" placeholder="Lugar de nacimiento" required/>
        </div>
      </div>
    </div>
    <div class="fila">
      <div class="columna">
        <label class="form-label text-black-50" for="familia_a_cargo">Familia a cargo *</label>
        <select class="form-control select" id="familia_a_cargo" name="familia_a_cargo" required>
          <option hidden>seleccionar</option>
          <option value="Sí">Sí</option>
          <option value="No">No</option>
        </select>
      </div>
      <div class="columna">
        <label class="form-label text-black-50" for="hijos">Hijos *</label>
        <select class="form-control select" id="hijos" name="hijos" required>
          <option hidden>seleccionar</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4 o mas">4 o mas</option>
        </select>
      </div>
      <div class="columna">
        <label class="form-label text-black-50" for="trabaja">Trabaja *</label>
        <select class="form-control select" id="trabaja" name="trabaja" required>
          <option hidden>seleccionar</option>
          <option value="Sí">Sí</option>
          <option value="No">No</option>
        </select>
      </div>
    </div>
  
    <div class="filas">
      <div class="titulo">
        <h5 style="margin-bottom: 0px">Domicilio</h5>
      </div>
        
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="pais_dom">País de domicilio *</label>
          <input type="text" class="form-control upLetra" id="pais_dom" name="pais_dom" placeholder="País de domicilio" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="provincia">Provincia *</label>
          <input type="text" class="form-control upLetra" id="provincia" name="provincia" placeholder="Provincia" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="partido">Partido *</label>
          <input type="text" class="form-control upLetra" id="partido" name="partido" placeholder="Partido" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="localidad">Localidad *</label>
          <input type="text" class="form-control upLetra" id="localidad" name="localidad" placeholder="Localidad" required />
        </div>
      </div>
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="calle">Calle *</label>
          <input type="text" class="form-control upLetra" id="calle" name="calle" placeholder="Calle" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="numero">Número *</label>
          <input type="number" class="form-control" id="numero" name="numero" placeholder="Número" required pattern="\d{1,6}$" />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="piso">Piso</label>
          <input type="text" class="form-control" id="piso" name="piso" placeholder="Piso" />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="departamento">Departamento</label>
          <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" />
        </div>
      </div>
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="edificio">Edificio</label>
          <input type="text" class="form-control upLetra" id="edificio" name="edificio" placeholder="Edificio" />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="codigo_postal">Código Postal *</label>
          <input type="number" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required pattern="\d{4,8}$" />
        </div>
      </div>
    </div>
  
    <div class="filas">
      <div class="titulo">
        <h5 style="margin-bottom: 0px">Estudios Secundarios</h5>
      </div>
  
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="nombre_escuela">Nombre de la Escuela *</label>
          <input type="text" class="form-control upLetra" id="nombre_escuela" name="nombre_escuela" placeholder="Nombre de la Escuela" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="titulo_secundario">Título Secundario *</label>
          <input type="text" class="form-control" id="titulo_secundario" name="titulo_secundario" placeholder="Título Secundario" required />
        </div>
      </div>
      <div class="fila">
        <div class="columna">
          <label class="form-label text-black-50" for="anio_de_egreso">Año de Egreso *</label>
          <input type="number" class="form-control" id="anio_de_egreso" name="anio_de_egreso" placeholder="2024" required />
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="titulo_certificado">Título Certificado *</label>
          <select class="form-control select" id="titulo_certificado" name="titulo_certificado" placeholder="Título Certificado" required>
            <option hidden>seleccionar</option>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="titulo_tecnico">Título Técnico *</label>
          <select class="form-control select" id="titulo_tecnico" name="titulo_tecnico" placeholder="Título Técnico" required>
            <option hidden>seleccionar</option>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="columna">
          <label class="form-label text-black-50" for="titulo_hab">Título Habilitante *</label>
          <select class="form-control select" id="titulo_hab" name="titulo_hab" placeholder="Título Habilitante" required>
            <option hidden>seleccionar</option>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
          </select>
        </div>
      </div>
    </div>
  
    <div class="fila">
      <div class="titulo">
        <h5 style="margin-bottom: 0px">Documentacion</h5>
      </div>
    </div>
  
    <div class="fila">
      <div class="columna">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="doc_dni" name="doc_dni">
          <label class="form-check-label" for="defaultCheck1">DNI (frente y dorso)</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="doc_medico" name="doc_medico">
          <label class="form-check-label" for="defaultCheck1">Certificado medico</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="analitico" name="analitico">
          <label class="form-check-label" for="defaultCheck1">Analitico</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="doc_nacimiento" name="doc_nacimiento">
          <label class="form-check-label" for="defaultCheck1">Partida Nacimiento</label>
        </div>
      </div>
      <div class="columna">
        <label class="form-label text-black-50" for="documentacion_completa">Documentación Completa *</label>
        <select class="form-control select" id="documentacion_completa" name="documentacion_completa" required>
          <option hidden>seleccionar</option>
          <option value="Completa">Completa</option>
          <option value="Incompleta">Incompleta</option>
        </select>
      </div>
      <div class="columna">
        <label class="form-label text-black-50" for="repositorio_documentacion">Repositorio de Documentación *</label>
        <input type="text" class="form-control" id="repositorio_documentacion" name="repositorio_documentacion" placeholder="Repositorio de Documentación" required />
      </div>
    </div>
  
    <div class="filas">
      <div class="titulo">
        <h5 style="margin-bottom: 0px">Otros Datos</h5>
      </div>
        
      <div class="filas">
        <div class="fila">
          <div class="columna">
            <?php
              // Aca se traen los nombres de las carreras de la tabla carrera para insertarlos en el select "plan de carrera".
              $sql = "SELECT nombre_carrera FROM carrera";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  echo '<label class="form-label text-black-50" for="plan_carrera">Plan de Carrera *</label>';
                  echo '<select class="form-control select" id="plan_carrera" name="plan_carrera" required>';
                  echo '<option hidden>Seleccionar</option>';
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['nombre_carrera']) . '">' . htmlspecialchars($row['nombre_carrera']) . '</option>';
                        // Aca se generan las opciones (carreras) traidas desde la tabla "carrera".
                    }
                  echo '</select>';
              }
              else {
                echo "No se encontraron carreras.";
              }

              $conn->close();
            ?>
          </div>
          <div class="columna">
            <label class="form-label text-black-50" for="estado_inscripcion">Estado de Inscripción *</label>
            <select class="form-control select" id="estado_inscripcion" name="estado_inscripcion" required>
              <option hidden>seleccionar</option>
              <option value="Completo">Completo</option>
              <option value="Incompleto">Incompleto</option>
            </select>
          </div>
          <div class="columna">
            <label class="form-label text-black-50" for="estado_estudiante">Estado del Estudiante *</label>
            <select class="form-control select" id="estado_estudiante" name="estado_estudiante" required>
              <option hidden>seleccionar</option>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
        </div>
      </div>
      <div class="columna">
        <label class="form-label text-black-50" for="observaciones">Observaciones</label>
        <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" rows="3"></textarea>
      </div>
    </div>
  
    <div class="btn_form">
      <button type="reset" class="btn btn-danger">Borrar todo</button>
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
  </form>

  <style>
    .btn.btn-primary{
      background-color: #083461;
      border: none;
    }

    .btn.btn-primary:hover{
      background-color:#2ca0dd;
    }
  </style>

  <script>
    document.getElementById('repositorio_documentacion').addEventListener('input', function () {
    const input = this;
    const pattern = /^https:\/\/drive\.google\.com\/.*$/;

    if (!pattern.test(input.value)) {
      input.setCustomValidity('Por favor, ingrese un enlace válido de Google Drive (debe comenzar con "https://drive.google.com/").');
    } else {
        input.setCustomValidity('');
      }
    });
  </script>
</body>
</html>