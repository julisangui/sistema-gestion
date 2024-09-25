<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
<?php 
    require('./conexion.php');
    $msge="";
?>
<?php 
    // Obtener el ID del registro a editar
$id_materia = $_GET['id_materia'];

    if ($id_materia === null || !is_numeric($id_materia)) {
        
        header("Location: tablalistadodematerias.php");
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
        $new_trayecto = $_POST['trayecto'];
        $new_correlatividades = $_POST['correlatividades'];
        $new_estado_materia = $_POST['estado_materia'];
        $new_ciclo_lectivo = $_POST['ciclo_lectivo'];
        $new_campo_formativo = $_POST['campo_formativo'];
        $new_carga_horaria_materia = $_POST['carga_horaria_materia'];
    
        // Consulta SQL con parámetros
        $sql = "UPDATE materia SET 
                    cod_num = ?, 
                    cod_alpha = ?, 
                    denominacion_materia = ?, 
                    tipo_aprobacion = ?, 
                    nota_min_aprobacion = ?, 
                    trayecto = ?, 
                    correlatividades = ?, 
                    estado_materia = ?,
                    ciclo_lectivo= ?,
                    campo_formativo = ?,
                    carga_horaria_materia = ?
                WHERE id_materia = ?";
    
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
    
        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param("isssisssssii",
            $new_cod_num,
            $new_cod_alpha,
            $new_denominacion_materia,
            $new_tipo_aprobacion,
            $new_nota_min_aprobacion,
            $new_trayecto,
            $new_correlatividades,
            $new_estado_materia,
            $new_ciclo_lectivo,
            $new_campo_formativo,
            $new_carga_horaria_materia,
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

$sql = "SELECT id_materia, cod_num, cod_alpha, denominacion_materia, tipo_aprobacion, nota_min_aprobacion, trayecto, correlatividades, estado_materia, ciclo_lectivo, campo_formativo, carga_horaria_materia 
        FROM materia
        WHERE id_materia=$id_materia";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Cerrar la conexión
$conn->close();
include "headernosearch.php";
?>
<main>
    <!-- Contenedor principal -->
    <div class="d-flex flex-nowrap sidebar-height"> 
      <!-- Aside/Wardrobe/Sidebar Menu --> 
      <?php
      include "sidebar.php"; 
        ?>  
      <!-- Fin de sidebar/aside -->
      <!-- Contenedor de ventana de contenido -->
      <div class="col-9 offset-3 bg-light-subtle pt-5">
            <div class="d-block p-3 m-4 h-100 ">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Materias</h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Editar Materia</h2>
                    <?=$msge?>
                    <!-- <h6 class="text-black-50">
                        *Dar de alta las Materias para la carrera correspondiente
                    </h6> -->
                </div>
                <div>
                    

                      <form class="row g-3 m-4" action="nuevomodificarmateria.php?id_materia=<?= $id_materia ?>" method="POST">
                            <div class="col-md-6 position-relative">
                                <input class="form-control" type="hidden" name="id_materia" value="<?= $row['id_materia'] ?>">
                                
                                <label class="form-label text-black-50" for="cod_num">Código numérico*:</label>
                                <input class="form-control" type="number" name="cod_num" id="cod_num" value="<?= $row['cod_num'] ?>">
                            </div>



                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="cod_alpha">Código alfabético*:</label>
                                <input class="form-control" type="text" name="cod_alpha" id="cod_alpha" value="<?= $row['cod_alpha'] ?>">
                            </div>


                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="denominacion_materia">Denominación*:</label>
                                <input class="form-control" type="text" name="denominacion_materia" id="denominacion_materia" value="<?= $row['denominacion_materia'] ?>">
                            </div>



                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="tipo_aprobacion">Tipo de aprobación</label>
                                <select class="form-select form-select mb-3" name="tipo_aprobacion" id="tipo_aprobacion" aria-label="tipo_aprobacion">
                                    <option selected value="Promoción">Promoción</option>
                                    <option value="Final">Final</option>
                                </select>
                            </div>


                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="nota_min_aprobacion">Nota mínima de aprobación*:</label>
                                <select class="form-select form-select mb-3" name="nota_min_aprobacion" id="nota_min_aprobacion" aria-label="nota_min_aprobacion" value="<?= $row['nota_min_aprobacion'] ?>">
                                    <option value="1" <?php if ($row['nota_min_aprobacion'] == '1') echo 'selected'; ?>>1</option>
                                    <option value="2" <?php if ($row['nota_min_aprobacion'] == '2') echo 'selected'; ?>>2</option>
                                    <option value="3" <?php if ($row['nota_min_aprobacion'] == '3') echo 'selected'; ?>>3</option>
                                    <option value="4" <?php if ($row['nota_min_aprobacion'] == '4') echo 'selected'; ?>>4</option>
                                    <option value="5" <?php if ($row['nota_min_aprobacion'] == '5') echo 'selected'; ?>>5</option>
                                    <option value="6" <?php if ($row['nota_min_aprobacion'] == '6') echo 'selected'; ?>>6</option>
                                    <option value="7" <?php if ($row['nota_min_aprobacion'] == '7') echo 'selected'; ?>>7</option>
                                    <option value="8" <?php if ($row['nota_min_aprobacion'] == '8') echo 'selected'; ?>>8</option>
                                    <option value="9" <?php if ($row['nota_min_aprobacion'] == '9') echo 'selected'; ?>>9</option>
                                    <option value="10" <?php if ($row['nota_min_aprobacion'] == '10') echo 'selected'; ?>>10</option>
                                </select>
                            </div>



                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50" for="trayecto">Trayecto*:</label>
                                <input class="form-control" type="text" name="trayecto" id="trayecto" value="<?= $row['trayecto'] ?>" required>
                            </div>


                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="correlatividades">Correlativas*:</label>
                                <input class="form-control" type="text" name="correlatividades" id="correlatividades" value="<?= $row['correlatividades'] ?>">
                            </div>



                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="estado_materia">Estado materia*:</label>
                                <select class="form-select form-select mb-3" name="estado_materia" id="estado_materia" aria-label="select estado_materia" value="<?= $row['estado_materia'] ?>">
                                    <option value="1" <?php if ($row['estado_materia'] == '1') echo 'selected'; ?>>Activo</option>
                                    <option value="0" <?php if ($row['estado_materia'] == '0') echo 'selected'; ?>>Inactivo</option>
                                </select>
                            </div>



                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50" for="ciclo_lectivo">Ciclo lectivo*:</label>
                                <input class="form-control" type="text" name="ciclo_lectivo" id="ciclo_lectivo" value="<?= $row['ciclo_lectivo'] ?>">
                            </div>


                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="campo_formativo">Campo formativo*:</label>
                                <select class="form-select form-select mb-3" name="campo_formativo" id="campo_formativo" aria-label="select campo_formativo" value="<?= $row['campo_formativo'] ?>">
                                    <option value="fundamento" <?php if ($row['campo_formativo'] == 'fundamento') echo 'selected'; ?>>Fundamento</option>
                                    <option value="practica" <?php if ($row['campo_formativo'] == 'practica') echo 'selected'; ?>>Prácticas</option>
                                    <option value="especifico" <?php if ($row['campo_formativo'] == 'especifico') echo 'selected'; ?>>Específico</option>
                                    <option value="general" <?php if ($row['campo_formativo'] == 'general') echo 'selected'; ?>>General</option>
                                </select>
                            </div>



                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="carga_horaria_materia">Carga horaria*:</label>
                                <input class="form-control" type="number" name="carga_horaria_materia" id="carga_horaria_materia" value="<?= $row['carga_horaria_materia'] ?>" required>
                            </div>


                            <div class="col-md-6 offset-1 mb-5">
                                <div class="d-block mb-5 gap-2 align-content-start">
                                </div>
                            </div>


                        <div class="col-md-6 offset-2 mb-5">
                            <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                            <a href="tablalistadodematerias.php"><button class='btn btn-primary menu-icon border-0 px-4' type="button">Volver</button></a>
                                <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit" value="Actualizar">       
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
