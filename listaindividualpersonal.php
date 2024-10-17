<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/personal.css">
</head>
 
<body>
    <!--Enlace de conexion-->
    <?php
    require('./conexion.php');

    // Obtener el ID del registro a editar
    if (isset($_GET['id_personal'])) {
        $id_personal = $_GET['id_personal'];

        // Consultar la materia existente
        $sql = "SELECT * FROM personal WHERE id_personal=?";
        //    $sql = "SELECT * FROM personal WHERE id_personal = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_personal);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "Personal no encontrado.";
            exit();
        }
    } else {
        echo "ID de materia no especificado.";
        exit();
    }

    // Obtener los datos del registro actual
    
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $sql = "SELECT *
    FROM personal
    WHERE id_personal =$id_personal";


    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $conn->close();

    // Header sin buscador
    include 'nuevo-header.php';

    ?>

    <main>
        <!-- Contenedor principal -->
        <div class="container-fluid bg-light-subtle pt-3">
            <!-- Aside/Wardrobe/Sidebar Menu -->
            <?php
            
            ?>
            <!-- Fin de sidebar/aside -->
            <!-- Contenedor de ventana de contenido -->
            
                <div class="d-block p-3 m-2 h-100 ">
                    <h3 class="card-footer-text mt-2 mb-3 p-2">Personal</h3>
                    <div class="m-4">
                        <h2 class="text-dark-subtle title">Información solicitada</h2>
                    </div>

                    <div>
                        <h3 class="card-footer-text mt-2 mb-2 p-2 ">Datos personales</h3>

                        <!--Datos personales-->
                        <form class="row g-3 m-4" method="post"
                            action="edicionpersonal.php?id_personal=<?= $id_personal ?>">
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="nombre_personal">Nombre completo*</label>
                                <input class="form-control" type="text" name="nombre_personal" id="nombre_personal"
                                    value="<?= $row['nombre_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="apellido_personal">Apellido
                                    completo*</label>
                                <input class="form-control" type="text" name="apellido_personal" id="apellido_personal"
                                    value="<?= $row['apellido_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="email_personal">Correo electrónico*</label>
                                <input class="form-control" type="text" name="email_personal" id="email_personal"
                                    placeholder="ejemplo@ejemplo.com" value="<?= $row['email_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="telefono_personal">Número de
                                    teléfono*</label>
                                <input class="form-control" type="text" name="telefono_personal" id="telefono_personal"
                                    value="<?= $row['telefono_personal'] ?>" readonly>
                            </div>
                            <div class="col-md position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="tipodoc_personal">Tipo de
                                    documento</label>
                                <input class="form-control" type="text" name="tipodoc_personal" id="tipodoc_personal"
                                    value="<?= $row['tipodoc_personal'] ?>" readonly>

                            </div>
                            <div class="col-md-4  position-relative">
                                <label class="form-label text-black-50" for="nrodni_personal">Número de DNI*</label>
                                <input class="form-control" type="text" name="nrodni_personal" id="nrodni_personal"
                                    value="<?= $row['nrodni_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-4  position-relative">
                                <label class="form-label text-black-50" for="nrocuil_personal">Número de CUIL
                                    (xx-xxxxxxxx-x)*</label>
                                <input class="form-control" type="text" name="nrocuil_personal" id="nrocuil_personal"
                                    value="<?= $row['nrocuil_personal'] ?>" readonly>
                            </div>
                            <div class="col-md position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="sexo_personal">Sexo</label>
                                <input class="form-control" type="text" name="sexo_personal" id="sexo_personal"
                                    value="<?= $row['sexo_personal'] ?>" readonly>

                            </div>

                            <div class="col-md-4  position-relative">
                                <label class="form-label text-black-50" for="fechanac_personal">Fecha de nacimiento
                                    (xx-xx-xxxx)*</label>
                                <input class="form-control" type="text" name="fechanac_personal" id="fechanac_personal"
                                    value="<?= $row['fechanac_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-4  position-relative">
                                <label class="form-label text-black-50" for="paisnac_personal">País de
                                    nacimiento*</label>
                                <input class="form-control" type="text" name="paisnac_personal" id="paisnac_personal"
                                    value="<?= $row['paisnac_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-4  position-relative">
                                <label class="form-label text-black-50" for="lugarnac_personal">Lugar de
                                    nacimiento</label>
                                <input class="form-control" type="text" name="lugarnac_personal" id="lugarnac_personal"
                                    value="<?= $row['lugarnac_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-5  position-relative">
                                <label class="form-label text-black-50" for="fecha_designacion">Fecha de designacion
                                    (xx-xx-xxxx)*</label>
                                <input class="form-control" type="text" name="fecha_designacion" id="fecha_designacion"
                                    value="<?= $row['fecha_designacion'] ?>" readonly>
                            </div>
                            <div class="col-md-4  position-relative">
                                <label class="form-label text-black-50" for="nro_designacion">Número de
                                    designacion</label>
                                <input class="form-control" type="text" name="nro_designacion" id="nro_designacion"
                                    value="<?= $row['nro_designacion'] ?>" readonly>
                            </div>
                            <!--Fin Datos personales-->
                            <!--Domicilio-->
                            <h3 class="card-footer-text mt-2 mb-2 p-2 ">Domicilio</h3>

                            <div class="col-md-6  position-relative">
                                <label class="form-label text-black-50" for="paisdomic_personal">País</label>
                                <input class="form-control" type="text" name="paisdomic_personal"
                                    id="paisdomic_personal" value="<?= $row['paisdomic_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-6  position-relative">
                                <label class="form-label text-black-50" for="provdomic_personal">Provincia</label>
                                <input class="form-control" type="text" name="provdomic_personal"
                                    id="provdomic_personal" value="<?= $row['provdomic_personal'] ?>" readonly>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="calle_personal">Calle</label>
                                <input class="form-control" type="text" name="calle_personal" id="calle_personal"
                                    value="<?= $row['calle_personal'] ?>" readonly>
                            </div>
                            <div class="col-md position-relative">
                                <label class="form-label text-black-50" for="nro_personal">Número </label>
                                <input class="form-control" type="text" name="nro_personal" id="nro_personal"
                                    value="<?= $row['nro_personal'] ?>" readonly>
                            </div>

                            <div class="col-md position-relative">
                                <label class="form-label text-black-50" for="piso_personal">Piso</label>
                                <input class="form-control" type="text" name="piso_personal" id="piso_personal"
                                    value="<?= $row['piso_personal'] ?>" readonly>
                            </div>
                            <div class="col-md position-relative">
                                <label class="form-label text-black-50" for="depto_personal">Dpto</label>
                                <input class="form-control" type="text" name="depto_personal" id="depto_personal"
                                    value="<?= $row['depto_personal'] ?>" readonly>
                            </div>


                            <div class="col-md position-relative">
                                <label class="form-label text-black-50" for="edificio_personal">Edificio</label>
                                <input class="form-control" type="text" name="edificio_personal" id="edificio_personal"
                                    value="<?= $row['edificio_personal'] ?>" readonly>
                            </div>
                            <div class="col-md-5 position-relative">
                                <label class="form-label text-black-50" for="localidad_personal">Localidad</label>
                                <input class="form-control" type="text" name="localidad_personal"
                                    id="localidad_personal" value="<?= $row['localidad_personal'] ?>" readonly>
                            </div>

                            <div class="col-md-5 position-relative">
                                <label class="form-label text-black-50" for="partido_personal">Partido</label>
                                <input class="form-control" type="text" name="partido_personal" id="partido_personal"
                                    value="<?= $row['partido_personal'] ?>" readonly>
                            </div>
                            <div class="col-md position-relative">
                                <label class="form-label text-black-50" for="cp_personal">C.P.</label>
                                <input class="form-control" type="text" name="cp_personal" id="cp_personal"
                                    value="<?= $row['cp_personal'] ?>" readonly>
                            </div>
                            <!--Fin Domicilio-->
                            <!--Titulos académicos-->
                            <h3 class="card-footer-text mt-2 mb-2 p-2 ">Títulos</h3>


                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="titulo">Título de grado*</label>
                                <input class="form-control" type="text" name="titulo" id="titulo"
                                    value="<?= $row['titulo'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="titulo_institucion">Nombre de la
                                    Institucion</label>
                                <input class="form-control" type="text" name="titulo_institucion"
                                    id="titulo_institucion" value="<?= $row['titulo_institucion'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="anio_egreso">Año de egreso (xxxx) *</label>
                                <input class="form-control" type="text" name="anio_egreso" id="anio_egreso"
                                    value="<?= $row['anio_egreso'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="tipo_titulo">Tipo de título docente</label>
                                <input class="form-control" type="text" name="tipo_titulo" id="tipo_titulo"
                                    value="<?= $row['tipo_titulo'] ?>" readonly>
                            </div>
                            <!--Fin Titulos académicos-->
                            <!--Otros recorridos académicos-->
                            <h3 class="card-footer-text mt-2 mb-2 p-2 ">Otro recorrido académico</h3>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="carr1">Carrera</label>
                                <input class="form-control" type="text" name="carr1" id="carr1"
                                    value="<?= $row['carr1'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="carr1_institucion">Institucion</label>
                                <input class="form-control" type="text" name="carr1_institucion" id="carr1_institucion"
                                    value="<?= $row['carr1_institucion'] ?>" readonly>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="carr1_estado">Estudio
                                    finalizado</label>
                                <input class="form-control" type="text" name="carr1_estado" id="carr1_estado"
                                    value="<?= $row['carr1_estado'] ?>" readonly>

                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50" for="carr1_anioegreso">Año de egreso
                                    (xxxx)</label>
                                <input class="form-control" type="text" name="carr1_anioegreso" id="carr1_anioegreso"
                                    value="<?= $row['carr1_anioegreso'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="carr1_titulo">Titulo académico</label>
                                <input class="form-control" type="text" name="carr1_titulo" id="carr1_titulo"
                                    value="<?= $row['carr1_titulo'] ?>" readonly>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="carr2">Carrera</label>
                                <input class="form-control" type="text" name="carr2" id="carr2"
                                    value="<?= $row['carr2'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="carr2_institucion">Institucion</label>
                                <input class="form-control" type="text" name="carr2_institucion" id="carr2_institucion"
                                    value="<?= $row['carr2_institucion'] ?>" readonly>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50 text-nowrap" for="carr2_estado">Estudio
                                    finalizado</label>
                                <input class="form-control" type="text" name="carr2_estado" id="carr2_estado"
                                    value="<?= $row['carr2_estado'] ?>" readonly>

                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label text-black-50" for="carr2_anioegreso">Año de egreso
                                    (xxxx)</label>
                                <input class="form-control" type="text" name="carr2_anioegreso" id="carr2_anioegreso"
                                    value="<?= $row['carr2_anioegreso'] ?>" readonly>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label text-black-50" for="carr2_titulo">Titulo académico</label>
                                <input class="form-control" type="text" name="carr2_titulo" id="carr2_titulo"
                                    value="<?= $row['carr2_titulo'] ?>" readonly>
                            </div>
                            <!--Otros recorridos académicos-->
                            <!--Documentacion-->
                            <h3 class="card-footer-text mt-2 mb-2 p-2 ">Documentación requerida</h3>
                            <div class="col-md-6  position-relative">

                                <h6 class="text-black-50">Documentacion requerida</h6><br>
                                <input type="checkbox" id="cbox1" value="id" />
                                <label for="cbox1">DNI (Frente y dorso)</label> <br>

                                <input type="checkbox" id="cbox2" value="dni" />
                                <label for="cbox2">CV</label> <br>

                                <input type="checkbox" id="cbox3" value="cv" />
                                <label for="cbox3">Constancia de CUIL</label> <br>

                                <input type="checkbox" id="cbox4" value="cuil" />
                                <label for="cbox4">Título de base</label><br>

                                <input type="checkbox" id="cbox5" value="titulobase" />
                                <label for="cbox5">Título docente</label><br>

                                <input type="checkbox" id="cbox6" value="titulodoc" />
                                <label for="cbox6">Proyecto pedagógico</label> <br>

                                <input type="checkbox" id="cbox7" value="DJ" />
                                <label for="cbox7">DDJJ de incompatibilidades</label><br>
                            </div>

                            <div class="col-md-4 checks position-relative">
                                <div class="d-block mb-5 gap-2 align-content-start">
                                    <h6 class="text-black-50">Ingresar archivos</h6><br>
                                    <p class="text-black-50 ">Adjuntar documentación del docente</p>
                                    <a class="" href=#><button
                                            class="btn btn-primary px-4 nav-bar border-0 text-wrap">Adjuntar</button></a>
                                    <br><br>


                                    <a href=#><button
                                            class='btn btn-primary btn-lg menu-icon border-0 px-4'>Ver</button></a>
                                </div>
                            </div>
                            <!--Fin Documentacion-->
                            <!--Situación laboral-->
                            <?php
                            if (isset($POST['estado_personal']) == "licencia" or isset($POST['estado_personal']) == "suplente" or isset($POST['estado_personal']) == "baja")
                                echo "veamos"
                                    ?>


                                <div class="col-md-4 position-relative">
                                    <label class="form-label text-black-50 text-nowrap" for="estado_personal">Estado
                                        Profesor*:</label>
                                    <input class="form-control" type="text" name="estado_personal" id="estado_personal"
                                        value="<?= $row['estado_personal'] ?>" readonly>

                            </div>
                            <div class="col-md-4 position-relative">

                                <label class="form-label text-black-50" for="desde">Desde (xx/xx/xxxx)</label>
                                <input class="form-control" type="text" name="desde" id="desde" readonly>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label text-black-50" for="hasta">Hasta (xx/xx/xxxx)</label>
                                <input class="form-control" type="text" name="hasta" id="hasta" readonly>
                            </div>
                            <!--Fin Situación laboral-->
                            <!--Observaciones-->
                            <div class="col-md-12 position-relative">
                                <label class="form-label text-black-50" for="observaciones">Observaciones</label><br>
                                <textarea name="observaciones" rows="2" cols="130" id="observaciones"></textarea readonly>
                                </div>

                                <!--Fin Observaciones-->

                                <div class="col-md-12 offset-5 ">
                                    <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                        <a href="tablaspersonal.php"><button type="button"
                                                class='btn btn-primary menu-icon border-0 px-4'>Volver</button></a>
                                       
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
    </body>

    </html>