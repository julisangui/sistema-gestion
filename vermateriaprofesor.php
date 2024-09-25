<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de Profesores a Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/styletablas.css">
</head>
<body>
<?php
// 1. Agregamos la inclusión del archivo de conexión y declaramos la variable de mensaje.
require('./conexion.php');

$msge = "";
$busqueda = "";
$result = null;
$id_materia = $_GET['id_materia'];

// 2. Verificar si se ha enviado un ID de materiaprofesor
if (isset($_GET['id_materia'])) {
    $id_materia = $_GET['id_materia'];

    // 3. Consultar el profesor y la materia asignada
    try {
        $sql = "SELECT mp.id_materiaprofesor, mp.id_personal, m.denominacion_materia
                FROM materia_profesor AS mp 
                JOIN materia AS m ON m.id_materia = mp.id_materia
                WHERE mp.id_materiaprofesor = $id_materiaprofesor";

        $result = $conn->query($sql);

        if ($result !== null && $result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $id_personal = $fila['id_personal'];

            // Obtener el nombre del personal
            $sql_nombre_personal = "SELECT nombre_personal FROM personal WHERE id_personal = $id_personal";
            $result_nombre_personal = $conn->query($sql_nombre_personal);

            if ($result_nombre_personal !== null && $result_nombre_personal->num_rows > 0) {
                $fila_nombre_personal = $result_nombre_personal->fetch_assoc();
                $nombre_personal = $fila_nombre_personal['nombre_personal'];
            } else {
                $nombre_personal = "-";
            }
        }
    } catch (Exception $e) {
        echo "Error en la consulta SQL: " . $e->getMessage();
    }

    // 5. Incluimos el archivo del encabezado.
    include "header.php";

    // 6. Cierre de la conexión
    $conn->close();
}
?>

<main>
    <!-- Contenedor principal -->
    <div class="d-flex flex-nowrap sidebar-height"> 
        <!-- Contenedor de ventana de contenido -->
        <div class="col-9 offset-3 bg-light-subtle pt-5">
            <div class="d-block p-3 m-4 h-100 ">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Profesores Asignados a Materia: <?php echo $denominacion_materia; ?></h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Listado</h2>
                </div>

                <div class="container table-responsive">
                    <form class="" method="POST" action="vermateriaprofesor.php">
                        <!-- Puedes agregar un formulario de búsqueda similar al anterior si es necesario -->
                    </form>

                    <table class="table table-bordered table-striped mt-3 space-between">
                        <thead>
                            <tr>
                                <th class="d-none">ID Materia Profesor</th>
                                <th>Profesor</th>
                                <th>Materia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($id_personal) && isset($nombre_personal) && isset($fila['denominacion_materia'])) {
                                echo "<tr>";
                                echo "<td class='d-none'>" . $id_materiaprofesor . "</td>";
                                echo "<td>" . $nombre_personal . "</td>";
                                echo "<td>" . $fila['denominacion_materia'] . "</td>";
                                echo "</tr>";
                            } else {
                                $msge = "<h5 style='color: #CA2E2E;'>No hay profesores asignados a esta materia<h5>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?=$msge?>
                </div>

                <div class="col-md-6 offset-2 mb-5">
                    <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                        <a href='tablalistadodematerias.php'><button class='btn btn-primary menu-icon border-0 px-4'>Volver</button></a>
                        <!-- Puedes agregar enlaces o botones adicionales según tus necesidades -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin de contenido -->
    </div>
    <!-- Fin de contenedor principal -->
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
