<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles/estudiantes.css" type="text/css">
    <title>Asignar materia</title>
</head>
<body>
    <?php
        include "variablesPath.php";
        require(rutas::$pathConetion);

        // Verifica si se ha pasado el ID de estudiante
        if (isset($_GET['id_estudiante'])) {
            $id_estudiante = $_GET['id_estudiante'];
        } else {
            echo "<h5 style='color: #CA2E2E;'>ID de estudiante no especificado.</h5>";
            exit();
        }

        $mensaje = '';

        // Procesa la asignación de materias al estudiante
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['asignar_materia'])) {
                // Recibe las materias seleccionadas como array
                $materias_seleccionadas = $_POST['asignar_materia'];
                $id_carrera = $_POST['id_carrera'];
                $id_ciclo_electivo = $_POST['id_ciclo_electivo'];
                $estado_inscripcion = $_POST['estado_inscripcion'];
                $estado_materia = $_POST['estado_materia'];
                $horario_cursada = $_POST['horario_cursada'];
                $fecha_estado_materia = $_POST['fecha_estado_materia'];

                // Inserta las materias seleccionadas en la tabla cursada

                $sql_insert = "INSERT INTO cursada (id_estudiante, id_ciclo_electivo, estado_inscripcion, estado_materia, horario_cursada, id_materia, id_carrera, fecha_estado_materia) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt_insert = $conn->prepare($sql_insert);

                // Procesa cada materia seleccionada
                foreach ($materias_seleccionadas as $id_materia) {

                    $id_materia = (int)$id_materia; // Asegúrate de que es un entero
                    $stmt_insert->bind_param("iissssss", $id_estudiante, $id_ciclo_electivo, $estado_inscripcion, $estado_materia, $horario_cursada, $id_materia, $id_carrera, $fecha_estado_materia);
                    
                    // Ejecuta la consulta
                    if (!$stmt_insert->execute()) {
                        $mensaje = "<div class='alert alert-danger text-center' style='widht: 100%'>
                                        <h4 class='alert-heading'>¡Error al asignar las materias!</h4>
                                        <p>Hubo un problema al asignar las materias: " . $stmt_insert->error . "</p>
                                    </div>";
                    }
                }

                $stmt_insert->close();
                if (empty($mensaje)) {

                    $mensaje = "<div class='container mt-4 style= 'Margin: 0 auto';'>
                                    <div class='alert alert-success text-center' style='max-width: 100%;'>
                                        <h4 class='alert-heading'>¡Materias asignadas correctamente!</h4>
                                        <p>El registro se ha ingresado exitosamente en la base de datos.</p>
                                        <hr>
                                        <a href='tablaestudiantes.php' class='btn btn-primary'>Volver a la lista de estudiantes</a>
                                    </div>
                                </div>";
                }
            }
        }

        // A través del select se traen las materias del año seleccionado
        if (isset($_GET['anio_carrera'])) {
            $anio_carrera = $_GET['anio_carrera'];
            
            // Consulta para obtener las materias según el año
            $sql_materias = "SELECT id_materia, denominacion_materia FROM materia WHERE anio_carrera = ?";
            $stmt_materias = $conn->prepare($sql_materias);
            $stmt_materias->bind_param("i", $anio_carrera);
            $stmt_materias->execute();
            $result_materias = $stmt_materias->get_result();
            
            if ($result_materias->num_rows > 0) {
                while ($rowm = $result_materias->fetch_assoc()) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="asignar_materia[]" value="' . $rowm['id_materia'] . '" id="materia' . $rowm['id_materia'] . '">';
                    echo '<label class="form-check-label" for="materia' . $rowm['id_materia'] . '">' . $rowm['denominacion_materia'] . '</label>';
                    echo '</div>';

                }
            }
            
            $stmt_materias->close();
            exit();
        }

        // Obtener ciclos electivos disponibles
        $sql_ciclos = "SELECT id_ciclo_electivo, nombre_ciclo FROM ciclo_electivo";
        $stmt_ciclos = $conn->prepare($sql_ciclos);
        $stmt_ciclos->execute();
        $result_ciclos = $stmt_ciclos->get_result();

        // Trae los datos del estudiante
        $sql_estudiante = "SELECT dni_estudiante, nro_legajo, nombre, apellido, plan_carrera FROM estudiantes WHERE id_estudiante = ?";
        $stmt_estudiante = $conn->prepare($sql_estudiante);
        $stmt_estudiante->bind_param("i", $id_estudiante);
        $stmt_estudiante->execute();
        $result_sql = $stmt_estudiante->get_result();

        if ($result_sql->num_rows > 0) {
            $fila = $result_sql->fetch_assoc();     

            // Obtener el id_carrera segun el plan_carrera
            $sql_id_carrera = "SELECT id_carrera FROM carrera WHERE nombre_carrera = ?";
            $stmt_id_carrera = $conn->prepare($sql_id_carrera);
            $stmt_id_carrera->bind_param("s", $fila['plan_carrera']);
            $stmt_id_carrera->execute();
            $result_id_carrera = $stmt_id_carrera->get_result();

            if ($result_id_carrera->num_rows > 0) {
                $fila_id_carrera = $result_id_carrera->fetch_assoc();
                $id_carrera = $fila_id_carrera['id_carrera'];
            } else {
                echo "<h5 style='color: #CA2E2E;'>ID de carrera no encontrado.</h5>";
                exit();
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron datos para este estudiante.</td></tr>";
        }

        include(rutas::$pathNuevoHeader);
    ?>

    <style>
        .table {
            width: 100%;
            margin: 0 auto;
            margin-bottom: 15px;
            text-align: center;
        }

        th, td {
            text-align: center;
        }

        .btn.btn-primary {
            margin-top: 15px;
            background-color: #083461;
            border: none;
        }

        .btn.btn-primary:hover {
            background-color: #2ca0dd;
        }
    </style>

    <div>
        <?= $mensaje ?>
        <form class="d-block p-3 m-4 h-100" class="formulario" name="formulario" method="POST" action="asignarmateriaestudiante.php?id_estudiante=<?=$id_estudiante?>" method="POST">                       
            <h4 class="ps-0">Datos del estudiante</h4>             
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <input type="hidden" name="id_estudiante" value="<?=$id_estudiante?>">
                    <th>DNI</th>
                    <th>Nro. Legajo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Carrera</th>
                    </tr>
                </thead>
                <tbody>                    
                    
                    <?php
                    // Trae los datos del estudiante                                           
                    $sql_estudiante = "SELECT dni_estudiante, nro_legajo, nombre, apellido, plan_carrera FROM estudiantes WHERE id_estudiante = ?";
                    $stmt_estudiante = $conn->prepare($sql_estudiante);
                    $stmt_estudiante->bind_param("i", $id_estudiante);
                    $stmt_estudiante->execute();
                    $result_sql = $stmt_estudiante->get_result();
    
                    if ($result_sql->num_rows > 0) {
                            $fila = $result_sql->fetch_assoc();     
                            echo "<tr>";
                            echo "<td>" . $fila['dni_estudiante'] . "</td>";
                            echo "<td>" . $fila['nro_legajo'] . "</td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>" . $fila['apellido'] . "</td>";
                            echo "<td>" . $fila['plan_carrera'] . "</td>";
                            echo "</tr>";  
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron datos para este estudiante.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
            <div class="filas">
                <div class="fila">
                    <div class="columna">
                        <label class="form-label text-black-50 mt-3">Seleccionar Ciclo electivo:</label>
                        <select id="id_ciclo_electivo" name="id_ciclo_electivo" class="form-select" required>
                            <option hidden>Seleccione un ciclo electivo</option>
                            <?php while ($row = $result_ciclos->fetch_assoc()): ?>
                            <option value="<?= $row['id_ciclo_electivo'] ?>"><?= $row['nombre_ciclo'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="columna">
                        <label class="form-label text-black-50 mt-3">Estado de Inscripción:</label>
                        <select name="estado_inscripcion" class="form-select" required>
                            <option hidden>Seleccione un estado de la inscripción</option>
                            <option value="completo">Completo</option>
                            <option value="en curso">En curso</option>
                            <option value="incompleto">Incompleto</option>
                        </select>
                    </div>
                    <div class="columna">
                        <label class="form-label text-black-50 mt-3">Estado de Materia:</label>
                        <select name="estado_materia" class="form-select" required>
                            <option hidden>Seleccione un estado</option>
                            <option value="aprobada">Aprobada</option>
                            <option value="reprobada">Reprobada</option>
                            <option value="cursando">Cursando</option>
                            <option value="libre">Libre</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="filas">
                <div class="fila">
                    <div class="columna">
                        <label class="form-label text-black-50 mt-3">Horario de Cursada:</label>
                        <select name="horario_cursada" class="form-select" required>
                            <option hidden>Seleccione un horario</option>
                            <option value="08:00-10:00">08:00 - 10:00</option>
                            <option value="10:00-12:00">10:00 - 12:00</option>
                            <option value="14:00-16:00">14:00 - 16:00</option>
                            <option value="16:00-18:00">16:00 - 18:00</option>
                        </select>
                    </div>
                    <div class="columna">
                        <label class="form-label text-black-50 mt-3">Fecha del Estado de Materia:</label>
                        <input type="date" name="fecha_estado_materia" class="form-control" required>
                    </div>
                </div>
                <div class="columna">
                    <label class="form-label text-black-50 mt-3">Seleccionar Año:</label>
                    <select id="anio_carrera" name="anio_carrera" class="form-select" onchange="cargarMaterias()">
                        <option hidden>Seleccione un año</option>
                        <option value="1">Año 1</option>
                        <option value="2">Año 2</option>
                        <option value="3">Año 3</option>
                    </select>
                </div>
            
            <div class="columna">
                <label class="form-label text-black-50 mt-3">Asignar materia:</label>
                <div id="materias">
                    <!-- Aca se cargan las materias según su respectivo año -->
                </div>
            </div>

            <!-- Campo oculto para el ID de carrera -->
            <input type="hidden" name="id_carrera" value="<?= $id_carrera ?>">
            
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

        </form>
    </main>
    <script>
        function cargarMaterias() {
            const anio_carrera = document.getElementById('anio_carrera').value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `asignarmateriaestudiante.php?anio_carrera=${anio_carrera}&id_estudiante=<?=$id_estudiante?>`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('materias').innerHTML = xhr.responseText;
                } else {
                    console.error('Error al cargar las materias: ' + xhr.status);
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>