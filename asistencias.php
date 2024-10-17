<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Metadato para que la página sea responsiva en dispositivos móviles. -->
    <title>Asistencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <?php
    // Crea la conexión
    require('./conexion.php'); // Incluye el archivo de la conexión a la base de datos
    include "header.php"; // Incluye el archivo del header principal

    function traerDatos($conn, $sql) {

        $result = $conn->query($sql); // Ejecuta la consulta
        if ($result) { // Verifica 
           // return $result->fetch_all(MYSQLI_ASSOC); // Devuelve resultados
           return $result; }
         else {
            throw new Exception("Error en la consulta SQL: " . $conn->error); // Si falla la consulta
        }
    
    }

    try { // Estructura de manejo de errores
        if (!$conn) { // Si la conexión no se establece
            throw new Exception("Error en la conexión a la base de datos");
        }
        // Obtención de datos provenientes de las respectivas tablas a través de la función "traerDatos"
        $carreras = traerDatos($conn, "SELECT nombre_carrera FROM CARRERA");
        $cursadas = traerDatos($conn, "SELECT anio FROM CURSADA"); // NO
        $materias = traerDatos($conn, "SELECT id_materia, denominacion_materia FROM MATERIA");
        $docentes = traerDatos($conn, "SELECT id_personal, rol_personal, nombre_personal, apellido_personal FROM PERSONAL"); // NO
        // $estudiantes = traerDatos($conn, "SELECT tipo_documento, dni_estudiante, nombre FROM ESTUDIANTES");
        $estudiantes = $conn -> query("SELECT tipo_documento, dni_estudiante, nombre FROM ESTUDIANTES" );

    } catch (Exception $e) {
        $mensaje = $e->getMessage(); // Obtiene el mensaje de error y lo muestra con Bootstrap
        echo "<div class='alert alert-danger'>$mensaje</div>";
    } finally { // Cierra la conexión
        $conn->close();  
    }

    // Obtiene valores enviados por medio de POST. Si no llegan, muestra una cadena vacía. (Todavía sin resolver del todo)
    $id_docente = isset($_POST['docente']) ? $_POST['docente'] : '';
    $nombre_apellido = isset($_POST['nombre_apellido']) ? $_POST['nombre_apellido'] : '';
    $id_materia = isset($_POST['materia']) ? $_POST['materia'] : '';
    $denominacion_materia = isset($_POST['denominacion_materia']) ? $_POST['denominacion_materia'] : '';

    ?>

    <main>
        <div class="d-flex flex-nowrap sidebar-height"> 
            <?php include "sidebar.php"; ?> <!-- Muestra la barra lateral -->
            <div class="col-9 offset-3 bg-light-subtle pt-5"> 
                <div class="d-block p-3 m-4 h-100">
                    <h2 class="card-footer-text mt-2 mb-5 p-2">Asistencias</h2>

                    <form action="procesar_asistencia.php" method="post" class="needs-validation" novalidate> <!-- El formulario envía los datos a procesar_asistencia.php por medio de POST. Inclue validación de Bootstrap-->

                        <div class="mb-3">
                            <label for="ciclo_lectivo" class="form-label">Ciclo Lectivo</label> <!-- Texto del campo -->
                            <input type="text" class="form-control" id="ciclo_lectivo" name="ciclo_lectivo" required readonly> <!-- Identificadores del campo -->
                            <div class="invalid-feedback"> <!-- Mensaje de error en la validación -->
                                Por favor, ingrese el ciclo lectivo.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="carrera" class="form-label">Carrera</label> <!-- Etiqueta para el campo -->
                            <select class="form-select" name="carrera" id="carrera" required> <!-- Lista desplegable para el campo e identificadores de campo -->
                                <option value="">Seleccione una carrera</option> 
                                <?php foreach ($carreras as $carrera): ?> <!-- Itera sobre el vector "carreras" obtenido de la base de datos y crea una opción por cada carrera -->
                                    <option value="<?php echo ($carrera['nombre_carrera']); ?>"> <!-- Valor de la opción -->
                                        <?php echo ($carrera['nombre_carrera']); ?> <!-- Texto que muestra -->
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, seleccione una carrera.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="curso" class="form-label">Curso</label>
                            <select class="form-select" name="curso" id="curso" required>
                                <option value="">Seleccione un curso</option>
                                <?php foreach ($cursadas as $cursada): ?>
                                    <option value="<?php echo ($cursada['anio']); ?>">
                                        <?php echo ($cursada['anio']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, seleccione un curso.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="materia" class="form-label">Materia</label>
                            <select class="form-select" name="materia" id="materia" required>
                                <option value="">Seleccione una materia</option>
                                <?php foreach ($materias as $materia): ?>
                                    <option value="<?php echo ($materia['id_materia']); ?>">
                                        <?php echo ($materia['denominacion_materia']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, seleccione una materia.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rol_personal" class="form-label">Profesor</label>
                            <select class="form-select" name="personal" id="rol_personal" required>
                                <option value="">Seleccione un profesor</option>
                                <?php foreach ($docentes as $personal): ?>
                                    <option value="<?php echo ($personal['id_personal']); ?>">
                                        <?php echo ($personal['nombre_personal']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, seleccione un profesor.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required> <!-- Selecciona fecha a través de calendario -->
                            <div class="invalid-feedback">
                                Por favor, seleccione una fecha.
                            </div>
                        </div>

                        <!-- Campos ocultos, se envían con el formulario. ¿Está funcionando? -->

                        <input type="hidden" name="id_docente" value="<?php echo $id_docente; ?>">
                        <input type="hidden" name="nombre_apellido" value="<?php echo $nombre_apellido; ?>">
                        <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                        <input type="hidden" name="denominacion_materia" value="<?php echo $denominacion_materia; ?>">

                        <!-- Tabla de Estudiantes -->
                        <div class="mb-3">
                            <label for="estudiantes" class="form-label">Estudiantes</label>

                            <!-- Botones para "marcar todos" con estilización -->
                            <div class="d-flex justify-content-end mb-2 gap-2">
                                <button type="button" id="marcar-todos-presentes" class="btn btn-sm btn-outline-success">Presentes(T)</button>
                                <button type="button" id="marcar-todos-ausentes" class="btn btn-sm btn-outline-danger">Ausentes(T)</button>
                                <button type="button" id="marcar-todos-tarde" class="btn btn-sm btn-outline-warning">Tardes(T)</button>
                            </div> 

                            <table class="table table-bordered table-hover table-responsive d-none" id="tabla-estudiantes"> <!-- Clase básica de una tabla con agregados como bordes, filas resaltadas con el cursor, responsive y ocultamiento inicial -->
                                <thead class="table-light"> <!-- Define las columnas -->
                                    <tr>
                                        <th>DNI</th>
                                        <th>Nombre</th>
                                        <th>Presente</th>
                                        <th>Ausente</th>
                                        <th>Tarde</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-estudiantes-body">
                                <?php
                                if ($estudiantes->num_rows > 0) {
                                    $dato_estudiante = array();
                                    while ($row = $estudiantes->fetch_assoc()) {
                                        $dato_estudiante[] = $row;
                                    } }
                                if (($estudintes) > 0) {
                                    foreach ($dato_estudiante as $estudiante): // Itera sobre cada estudiante para crear una fila 
                                ?>
                                        <tr>        
                                            <td><?php echo htmlspecialchars($estudiante['dni_estudiante']); ?></td> <!-- Muestra DNI -->
                                               <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td> <!-- Muestra nombre -->
                                            <td class="text-center"> <!-- Opciones para marcar presente, ausente o tarde -->
                                                <input type="radio" name="asistencia[<?php echo htmlspecialchars($estudiante['dni_estudiante']); ?>]" value="Presente" required>
                                            </td>
                                            <td class="text-center">
                                                <iput type="radio" name="asistencia[<?php echo htmlspecialchars($estudiante['dni_estudiante']); ?>]" value="Ausente">
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="asistencia[<?php echo htmlspecialchars($estudiante['dni_estudiante']); ?>]" value="Tarde">
                                            </td>
                                        </tr>
                                <?php 
                                    endforeach; // Cierra el foreach
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No se encontraron estudiantes.</td></tr>";
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary">Registrar Asistencia</button> <!-- Enviar formulario -->
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Librerías -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-oP9ZBPtW4NG/O8EihkQBEI2gL3V8fEr6ioJPxB3frSSAt0tSTblZw3D6tds6dU8B" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9IbYyI2ZzyuT3iNUy0XtcmM8l9F4Y5du2vs7X6CRl2H5Yk4Z8/J" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script>
    document.addEventListener("DOMContentLoaded", () => { // El script se ejecuta una vez que todo el contenido del DOM fue cargado
        // Cacheo de elementos del DOM. (Almacena referencias a elementos específicos para usarlos sin tener que buscarlos todo el tiempo)
        const cicloLectivoInput = document.getElementById("ciclo_lectivo");
        const selectMateria = document.getElementById("materia");
        const tablaEstudiantes = document.getElementById("tabla-estudiantes");
        const tablaEstudiantesBody = document.getElementById("tabla-estudiantes-body");
        const btnMarcarTodosPresentes = document.getElementById("marcar-todos-presentes");
        const btnMarcarTodosAusentes = document.getElementById("marcar-todos-ausentes");
        const btnMarcarTodosTarde = document.getElementById("marcar-todos-tarde");

        // Establecer el ciclo lectivo automáticamente
        const establecerCicloLectivo = () => {
            const fecha = new Date(); // Obtiene la fecha
            const year = fecha.getFullYear(); // Extrae el año
            cicloLectivoInput.value = `${year}`; // Asigna el valor
        };

        // Función para ocultar la tabla. Añade la clase "d-none"
        const ocultarTablaEstudiantes = () => {
            tablaEstudiantes.classList.add('d-none'); // Añadir clase d-none para ocultar la tabla
        };

        // Función para mostrar la tabla. Borra la clase "d-none"
        const mostrarTablaEstudiantes = () => {
            tablaEstudiantes.classList.remove('d-none'); // Quitar clase d-none para mostrar la tabla
        };

        // Función para crear una fila de estudiante usando Template Literals
        const crearFilaEstudiante = (est) => { // "est" contiene los datos del estudiante
            return `
                <tr>
                    <td>${est.dni_estudiante}</td>
                    <td>${est.nombres}</td>
                    <td class="text-center">
                        <input type="radio" name="asistencia[${est.dni_estudiante}]" value="Presente" id="presente_${est.dni_estudiante}" required>
                        <label for="presente_${est.dni_estudiante}">Presente</label>
                    </td>
                    <td class="text-center">
                        <input type="radio" name="asistencia[${est.dni_estudiante}]" value="Ausente" id="ausente_${est.dni_estudiante}">
                        <label for="ausente_${est.dni_estudiante}">Ausente</label>
                    </td>
                    <td class="text-center">
                        <input type="radio" name="asistencia[${est.dni_estudiante}]" value="Tarde" id="tarde_${est.dni_estudiante}">
                        <label for="tarde_${est.dni_estudiante}">Tarde</label>
                    </td>
                </tr>
            `;
        };

        // Modificar las funciones que cargan estudiantes
        const cargarEstudiantes = (materiaSeleccionada) => {
            const estudiantes = <?php echo json_encode($estudiantes); ?>;

            limpiarTablaEstudiantes(); // Limpia contenido previo de la tabla

            if (estudiantes.length === 0) { // Si no hay estudiantes, hay mensaje de que no se encontraron y oculta la tabla
                tablaEstudiantesBody.innerHTML = "<tr><td colspan='5' class='text-center'>No se encontraron estudiantes.</td></tr>";
                ocultarTablaEstudiantes();
                return;
            }

            mostrarTablaEstudiantes(); // Mostrar la tabla si hay estudiantes

            const filasHTML = estudiantes.map(est => crearFilaEstudiante(est)).join(''); // Crea una cadena HTML con las filas de los estudiantes
            tablaEstudiantesBody.innerHTML = filasHTML; // Inserta las filas en el cuerpo de la tabla
        };

        const limpiarTablaEstudiantes = () => {
            tablaEstudiantesBody.innerHTML = ""; // Elimina el contenido HTML de la tabla
            ocultarTablaEstudiantes(); // Oculta la tabla cuando esté vacía
        };

        // Función para marcar todos los estudiantes
        const marcarTodos = (tipo) => {
            const radios = tablaEstudiantesBody.querySelectorAll(`input[type="radio"][value="${tipo}"]`); // Selecciona todos los botones de radio que tienen el valor especificado "tipo"
            radios.forEach(radio => { // Itera sobre cada radio seleccionado y lo marca
                radio.checked = true;
            });
        };

        // Asignar eventos a los botones. Cuando se hace "click" en alún botón se llama a "marcarTodos" con su respectivo argumento
        btnMarcarTodosPresentes.addEventListener("click", () => marcarTodos('Presente'));
        btnMarcarTodosAusentes.addEventListener("click", () => marcarTodos('Ausente'));
        btnMarcarTodosTarde.addEventListener("click", () => marcarTodos('Tarde'));

        // Asignar evento al cambio de materia
        selectMateria.addEventListener("change", (e) => {
            const materiaSeleccionada = e.target.value; // Obtiene el valor de la materia seleccionada
            if (materiaSeleccionada) { //Si se selecciona una materia, llama a los estudiantes
                cargarEstudiantes(materiaSeleccionada);
            } else {
                limpiarTablaEstudiantes(); // Si no hy materia seleccionada, limpia y esconde la tabla
            }
        });

        // Inicializar ciclo lectivo
        establecerCicloLectivo();

        // Ocultar la tabla de estudiantes al inicio
        ocultarTablaEstudiantes();
    });
    </script>

</body>
</html>
