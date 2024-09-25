<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles/styletablas.css" type="text/css">
    <link rel="stylesheet" href="./styles/estudiantes.css" type="text/css">
    <title>Asignar materia</title>
</head>
<body>
    <?php
    include "variablesPath.php";
    include(rutas::$pathNuevoHeader);
    require(rutas::$pathConetion);

    $msge = "";

    // Verificar si se ha enviado un ID de estudiante de referencia
    if (isset($_GET['id_estudiante'])) {
        $id_estudiante = $_GET['id_estudiante'];
    } else {
        $msge = "<h5 style='color: #CA2E2E;'>ID de estudiante no especificado.</h5>";
        $conn->close();
        exit();
    }

    // Verificar si se ha enviado el formulario de asignación de materias
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['asignar_materia'])) {
            $id_alumno = $_POST['id_estudiante'];

            foreach ($_POST['asignar_materia'] as $id_newmateria) {
                // Verificar si la materia ya está asignada
                $sql_check = "SELECT * FROM estudiante_materia WHERE id_estudiante = ? AND id_materia = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("ii", $id_alumno, $id_newmateria);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();

                if ($result_check->num_rows > 0) {
                    $msge = "<h5 style='color: #CA2E2E;'>La materia ya está asignada.</h5>";
                } else {
                    // Verificar correlatividad
                    $sql_correlativa = "SELECT correlativa_id FROM materia_correlativa WHERE id_materia = ? AND (estado = 'pendiente' OR estado = 'reprobado')";
                    $stmt_correlativa = $conn->prepare($sql_correlativa);
                    $stmt_correlativa->bind_param("i", $id_newmateria);
                    $stmt_correlativa->execute();
                    $result_correlativa = $stmt_correlativa->get_result();

                    if ($result_correlativa->num_rows > 0) {
                        $msge = "<h5 style='color: #CA2E2E;'>No es posible asignar esta materia debido a materias correlativas pendientes o reprobadas.</h5>";
                    } else {
                        // Insertar la nueva materia si pasa todas las verificaciones
                        $sql = "INSERT INTO estudiante_materia (id_estudiante, id_materia) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $id_alumno, $id_newmateria);

                        if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                $msge = "<h5 style='color: #2ECA6A;'>Materia asignada exitosamente.<h5>";
                            } else {
                                $msge = "<h5 style='color: #CA2E2E;'>No se insertó materia alguna.</h5>";
                            }
                        } else {
                            $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . "</h5>";
                        }

                        // Cerrar la consulta para cada ejecución
                        $stmt->close();
                    }
                }

                // Cerrar la consulta de verificación
                $stmt_check->close();
            }
        } else {
            $msge = "<h5 style='color: #CA2E2E;'>Por favor selecciona al menos una materia.</h5>";
        }
        $conn->close();
    }

    // Traer las materias de la carrera que cursa el estudiante
    $sql_estudiante = "SELECT dni_estudiante, nro_legajo, nombre, apellido, plan_carrera FROM estudiantes WHERE id_estudiante = $id_estudiante";
    $result_sql = $conn->query($sql_estudiante);
    ?>

    <main>
        <div class="d-block p-3 m-4 h-100">
            <div>
                <h4 class="text-dark-subtle title">Datos del estudiante</h4>
                <?=$msge?>
            </div>
            <form class="row m-2" action="asignarmateriaestudiante.php" method="POST">                      
                <div class="col-md-8">                           
                    <table class="table table-bordered table-striped mt-3">
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
                                    echo "<tr><td colspan='4'>No se encontraron materias para este estudiante.</td></tr>";
                                }

                                $sql_materias = "SELECT id_materia FROM estudiante_materia WHERE id_estudiante = $id_estudiante";
                                $result_materias = $conn->query($sql_materias);

                                $materias_cursadas = array();
                                if ($result_materias->num_rows > 0) {
                                    while ($row = $result_materias->fetch_assoc()) {
                                        $materias_cursadas[] = $row['id_materia'];
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-5">      
                    <label class="form-label text-black-50">Asignar materia:</label>
                    <?php
                        $result_sql->data_seek(0);
                        if ($result_sql->num_rows > 0) {
                            while ($rowm = $result_sql->fetch_assoc()) {
                                echo "<div class='form-check'>";
                                echo "<input class='form-check-input' type='checkbox' name='asignar_materia[]' id='asignar_materia_" . $rowm['id_materia'] . "' value='" . $rowm['id_materia'] . "'";
                                if (in_array($rowm['id_materia'], $materias_cursadas)) {
                                    echo " checked disabled";
                                }
                                echo ">";
                                echo "<label class='form-check-label' for='asignar_materia_" . $rowm['id_materia'] . "'>";
                                echo $rowm['denominacion_materia'];
                                echo "</label>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No hay materias para asignar en esta carrera.</p>";
                        }
                    ?>
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
