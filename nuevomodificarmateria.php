<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <?php

    require("variablesPath.php");
    require(rutas::$pathConection);
    $msge = "";
    ?>
    <?php
    // Obtener el ID del registro a editar
    $id_materia = $_GET['id_materia'];

    if ($id_materia === null || !is_numeric($id_materia)) {

        header("Location:" . rutas::$pathTablaListadodeMaterias);
        // Exit para detener la ejecución
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los valores de los campos del formulario
        $new_cod_num = $_POST['cod_num'];
        $new_cod_alpha = $_POST['cod_alpha'];
        $new_denominacion_materia = $_POST['denominacion_materia'];
        $new_tipo_aprobacion = $_POST['tipo_aprobacion'];
        $new_nota_min_aprobacion = $_POST['nota_min_aprobacion'];
        $new_correlatividades = $_POST['correlatividades'];
        $new_estado_materia = $_POST['estado_materia'];
        $new_campo_formativo = $_POST['campo_formativo'];
        $new_carga_horaria_materia = $_POST['carga_horaria_materia'];
        $new_id_carrera = $_POST['id_carrera'];
        $new_anio_carrera = $_POST['anio_carrera'];


        // Consulta SQL con parámetros
        $sql = "UPDATE materia SET 
                    cod_num = ?, 
                    cod_alpha = ?, 
                    denominacion_materia = ?, 
                    tipo_aprobacion = ?, 
                    nota_min_aprobacion = ?, 
                    correlatividades = ?, 
                    estado_materia = ?,
                    campo_formativo = ?,
                    carga_horaria_materia = ?,
                    id_carrera = ?,
                    anio_carrera = ?
                WHERE id_materia = ?";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param(
            "isssisssiiii",
            $new_cod_num,
            $new_cod_alpha,
            $new_denominacion_materia,
            $new_tipo_aprobacion,
            $new_nota_min_aprobacion,
            $new_correlatividades,
            $new_estado_materia,
            $new_campo_formativo,
            $new_carga_horaria_materia,
            $new_id_carrera,
            $new_anio_carrera,
            $id_materia
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
                exit();
            } else {
                $msge = "<h5 style='color: #CA2E2E;'>No se realizó ninguna actualización.<h5>";
            }
        } else {
            $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . "<h5>";
        }

        // Cerrar la consulta
        $stmt->close();
    }

    $conn->close();

    // Obtener los datos del registro actual
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $sql = "SELECT  m.*, c.nombre_carrera  FROM materia m
    inner join carrera c 
    on m.id_carrera = c.id_carrera 
    WHERE id_materia=$id_materia";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    // busca las carreras disponibles 
    $sql_carreras = "SELECT id_carrera, nombre_carrera FROM carrera";
    $result_carreras = $conn->query($sql_carreras);

    // Cerrar la conexión
    $conn->close();
    include rutas::$pathNuevoHeader;
    ?>
    <main>
        <!-- Contenedor principal -->
        <div class="d-flex flex-nowrap sidebar-height">
            <!-- Aside/Wardrobe/Sidebar Menu -->
            <?php

            ?>

            <!-- Contenedor de ventana de contenido -->
            <div class="container fluid">
                <div class="table responsive">
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Materias</h3>
                    <div class="m-4">
                        <h2 class="text-dark-subtle title">Editar Materia</h2>
                        <?= $msge ?>
 
                    </div>
                    
                    <div>

                        <form class="row g-3 m-4" action="nuevomodificarmateria.php?id_materia=<?= $id_materia ?>"
                            method="POST">

                            <div class="col-md-4 position-relative">
                                <input class="form-control" type="hidden" name="id_materia"
                                    value="<?= $row['id_materia'] ?>">

                                <label class="form-label text-black-50" for="anio_carrera">Año Materia:</label>
                                <input class="form-control" type="text" name="anio_carrera" id="anio_carrera"
                                    value="<?= $row['anio_carrera'] ?>">
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="cod_num">Código numerico*:</label>
                                <input class="form-control" type="text" name="cod_num" id="cod_num"
                                    value="<?= $row['cod_num'] ?>">
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="cod_alpha">Código alfabético*:</label>
                                <input class="form-control" type="text" name="cod_alpha" id="cod_alpha"
                                    value="<?= $row['cod_alpha'] ?>">
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50"
                                    for="denominacion_materia">Denominación*:</label>
                                <input class="form-control" type="text" name="denominacion_materia"
                                    id="denominacion_materia" value="<?= $row['denominacion_materia'] ?>">
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="tipo_aprobacion">Tipo de aprobación</label>
                                <select class="form-select form-select mb-3" name="tipo_aprobacion" id="tipo_aprobacion"
                                    aria-label="tipo_aprobacion">
                                    <option selected value="Promoción">Promoción</option>
                                    <option value="Final">Final</option>
                                </select>
                            </div>


                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="nota_min_aprobacion">Mínimo de
                                    aprobación*:</label>
                                <select class="form-select form-select mb-3" name="nota_min_aprobacion"
                                    id="nota_min_aprobacion" aria-label="nota_min_aprobacion">
                                    <?php
                                    $selectedNota = $row['nota_min_aprobacion'];
                                    // Usa un bucle for para generar las opciones de 1 a 10
                                    for ($i = 1; $i <= 10; $i++) {
                                        // Verifica si este valor debe estar seleccionado
                                        $selected = ($i == $selectedNota) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="correlatividades">Tiene
                                    Correlativas</label>
                                <select class="form-select form-select mb-3" name="correlatividades"
                                    id="correlatividades" aria-label="select_correlatividades">
                                    <option value="Si" <?= $row['correlatividades'] === 'Si' ? 'selected' : '' ?>>Si
                                    </option>
                                    <option value="No" <?= $row['correlatividades'] === 'No' ? 'selected' : '' ?>>No
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="estado_materia">Estado
                                    materia*:</label>
                                <select class="form-select form-select mb-3" name="estado_materia" id="estado_materia"
                                    aria-label="select estado_materia" value="<?= $row['estado_materia'] ?>">
                                    <option value="1" <?php if ($row['estado_materia'] == '1')
                                        echo 'selected'; ?>>Activo
                                    </option>
                                    <option value="0" <?php if ($row['estado_materia'] == '0')
                                        echo 'selected'; ?>>
                                        Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="campo_formativo">Campo
                                    formativo*:</label>
                                <select class="form-select form-select mb-3" name="campo_formativo" id="campo_formativo"
                                    aria-label="select campo_formativo" value="<?= $row['campo_formativo'] ?>">
                                    <option value="fundamento" <?php if ($row['campo_formativo'] == 'fundamento')
                                        echo 'selected'; ?>>Fundamento</option>
                                    <option value="practica" <?php if ($row['campo_formativo'] == 'practica')
                                        echo 'selected'; ?>>Prácticas</option>
                                    <option value="especifico" <?php if ($row['campo_formativo'] == 'especifico')
                                        echo 'selected'; ?>>Específico</option>
                                    <option value="general" <?php if ($row['campo_formativo'] == 'general')
                                        echo 'selected'; ?>>General</option>
                                </select>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="carga_horaria_materia">Carga
                                    horaria (Horas)*:</label>
                                <input class="form-control" type="number" name="carga_horaria_materia"
                                    id="carga_horaria_materia" value="<?= $row['carga_horaria_materia'] ?>" required>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="id_carrera">Carrera*:</label>
                                <select class="form-select form-select mb-3" name="id_carrera" id="id_carrera"
                                    aria-label="select_id_carrera">
                                    <?php
                                        // compara el id_Carrera de la materia seleccionada con el id_carrera de la tabla carreras, si son iguales queda preseleccionada
                                        // la opcion
                                    if ($result_carreras->num_rows > 0) {
                                        while ($row_carrera = $result_carreras->fetch_assoc()) {
                                            $selected = ($row['id_carrera'] == $row_carrera['id_carrera']) ? 'selected' : '';
                                            echo "<option value='" . $row_carrera['id_carrera'] . "' $selected>" . $row_carrera['nombre_carrera'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>



                            <div class="table-resposive mx-5">
                                <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                <a href="<?= rutas::$pathTablaListadodeMaterias ?>" class="btn btn-primary menu-icon border-0 px-4">Volver</a>
                                    <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit"value="Actualizar">
                                </div>
                            </div>





                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin de contenido -->
        </div>
        <!-- Fin de contenedor principal -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>