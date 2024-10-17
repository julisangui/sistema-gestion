<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/styletablas.css">
</head>
<body>

    <?php
    require('./conexion.php');
    include "nuevo-header.php";

        // Obtener los datos del formulario
    $searchTerm = isset($_GET['buscar']) ? trim($_GET['buscar']) : ''; //trim() se usa para eliminar espacios en blanco adicionales.
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';  //se establece en 'all'. Este valor se utiliza para decidir en qué columna aplicar el filtro.
 
    // Construir la consulta SQL
        $sql = "SELECT 
            personal.id_personal, 
            personal.nrocuil_personal AS CUIL, 
            CONCAT(personal.apellido_personal, ' ', personal.nombre_personal) AS nombrecompleto, 
            personal.estado_personal AS Estado,
            CASE 
                WHEN personal.DNIchecked = 1 AND personal.CVchecked = 1 AND personal.CUILchecked = 1 AND personal.TITchecked = 1 THEN 'Completo'
                ELSE 'Incompleto'
            END AS Documentacion,
            personal.rol_personal AS Rol,
            personal.sexo_personal AS Sexo
        FROM personal";

//Si el valor del filtro no es 'all' y el término de búsqueda no está vacío, se añade una condición WHERE a la consulta SQL.
//$sql .= " WHERE $filter LIKE '%$searchTerm%'";: Esta línea añade la condición WHERE a la consulta para buscar el término 
//en la columna especificada por $filter usando LIKE, lo cual permite buscar coincidencias parciales.
    if ($filter !== 'all' && !empty($searchTerm)) {
        $sql .= " WHERE $filter LIKE '%$searchTerm%'";
    }
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Error de consulta SQL: " . $conn->error);
    }

  
    ?>

<main class="container-fluid">
        <!-- Contenedor principal sin sidebar -->
        <div class="row">
            <!-- Contenido que ocupa todo el ancho de la pantalla -->
            <div class="col-12 bg-light-subtle pt-5">
                <div class="d-block p-3 m-4 h-100">
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Personal</h3>

                    <div class="container">
                        <!-- Formulario de búsqueda y filtro -->
                        <form action="" method="GET" class="mb-3">
                            <div class="input-group">
                                <select class="form-select" name="filter">
                                    <option value="all" <?php echo ($filter === 'all') ? 'selected' : ''; ?>>Todos los
                                        campos</option>
                                    <option value="personal.nombre_personal"
                                        <?php echo ($filter === 'personal.nombre_personal') ? 'selected' : ''; ?>>
                                        Nombre</option>
                                    <option value="personal.apellido_personal"
                                        <?php echo ($filter === 'personal.apellido_personal') ? 'selected' : ''; ?>>
                                        Apellido</option>
                                    <option value="personal.nrocuil_personal"
                                        <?php echo ($filter === 'personal.nrocuil_personal') ? 'selected' : ''; ?>>
                                        CUIL</option>
                                    <option value="personal.estado_personal"
                                        <?php echo ($filter === 'personal.estado_personal') ? 'selected' : ''; ?>>
                                        Estado</option>
                                    <option value="personal.rol_personal"
                                        <?php echo ($filter === 'personal.rol_personal') ? 'selected' : ''; ?>>
                                        Rol</option>
                                    <option value="personal.sexo_personal"
                                        <?php echo ($filter === 'personal.sexo_personal') ? 'selected' : ''; ?>>Sexo
                                    </option>
                                </select>
                                <input type="text" class="form-control" placeholder="Buscar" name="buscar"
                                    value="<?php echo htmlspecialchars($searchTerm); ?>">
                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                            </div>
                        </form>

                        <a href="ingresarpersonal.php" class="btn btn-primary custom-button mt-3">Ingresar Personal</a>
                        <table class="table table-bordered table-striped mt-3 space-between">
                            <thead>
                                <tr>
                                    <th style='display:none'>ID personal</th>
                                    <th>CUIL</th>
                                    <th>Apellido y Nombre</th>
                                    <th>Estado</th>
                                    <th>Documentación</th>
                                    <th>Rol</th>
                                    <th>Sexo</th>
                                    <th>Editar</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['CUIL'] . "</td>";
                                        echo "<td>" . $row['nombrecompleto'] . "</td>";
                                        echo "<td>" . $row['Estado'] . "</td>";
                                        echo "<td>" . $row['Documentacion'] . "</td>";
                                        echo "<td>" . $row['Rol'] . "</td>";
                                        echo "<td>" . $row['Sexo'] . "</td>";
                                        echo "<td><a href='edicionpersonal.php?id_personal=" . $row['id_personal'] . "' class='btn btn-custom-edit' title='Editar información del personal'><i class='fas fa-pencil-alt'></i></a></td>";
                                        echo "<td><a href='listaindividualpersonal.php?id_personal=" . $row['id_personal'] . "' class='btn btn-custom-view' title='Ver información del personal'><i class='fas fa-eye'></i></a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No hay datos para mostrar</td></tr>";
                                }
                            ?>
                            </tbody>


                        </table>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-oer..."></script>
</body>

</html>