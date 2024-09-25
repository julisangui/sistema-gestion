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

    // Verificar si se ha enviado un ID de carrera de referencia
    if (isset($_GET['id_carrera'])) {
        $id_carrera = $_GET['id_carrera'];
        //Traigo el nombre de carrera:
        $sql = "SELECT id_carrera, nombre_carrera, cod_carrera FROM carrera WHERE id_carrera = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_carrera);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $rowc = $result->fetch_assoc();
        } else {
            /*  echo "Carrera no encontrada."; */
            $msge = "<h5 style='color: #CA2E2E;'>Carrera no encontrada.</h5>";
            exit();
        }
    } else {
        /* echo "ID de carrera no especificado."; */
        $msge = "<h5 style='color: #CA2E2E;'>ID de carrera no especificado.</h5>";
        $stmt->close();
        exit();
    }
    /* $conn->close(); */

    //Traer los datos de materias disponibles:
    $sql2 = "SELECT id_materia, denominacion_materia FROM materia";
    $result2 = $conn->query($sql2);
    /*     echo '<script>console.log('.$result2.');</script>'; */

    // Verificar si se ha enviado el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos editados
        $id_materia = $_POST['asignar_materia'];

        // Actualizar la materia en la base de datos
        $sql = "INSERT INTO materia_carrera ( id_materia, id_carrera) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ii",
            $id_materia,
            $id_carrera

        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                /*  header("Location: tablalistadodematerias.php");
                 exit(); */
                $msge = "<h5 style='color: #2ECA6A;'>Materia asignada exitosamente.<h5>";
            } else {
                /* echo "No se insertó nada.."; */
                $msge = "<h5 style='color: #CA2E2E;'>No se insertó nada..</h5>";
            }
        } else {
            /* echo "Error al ejecutar la consulta: " . $stmt->error; */
            $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . "</h5>";
        }

        // Cerrar la consulta
        $stmt->close();
    }
    include "header.php";
    //cerrar la conexión */
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
                <div class="d-block p-3 m-4 h-100 ">
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Asignar materia a Carrera
                        <?php echo $rowc['nombre_carrera']; ?></h3>
                    <div class="m-4 d-flex align-items-center gap-3">
                        <h2 class="text-dark-subtle title">Asignar Materia</h2>
                        <?= $msge ?>
 
                        <a href='./ingresomateria.php'
                            class='btn btn-primary menu-icon border-0 px-4  ms-auto'>Crear nueva materia</a>
                            
                    </div>

                    <div>
                        <form class="row g-3 m-4" action="asignarmateriascarrera.php?id_carrera=<?= $id_carrera ?>"
                            method="POST">
                            <div class="row g-3 m-4">
                                <div class="col-md-6 position-relative">
                                    <label class="form-label text-black-50" for="cod_carrera">Código de carrera:</label>
                                    <input class="form-control" type="number" name="cod_carrera" id="cod_carrera"
                                        value="<?php echo $rowc['cod_carrera']; ?>" disabled>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <label class="form-label text-black-50" for="nombre_carrera">Nombre de
                                        Carrera:</label>
                                    <input class="form-control" type="text" name="nombre_carrera" id="nombre_carrera"
                                        value="<?php echo $rowc['nombre_carrera']; ?>" disabled>
                                </div>
                                <div class="col-md-3 position-relative">
                                    <label class="form-label text-black-50 text-nowrap" for="asignar_materia">Asignar
                                        materia:</label>
                                    <select class="form-select form-select mb-3" name="asignar_materia"
                                        id="asignar_materia" aria-label="asignar_materia">
                                        <?php
                                        if ($result2->num_rows > 0) {
                                            while ($rowm = $result2->fetch_assoc()) {
                                                echo "<option value='" . $rowm['id_materia'] . "'>" . $rowm['denominacion_materia'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 offset-2 mb-5">
                                    <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                        <a href='vercarrera.php?id_carrera=<?= $id_carrera ?>'
                                            class='btn btn-primary menu-icon border-0 px-4'>Volver</a>
                                        <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit"
                                            value="Guardar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>