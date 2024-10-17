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
    require ("variablesPath.php");
    require(rutas::$pathConection);

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

        $msge = "<h5 style='color: #CA2E2E;'>Error en la conexión: " . $conn->error . "</h5>";
    };

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
            <?php
           
            ?>
            <!-- Fin de sidebar/aside -->
            <!-- Contenedor de ventana de contenido -->
            <div class="container-fluid">
                <div class="table-responsive">
                    <h3 class="card-footer-text mt-2 mb-5 p-2">Carreras</h3>
                    <div class="m-4">
                        <h2 class="text-dark-subtle title">Carreras Listado</h2>

                        <!-- <h6 class="text-black-50">
                    *Dar de alta las Materias para la carrera correspondiente
                </h6> -->
                    </div>
                    <div class="container table-responsive">

                        <!-- Buscador -->
                        <form class="" method="POST" action=<?=rutas::$pathTablaListadoCarreras?>>
                            <div
                                class="justify-content-start col-md-5 col-lg-auto flex-fill w-100 navbar navbar-expand-md vh-50 pt-4 p-3 gap-1">
                                <a href="#" class="btn btn-primary custom-button mt-3">Carreras</a>

                                <ul class="navbar-nav mt-3 bg-search rounded-2">
                                    <li class="nav-item dropdown m-0 p-0 ">

                                        <select class="form-select form-select p-2 me-4" name="filtrar" id="filtrar"
                                            aria-label="filtro">
                                            <option class="disabled" selected>Filtro</option>
                                            <option value="Nombre">Nombre</option>
                                            <option value="Modalidad">Modalidad</option>
                                            <option value="Estado">Estado</option>
                                        </select>
                                    </li>
                                    <li>
                                        <div class="d-flex m-0 p-0 bg-light border rounded-end-2">
                                            <div class="input-group">
                                                <input id="busqueda" name="busqueda" type="text"
                                                    class="form-control bg-transparent focus-ring-none border-0 p-2"
                                                    placeholder="Busqueda" aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1">
                                                <button class="bg-light border-0" type="submit" id="button-addon1">
                                                    <svg class="mx-1" width="23" height="23" viewBox="0 0 17 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.2287 10.3421C13.197 9.02083 13.6307 7.38264 13.443 5.7553C13.2554 4.12796 12.4601 2.63149 11.2165 1.56528C9.97285 0.499068 8.37249 -0.0582491 6.73557 0.00482408C5.09866 0.0678972 3.54592 0.746709 2.38801 1.90545C1.23009 3.0642 0.552388 4.61742 0.490486 6.25438C0.428585 7.89134 0.987047 9.49131 2.05415 10.7342C3.12124 11.9771 4.61828 12.7712 6.24576 12.9577C7.87323 13.1442 9.51112 12.7094 10.8317 11.7401H10.8307C10.8607 11.7801 10.8927 11.8181 10.9287 11.8551L14.7787 15.7051C14.9662 15.8928 15.2206 15.9983 15.4859 15.9983C15.7512 15.9984 16.0056 15.8932 16.1932 15.7056C16.3809 15.5181 16.4863 15.2638 16.4864 14.9985C16.4865 14.7332 16.3812 14.4788 16.1937 14.2911L12.3437 10.4411C12.308 10.405 12.2695 10.3725 12.2287 10.3421ZM12.4867 6.49815C12.4867 7.22042 12.3445 7.93562 12.0681 8.60291C11.7917 9.2702 11.3865 9.87651 10.8758 10.3872C10.3651 10.898 9.75879 11.3031 9.0915 11.5795C8.42421 11.8559 7.70901 11.9981 6.98674 11.9981C6.26447 11.9981 5.54927 11.8559 4.88198 11.5795C4.21469 11.3031 3.60837 10.898 3.09765 10.3872C2.58693 9.87651 2.1818 9.2702 1.9054 8.60291C1.629 7.93562 1.48674 7.22042 1.48674 6.49815C1.48674 5.03946 2.0662 3.64051 3.09765 2.60906C4.1291 1.57761 5.52805 0.998147 6.98674 0.998147C8.44543 0.998147 9.84437 1.57761 10.8758 2.60906C11.9073 3.64051 12.4867 5.03946 12.4867 6.49815Z"
                                                            fill="#8A8A8A" />
                                                    </svg>
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
                                        echo "<td class='align-middle'><a href='".rutas::$pathModificarCarrera."?id_carrera=" . $fila["id_carrera"] . "' class='btn btn-custom-edit  '><i class='fas fa-pencil-alt'></i></a></td>";
                                        echo "<td class='align-middle'><a href='".rutas::$pathVerCarrera."?id_carrera=" . $fila["id_carrera"] . "' class='btn btn-custom-view'><i class='fas fa-eye'></i></a></td>";
                                        echo "<td class='align-middle'><a href='".rutas::$pathVerMateriasCarrera."?id_carrera=" . $fila['id_carrera'] . "' class='btn btn-custom-view'><i class='fa-sharp fa-solid fa-list'></i></a></td>";
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