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
    $msge="";
    
    // Verificar si se ha enviado un ID de la materia
    
    if (isset($_GET['id_materia'])) {
        $id_materia = $_GET['id_materia'];
        
        //Traigo el nombre de materia:
        
        $sql = "SELECT id_materia, denominacion_materia FROM materia WHERE id_materia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_materia);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $rowm = $result->fetch_assoc();
        } else {
           /*  echo "Materia no encontrada."; */
            $msge="<h5 style='color: #CA2E2E;'>Materia no encontrada.</h5>";
            exit();
        }
        if ($result->num_rows > 0) {
            $rowc = $result->fetch_assoc();
        } else {
              
            $msge="<h5 style='color: #CA2E2E;'>Carrera no encontrada.</h5>";
            exit();
        }
    } else {
        /* echo "ID de materia no especificado."; */
        $msge="<h5 style='color: #CA2E2E;'>ID de carrera no especificado.</h5>";
        $stmt->close();
        exit();
    }


    //Traer los datos de materias disponibles:
    $sql2 = "SELECT id_materia, denominacion_materia FROM materia";
    $result2 = $conn->query($sql2);
    $sql3 = "SELECT id_tipo_aprobacion, nombre_tipo_aprobacion FROM tipo_aprobacion";
    $result3 = $conn->query($sql3);
    
   

    // Verificar si se ha enviado el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos editados
        //$id_materia = $_POST['id_materia'];
        $materia_correlativa = $_POST['denominacion_materia'];
        $id_tipo_aprobacion = $_POST['tipo_aprobacion'];

        
        // Actualizar la materia en la base de datos
        $sql = "INSERT INTO correlativas (id_materia, materia_correlativa, tipo_aprobacion_correlativa) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii",
        $id_materia,
        $materia_correlativa,
        $id_tipo_aprobacion
    );
    
    
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
            exit();
        } else {
            $msge = "<h5 style='color: #CA2E2E;'>No se insertó nada..</h5>";
            
        }
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;  
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
                <h3 class="card-footer-text mt-2 mb-5 p-2">Materias correlativa/s a la materia <?php echo $rowm['denominacion_materia']; ?></h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Asignar Materia</h2>
                    <!-- <h6 class="text-black-50">
                        *Dar de alta las Materias para la carrera correspondiente
                    </h6> -->
                </div>

                <div>
            <form class="row g-3 m-4" action="pruebaasignarmaterias.php?id_materia=<?=$id_materia?>" method="POST">
            <div class="row g-3 m-4">

            <div class="col-md-6 position-relative">
                    <label class="form-label text-black-50" for="id_materia">ID Materia</label>
                    <input class="form-control" type="number" name="id_materia" id="id_materia" value="<?php echo $rowm['id_materia']; ?>" disabled>
                </div>

             


                <div class="col-md-3 position-relative">
                    <label class="form-label text-black-50 text-nowrap" for="denominacion_materia">Asignar materia correlativas</label>
                    <select class="form-select form-select mb-3" name="denominacion_materia" id="denominacion_materia" aria-label="denominacion_materia">
                       
                       <?php
                        if ($result2->num_rows > 0) {
                            while ($rowm = $result2->fetch_assoc()) {
                            echo "<option value='" . $rowm['id_materia'] . "'>" . $rowm['denominacion_materia'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3 position-relative">
                    <label class="form-label text-black-50 text-nowrap" for="tipo_aprobacion">Asignar tipo de aprobación</label>
                    <select class="form-select form-select mb-3" name="tipo_aprobacion" id="tipo_aprobacion" aria-label="tipo_aprobacion">
                    
                       <?php
                        if ($result3->num_rows > 0) {
                            
                            while ($rowd = $result3->fetch_assoc()) {
                            echo "<option value='" . $rowd['id_tipo_aprobacion'] . "'>" . $rowd['nombre_tipo_aprobacion'] . "</option>";
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
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
