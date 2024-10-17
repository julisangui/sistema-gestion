<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISFT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <script>
        function logToConsole(message) {
            console.log(message);
        }
    </script>
</head>

<body>
<?php
include "variablesPath.php";
require(rutas::$pathConection);
$msge = "";

// Verificar si se ha enviado un ID de la materia
if (isset($_GET['id_materia'])) {
    $id_materia = $_GET['id_materia'];
    
    // Traigo el nombre de materia:
    $sql = "SELECT id_materia, denominacion_materia FROM materia WHERE id_materia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_materia);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowm = $result->fetch_assoc();
    } else {
        $msge = "<h5 style='color: #CA2E2E;'>Materia no encontrada.</h5>";
        exit();
    }
} else {
    $msge = "<h5 style='color: #CA2E2E;'>ID de materia no especificado.</h5>";
    exit();
}

// Traer los datos de materias disponibles
$sql2 = "SELECT id_materia, denominacion_materia FROM materia";
$result2 = $conn->query($sql2);
$sql3 = "SELECT id_tipo_aprobacion, nombre_tipo_aprobacion FROM tipo_aprobacion";
$result3 = $conn->query($sql3);

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados
    $materia_correlativa = $_POST['denominacion_materia'];
    $id_tipo_aprobacion = $_POST['tipo_aprobacion'];

    // query para validar si ya existe la correlativa
    $sql_check = "SELECT * FROM correlativas WHERE id_materia = ? AND materia_correlativa = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $id_materia, $materia_correlativa);  
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();



    if ($result_check->num_rows > 0) {
        $msge = "<h5 style='color: #CA2E2E;'>Esta materia ya está asignada como correlativa.</h5>";
    } else {
        // Insertar la correlativa en la base de datos si no existe
        $sql = "INSERT INTO correlativas (id_materia, materia_correlativa, tipo_aprobacion_correlativa) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_materia, $materia_correlativa, $id_tipo_aprobacion);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Mensaje de éxito
                $msge = "<h5 style='color: #28A745;'>Correlativa agregada correctamente.</h5>";
            } else {
                $msge = "<h5 style='color: #CA2E2E;'>No se pudo agregar la correlativa.</h5>";          
            }
        } else {
            $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . "</h5>";
        
        }
    }
    // Cerrar la consulta
    $stmt->close();
    $stmt_check->close();
}

include rutas::$pathNuevoHeader; 
?>

<!-- Código HTML para el formulario -->
<main>
    <div class="d-flex flex-nowrap sidebar-height">
        <div class="container-fluid">
            <div class="table-responsive">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Materias correlativas a la materia <?php echo isset($rowm['denominacion_materia']) ? $rowm['denominacion_materia'] : ''; ?></h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title container table-responsive">Asignar Materia</h2>
                </div>
                <div>
                    <form class="container table-responsive" action="asignarmaterias.php?id_materia=<?= $id_materia ?>" method="POST">
                        <div class="row g-3 m-4">
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="id_materia">ID Materia</label>
                                <input class="form-control" type="number" name="id_materia" id="id_materia" value="<?php echo isset($rowm['id_materia']) ? $rowm['id_materia'] : ''; ?>" disabled>
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50" for="denominacion_materia">Asignar materia correlativa</label>
                                <select class="form-select form-select mb-3" name="denominacion_materia" id="denominacion_materia" aria-label="denominacion_materia">
                                    <?php
                                    if ($result2->num_rows > 0) {
                                        while ($row2 = $result2->fetch_assoc()) {
                                            echo "<option value='" . $row2['id_materia'] . "'>" . $row2['denominacion_materia'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50" for="tipo_aprobacion">Asignar tipo de aprobación</label>
                                <select class="form-select form-select mb-3" name="tipo_aprobacion" id="tipo_aprobacion">
                                    <?php
                                    if ($result3->num_rows > 0) {
                                        while ($row3 = $result3->fetch_assoc()) {
                                            echo "<option value='" . $row3['id_tipo_aprobacion'] . "'>" . $row3['nombre_tipo_aprobacion'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                <a href="<?= rutas::$pathTablaListadoMaterias ?>" class="btn btn-primary border-0 px-4">Volver</a>
                                <input class="btn btn-primary px-4 nav-bar border-0" type="submit" value="Guardar">
                            </div>
                        </div>
                    </form>
                    <?php echo $msge; // Mensaje de error o éxito ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html
