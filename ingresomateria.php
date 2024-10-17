<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Materia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <?php

    require('variablespath.php');
    require(rutas::$pathConection);

    // busca las carreras disponibles 
    $sql_carreras = "SELECT id_carrera, nombre_carrera FROM carrera";
    $result_carreras = $conn->query($sql_carreras);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cod_num_n = $_POST['cod_num'];
        $cod_alpha_n = $_POST['cod_alpha'];
        $denominacion_materia_n = $_POST['denominacion_materia'];
        $tipo_aprobacion_n = $_POST['tipo_aprobacion'];
        $nota_min_aprobacion_n = $_POST['nota_min_aprobacion'];
        $correlatividades_n = $_POST['correlatividades'];
        $estado_materia_n = $_POST['estado_materia'];
        $campo_formativo_n = $_POST['campo_formativo'];
        $carga_horaria_materia_n = $_POST['carga_horaria_materia'];
        $id_carrera_n = $_POST['id_carrera'];
        $anio_carrera_n = $_POST['anio_carrera'];


        $cod_num = htmlspecialchars($cod_num_n, ENT_QUOTES, 'UTF-8');
        $cod_alpha = htmlspecialchars($cod_alpha_n, ENT_QUOTES, 'UTF-8');
        $denominacion_materia = htmlspecialchars($denominacion_materia_n, ENT_QUOTES, 'UTF-8');
        $tipo_aprobacion = htmlspecialchars($tipo_aprobacion_n, ENT_QUOTES, 'UTF-8');
        $nota_min_aprobacion = htmlspecialchars($nota_min_aprobacion_n, ENT_QUOTES, 'UTF-8');
        $correlatividades = htmlspecialchars($correlatividades_n, ENT_QUOTES, 'UTF-8');
        $estado_materia = htmlspecialchars($estado_materia_n, ENT_QUOTES, 'UTF-8');
        $campo_formativo = htmlspecialchars($campo_formativo_n, ENT_QUOTES, 'UTF-8');
        $carga_horaria_materia = htmlspecialchars($carga_horaria_materia_n, ENT_QUOTES, 'UTF-8');
        $id_carrera = htmlspecialchars($id_carrera_n, ENT_QUOTES, 'UTF-8');
        $anio_carrera = htmlspecialchars($anio_carrera_n, ENT_QUOTES, 'UTF-8');

        $sql = "INSERT INTO materia (
        cod_num,
        cod_alpha,
        denominacion_materia,
        tipo_aprobacion,
        nota_min_aprobacion,
        correlatividades,
        estado_materia,
        campo_formativo,
        carga_horaria_materia,
        id_carrera,
        anio_carrera
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "isssisssiii",
            $cod_num,
            $cod_alpha,
            $denominacion_materia,
            $tipo_aprobacion,
            $nota_min_aprobacion,
            $correlatividades,
            $estado_materia,
            $campo_formativo,
            $carga_horaria_materia,
            $id_carrera,
            $anio_carrera
        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Registro insertado correctamente";
                echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
            } else {
                echo "Error al insertar el registro";
                echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
            }
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
        }

        $stmt->close();
    }

    $conn->close();
    include rutas::$pathNuevoHeader;
    ?>

    <main>
        <div class="d-flex flex-nowrap sidebar-height">
            <?php
            ?>
            <div class="container-fluid">
                <div class="table responsive">
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Materia</h3>
                    <div class="m-4">
                        <h2 class="text-dark-subtle title">Ingresar Nueva Materia</h2>
                    </div>

                    <div>
                        <form class="row g-3 m-4" method="post" action="ingresomateria.php">
                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="anio_carrera">Año de la carrera*:</label>
                                <input class="form-control" type="number" name="anio_carrera" id="anio_carrera"
                                    required>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="cod_num">Codigo numerico*:</label>
                                <input class="form-control" type="number" name="cod_num" id="cod_num" required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="cod_alpha">Código alfabético *:</label>
                                <input class="form-control" type="text" name="cod_alpha" id="cod_alpha" required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50"
                                    for="denominacion_materia">Denominación*:</label>
                                <input class="form-control" type="text" name="denominacion_materia"
                                    id="denominacion_materia" required>

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
                                <label class="form-label text-black-50" for="nota_min_aprobacion">Mínimo de aprobación*:</label>
                                <select class="form-select form-select mb-3" name="nota_min_aprobacion"
                                    id="nota_min_aprobacion" aria-label="nota_min_aprobacion">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option selected value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="correlatividades">Materias Correlativas*:</label>
                                <select class="form-select form-select mb-3" name="correlatividades"
                                    id="correlatividades" aria-label="select_correlatividades">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="estado_materia">Estado de
                                    materia*:</label>
                                <select class="form-select form-select mb-3" name="estado_materia" id="estado_materia"
                                    aria-label="select_estado_materia">
                                    <option selected value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="campo_formativo">Campo
                                    Formativo*:</label>
                                <select class="form-select form-select mb-3" name="campo_formativo" id="campo_formativo"
                                    aria-label="select_campo_formativo">
                                    <option selected value="fundamento">Campo de fundamento</option>
                                    <option value="practica">Campo de la práctica</option>
                                    <option value="especifico">Campo específico</option>
                                    <option value="general">Campo general</option>
                                </select>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="carga_horaria_materia">Carga horaria (En
                                    horas)*:</label>
                                <input class="form-control" type="number" name="carga_horaria_materia"
                                    id="carga_horaria_materia" required>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="id_carrera">Carrera*:</label>
                                <select class="form-select form-select mb-3" name="id_carrera" id="id_carrera"
                                    aria-label="select_id_carrera">
                                    <?php
                                    if ($result_carreras->num_rows > 0) {
                                        while ($row = $result_carreras->fetch_assoc()) {
                                            echo "<option value='" . $row['id_carrera'] . "'>" . $row['nombre_carrera'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                    <a href="<?=rutas::$pathTablaListadodeMaterias?>"><button
                                            class='btn btn-primary menu-icon border-0 px-4'
                                            type="button">Volver</button></a>
                                    <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit"
                                        value="Guardar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>