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
    include "variablesPath.php";
    require(rutas::$pathConetion);
    $msge = "<h5 style='color: #CA2E2E;'></h5>";
?>
<?php 
    // Obtener el ID del registro a editar
$id_carrera = $_GET['id_carrera'];

    if ($id_carrera === null || !is_numeric($id_carrera)) {
        header("Location: tablalistadocarreras.php");
        // Exit para detener la ejecución
        exit();
    }
   
// Obtener los datos del registro actual
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$sql = "SELECT id_carrera, cod_carrera, nro_resolucion,  nombre_carrera, titulo_otorgado, estado_carrera, duracion, modalidad, carga_horaria, nivel, tipo_duracion 
        FROM carrera 
        WHERE id_carrera=$id_carrera";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// Cerrar la conexión
$conn->close();
include rutas::$pathHeadernoSearch;
?>
<main>
    <!-- Contenedor principal -->
    <div class="d-flex flex-nowrap sidebar-height"> 
      <!-- Aside/Wardrobe/Sidebar Menu --> 
      <?php
      include rutas::$pathSlidebar; 
        ?>  
      <!-- Fin de sidebar/aside -->
      <!-- Contenedor de ventana de contenido -->
      <div class="col-9 offset-3 bg-light-subtle pt-5">
            <div class="d-block p-3 m-4 h-100 ">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Visualizar carrera</h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title"><?php echo $row['nombre_carrera']; ?></h2>
                    <?=$msge?>
                </div>
                <div>
                    <form class="row g-3 m-4" action="vercarrera.php" method="POST">
                        <!-- 
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="id_carrera">Id de Carrera*:</label>
                            <input class="form-control" type="hidden" name="id_carrera" id="id_carrera" required>
                      </div>  -->

                        <div class="col-md-6 position-relative">
                            <input class="form-control" type="hidden" name="id_carrera" value="<?= $row['id_carrera'] ?>">
                            <label class="form-label text-black-50" for="cod_carrera">Código de  Carrera:</label>
                            <input class="form-control" type="text" name="cod_carrera" id="cod_carrera" value="<?= $row['cod_carrera'] ?>"readonly>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="nro_resolucion">Número de Resolución:</label>
                            <input class="form-control" type="text" name="nro_resolucion" id="nro_resolucion" value="<?= $row['nro_resolucion'] ?>"readonly>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="nombre_carrera">Nombre de carrera:</label>
                            <input class="form-control" type="text" name="nombre_carrera" id="nombre_carrera" value="<?= $row['nombre_carrera'] ?>"readonly>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="titulo_otorgado">Título que entrega:</label>
                            <input class="form-control" type="text" name="titulo_otorgado" id="titulo_otorgado" value="<?= $row['titulo_otorgado'] ?>"readonly>
                        </div>

                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="nivel">Nivel:</label>
                            <input class="form-control" type="text" name="nivel" id="nivel" value="<?= $row['nivel'] ?>"readonly>
                        </div>
                     
                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="estado_carrera">Estado de carrera:</label>
                            <input class="form-control" type="text" name="estado_carrera" id="estado_carrera" value="<?= $row['estado_carrera'] ?>"readonly>   
                        </div>

                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50" for="duracion">Duración:</label>
                            <input class="form-control" type="text" name="duracion" id="duracion" value="<?= $row['duracion'] ?>" readonly>
                        </div>

                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="estado_carrera">Tipo de Duracion*:</label>
                            <input class="form-control" type="text" name="tipo_duracion" id="tipo_duracion" value="<?= $row['tipo_duracion'] ?>" readonly>   
                        </div>

                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50" for="modalidad">Modalidad:</label>
                            <input class="form-control" type="text" name="modalidad" id="modalidad" value="<?= $row['modalidad'] ?>" readonly>
                        </div>

                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50" for="carga_horaria">Carga horaria:</label>
                            <input class="form-control" type="text" name="carga_horaria" id="carga_horaria" value="<?= $row['carga_horaria'] ?>"readonly>
                        </div>

                        <div class="col-md-3 position-relative">
                            <div class="d-flex mb-5 gap-2 justify-content-between ">
                                <a href=<?=rutas::$pathTablaListadoCarreras?>><button type="button" class='btn btn-primary menu-icon border-0 px-4'>Volver</button></a>
                            </div>
                        </div>

                        <div class="col-md-6 position-relative d-flex ms-auto ">
                            <div class="d-flex ms-auto ">
                                    <a class="" href=<?=rutas::$pathVerMateriasCarrera."?id_carrera=".$id_carrera?>><button type="button" class='btn btn-primary  px-4 menu-icon border-0'>Ver materias asociadas</button></a>
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
