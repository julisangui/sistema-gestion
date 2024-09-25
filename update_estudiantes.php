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
        $new_correo = htmlspecialchars(trim($_POST["correo"]));
        $new_telefono = htmlspecialchars(trim($_POST["telefono"]));
        $new_tipo_documento = htmlspecialchars(trim($_POST["tipo_documento"]));
        $new_nro_documento = htmlspecialchars(trim($_POST["nro_documento"])); // dni_estudiante
        $new_nro_legajo = htmlspecialchars(trim($_POST["nro_legajo"]));
        $new_genero = htmlspecialchars(trim($_POST["genero"]));
        $new_fecha_nac = htmlspecialchars(trim($_POST["fecha_nac"]));
        $new_pais_nac = htmlspecialchars(trim($_POST["pais_nac"]));
        $new_lugar_nac = htmlspecialchars(trim($_POST["lugar_nac"]));
        $new_familia_cargo = htmlspecialchars(trim($_POST["familia_cargo"]));
        $new_hijos = htmlspecialchars(trim($_POST["hijos"]));
        $new_trabaja = htmlspecialchars(trim($_POST["trabaja"]));

        // Domicilio contacto 10 campos

        $new_pais_dom = htmlspecialchars(trim($_POST["pais_dom"]));
        $new_provincia = htmlspecialchars(trim($_POST["provincia"]));
        $new_localidad = htmlspecialchars(trim($_POST["localidad"]));
        $new_partido = htmlspecialchars(trim($_POST["partido"]));
        $new_calle = htmlspecialchars(trim($_POST["calle"]));
        $new_numero = htmlspecialchars(trim($_POST["numero"]));
        $new_edificio = htmlspecialchars(trim($_POST["edificio"]));
        $new_piso = htmlspecialchars(trim($_POST["piso"]));
        $new_departamento = htmlspecialchars(trim($_POST["departamento"]));
        $new_codigo_postal = htmlspecialchars(trim($_POST["codigo_postal"]));

        // Estudios Secundarios 6 campos

        $new_titulo_secundario = htmlspecialchars(trim($_POST["titulo_secundario"]));
        $new_nombre_escuela = htmlspecialchars(trim($_POST["nombre_escuela"]));
        $new_anio_egreso = htmlspecialchars(trim($_POST["anio_egreso"]));
        $new_certificado = htmlspecialchars(trim($_POST["certificado"]));
        $new_titulo_tecnico = htmlspecialchars(trim($_POST["titulo_tecnico"]));
        $new_titulo_hab = htmlspecialchars(trim($_POST["titulo_hab"]));

        // Documentación Requerida 4 campos

        $new_doc_dni = isset($_POST['doc_dni']);
        $new_doc_medica = isset($_POST['doc_medica']);
        $new_analitico = isset($_POST['analitico']);
        $new_doc_nac = isset($_POST['doc_nac']);

        $new_adjunto = htmlspecialchars(trim($_POST["adjunto"]));
        $new_plan_carrera = htmlspecialchars(trim($_POST["plan_carrera"]));
        $new_estado_inscripcion = htmlspecialchars(trim($_POST["estado_inscripcion"]));
        $new_estado_estudiante = htmlspecialchars(trim($_POST["estado_estudiante"]));
        $new_observaciones = htmlspecialchars(trim($_POST["observaciones"]));

        // Verifica si los campos existen y no están vacíos antes de asignarlos a las variables- 5 campos
        if (isset($_POST['carrera']) && !empty($_POST['carrera'])) {
            $new_carreras = array_map('htmlspecialchars', array_map('trim', $_POST["carrera"]));
            $new_instituciones = array_map('htmlspecialchars', array_map('trim', $_POST["institucion"]));
            $new_estudios_finalizados = array_map('htmlspecialchars', array_map('trim', $_POST["estudio_finalizado"]));
            $new_anios_egresos2 = array_map('htmlspecialchars', array_map('trim', $_POST["anio_egreso2"]));
            $new_titulos_academicos = array_map('htmlspecialchars', array_map('trim', $_POST["titulo_academico"]));
        } /* else {
            $new_carreras = $new_instituciones = $new_estudios_finalizados = $new_anios_egresos2 = $new_titulos_academicos = array_fill(0, 2, "");
        } */

        // Documentación Requerida 2 booleanos y 4 campos
        if ($new_doc_dni && $new_doc_medica && $new_analitico && $new_doc_nac) {
            $new_doc_completa = true;
        } else {
            $new_doc_completa = false;
        }

        // Sentencia SQL para actualizar los datos en la tabla estudiantes
        // Crear una consulta preparada

        $sql_up_estudiante = $conn->prepare(
            "UPDATE estudiantes SET
            nro_legajo = ?,
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
            localidad = ?,
            partido = ?,
            codigo_postal = ?,
            nombre_escuela = ?,
            titulo_secundario = ?,
            anio_de_egreso = ?,
            titulo_certificado = ?,
            titulo_tecnico = ?,
            titulo_hab = ?,
            documentacion_completa = ?,
            repositorio_documentacion = ?,
            plan_carrera = ?,
            estado_inscripcion = ?,
            estado_estudiante = ?,
            observaciones = ?
            WHERE id_estudiante = ?"
        );

        $stmt_up_estudiante = $conn->prepare($sql_up_estudiante);

        if (!$stmt_up_estudiante) {
            throw new Exception("Error al preparar la consulta.");
        }

        // Vincular los parámetros con los valores
        $stmt_up_estudiante->bind_param(
            "sssssssssssiiissssisssssssisiiisssssi",
            $new_nombres,
            $new_apellido,
            $new_correo,
            $new_telefono,
            $new_tipo_documento,
            $new_nro_documento,
            $new_nro_legajo,
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
            $new_localidad,
            $new_partido,
            $new_codigo_postal,
            $new_nombre_escuela,
            $new_titulo_secundario,
            $new_anio_egreso,
            $new_certificado,
            $new_titulo_tecnico,
            $new_titulo_hab,
            $new_doc_completa,
            $new_adjunto,
            $new_plan_carrera,
            $new_estado_inscripcion,
            $new_estado_estudiante,
            $new_observaciones,
            $id_estudiante
        );

        $sql_up_carreras = $conn->prepare("UPDATE carreras_adicionales
            SET carrera = ?, institucion = ?, estudio_finalizado = ?, anio_de_egreso = ?, titulo_academico = ?, carrera_2 = ?, institucion_2 = ?, estudio_finalizado_2 = ?, anio_de_egreso_2 = ?, titulo_academico_2 = ?
            WHERE id_estudiante = ?"
        );

        // Preparar la consulta
        $stmt_up_carreras = $conn->prepare($sql_up_carreras);

        if (!$stmt_up_carreras) {
            throw new Exception("Error al preparar la consulta.");
        }

        // Vincular los parámetros(valores) a los marcadores de posición
        $stmt_up_carreras->bind_param(
            "ssissssiss",
            $new_carreras[0],
            $new_instituciones[0],
            $new_estudios_finalizados[0],
            $new_anios_egreso2[0],
            $new_titulos_academicos[0],
            $new_carreras[1],
            $new_instituciones[1],
            $new_estudios_finalizados[1],
            $new_anios_egreso2[1],
            $new_titulos_academicos[1],
            $id_estudiante
        );

        // Preparar la consulta SQL con marcadores de posición
        $sql_up_checkboxes  = $conn->prepare("UPDATE doc_check
            SET doc_dni = ?, doc_medica = ?, analitico = ?, doc_nac = ?
            WHERE id_estudiante = ?;"
        );

        // Preparar la consulta
        $stmt_up_checkboxes = $conn->prepare($sql_up_checkboxes);

        if (!$stmt_up_checkboxes) {
            throw new Exception("Error al preparar la consulta.");
        }

        // Vincular los parámetros(valores) a los marcadores de posición
        $stmt_up_checkboxes->bind_param("iiiii", $new_doc_dni, $new_doc_medica, $new_analitico, $new_doc_nac, $id_estudiante);

        // Ejecutar la consulta preparada
        if ($stmt_up_estudiante->execute() && $stmt_up_carreras->execute() && $stmt_up_checkboxes->execute()) {
            header("Location: /app/tablaestudiantes.php");
            //echo "Los datos se han actualizado con éxito.";
        } else {
            throw new Exception("Error al insertar los datos: " . $stmt_up_estudiante->error);
        }

        // Cerrar la consulta preparada
        $stmt_up_estudiante->close();
        $stmt_up_carreras->close();
        $stmt_up_checkboxes->close();
        // Cierra la conexión a la base de datos
        $conn->close();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    /*  header("Location: editar.php"); */
}
?>