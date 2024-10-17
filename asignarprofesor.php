<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISFT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <script src=".\scripts/funciones-generales.js"></script>
</head>

<body>
<?php
require ('variablesPath.php');
require(rutas::$pathConection);
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
   // $stmt->close();
    exit();
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_materia = $_GET['id_materia'];
    $id_personal = $_POST['id_personal'];


    // query para validar que ya no tenga la misma materia asignada
        $sql_check = "SELECT * from materia_profesor where id_personal = ? and id_materia = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ii",$id_personal, $id_materia);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $msge = "<h5 style='color: #CA2E2E;'>El profesor ya está asignado a esta materia.</h5>";
        } else {

    // Insertar un registro en la tabla materia_profesor

                 $sql = "INSERT INTO materia_profesor (id_materia, id_personal) VALUES (?, ?)";
                 $stmt = $conn->prepare($sql);
                 $stmt->bind_param("ii", $id_materia, $id_personal);

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                         $msge = "<h5 style='color: #28A745;'>Materia asignada al profesor correctamente.</h5>";
                    } else {
                                $msge = "<h5 style='color: #CA2E2E;'>No se Pudo  asignar el profesor .</h5>";
                             }
                    } else {
                                 $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . ' '. $id_materia . ' ' . $id_personal . "</h5>";
                                 $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . ' '. $id_materia . ' ' . $id_personal . "</h5>";
                            }

    // Cerrar la consulta
                    $stmt->close();
                }
                $stmt_check->close();
}
$sql3 = "SELECT id_personal, nombre_personal FROM personal";
$result3 = $conn->query($sql3);

include rutas::$pathNuevoHeader;
$conn->close();
?>

<main>
    <!-- Contenedor principal -->
    <div class="d-flex flex-nowrap sidebar-height">
        <!-- Aside/Wardrobe/Sidebar Menu -->
        <?php
      
        ?>

        <div class="container-fluid">
            <div class="table responsive">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Asignar Profesor a la materia <?php echo $rowm['denominacion_materia']; ?></h3>
                <div class="m-4 px-5">
                    <h2 class="text-dark-subtle title">Asignar Profesor</h2>
                </div>

                <div>
                    
    <form class="table-responsive mx-auto" action=<?=rutas::$pathAsignarProfesor."?id_materia=".$id_materia?> method="POST" style="width: 60%; position: relative;">
    <div class="row g-3 m-4">
        <div class="col-md-6 position-relative">
            <label class="form-label text-black-50" for="id_materia">ID Materia</label>
            <input class="form-control" type="number" name="id_materia" id="id_materia" value=<?=$id_materia?> disabled="">
        </div>
 
        <div class="col-md-3 position-relative">
            <label class="form-label text-black-50 text-nowrap" for="id_personal">Asignar profesor</label>
            <select class="form-select form-select mb-3" name="id_personal" id="id_personal" aria-label="id_personal">
                <?php
                     if ($result3->num_rows > 0) {
                        while ($rowd = $result3->fetch_assoc()) {
                        echo "<option value='" . $rowd['id_personal'] . "'>" . $rowd['nombre_personal'] . "</option>";
                            }
                        }
                ?>
            </select>
        </div>
        
        <div class="d-flex justify-content-start  w-60 mx-auto " style="bottom: 0; left: 0; padding: 15px;">
            <a href=<?=rutas::$pathTablaListadoMaterias?> class="btn btn-primary menu-icon border-0 px-4 me-5">Volver</a>
            <input class="btn btn-primary px-4 nav-bar border-0 text-wrap ms-5" type="submit" value="Guardar">
        </div>
    </div>
</form>

        <?php echo $msge; 
            ?>




                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
