<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./styles/estudiantes.css" type="text/css">
  <title>Datos de estudiante</title>
</head>
<body>
    <?php
        require("conexion.php");
        include("nuevo-header.php");

        // Función para obtener los datos del estudiante
        function get_student_data($id) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "c1602068_isft225";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM estudiantes WHERE id_estudiante='$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        }

        // Actualizar los datos del estudiante
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_estudiante = $_POST['id_estudiante'];
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
        $doc_dni = isset($_POST['doc_dni'])  ? 'Sí' : 'No';
        $doc_medico = isset($_POST['doc_medico'])  ? 'Sí' : 'No';
        $analitico = isset($_POST['analitico'])  ? 'Sí' : 'No';
        $doc_nacimiento = isset($_POST['doc_nacimiento']) ? 'Sí' : 'No';
        $documentacion_completa = $_POST['documentacion_completa'];
        $repositorio_documentacion = $_POST['repositorio_documentacion'];
        $plan_carrera = $_POST['plan_carrera'];
        $estado_inscripcion = $_POST['estado_inscripcion'];
        $estado_estudiante = $_POST['estado_estudiante'];
        $observaciones = $_POST['observaciones'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "c1602068_isft225";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "No se pudo realizar la consulta";
        }

        $conn->close();
        }

        // Obtener datos del estudiante para precargar en el formulario
        $id_estudiante = $_GET['id_estudiante'] ?? '';
        $student_data = get_student_data($id_estudiante);
    ?>

    <form class="d-block p-3 m-4 h-100" class="formulario" name="formulario" method="POST" enctype="multipart/form-data" autocomplete="off">

        <div class="filas">
            <div class="titulo">
                <h5>Datos Personales</h5>
            </div>

            <!-- Campo oculto para el ID del estudiante, sirve solo para que el sistema identifique el id del estudiante a editar y traiga y actualice sus datos -->
            <input type="hidden" id="id_estudiante" name="id_estudiante" value="<?php echo htmlspecialchars($student_data['id_estudiante'] ?? ''); ?>" />

            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="nombre">Nombre completo *</label>
                    <input type="text" class="form-control upLetra" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($student_data['nombre'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="apellido">Apellido completo *</label>
                    <input type="text" class="form-control upLetra" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo htmlspecialchars($student_data['apellido'] ?? ''); ?>" disabled/>
                </div>
            </div>
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="email">Email electrónico *</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="juan@ejemplo.com" value="<?php echo htmlspecialchars($student_data['email'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="telefono">Número de teléfono *</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo htmlspecialchars($student_data['telefono'] ?? ''); ?>" disabled/>
                </div>
            </div>
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="tipo_documento">Tipo documento *</label>
                    <select class="form-control select" id="tipo_documento" name="tipo_documento" disabled>
                        <option value="DNI" <?php echo htmlspecialchars($student_data['tipo_documento'] ?? ''); ?>>DNI</option>
                    </select>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="dni_estudiante">Número de documento *</label>
                    <input type="number" class="form-control" id="dni_estudiante" name="dni_estudiante" placeholder="12345678" value="<?php echo htmlspecialchars($student_data['dni_estudiante'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="nro_legajo">Número de legajo *</label>
                    <input type="text" class="form-control" id="nro_legajo" name="nro_legajo" value="<?php echo htmlspecialchars($student_data['nro_legajo'] ?? ''); ?>" disabled/>
                </div>
            </div>
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="genero">Género *</label>
                    <select class="form-control select" id="genero" name="genero" disabled>
                        <option value="Masculino" <?php echo (htmlspecialchars($student_data['genero'] ?? '') === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?php echo (htmlspecialchars($student_data['genero'] ?? '') === 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Otro" <?php echo (htmlspecialchars($student_data['genero'] ?? '') === 'Otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="fecha_nacimiento">Fecha Nacimiento *</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($student_data['fecha_nacimiento'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="pais_nacimiento">País de nacimiento *</label>
                    <input type="text" class="form-control upLetra" id="pais_nacimiento" name="pais_nacimiento" placeholder="País de nacimiento" value="<?php echo htmlspecialchars($student_data['pais_nacimiento'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="lugar_nacimiento">Lugar de nacimiento *</label>
                    <input type="text" class="form-control upLetra" id="lugar_nacimiento" name="lugar_nacimiento" placeholder="Lugar de nacimiento" value="<?php echo htmlspecialchars($student_data['lugar_nacimiento'] ?? ''); ?>" disabled/>
                </div>
            </div>
        </div>
        <div class="fila">
            <div class="columna">
                <label class="form-label text-black-50" for="familia_a_cargo">Familia a cargo *</label>
                <select class="form-control select" id="familia_a_cargo" name="familia_a_cargo" disabled>
                    <option value="Sí" <?php echo (htmlspecialchars($student_data['familia_a_cargo'] ?? '') === 'Sí') ? 'selected' : ''; ?>>Sí</option>
                    <option value="No" <?php echo (htmlspecialchars($student_data['familia_a_cargo'] ?? '') === 'No') ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <div class="columna">
                <label class="form-label text-black-50" for="hijos">Hijos *</label>
                <select class="form-control select" id="hijos" name="hijos" disabled>
                    <option value="0" <?php echo (htmlspecialchars($student_data['hijos'] ?? '') === '0') ? 'selected' : ''; ?>>0</option>
                    <option value="1" <?php echo (htmlspecialchars($student_data['hijos'] ?? '') === '1') ? 'selected' : ''; ?>>1</option>
                    <option value="2" <?php echo (htmlspecialchars($student_data['hijos'] ?? '') === '2') ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo (htmlspecialchars($student_data['hijos'] ?? '') === '3') ? 'selected' : ''; ?>>3</option>
                    <option value="4 o mas" <?php echo (htmlspecialchars($student_data['hijos'] ?? '') === '4 o mas') ? 'selected' : ''; ?>>4 o mas</option>
                </select>
            </div>
            <div class="columna">
                <label class="form-label text-black-50" for="trabaja">Trabaja *</label>
                <select class="form-control select" id="trabaja" name="trabaja" disabled>
                    <option value="Sí" <?php echo (htmlspecialchars($student_data['trabaja'] ?? '') === 'Sí') ? 'selected' : ''; ?>>Sí</option>
                    <option value="No" <?php echo (htmlspecialchars($student_data['trabaja'] ?? '') === 'No') ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
        </div>

        <div class="filas">
            <div class="titulo">
                <h5>Domicilio</h5>
            </div>
        
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="pais_dom">País de domicilio *</label>
                    <input type="text" class="form-control upLetra" id="pais_dom" name="pais_dom" placeholder="País de domicilio" value="<?php echo htmlspecialchars($student_data['pais_dom'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="provincia">Provincia *</label>
                    <input type="text" class="form-control upLetra" id="provincia" name="provincia" placeholder="Provincia" value="<?php echo htmlspecialchars($student_data['provincia'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="partido">Partido *</label>
                    <input type="text" class="form-control upLetra" id="partido" name="partido" placeholder="Partido" value="<?php echo htmlspecialchars($student_data['partido'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="localidad">Localidad *</label>
                    <input type="text" class="form-control upLetra" id="localidad" name="localidad" placeholder="Localidad" value="<?php echo htmlspecialchars($student_data['localidad'] ?? ''); ?>" disabled>
                </div>
            </div>
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="calle">Calle *</label>
                    <input type="text" class="form-control upLetra" id="calle" name="calle" placeholder="Calle" value="<?php echo htmlspecialchars($student_data['calle'] ?? ''); ?>" disabled>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="numero">Número *</label>
                    <input type="number" class="form-control" id="numero" name="numero" placeholder="Número" value="<?php echo htmlspecialchars($student_data['numero'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="piso">Piso</label>
                    <input type="text" class="form-control" id="piso" name="piso" placeholder="Piso" value="<?php echo htmlspecialchars($student_data['piso'] ?? ''); ?>" disabled>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" value="<?php echo htmlspecialchars($student_data['departamento'] ?? ''); ?>" disabled/>
                </div>
            </div>
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="edificio">Edificio</label>
                    <input type="text" class="form-control upLetra" id="edificio" name="edificio" placeholder="Edificio" value="<?php echo htmlspecialchars($student_data['edificio'] ?? ''); ?>" disabled>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="codigo_postal">Código Postal *</label>
                    <input type="number" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" value="<?php echo htmlspecialchars($student_data['codigo_postal'] ?? ''); ?>" disabled/>
                </div>
            </div>
        </div>

        <div class="filas">
            <div class="titulo">
                <h5>Estudios Secundarios</h5>
            </div>

            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="nombre_escuela">Nombre de la Escuela *</label>
                    <input type="text" class="form-control upLetra" id="nombre_escuela" name="nombre_escuela" placeholder="Nombre de la Escuela" value="<?php echo htmlspecialchars($student_data['nombre_escuela'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="titulo_secundario">Título Secundario *</label>
                    <input type="text" class="form-control" id="titulo_secundario" name="titulo_secundario" placeholder="Título Secundario" value="<?php echo htmlspecialchars($student_data['titulo_secundario'] ?? ''); ?>" disabled/>
                </div>
            </div>
            <div class="fila">
                <div class="columna">
                    <label class="form-label text-black-50" for="anio_de_egreso">Año de Egreso *</label>
                    <input type="number" class="form-control" id="anio_de_egreso" name="anio_de_egreso" value="<?php echo htmlspecialchars($student_data['anio_de_egreso'] ?? ''); ?>" disabled/>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="titulo_certificado">Título Certificado *</label>
                    <select class="form-control select" id="titulo_certificado" name="titulo_certificado" placeholder="Título Certificado" disabled>
                        <option value="Sí" <?php echo (htmlspecialchars($student_data['titulo_certificado'] ?? '') === 'Sí') ? 'selected' : ''; ?>>Sí</option>
                        <option value="No" <?php echo (htmlspecialchars($student_data['titulo_certificado'] ?? '') === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="titulo_tecnico">Título Técnico *</label>
                    <select class="form-control select" id="titulo_tecnico" name="titulo_tecnico" placeholder="Título Técnico" disabled>
                        <option value="Sí" <?php echo (htmlspecialchars($student_data['titulo_tecnico'] ?? '') === 'Sí') ? 'selected' : ''; ?>>Sí</option>
                        <option value="No" <?php echo (htmlspecialchars($student_data['titulo_tecnico'] ?? '') === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50" for="titulo_hab">Título Habilitante *</label>
                    <select class="form-control select" id="titulo_hab" name="titulo_hab" placeholder="Título Habilitante" disabled>
                        <option value="Sí" <?php echo (htmlspecialchars($student_data['titulo_hab'] ?? '') === 'Sí') ? 'selected' : ''; ?>>Sí</option>
                        <option value="No" <?php echo (htmlspecialchars($student_data['titulo_hab'] ?? '') === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="fila">
            <div class="titulo">
                <h5>Documentacion</h5>
            </div>
        </div>

        <div class="fila">
            <div class="columna">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="doc_dni" name="doc_dni" <?php if (isset($student_data['doc_dni']) && $student_data['doc_dni'] == 'Sí') echo 'checked'; ?> disabled>
                    <label class="form-check-label" for="defaultCheck1">DNI (frente y dorso)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="doc_medico" name="doc_medico" <?php if (isset($student_data['doc_medico']) && $student_data['doc_medico'] == 'Sí') echo 'checked'; ?> disabled/>
                    <label class="form-check-label" for="defaultCheck1">Certificado medico</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="analitico" name="analitico" <?php if (isset($student_data['analitico']) && $student_data['analitico'] == 'Sí') echo 'checked'; ?> disabled/>
                    <label class="form-check-label" for="defaultCheck1">Analitico</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="doc_nacimiento" name="doc_nacimiento" <?php if (isset($student_data['doc_nacimiento']) && $student_data['doc_nacimiento'] == 'Sí') echo 'checked'; ?> disabled/>
                    <label class="form-check-label" for="defaultCheck1">Partida Nacimiento</label>
                </div>
            </div>
            <div class="columna">
                <label class="form-label text-black-50" for="documentacion_completa">Documentación Completa *</label>
                <select class="form-control select" id="documentacion_completa" name="documentacion_completa" disabled>
                    <option value="Completa" <?php echo (htmlspecialchars($student_data['documentacion_completa'] ?? '') === 'Completa') ? 'selected' : ''; ?>>Completa</option>
                    <option value="Incompleta" <?php echo (htmlspecialchars($student_data['documentacion_completa'] ?? '') === 'Incompleta') ? 'selected' : ''; ?>>Incompleta</option>
                </select>
            </div>
            <div class="columna">
                <label class="form-label text-black-50" for="repositorio_documentacion">Repositorio de Documentación *</label>
                <input type="text" class="form-control" id="repositorio_documentacion" name="repositorio_documentacion" placeholder="Repositorio de Documentación" value="<?php echo htmlspecialchars($student_data['repositorio_documentacion'] ?? ''); ?>" disabled/>
            </div>
        </div>

        <div class="filas">
            <div class="titulo">
                <h5>Otros Datos</h5>
            </div>
            
            <div class="filas">
                <div class="fila">
                    <div class="columna">
                        <?php
                            // Consulta para obtener las carreras
                            $sql = "SELECT nombre_carrera FROM carrera";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo '<label class="form-label text-black-50" for="plan_carrera">Plan de Carrera *</label>';
                                echo '<select class="form-control select" id="plan_carrera" name="plan_carrera" disabled>';
                                echo '<option hidden>Seleccionar</option>';
                                    // Iteramos sobre los resultados y generamos las opciones
                                    while($row = $result->fetch_assoc()) {
                                        $nombre_carrera = htmlspecialchars($row['nombre_carrera']);
                                            
                                        // Si el valor coincide con la carrera seleccionada en $student_data, se marca como seleccionada
                                        $selected = (isset($student_data['plan_carrera']) && $student_data['plan_carrera'] == $nombre_carrera) ? 'selected' : '';
                                        echo '<option value="' . $nombre_carrera . '" ' . $selected . '>' . $nombre_carrera . '</option>';
                                    }
                                echo '</select>';
                            }
                            else {
                                echo "No se encontraron carreras.";
                            }
                        ?>
                    </div>
                    <div class="columna">
                        <label class="form-label text-black-50" for="estado_inscripcion">Estado de Inscripción *</label>
                        <select class="form-control select" id="estado_inscripcion" name="estado_inscripcion" disabled>
                            <option value="Completo" <?php echo (htmlspecialchars($student_data['estado_inscripcion'] ?? '') === 'Completo') ? 'selected' : ''; ?>>Completo</option>
                            <option value="Incompleto" <?php echo (htmlspecialchars($student_data['estado_inscripcion'] ?? '') === 'Incompleto') ? 'selected' : ''; ?>>Incompleto</option>
                        </select>
                    </div>
                    <div class="columna">
                        <label class="form-label text-black-50" for="estado_estudiante">Estado del Estudiante *</label>
                        <select class="form-control select" id="estado_estudiante" name="estado_estudiante" disabled>
                            <option value="Activo" <?php echo (htmlspecialchars($student_data['estado_estudiante'] ?? '') === 'Activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?php echo (htmlspecialchars($student_data['estado_estudiante'] ?? '') === 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="columna">
                <label class="form-label text-black-50" for="observaciones">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" rows="3" disabled><?php echo htmlspecialchars($student_data['observaciones'] ?? ''); ?></textarea>
            </div>
        </div>
        <div class="btn-form">
          <a href="tablaestudiantes.php" class="btn btn-secondary">Volver</a>
          <a href="formeditarestudiantes.php?id_estudiante=<?php echo htmlspecialchars($student_data['id_estudiante'] ?? ''); ?>" class="btn btn-primary">Editar</a>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9iIA5g08fN1uMzKjRsjYAmk/JEd1a2T2OXFik7kA9B43a8b2AT" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-QUT2k+S5b0EXG1g9U5B2rNwM8D0myO1yRzXp5zqFvKeMTff3S5uDDUqFMRh06jJr" crossorigin="anonymous"></script>
</body>
</html>