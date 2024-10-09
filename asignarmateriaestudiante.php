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
        require("conexion.php");

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
                
                // Inserta las materias seleccionadas en la tabla estudiante_materia
                $sql_insert = "INSERT INTO estudiante_materia (id_estudiante, id_materia) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);

                foreach ($materias_seleccionadas as $id_materia) {
                    $stmt_insert->bind_param("ii", $id_estudiante, $id_materia);
                    $stmt_insert->execute();
                }

                $stmt_insert->close();
                $mensaje = "<div class='container mt-4 style= 'Margin: 0 auto';'>
                                    <div class='alert alert-success text-center' style='max-width: 95%;'>
                                        <h4 class='alert-heading'>¡Materias asignadas correctamente!</h4>
                                        <hr>
                                        <p>El registro se ha guardado exitosamente en la base de datos.</p>
                                    </div>
                                </div>";
            }
            else {
                $mensaje = "<div class='container mt-4 style= 'Margin: 0 auto';'>
                                <div class='alert alert-danger text-center' style='max-width: 95%;'>
                                    <h4 class='alert-heading'>¡Error al asignar las materias!</h4>
                                    <hr>
                                    <p>Hubo un problema al asignar las materias: " . $conn->error . "</p>
                                </div>
                            </div>";
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
            } else {
                echo '<p>No hay materias disponibles para el año seleccionado.</p>';
            }

            $stmt_materias->close();
            exit();
        }

        // Incluir el header
        include('nuevo-header.php');
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
                    <label class="form-label text-black-50">Seleccionar Año:</label>
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