<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
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

        // Procesa la asignación de materias seleccionadas
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['asignar_materia'])) {
                $materias_seleccionadas = $_POST['asignar_materia'];
                $id_carrera = $_POST['id_carrera'];
                $id_ciclo_electivo = $_POST['id_ciclo_electivo'];
                $estado_inscripcion = $_POST['estado_inscripcion'];
                $estado_materia = $_POST['estado_materia'];
                $horario_cursada = $_POST['horario_cursada'];
                $fecha_estado_materia = $_POST['fecha_estado_materia'];

                // Inserta las materias seleccionadas en la tabla cursada
                $sql_insert = "INSERT INTO cursada (id_estudiante, id_ciclo_electivo, estado_inscripcion, estado_materia, horario_cursada, id_materia, id_carrera, fecha_estado_materia) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);

                foreach ($materias_seleccionadas as $id_materia) {
                    $stmt_insert->bind_param("iissssss", $id_estudiante, $id_ciclo_electivo, $estado_inscripcion, $estado_materia, $horario_cursada, $id_materia, $id_carrera, $fecha_estado_materia);
                    if (!$stmt_insert->execute()) {
                        $mensaje = "<div class='alert alert-danger text-center'>
                                        <h4 class='alert-heading'>¡Error al asignar las materias!</h4>
                                        <p>Hubo un problema al asignar las materias: " . $stmt_insert->error . "</p>
                                    </div>";
                    }
                }

                $stmt_insert->close();
                if (empty($mensaje)) {
                    $mensaje = "<div class='alert alert-success text-center'>
                                    <h4 class='alert-heading'>¡Materias asignadas correctamente!</h4>
                                    <p>El registro se ha guardado exitosamente en la base de datos.</p>
                                </div>";
                }
            }
        }

        // Obtener ciclos electivos disponibles
        $sql_ciclos = "SELECT id_ciclo_electivo, nombre_ciclo FROM ciclo_electivo";
        $stmt_ciclos = $conn->prepare($sql_ciclos);
        $stmt_ciclos->execute();
        $result_ciclos = $stmt_ciclos->get_result();

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
    
    <main>
        <div class="container d-block p-3 m-4 h-100">
            <h4>Datos del estudiante</h4>
            <form action="asignarmateriaestudiante.php?id_estudiante=<?=$id_estudiante?>" method="POST">                       
                <div>                            
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
                </div>
                
                <div class="col-md-5">
                    <label class="form-label text-black-50">Seleccionar Ciclo electivo:</label>
                    <select id="id_ciclo_electivo" name="id_ciclo_electivo" class="form-select" required>
                        <option hidden>Seleccione un ciclo electivo</option>
                        <?php while ($row = $result_ciclos->fetch_assoc()): ?>
                            <option value="<?= $row['id_ciclo_electivo'] ?>"><?= $row['nombre_ciclo'] ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="form-label text-black-50 mt-3">Estado de Inscripción:</label>
                    <select name="estado_inscripcion" class="form-select" required>
                        <option value="completo">Completo</option>
                        <option value="en curso">En curso</option>
                        <option value="incompleto">Incompleto</option>
                    </select>

                    <label class="form-label text-black-50 mt-3">Estado de Materia:</label>
                    <select name="estado_materia" class="form-select" required>
                        <option value="aprobada">Aprobada</option>
                        <option value="reprobada">Reprobada</option>
                        <option value="cursando">Cursando</option>
                        <option value="libre">Libre</option>
                    </select>

                    <label class="form-label text-black-50 mt-3">Horario de Cursada:</label>
                    <select name="horario_cursada" class="form-select" required>
                        <option value="08:00-10:00">08:00 - 10:00</option>
                        <option value="10:00-12:00">10:00 - 12:00</option>
                        <option value="14:00-16:00">14:00 - 16:00</option>
                        <option value="16:00-18:00">16:00 - 18:00</option>
                    </select>

                    <label class="form-label text-black-50 mt-3">Fecha del Estado de Materia:</label>
                    <input type="date" name="fecha_estado_materia" class="form-control" required>
                </div>

                <div class="col-md-5">      
                    <label class="form-label text-black-50 mt-3">Seleccionar Año:</label>
                    <select id="anio_carrera" name="anio_carrera" class="form-select" onchange="cargarMaterias()">
                        <option hidden>Seleccione un año</option>
                        <option value="1">Año 1</option>
                        <option value="2">Año 2</option>
                        <option value="3">Año 3</option>
                    </select>
                    <label class="form-label text-black-50 mt-3">Asignar materia:</label>
                    <div id="materias">
                        <!-- Aquí se cargan las materias según su respectivo año -->
                    </div>
                </div>
                <input type="hidden" name="id_carrera" value="<?= $fila['plan_carrera'] ?? '' ?>"> <!-- Asegúrate de tener el id_carrera -->
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>

            <?= $mensaje ?>
        </div>
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