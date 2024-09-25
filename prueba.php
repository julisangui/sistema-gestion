<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISFT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
<?php
require('./conexion.php');
$msge = "";

// Verificar si se ha enviado un ID de la materia
if (isset($_GET['id_materia'])) {
    $id_materia = $_GET['id_materia'];

    // Traigo el nombre de la materia:
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
    $stmt->close();
    exit();
}

// Traer los datos de materias disponibles:
$sql2 = "SELECT id_materia, denominacion_materia FROM materia";
$result2 = $conn->query($sql2);

$sql3 = "SELECT id_personal, nombre_personal FROM personal";
$result3 = $conn->query($sql3);

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_materia = $_POST['id_materia'];
    $id_personal = $_POST['id_personal'];

    // Validar los datos (debes agregar validaciones adecuadas)

    // Insertar un registro en la tabla materia_profesor
    $sql = "INSERT INTO materia_profesor (id_materia, id_personal) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_materia, $id_personal);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $msge = "<h5 style='color: #28A745;'>Materia asignada al profesor correctamente.</h5>";
        } else {
            $msge = "<h5 style='color: #CA2E2E;'>No se insertó nada.</h5>";
        }
    } else {
        $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . "</h5>";
    }

    // Cerrar la consulta
    $stmt->close();
}
include "header.php";
$conn->close();
?>

<main>
    <!-- Contenedor principal -->
    <div class="d-flex flex-nowrap sidebar-height">
        <!-- Aside/Wardrobe/Sidebar Menu -->
        <?php
        include "sidebar.php";
        ?>

        <div class="col-9 offset-3 bg-light-subtle pt-5">
            <div class="d-block p-3 m-4 h-100">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Asignar Profesor a la materia <?php echo $rowm['denominacion_materia']; ?></h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Asignar Profesor</h2>
                </div>

                <div>
                    <form class="row g-3 m-4" action="prueba.php?id_materia=<?=$id_materia?>" method="POST">
                        <div class="row g-3 m-4">
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="id_materia">ID Materia</label>
                                <input class="form-control" type="number" name="id_materia" id="id_materia" value="<?php echo $rowm['id_materia']; ?>" disabled>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="denominacion_materia">Materia</label>
                                <select class="form-select form-select mb-3" name="id_materia" id="id_materia" aria-label="id_materia">
                                    <?php
                                    if ($result2->num_rows > 0) {
                                        while ($rowm2 = $result2->fetch_assoc()) {
                                            echo "<option value='" . $rowm2['id_materia'] . "'>" . $rowm2['denominacion_materia'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="id_personal">Asignar profesor</label>
                                <select class="form-select form-select mb-3" name="id_personal" id="id_personal" aria-label="id_personalr">
                                    <?php
                                    if ($result3->num_rows > 0) {
                                        while ($rowd = $result3->fetch_assoc()) {
                                            echo "<option value='" . $rowd['id_personal'] . "'>" . $rowd['nombre_personal'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 offset-2 mb-5">
                                <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                    <a href='vermateria.php?id_materia=<?=$id_materia?>' class='btn btn-primary menu-icon border-0 px-4'>Volver</a>
                                    <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit" value="Guardar">
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php echo $msge; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
