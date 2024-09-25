<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/styletablas.css">
</head>
<body>
<?php
include ("variablesPath.php");
require(rutas::$pathConetion);

// Consultar los datos con posibilidad de búsqueda
$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$sql = "SELECT id_materia, cod_num, cod_alpha, denominacion_materia, tipo_aprobacion, nota_min_aprobacion, trayecto, correlatividades, estado_materia, ciclo_lectivo, campo_formativo, carga_horaria_materia 
        FROM materia ";

if ($filter !== 'all') {
    $sql .= " WHERE $filter LIKE '%$searchTerm%' ";
}

$result = $conn->query($sql);

include rutas::$pathNuevoHeader;
?>

<main>
    <!-- Contenedor principal -->
    <div class="d-flex flex-nowrap sidebar-height"> 
        <!-- Aside/Wardrobe/Sidebar Menu --> 
      <!--  <//?php// include "sidebar.php"; ?>-->  
        <!-- Fin de sidebar/aside -->
      
        <!-- Contenedor de ventana de contenido -->
        <div class="container">
            <div class="table-responsive">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Materias</h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Listado de Materias</h2>
                </div>
                <div class="container table-responsive">
                    <form action="" method="GET" class="mb-3">
                        <div class="input-group">
                            <select class="form-select" name="filter">
                                <option value="all" <?php echo ($filter === 'all') ? 'selected' : ''; ?>>Todos los campos</option>
                                <option value="denominacion_materia" <?php echo ($filter === 'denominacion_materia') ? 'selected' : ''; ?>>Denominación Materia</option>
                                <option value="tipo_aprobacion" <?php echo ($filter === 'tipo_aprobacion') ? 'selected' : ''; ?>>Tipo Aprobación</option>
                                <option value="correlatividades" <?php echo ($filter === 'correlatividades') ? 'selected' : ''; ?>>Correlatividades</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Buscar" name="q" value="<?php echo $searchTerm; ?>">
                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                            <a href=<?=rutas::$pathTablaListadodeMaterias?> class="btn btn-primary custom-button ms-2">volver a Listado</a>
                        </div>


                        
                    </form>
                    <a href="ingresomateria.php" class="btn btn-primary custom-button mt-1">Ingresar Materia</a>

                    <table class="table table-bordered table-striped mt-3 space-between">
                        <thead>
                            <tr>
                                <th class="d-none">ID materia</th>
                                <th>Año<br>Carrera</th>
                                <th>Denominación<br> Materia</th>
                                <th>Tipo<br> Aprobación</th>
                                <th>Correlativas</th>
                                <th>Agregar<br>Correlativas</th>
                                <th>Ver<br>Correlativas</th>
                                <th>Editar<br>Materia</th>
                                <th>Ver<br>Materia</th>
                                <th>Asignar<br>Profesor</th>
                            </tr>
                        </thead>
                        <tbody class = "align-middle">
                            <?php
                            if ($result->num_rows > 0) {
                                $datos = array();
                                while ($row = $result->fetch_assoc()) {
                                    $datos[] = $row;
                                }

                                foreach ($datos as $fila) {
                                    echo "<tr>";
                                    echo "<td class='d-none'>" . $fila['id_materia'] . "</td>";      
                                    echo "<td>" . $fila['cod_num'] . "</td>";
                                    echo "<td>" . $fila['denominacion_materia'] . "</td>";
                                    echo "<td>" . $fila['tipo_aprobacion'] . "</td>";
                                    echo "<td>" . $fila['correlatividades'] . "</td>";

                                    echo "<td><a href='asignarmaterias.php?id_materia=".$fila['id_materia']."' class='btn btn-custom-view d-flex justify-content-center align-items-center' title='Agregar Materias Correlativas'>";
                                    echo "<i class='fa-solid fa-plus'></i>";
                                    echo "</a></td>";

                                    echo "<td><a href='vermateriascorrelativas.php?id_materia=".$fila['id_materia']."' class='btn btn-custom-view  d-flex justify-content-center align-items-center ' title='Ver Materias Correlativas'>";
                                    echo "<i class='fa-solid fa-book' style='color: #0077FF;'></i>";
                                    echo "</a></td>";

                                    echo "<td><a href='nuevomodificarmateria.php?id_materia=".$fila["id_materia"]."' class='btn btn-custom-edit  d-flex justify-content-center align-items-center' title='Editar Materia'>";
                                    echo "<i class='fas fa-pencil-alt'></i>";
                                    echo "</a></td>";

                                    echo "<td><a href='vermateria.php?id_materia=".$fila["id_materia"]." ' class='btn btn-custom-view d-flex justify-content-center align-items-center' title='Ver materia'>";
                                    echo "<i class='fas fa-eye'></i>";
                                    echo "</a></td>";

                                    echo "<td><a href='asignarprofesor.php?id_materia=" . $fila['id_materia'] . "' class='btn btn-custom-view d-flex justify-content-center align-items-center ' title='Asignar Profesor'>";
                                    echo "<i class='fas fa-user text-info'></i>";
                                    echo "</a></td>";
    
                                    echo "</tr>";
                                }

                                if (empty($datos)) {
                                    echo "<h4>No hay datos para mostrar</h4>";
                                }
                            } else {
                                echo "<h4>No hay datos para mostrar</h4>";
                            }
                             
                            $conn->close()
                            ?>
                        </tbody>
                    </table>
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
