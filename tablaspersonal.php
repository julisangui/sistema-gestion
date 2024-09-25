<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
    include "header.php";

    // Obtener los datos del formulario
    // Consultar los datos  , personal.repo_documentos
    
    $sql = "SELECT personal.id_personal, personal.nrocuil_personal, concat(personal.apellido_personal,' ',personal.nombre_personal)as nombrecompleto, personal.nro_designacion, personal.estado_personal, 
    personal.DNIchecked, personal.CVchecked, personal.CUILchecked, personal.TITchecked,
    materia.denominacion_materia, carrera.nombre_carrera 
    FROM personal 
    INNER JOIN materia_profesor ON personal.id_personal = materia_profesor.id_personal 
    INNER JOIN materia ON materia_profesor.id_materia = materia.id_materia 
    INNER JOIN materia_carrera ON materia.id_materia = materia_carrera.id_materia 
    INNER JOIN carrera ON materia_carrera.id_carrera = carrera.id_carrera";

    $result = $conn->query($sql);
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
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Personal</h3>


                    <div class="container">

                        <a href="ingresarpersonal.php" class="btn btn-primary custom-button mt-3">Ingresar Personal</a>
                        <table class="table table-bordered table-striped mt-3 space-between">
                            <thead>

                                <tr>
                                    <th style='display:none'>ID personal</th>
                                    <th>CUIL</th>
                                    <th>Apellido y Nombre</th>
                                    <th>Materia</th>
                                    <th>Número designación</th>
                                    <th>Carrera</th>
                                    <th>Estado</th>
                                    <th>Documentación</th>
                                    <th>Editar</th>
                                    <th>Ver</th>
                                    <th>Asignar materia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                             
                                if ($result->num_rows > 0) {
                                    $datos = array();
                                    while ($row = $result->fetch_assoc()) {
                                        $datos[] = $row;

                                    }

                                    // Generar filas de la tabla
                                    foreach ($datos as $fila) {
                                        echo "<tr>";
                                        echo "<td style='display:none'>" . $fila['id_personal'] . "</td>";
                                        echo "<td>" . $fila['nrocuil_personal'] . "</td>";
                                        echo "<td>" . $fila['nombrecompleto'] . "</td>";
                                        echo "<td>" . $fila['denominacion_materia'] . "</td>";
                                        echo "<td>" . $fila['nro_designacion'] . "</td>";
                                        echo "<td>" . $fila['nombre_carrera'] . "</td>";
                                        echo "<td>" . $fila['estado_personal'] . "</td>";
                                        $DNICheckedValue = $fila['DNIchecked'];
                                        $CVCheckedValue = $fila['CVchecked'];
                                        $CUILCheckedValue = $fila['CUILchecked'];
                                        $TITCheckedValue = $fila['TITchecked'];
                                       if($CUILCheckedValue == 1 && $CVCheckedValue == 1 && $DNICheckedValue == 1 && $TITCheckedValue == 1) {
                                        $texto="completo";
                                        echo "<td>" . $texto."</td>";
                                       }else {
                                        echo "<td>" . "incompleto"."</td>";
                                    }
                                    
                                     //  echo "<td>" . $fila['repo_documentos'] . "</td>";
                                        // echo "<td>"."dj"."</td>";
                                
                                        // enlace a  editar  pagina de edicion                 
                                        echo "<td><a href='edicionpersonal.php?id_personal=" . $fila["id_personal"] . "'class='btn btn-custom-edit'><i class='fas fa-pencil-alt'></i></a></td>";
                                        // enlace a  pagina de vista       
                                        echo "<td><a href='listaindividualpersonal.php?id_personal=" . $fila["id_personal"] . "' class='btn btn-custom-view'><i class='fas fa-eye'></i></a></td>";
                                        echo "<td><a href='asignarmateriapersonal.php?id_personal=" . $fila["id_personal"] . "'   class='btn btn-custom-view'><i class='fas fa-book' style='font-size:20px;color:#523497'</i></a></td>";


                                        echo "</tr>";
                                    }

                                } else {
                                    echo "<h4>No hay datos para mostrar</h4>";

                                }
                                $conn->close()
                                    ?>
                            </tbody>


                        </table>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-oer..."></script>
</body>

</html>