<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
<?php
try{
include "variablesPath.php";
require(rutas::$pathConetion);
$msge="";
$validacion="";



// Obtener los datos del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    
        $cod_carrera_n = trim($_POST['cod_carrera']);
        $nro_resolucion_n = trim($_POST['nro_resolucion']);
        $nombre_carrera_n = trim($_POST['nombre_carrera']);
        $titulo_otorgado_n = trim($_POST['titulo_otorgado']);
        $duracion_n = trim($_POST['duracion']);
        $modalidad_n = trim($_POST['modalidad']);
        $carga_horaria_n = trim($_POST['carga_horaria']);
        $estado_carrera_n = trim($_POST['estado_carrera']);
        $nivel_n = trim($_POST['nivel']);
        $tipo_duracion_n = trim($_POST['tipo_duracion']);


        $errors=[];
        //Validacion de campos vacios:
        if (
            empty($cod_carrera_n) ||
            empty($nro_resolucion_n) ||
            empty($nombre_carrera_n) ||
            empty($titulo_otorgado_n) ||
            empty($duracion_n) ||
            empty($modalidad_n) ||
            empty($carga_horaria_n) ||
            empty($estado_carrera_n)||
            empty($nivel_n) ||
            empty($tipo_duracion_n) 
        ) {
            $errors['cod_carrera_n'] = "Por favor, complete todos los campos antes de enviar el formulario.";
           
        }
        elseif(!is_numeric($duracion_n) || floatval($duracion_n) != $duracion_n) {
            $errors['duracion_n'] ="El campo duracion debe ser numerico";
        }
        elseif(!is_numeric($carga_horaria_n) || floatval($carga_horaria_n) != $carga_horaria_n){
            $errors['carga_horaria_n'] ="El campo carga horaria debe ser numerico";
        }
         else {

        //Evitar inyeccion SQL
        $cod_carrera = htmlspecialchars($cod_carrera_n, ENT_QUOTES, 'UTF-8');
        $nro_resolucion = htmlspecialchars($nro_resolucion_n, ENT_QUOTES, 'UTF-8');
        $nombre_carrera = htmlspecialchars($nombre_carrera_n, ENT_QUOTES, 'UTF-8');
        $titulo_otorgado = htmlspecialchars($titulo_otorgado_n, ENT_QUOTES, 'UTF-8');
        $duracion = htmlspecialchars($duracion_n, ENT_QUOTES, 'UTF-8');
        $modalidad = htmlspecialchars($modalidad_n, ENT_QUOTES, 'UTF-8');
        $carga_horaria = htmlspecialchars($carga_horaria_n, ENT_QUOTES, 'UTF-8');
        $estado_carrera = htmlspecialchars($estado_carrera_n, ENT_QUOTES, 'UTF-8');
        $nivel = htmlspecialchars($nivel_n, ENT_QUOTES, 'UTF-8');
        $tipo_duracion = htmlspecialchars($tipo_duracion_n, ENT_QUOTES, 'UTF-8');
        //Sentencia SQL para insertar los datos

        $sql = "INSERT INTO carrera (cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, duracion, modalidad, carga_horaria, estado_carrera, nivel, tipo_duracion) VALUES (?, ?, ?, ?, ? ,? ,?, ?, ?, ? )";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssisss", $cod_carrera, $nro_resolucion, $nombre_carrera, $titulo_otorgado, $duracion, $modalidad, $carga_horaria, $estado_carrera,$nivel,$tipo_duracion);

        /*Si se puede ejecutar la consulta dependiendo del resultado se muestra un mensaje exitoso
        y si no se puede se muestra un mensaje de error al ejecutar*/
        if ($stmt->execute()){
            /*Si se hicieron cambios en la base, primero se muestra el mensaje de exito, 
            sino, se muestra un mensaje  de error*/

            if ($stmt->affected_rows > 0) {
                /* $msge="Registro insertado"; */
                $msge = "<h5 style='color: #2ECA6A;'>Registro insertado</h5>";
                echo "<meta http-equiv='refresh' content='1;url=ingresarcarrera.php'>";
            }else{
                /* $msge="Error al insertar el registro"; */
                $msge = "<h5 style='color: #CA2E2E;'>Error al insertar el registro</h5>";

            }
        } else{
                //Muestra mensaje de error si no se puede ejecutar la consulta
                /* $msge="Error al ejecutar la consulta: " . $stmt->error; */
                $msge = "<h5 style='color: #CA2E2E;'>Error al ejecutar la consulta: " . $stmt->error . "</h5>";
        }
        $stmt->close();
    }
    if (isset($_POST["volver"])) {
        header("Location: tablalistadocarreras.php");
        exit();
    }

    }
/* if (isset($_POST["volver"])) {
    header("Location: tablalistadocarreras.php");
    exit();
} */

}catch(Exception $e){
    echo "<h5 style='color: #CA2E2E;'>Error conectando a la base de datos: " . $e->getMessage() . "</h5>";
}
finally{
    $conn->close();
  }
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
                <h3 class="card-footer-text mt-2 mb-5 p-2">Carreras</h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Ingresar Nueva Carrera</h2>
                    <?=$msge?>
                    <!-- <h6 class="text-black-50">
                        *Dar de alta las Materias para la carrera correspondiente
                    </h6> -->
                </div>
                <div>
                    <form class="row g-3 mt-4 ms-4 me-4" method="post" action="ingresarcarrera.php" >
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="cod_carrera">Código de  Carrera*:</label>
                            <input class="form-control" type="text" name="cod_carrera" id="cod_carrera" maxlength="20" required>
                            <?php if (isset($errors['cod_carrera_n'])) { ?>
                                <h5 style='color: #CA2E2E;'><?= $errors['cod_carrera_n'] ?></h5>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="nro_resolucion">Número de Resolución*:</label>
                            <input class="form-control" type="text" name="nro_resolucion" id="nro_resolucion" maxlength="20" required>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="nombre_carrera">Nombre de carrera*:</label>
                            <input class="form-control" type="text" name="nombre_carrera" id="nombre_carrera" maxlength="100" required>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="titulo_otorgado">Título que entrega*:</label>
                            <input class="form-control" type="text" name="titulo_otorgado" id="titulo_otorgado" maxlength="100" required>
                        </div>
                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="nivel">Nivel*:</label>
                                <select class="form-select form-select mb-2" name="nivel" id="nivel" aria-label="select nivel" required>
                                    <option value="primaria">Primaria</option>
                                    <option value="segundaria">Segundaria</option>
                                    <option value="terciario">Terciario</option>
                                    <option value="universitario">Universitario</option>
                                </select>
                        </div>
                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="estado_carrera">Estado de carrera*:</label>
                            <select class="form-select form-select mb-2" name="estado_carrera" id="estado_carrera" aria-label="select estado_carrera" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                              </select>
                              
                        </div>
                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50" for="duracion">Duracion*:</label>
                            <input class="form-control" type="number" name="duracion" id="duracion" min="1" maxlength="2"  required>
                            <?php if (isset($errors['duracion_n'])) { ?>
                                <h5 style='color: #FC2372;'><?= $errors['duracion_n'] ?></h5>
                            <?php } ?>
                        </div>
                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="estado_carrera">Tipo de Duracion*:</label>
                                <select class="form-select form-select mb-3" name="tipo_duracion" id="tipo_duracion" aria-label="select tipo_duracion" required>
                                    <option value="anio">Año</option>
                                    <option value="mes">Mes</option>
                                    <option value="semana">Semana</option>
                                    <option value="dias">Dias</option>
                                 </select>    
                        </div>

                        
                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50" for="modalidad">Modalidad*:</label>
                            <select class="form-select form-select mb-3" name="modalidad" id="modalidad" aria-label="select modalidad" required>
                                <option value="presencial">Presencial</option>
                                <option value="virtual">Virtual</option>
                                <option value="hibrido">Hibrido</option>
                              </select>   
                        </div>

                        <div class="col-md-2 position-relative">
                            <label class="form-label text-black-50" for="carga_horaria">Carga horaria*:</label>
                            <input class="form-control" type="number" name="carga_horaria" id="carga_horaria" min="1" maxlength="4" required>
                            <?php if (isset($errors['carga_horaria_n'])) { ?>
                                <h5 style='color: #CA2E2E;'><?= $errors['carga_horaria_n'] ?></h5>
                            <?php } ?>
                        </div>
                        
        
                         <div class="col-md-6 offset-2 mb-5">
                            <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                <input class="btn btn-primary px-4 nav-bar border-0 text-wrap"  id="liveToastBtn" name="guardar" type="submit" value="Guardar">
                                <!-- <input class="btn btn-primary menu-icon border-0 px-4 text-wrap"  id="liveToastBtn" name="volver" type="button" value="Volver"> -->
                                <a class="" href=<?=rutas::$pathTablaListadoCarreras?>><button type="button" class="btn btn-primary menu-icon border-0 px-4">Volver</button></a>                     
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
