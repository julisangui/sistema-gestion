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

    require('./conexion.php');
    // Obtener los datos del formulario
    $searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    // Consultar los datos con posibilidad de búsqueda
    $sql = "SELECT personal.id_personal,  concat(personal.apellido_personal, ' ', personal.nombre_personal) as nombrecompleto, materia.id_materia, materia.cod_num, materia.denominacion_materia, materia.tipo_aprobacion, materia.correlatividades
        FROM personal 
        INNER JOIN materia_profesor ON personal.id_personal = materia_profesor.id_personal 
        INNER JOIN materia ON materia_profesor.id_materia = materia.id_materia";
    if ($filter !== 'all' && !empty($searchTerm)) {
        $sql .= " WHERE $filter LIKE '%$searchTerm%' ";
    }
    $result = $conn->query($sql);
    include './header.php';
    ?>
    <main>
        <!-- Contenedor principal -->
        <div class="d-flex flex-nowrap sidebar-height"> 
            <!-- Aside/Wardrobe/Sidebar Menu --> 
            <?php include "./sidebar.php"; ?>  
            <!-- Fin de sidebar/aside -->
            
            <!-- Contenedor de ventana de contenido -->
            <div class="col-9 offset-3 bg-light-subtle pt-5">
                <div class="d-block p-3 m-4 h-100 ">
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
                                <button class="btn btn-outline-secondary" id="bottonbusqueda" type="submit">Buscar</button>
                                
                                <!-- Añadi este boton para intentar limpiar los filtros-->
                                <a href="tablalistadomaterias333.php" id="limpiar" class="btn btn-outline-secondary">Limpiar</a>
                           
                            </div>
                        </form>
                        <a href="tablalistadodematerias.php" class="btn btn-primary custom-button mt-3">Configuración Materia</a>
                        <table class="table table-bordered table-striped mt-3 space-between">
                            <thead>
                                <tr>
                                    <th class="d-none">ID materia</th>
                                    <th>Año<br>Carrera</th>
                                    <th>Denominación<br>Materia</th>
                                    <th>Tipo<br>Aprobación</th>
                                    <th>Correlativas</th>
                                    <th>Nombre Profesor</th>
                                    <th>Ver<br>Correlativas</th>
                                    <th>Ver<br>Materia</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($fila = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='d-none'>" . $fila['id_materia'] . "</td>";
                                    echo "<td>" . $fila['cod_num'] . "</td>";
                                    echo "<td>" . $fila['denominacion_materia'] . "</td>";
                                    echo "<td>" . $fila['tipo_aprobacion'] . "</td>";
                                    echo "<td>" . $fila['correlatividades'] . "</td>";
                                    echo "<td>" . $fila['nombrecompleto'] . "</td>";

                                    echo "<td><a href='vermateriascorrelativas.php?id_materia=" . $fila['id_materia'] . "' class='btn btn-custom-view' title='Ver Materias Correlativas'>";
                                    echo "<i class='fa-solid fa-book' style='color: #0077FF;'></i>";
                                    echo "</a></td>";

                                    echo "<td><a href='vermateria.php?id_materia=" . $fila["id_materia"] . " ' class='btn btn-custom-view' title='Ver materia'>";
                                    echo "<i class='fas fa-eye'></i>";
                                    echo "</a></td>";

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No hay datos para mostrar</td></tr>";
                            }
                            $conn->close();
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



                            <!-- Añadi este pequeño script para intentar limpiar los filtros-->
<script>
document.getElementById('limpiar').addEventListener('click', function(){

    document.getElementById('bottonbusqueda').value = '';
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
