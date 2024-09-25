<?php

require("conexion.php"); // Incluye el archivo de conexión

// Obtener el ID del registro a editar
$id_estudiante = $_GET['id_estudiante'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 34 variables de campos en total
        // Datos personales 14 campos

        $new_nombres = htmlspecialchars(trim($_POST["nombres"]));
        $new_apellido = htmlspecialchars(trim($_POST["apellido"]));
        $new_email = htmlspecialchars(trim($_POST["email"]));
        // Eliminar caracteres invalidos y filtrar email
        $new_correo = filter_var($new_email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("La dirección $new_email no es válida");
        }
        $new_telefono = htmlspecialchars(trim($_POST["telefono"]));
        $new_tipo_documento = htmlspecialchars(trim($_POST["tipo_documento"]));
        $new_nro_documento = htmlspecialchars(trim($_POST["nro_documento"]));
        $new_nro_legajo = htmlspecialchars(trim($_POST["nro_legajo"]));
        $new_genero = htmlspecialchars(trim($_POST["genero"]));
        $new_fecha_nac = htmlspecialchars(trim($_POST["fecha_nac"]));
        $new_pais_nac = htmlspecialchars(trim($_POST["pais_nac"]));
        $new_lugar_nac = htmlspecialchars(trim($_POST["lugar_nac"]));
        $new_familia_cargo = ($_POST["familia_cargo"] === "Si");
        $new_hijos = htmlspecialchars(trim($_POST["hijos"]));
        // echo "Contenido de \$hijos: ";
        // var_dump($new_hijos);
        // exit();
        $new_trabaja = ($_POST["trabaja"] === "Si");

        // Domicilio contacto 10 campos
        $new_pais_dom = htmlspecialchars(trim($_POST["pais_dom"]));
        $new_provincia = htmlspecialchars(trim($_POST["provincia"]));
        $new_localidad = htmlspecialchars(trim($_POST["localidad"]));
        $new_partido = htmlspecialchars(trim($_POST["partido"]));
        $new_calle = htmlspecialchars(trim($_POST["calle"]));
        $new_numero = htmlspecialchars(trim($_POST["numero"]));
        $new_edificio = htmlspecialchars(trim($_POST["edificio"]));
        $new_departamento = htmlspecialchars(trim($_POST["departamento"]));
        $new_piso = htmlspecialchars(trim($_POST["piso"]));
        $new_codigo_postal = htmlspecialchars(trim($_POST["codigo_postal"]));

        // Estudios Secundarios 6 campos
        $new_titulo_secundario = htmlspecialchars(trim($_POST["titulo_secundario"]));
        $new_nombre_escuela = htmlspecialchars(trim($_POST["nombre_escuela"]));
        $new_anio_egreso = htmlspecialchars(trim($_POST["anio_egreso"]));
        $new_titulo_certificado = htmlspecialchars(trim($_POST["titulo_certificado"]));
        $new_titulo_tecnico = ($_POST["titulo_tecnico"] === "Si");
        $new_titulo_hab = ($_POST["titulo_hab"] === "Si");

        // Estudios Adicionales - Otro Recorrido Académico 5 campos Opcionales
        // Verifica si los campos existen y no están vacíos antes de guardarlos en variables
        $new_carreras = $new_instituciones = $new_estudios_finalizados = $new_anios_egresos2 = $new_titulos_academicos = array_fill(0, 2, null);
        if (!empty($_POST["carrera"]) && is_array($_POST["carrera"])) {
            $maxcarrera = count($_POST["carrera"]);

            for ($i = 0; $i < $maxcarrera; $i++) {
                $new_carreras[$i] = isset($_POST['carrera'][$i]) ? htmlspecialchars(trim($_POST["carrera"][$i])) : null;
                $new_instituciones[$i] = isset($_POST["institucion"][$i]) ? htmlspecialchars(trim($_POST["institucion"][$i])) : null;
                $new_estudios_finalizados[$i] = ($_POST["estudio_finalizado"][$i] === "Si");
                $new_anios_egresos2[$i] = (isset($_POST["anio_egreso2"][$i]) && ctype_digit($_POST["anio_egreso2"][$i])) ? $_POST["anio_egreso2"][$i] : null;
                $new_titulos_academicos[$i] = isset($_POST["titulo_academico"][$i]) ? htmlspecialchars(trim($_POST["titulo_academico"][$i])) : null;
            }
        }

        // Documentacion requerida 9 campos
        $new_doc_dni = isset($_POST['doc_dni']);
        $new_doc_medica = isset($_POST['doc_medica']);
        $new_doc_analitico = isset($_POST['doc_analitico']);
        $new_doc_nacimiento = isset($_POST['doc_nacimiento']);

        // Documentación Requerida / 1 campo en tabla de la base de datos
        if (isset($_POST['doc_dni']) && isset($_POST['doc_medica']) && isset($_POST['doc_analitico']) && isset($_POST['doc_nacimiento'])) {
            $new_doc_completa = true;
        } else {
            $new_doc_completa = false;
        }

        $new_archivos = $_FILES["adjunto"];
        $new_plan_carrera = htmlspecialchars(trim($_POST["plan_carrera"]));
        $new_estado_inscripcion = htmlspecialchars(trim($_POST["estado_inscripcion"]));
        $new_estado_estudiante = htmlspecialchars(trim($_POST["estado_estudiante"]));
        $new_observaciones = htmlspecialchars(trim($_POST["observaciones"]));

        // Sentencia SQL para actualizar los datos en la tabla estudiantes
        // Crear una consulta preparada

        $up_estudiante = 
        "UPDATE estudiantes SET
        tipo_documento = ?,
        dni_estudiante = ?,
        nombres = ?,
        apellidos = ?,
        email = ?,
        telefono = ?,
        genero = ?,
        fecha_nacimiento = ?,
        pais_nacimiento = ?,
        lugar_nacimiento = ?,
        familiares_a_cargo = ?,
        hijos = ?,
        trabaja = ?,
        pais_dom = ?,
        provincia = ?,
        calle = ?,
        numero = ?,
        piso = ?,
        departamento = ?,
        edificio = ?,
        partido = ?,
        localidad = ?,
        codigo_postal = ?,
        nombre_escuela = ?,
        titulo_secundario = ?,
        anio_de_egreso = ?,
        titulo_certificado = ?,
        titulo_tecnico = ?,
        titulo_hab = ?,
        documentacion_completa = ?,
        plan_carrera = ?,
        estado_inscripcion = ?,
        estado_estudiante = ?,
        observaciones = ?
        WHERE id_estudiante = ?";

        /*sobre doc_completa va repositorio_documentacion = ?,*/
        
        //DEPURAR CONSULTA PREPARADA 

        $stmt_up_estudiante = $conn->prepare($up_estudiante);

        if (!$stmt_up_estudiante) {
            throw new Exception("Error al preparar la consulta preparada para actualizar estudiantes.");
        }

        // Vincular los parámetros con los valores  "sssssssssssiiissssisssssssisiiisssssi", original con todas las celdas /*$new_archivos,*/ debajo de doc completa
        $stmt_up_estudiante->bind_param(
            "ssssssssssiiissssisssssssisiiissssi",
            $new_tipo_documento,
            $new_nro_documento,
            $new_nombres,
            $new_apellido,
            $new_correo,
            $new_telefono,
            $new_genero,
            $new_fecha_nac,
            $new_pais_nac,
            $new_lugar_nac,
            $new_familia_cargo,
            $new_hijos,
            $new_trabaja,
            $new_pais_dom,
            $new_provincia,
            $new_calle,
            $new_numero,
            $new_piso,
            $new_departamento,
            $new_edificio,
            $new_partido,
            $new_localidad,
            $new_codigo_postal,
            $new_nombre_escuela,
            $new_titulo_secundario,
            $new_anio_egreso,
            $new_titulo_certificado,
            $new_titulo_tecnico,
            $new_titulo_hab,
            $new_doc_completa,
            $new_plan_carrera,
            $new_estado_inscripcion,
            $new_estado_estudiante,
            $new_observaciones,
            $id_estudiante
        );

        // Ejecutar la consulta preparada
        if (!$stmt_up_estudiante->execute()) {
            throw new Exception("Error al insertar los datos: " . $stmt_up_estudiante->error);
        }

        $up_carreras = "UPDATE carreras_adicionales 
                        SET carrera = ?, institucion = ?, estudio_finalizado = ?, anio_de_egreso = ?, titulo_academico = ?,
                        carrera_2 = ?, institucion_2 = ?, estudio_finalizado_2 = ?, anio_de_egreso_2 = ?, titulo_academico_2 = ? 
                        WHERE id_estudiante = ?";

        $stmt_up_carreras = $conn->prepare($up_carreras);

        if (!$stmt_up_carreras) {
            throw new Exception("Error al preparar la consulta preparada para actualizar carreras_adicionales.");
        }

        $stmt_up_carreras->bind_param(
            "ssiisssiisi",
            $new_carreras[0],
            $new_instituciones[0],
            $new_estudios_finalizados[0],
            $new_anios_egresos2[0],
            $new_titulos_academicos[0],
            $new_carreras[1],
            $new_instituciones[1],
            $new_estudios_finalizados[1],
            $new_anios_egresos2[1],
            $new_titulos_academicos[1],
            $id_estudiante
        );

        // Ejecutar la consulta preparada
        if (!$stmt_up_carreras->execute()) {
            throw new Exception("Error al insertar los datos: " . !$stmt_up_carreras->error);
        }

        // Preparar la consulta SQL con marcadores de posición agregar a SET COMO EN INSERT id_estudiante = ?,
        $up_cbox = "UPDATE doc_check 
        SET doc_dni = ?, doc_medica = ?, analitico = ?, doc_nacimiento = ? 
        WHERE id_estudiante = ?";

        // Preparar la consulta
        $stmt_up_cbox = $conn->prepare($up_cbox);

        if (!$stmt_up_cbox) {
            throw new Exception("Error al preparar la consulta preparada para actualizar doc_check.");
        }

        // Vincular los parámetros(valores) a los marcadores de posición
        $stmt_up_cbox->bind_param(
            "iiiii",
            $id_estudiante,
            $new_doc_dni,
            $new_doc_medica,
            $new_doc_analitico,
            $new_doc_nacimiento
        );

        // Ejecutar la consulta preparada
        if (!$stmt_up_cbox->execute()) {
            throw new Exception("Error al insertar los datos: " . $stmt_up_cbox->error);
        } 

        // Cerrar la consulta preparada
        $stmt_up_estudiante->close();
        $stmt_up_carreras->close();
        $stmt_up_cbox->close();
        // Cierra la conexión a la base de datos
        $conn->close();

        header("Location: tablaestudiantes.php");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    /*  header("Location: editar.php"); */
}
?>