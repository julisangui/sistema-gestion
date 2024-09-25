<!doctype html>
<html lang="en">

<head>
    <!--  <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado Carreras-ISFT 225</title>
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
    include "variablesPath.php";
    require(rutas::$pathConetion);

    $msge = "";
    $busqueda = "";
    $result = null;
    $sql = "CREATE TABLE IF NOT EXISTS carrera (
    id_carrera INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    cod_carrera varchar(20) NOT NULL,
    nro_resolucion varchar(20) NOT NULL,
    nombre_carrera VARCHAR(100) NOT NULL,
    titulo_otorgado VARCHAR(50) NOT NULL,
    duracion INT(2) UNSIGNED NOT NULL,
    modalidad VARCHAR(10) NOT NULL,
    carga_horaria INT(4) UNSIGNED,
    estado_carrera VARCHAR(10) NOT NULL
)";
    if ($conn->query($sql) === FALSE) {
        /*Cambiado de false a FALSE*/
        /*  $msge="Error en la conexion" . $conn->error; */
        $msge = "<h5 style='color: #CA2E2E;'>Error en la conexión: " . $conn->error . "</h5>";
    }
    ;

    // Obtener los datos del formulario
    
    /*     $cod_carrera = $_POST['cod_carrera'];
        $nro_resolucion = $_POST['nro_resolucion'];
        $nombre_carrera = $_POST['nombre_carrera'];
        $titulo_otorgado = $_POST['titulo_otorgado'];
        $duracion = $_POST['duracion'];
        $modalidad = $_POST['modalidad'];
        $carga_horaria = $_POST['carga_horaria'];
        $estado_carrera = $_POST['estado_carrera'];

     */
    // Consultar los datos
    $sql = "SELECT id_carrera, cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, CONCAT( duracion, ' ',tipo_duracion) as duracion, modalidad, carga_horaria, estado_carrera FROM carrera";
    $result = $conn->query($sql);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filtrar = $_POST['filtrar'];
        $busqueda = $_POST['busqueda'];
        switch ($filtrar) {
            case $filtrar === "":
                $sql = "SELECT id_carrera, cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, CONCAT( duracion, ' ',tipo_duracion) as duracion, modalidad, carga_horaria, estado_carrera FROM carrera WHERE nombre_carrera LIKE '$busqueda%'";
                $result = $conn->query($sql);
                break;
            case $filtrar === "Nombre":
                $sql = "SELECT id_carrera, cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, CONCAT( duracion, ' ',tipo_duracion) as duracion, modalidad, carga_horaria, estado_carrera FROM carrera WHERE nombre_carrera LIKE '$busqueda%'";
                $result = $conn->query($sql);
                break;
            case $filtrar === "Modalidad":
                $sql = "SELECT id_carrera, cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, CONCAT( duracion, ' ',tipo_duracion) as duracion, modalidad, carga_horaria, estado_carrera FROM carrera WHERE modalidad LIKE '$busqueda%'";
                $result = $conn->query($sql);
                break;
            case $filtrar === "Estado":
                $sql = "SELECT id_carrera, cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, CONCAT( duracion, ' ',tipo_duracion) as duracion, modalidad, carga_horaria, estado_carrera FROM carrera WHERE estado_carrera LIKE '$busqueda%'";
                $result = $conn->query($sql);
                break;
            default:
                $sql = "SELECT id_carrera, cod_carrera, nro_resolucion, nombre_carrera, titulo_otorgado, CONCAT( duracion, ' ',tipo_duracion) as duracion, modalidad, carga_horaria, estado_carrera FROM carrera";
                $result = $conn->query($sql);
                break;
        }
    }

    include rutas::$pathNuevoHeader;
    ?>

    <main>
        <!-- Contenedor principal -->
        <div class="d-flex flex-nowrap sidebar-height">
            <!-- Aside/Wardrobe/Sidebar Menu -->
            <?php
           // include rutas::$pathSlidebar;
            ?>
            <!-- Fin de sidebar/aside -->
            <!-- Contenedor de ventana de contenido -->
            <div class="container-fluid">
                <div class="table-responsive ">
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Carreras</h3>
                    <div class="m-4">
                        <h2 class="text-dark-subtle title">Listado de Carreras </h2>

                        <!-- <h6 class="text-black-50">
                    *Dar de alta las Materias para la carrera correspondiente
                </h6> -->
                    </div>
                    <div class="container-fluid table-responsive">

                        <!-- Buscador -->
                        <form class="" method="POST" action=<?=rutas::$pathTablaListadoCarreras?>>
                            <div
                                class="justify-content-start col-md-5 col-lg-auto flex-fill w-100 navbar navbar-expand-md vh-50 pt-2 p-0 gap-1">
                             

                                <ul class="navbar-nav mt-3 bg-search rounded-2">
                                    <li class="nav-item dropdown m-0 p-0 ">

                                        <select class="form-select form-select p-2 me-4" name="filtrar" id="filtrar"
                                            aria-label="filtro">
                                            <option class="disabled" selected>Filtro</option>
                                            <option value="Nombre">Nombre</option>
                                            <option value="Modalidad">Modalidad</option>
                                            <option value="Estado">Estado</option>
                                        </select>
                                        <!-- <label for="filtrar">Filtro</label> -->
                                        <!--   </div> -->
                                    </li>
                                    <li>
                                        <div class="d-flex m-0 p-0 bg-light border rounded-end-2">
                                            <div class="input-group">
                                                <input id="busqueda" name="busqueda" type="text"
                                                    class="form-control bg-transparent focus-ring-none border-0 p-2"
                                                    placeholder="Busqueda" aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                        
                                                </button>
                                            </div>
                                        </div>

                                    </li>
                                </ul>
                                <a href=<?=rutas::$pathTablaListadoCarreras?> 
                                    class="btn btn-primary custom-button m-2 mt-4">volver a Listado</a>






                                <a href=<?=rutas::$pathIngresarCarrera?> 
                                    class="btn btn-primary custom-button mt-3 ms-auto">Ingresar Nueva Carrera</a>
                            </div>
                        </form>
                        <!-- Fin de buscador -->
                        <table class="table table-bordered table-striped mt-3 space-between">
                            <thead>
                                <tr>
                                    <th class="d-none">ID carrera</th>
                                    <th class="align-middle">Código de carrera</th>
                                    <th class="align-middle">Nro de resolución</th>
                                    <th class="align-middle">Nombre de Carrera</th>
                                    <th class="align-middle">Título otorgado</th>
                                    <th class="align-middle">Duración</th>
                                    <th class="align-middle">Modalidad</th>
                                    <th class="align-middle">Carga Horaria</th>
                                    <th class=" text-center align-middle">Estado de carrera</th>
                                    <th class="text-center align-middle">Editar</th>
                                    <th class="text-center align-middle">Ver</th>
                                    <th class="text-center align-middle">Materias</th>

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
                                        echo "<td class='d-none'>" . $fila['id_carrera'] . "</td>";
                                        echo "<td>" . $fila['cod_carrera'] . "</td>";
                                        echo "<td>" . $fila['nro_resolucion'] . "</td>";
                                        echo "<td>" . $fila['nombre_carrera'] . "</td>";
                                        echo "<td>" . $fila['titulo_otorgado'] . "</td>";
                                        echo "<td>" . $fila['duracion'] . "</td>";
                                        echo "<td>" . $fila['modalidad'] . "</td>";
                                        echo "<td>" . $fila['carga_horaria'] . " Horas</td>";
                                        echo "<td>" . $fila['estado_carrera'] . "</td>";
                                        echo "<td class='align-middle'><a href='".rutas::$pathModificarCarrera."?id_carrera=" . $fila["id_carrera"] . "' class='btn btn-custom-edit d-flex justify-content-center align-items-center  '><i class='fas fa-pencil-alt'></i></a></td>";
                                        echo "<td class='align-middle'><a href='".rutas::$pathVerCarrera."?id_carrera=" . $fila["id_carrera"] . "' class='btn btn-custom-view' d-flex justify-content-center align-items-center><i class='fas fa-eye'></i></a></td>";
                                        echo "<td class='align-middle'><a href='".rutas::$pathVerMateriasCarrera."?id_carrera=" . $fila['id_carrera'] . "' class='btn btn-custom-view d-flex justify-content-center align-items-center'><i class='fa-sharp fa-solid fa-list'></i></a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    $msge = "<h5 style='color: #CA2E2E;'>No hay carreras cargadas</h5>";
                                }
                                $conn->close()
                                    ?>
                            </tbody>
                            <?= $msge ?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Fin de contenido -->
        </div>
        <!-- Fin de contenedor principal -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>