<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de Materias Correlativas</title>
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


// 2. Verificar si se ha enviado un ID de materia
if (isset($_GET['id_materia'])) {
    $id_materia = $_GET['id_materia'];
    
    // 3. Consultar el nombre de la materia
    $sql_denominacion_materia = "SELECT denominacion_materia FROM materia WHERE id_materia = $id_materia";
    $result_denominacion_materia = $conn->query($sql_denominacion_materia);
    
    if ($result_denominacion_materia !== null && $result_denominacion_materia->num_rows > 0) {
        $row_denominacion_materia = $result_denominacion_materia->fetch_assoc();
        $denominacion_materia = $row_denominacion_materia['denominacion_materia'];
    } else {
        $denominacion_materia = "-";
        
    }
    
    // 4. Consultar las materias correlativas y el tipo de aprobación
    try {
        $sql = "SELECT m.id_materia, m.denominacion_materia, ta.nombre_tipo_aprobacion, (select m.denominacion_materia from materia as m where id_materia = mc.materia_correlativa) as materia_correlativa
        FROM materia AS m 
        JOIN correlativas AS mc ON mc.id_materia = m.id_materia 
        JOIN tipo_aprobacion AS ta ON ta.id_tipo_aprobacion = mc.tipo_aprobacion_correlativa
        WHERE m.id_materia = $id_materia";

        
        $result = $conn->query($sql);
    } catch (Exception $e) {
        echo "Error en la consulta SQL: " . $e->getMessage();
    }



    // 5. Incluimos el archivo del encabezado.
    include "header.php";
}
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
            <h3 class="card-footer-text mt-2 mb-5 p-2">Materias Correlativas de <?php echo $denominacion_materia?></h3>
            <div class="m-4">
                <h2 class="text-dark-subtle title">Listado</h2>
            </div>

            <div class="container table-responsive">

            <form class="" method="POST" action="vermateriascorrelativas.php">

                <div class="justify-content-start col-md-5 col-lg-auto flex-fill w-100 navbar navbar-expand-md vh-50 pt-4 p-3 gap-1">
                <a href="#" class="btn btn-primary custom-button mt-3">Materias Correlativas</a>
                    <ul class="navbar-nav mt-3 bg-search rounded-2">
                        <li class="nav-item dropdown m-0 p-0 ">
                            <select class="form-select form-select p-2 me-4" name="filtrar" id="filtrar" aria-label="filtro">
                                <option class="disabled" selected>Filtro</option>
                                <option value="Materia">Materia</option>
                                <option value="Tipo de Aprobacion">Tipo de Aprobación</option>
                                
                            </select>
                        </li> 
                        <li>
                            <div class="d-flex m-0 p-0 bg-light border rounded-end-2">
                                <div class="input-group">
                                    <button class="bg-light border-0" type="submit" id="button-addon1"><svg class="mx-1" width="19" height="20" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.2287 10.3421C13.197 9.02083 13.6307 7.38264 13.443 5.7553C13.2554 4.12796 12.4601 2.63149 11.2165 1.56528C9.97285 0.499068 8.37249 -0.0582491 6.73557 0.00482408C5.09866 0.0678972 3.54592 0.746709 2.38801 1.90545C1.23009 3.0642 0.552388 4.61742 0.490486 6.25438C0.428585 7.89134 0.987047 9.49131 2.05415 10.7342C3.12124 11.9771 4.61828 12.7712 6.24576 12.9577C7.87323 13.1442 9.51112 12.7094 10.8317 11.7401H10.8307C10.8607 11.7801 10.8927 11.8181 10.9287 11.8551L14.7787 15.7051C14.9662 15.8928 15.2206 15.9983 15.4859 15.9983C15.7512 15.9984 16.0056 15.8932 16.1932 15.7056C16.3809 15.5181 16.4863 15.2638 16.4864 14.9985C16.4865 14.7332 16.3812 14.4788 16.1937 14.2911L12.3437 10.4411C12.308 10.405 12.2695 10.3725 12.2287 10.3421ZM12.4867 6.49815C12.4867 7.22042 12.3445 7.93562 12.0681 8.60291C11.7917 9.2702 11.3865 9.87651 10.8758 10.3872C10.3651 10.898 9.75879 11.3031 9.0915 11.5795C8.42421 11.8559 7.70901 11.9981 6.98674 11.9981C6.26447 11.9981 5.54927 11.8559 4.88198 11.5795C4.21469 11.3031 3.60837 10.898 3.09765 10.3872C2.58693 9.87651 2.1818 9.2702 1.9054 8.60291C1.629 7.93562 1.48674 7.22042 1.48674 6.49815C1.48674 5.03946 2.0662 3.64051 3.09765 2.60906C4.1291 1.57761 5.52805 0.998147 6.98674 0.998147C8.44543 0.998147 9.84437 1.57761 10.8758 2.60906C11.9073 3.64051 12.4867 5.03946 12.4867 6.49815Z" fill="#8A8A8A"/>
                                        </svg>
                                    </button>
                                    <input id="busqueda" name="busqueda" type="text" class="form-control bg-transparent focus-ring-none border-0 p-2" placeholder="Busqueda" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </form>


            <table class="table table-bordered table-striped mt-3 space-between">
                <thead>
                    <tr>
                        <th class="d-none">ID Materia</th>
                        <th>Materia</th>
                        <th>Materia Correlativa</th>
                        <th>Tipo de Aprobación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result !== null && $result->num_rows > 0) {
                        $datos = array();
                        while ($row = $result->fetch_assoc()) {
                            $datos[] = $row;
                        }
                        // Generar filas de la tabla
                        foreach ($datos as $fila) {
                            echo "<tr>";
                            echo "<td class='d-none'>" . $fila['id_materia'] . "</td>";
                            echo "<td>" . $fila['denominacion_materia'] . "</td>";
                            echo "<td>" . $fila['materia_correlativa'] . "</td>";
                            echo "<td>" . $fila['nombre_tipo_aprobacion'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        $msge = "<h5 style='color: #CA2E2E;'>No hay materias correlativas asociadas a la materia<h5>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <?=$msge?>
        </div>

        <div class="col-md-6 offset-2 mb-5">
            <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                
                <a href='tablalistadodematerias.php'><button class='btn btn-primary menu-icon border-0 px-4'>Volver</button></a>
                <a href='asignarmaterias.php?id_materia=<?=$id_materia?>'><button class='btn btn-primary menu-icon border-0 px-4'>Agregar Materia</button></a>
            </div>
        </div>
    </div>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
