<?php
require("conexion.php"); // Incluye el archivo de conexión
include "creartablaestudiantes.php";  
include "./api/google-api-php-client--PHP7.4/vendor/autoload.php";

//mysqli_report(MYSQLI_REPORT_ERROR); 
$conn->set_charset("utf8");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 41 campos - 5 campos -- 1 campo del legajo y 4 booleanos = 36 variables usadas en total
        // Datos personales 14 campos

        $nombres = htmlspecialchars(trim($_POST["nombres"]));
        $apellido = htmlspecialchars(trim($_POST["apellido"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        // Eliminar caracteres invalidos y filtrar email
        $correo = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("La dirección $email no es válida");
        }  
        $telefono = htmlspecialchars(trim($_POST["telefono"]));
        $tipo_documento = htmlspecialchars(trim($_POST["tipo_documento"]));
        $nro_documento = htmlspecialchars(trim($_POST["nro_documento"]));
        //$nro_legajo = htmlspecialchars(trim($_POST["nro_legajo"]));
        $genero = htmlspecialchars(trim($_POST["genero"]));
        $fecha_nac = htmlspecialchars(trim($_POST["fecha_nac"]));
        $pais_nac = htmlspecialchars(trim($_POST["pais_nac"]));
        $lugar_nac = htmlspecialchars(trim($_POST["lugar_nac"]));
        $familia_cargo = ($_POST["familia_cargo"] === "Si");
        $hijos = htmlspecialchars(trim($_POST["hijos"]));
        $trabaja = ($_POST["trabaja"] === "Si");

        // Domicilio contacto 10 campos
        $pais_dom = htmlspecialchars(trim($_POST["pais_dom"]));
        $provincia = htmlspecialchars(trim($_POST["provincia"]));
        $localidad = htmlspecialchars(trim($_POST["localidad"]));
        $partido = htmlspecialchars(trim($_POST["partido"]));
        $calle = htmlspecialchars(trim($_POST["calle"]));
        $numero = htmlspecialchars(trim($_POST["numero"]));
        $edificio = htmlspecialchars(trim($_POST["edificio"]));
        $piso = htmlspecialchars(trim($_POST["piso"]));
        $departamento = htmlspecialchars(trim($_POST["departamento"]));
        $codigo_postal = htmlspecialchars(trim($_POST["codigo_postal"]));

        // Estudios Secundarios 6 campos
        $titulo_secundario = htmlspecialchars(trim($_POST["titulo_secundario"]));
        $nombre_escuela = htmlspecialchars(trim($_POST["nombre_escuela"]));
        $anio_egreso = htmlspecialchars(trim($_POST["anio_egreso"]));
        $titulo_certificado = htmlspecialchars(trim($_POST["titulo_certificado"]));
        $titulo_tecnico = ($_POST["titulo_tecnico"] === "Si");
        $titulo_hab = ($_POST["titulo_hab"] === "Si");

        // Estudios Adicionales - Otro Recorrido Académico 5 campos Opcionales
        // Verifica si los campos existen y no están vacíos antes de guardarlos en variables
        $carreras = $instituciones = $estudios_finalizados = $anios_egresos2 = $titulos_academicos = array_fill(0, 2, null);
        if (!empty($_POST["carrera"]) && is_array($_POST["carrera"])) {
            $maxcarrera = count($_POST["carrera"]);
                   
            for ($i = 0; $i < $maxcarrera; $i++) {
                $carreras[$i] = isset($_POST['carrera'][$i]) ? htmlspecialchars(trim($_POST["carrera"][$i])) : null;
                $instituciones[$i] = isset($_POST["institucion"][$i]) ? htmlspecialchars(trim($_POST["institucion"][$i])) : null;
                $estudios_finalizados[$i] = ($_POST["estudio_finalizado"][$i] === "Si");
                $anios_egresos2[$i] = (isset($_POST["anio_egreso2"][$i]) && ctype_digit($_POST["anio_egreso2"][$i])) ? $_POST["anio_egreso2"][$i] : null;
                $titulos_academicos[$i] = isset($_POST["titulo_academico"][$i]) ? htmlspecialchars(trim($_POST["titulo_academico"][$i])) : null;
            }
        }

        // Documentacion requerida 9 campos
        $doc_dni = isset($_POST['doc_dni']);
        $doc_medica = isset($_POST['doc_medica']);
        $doc_analitico = isset($_POST['doc_analitico']);
        $doc_nacimiento = isset($_POST['doc_nacimiento']);

        // Después de llenar los arrays

       /*  echo "Contenido de \$doc_dni: ";
        var_dump($doc_dni);

        echo "Contenido de \$doc_medica: ";
        var_dump($doc_medica);

        echo "Contenido de \$doc_analitico: ";
        var_dump($doc_analitico);

        echo "Contenido de \$doc_nacimiento: ";
        var_dump($doc_nacimiento);

        exit();
        die(); 
        */

        // Documentación Requerida / 1 campo en tabla de la base de datos
        if (isset($_POST['doc_dni']) && isset($_POST['doc_medica']) && isset($_POST['doc_analitico']) && isset($_POST['doc_nacimiento'])) {
            $doc_completa = true;
        } else {
            $doc_completa = false;
        }

        $archivos = $_FILES["adjunto"];
        $plan_carrera = htmlspecialchars(trim($_POST["plan_carrera"]));
        $estado_inscripcion = htmlspecialchars(trim($_POST["estado_inscripcion"]));
        $estado_estudiante = htmlspecialchars(trim($_POST["estado_estudiante"]));
        $observaciones = htmlspecialchars(trim($_POST["observaciones"]));

        try {
                    
            /*Funciona bien pero hay un problema repeti codigo por que no subiae a drive la imagen, 
              no es el tipo de archivo a pesar de que el MimeType de la imagen es solo png 
              Primero se crea el objeto de tipo carpeta y luego el de tipo imagen, tuve que hacer un if (count) list y volver a crear la 
              carpeta por que nose creaba, puede que el error este en que no guardo en variable el primer files->create() no estoy seguro
              por que despues guardo en la variable subfolder el files->create() y no vuelvo a usar esa variable, 
              al final asigno id a la carpeta quizas es este el error de no asignar id al principio antes del if arreglar *** */

            $ruta_archivo = "https://drive.google.com/open?id=";

            // ID de la carpeta "images"
            $carpeta_raiz_id = "1MG8j4iMAMCsXirLqyHkPY3qqjWxwD6IR";

            // conexion Api PHP 8.0
            /* $cliente = new Google_Client();
            $cliente->setAuthConfig('hardmente.json');
            $cliente->addScope(Google_Service_Drive::DRIVE); */

              // conexion Api PHP 7.4
             putenv('GOOGLE_APPLICATION_CREDENTIALS=hardmente.json');
             $cliente = new Google_Client();
             $cliente->useApplicationDefaultCredentials();
             $cliente->setScopes(['https://www.googleapis.com/auth/drive.file']);

            $servicio = new Google_Service_Drive($cliente);

            // Crear objeto subcarpeta
            $subcarpeta = new Google_Service_Drive_DriveFile(); // arreglar ***
            $subcarpeta->setName($new_nro_legajo);
            $subcarpeta->setMimeType('application/vnd.google-apps.folder');
            $subcarpeta->setParents([$carpeta_raiz_id]); // Al crear settear el parent carpeta padre

            // Crear subcarpeta
            $servicio->files->create($subcarpeta,array('fields' => 'id'));

            // Nombre de la carpeta
            $subcarpeta_name = $new_nro_legajo;

            // Listar archivos y buscar la carpeta
            $list_carpetas = $servicio->files->listFiles([
                'q' => "name = '$subcarpeta_name' and mimeType = 'application/vnd.google-apps.folder'",
                'spaces' => 'drive',
                'fields' => 'files(id)'
            ]);

            // Si no existe, crearla
            if (count($list_carpetas->getFiles()) == 0) {
                // Creando objeto carpeta
                $subcarpeta = new Google_Service_Drive_DriveFile( // arreglar ***
                    array(
                        'name' => $subcarpeta_name,
                        'mimeType' => 'application/vnd.google-apps.folder'
                    )
                );

                // Creando carpeta en drive
                $subfolder = $servicio->files->create($subcarpeta, array('fields' => 'id'));

                $subcarpeta_id = $subcarpeta->id;
            } else {
                $subcarpeta_id = $list_carpetas->getFiles()[0]->getId();
            }

            // Setear el parent al crear el archivo
            $subcarpeta->setParents([$carpeta_raiz_id]);

            // Iterar a través de los enviados desde el forumulario
            foreach ($archivos["name"] as $key => $nombre_archivo) {
                if (isset($archivos["name"][$key])) {
                    $archivo_temporal = $archivos["tmp_name"][$key];
                }

                // Subir el archivo a la subcarpeta / $archivos_up = $archivos;
                $archivos_drive = new Google_Service_Drive_DriveFile(); // arreglar ***
                $archivos_drive->setName($nombre_archivo);
                $archivos_drive->setParents([$subcarpeta_id]);

                $resultado = $servicio->files->create(
                    $archivos_drive,
                    array(
                        'data' => file_get_contents($archivo_temporal),
                        'mimeType' => 'image/png', // MimeType de la imagen solo es png 
                        'uploadType' => 'media'
                    )
                );

                //echo 'El archivo ' . $nombre_archivo . ' se ha subido a Google Drive.<br>';
                //echo '<a href="https://drive.google.com/open?id=' . $resultado->id . '" target="_blank">' . $resultado->name . '</a>';
            }

        } catch (Google_Service_Exception $gs) {
            $mensaje = json_decode($gs->getMessage());
            echo $mensaje->error->message();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        // 1 campo en la tabla
        $ruta_archivo = $ruta_archivo . $subcarpeta_id;
        //$ruta_archivo = "";

        // Sentencia SQL para insertar los datos en la tabla estudiante 36 campos -- 1. Agregar un nuevo estudiante en la tabla estudiantes
        // Crear una consulta preparada
        $insert_estudiantes = "INSERT INTO estudiantes (nro_legajo, tipo_documento, dni_estudiante, nombres, apellidos, email, telefono, genero, fecha_nacimiento, pais_nacimiento, lugar_nacimiento,
        familiares_a_cargo, hijos, trabaja, pais_dom, provincia, calle, numero, piso, departamento, edificio, localidad, partido,
        codigo_postal, nombre_escuela, titulo_secundario, anio_de_egreso, titulo_certificado, titulo_tecnico, titulo_hab, documentacion_completa, repositorio_documentacion, plan_carrera, estado_inscripcion, estado_estudiante, observaciones
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";      

        $stmt_ins_est = $conn->prepare($insert_estudiantes);
        if (!$stmt_ins_est) {
            throw new Exception("Error al preparar la consulta.");
        } 

        // Vincular los parámetros con los valores 41 datos
        $stmt_ins_est->bind_param(
            "sssssssssssiiissssisssssssisiiisssss",
            /* 14 datos */
            $new_nro_legajo,
            $tipo_documento,
            $nro_documento,
            $nombres,
            $apellido,
            $correo,
            $telefono,
            $genero,
            $fecha_nac,
            $pais_nac,
            $lugar_nac,
            $familia_cargo,
            $hijos,
            $trabaja,
            /*  $id_domicilio, */
            /* 10 datos */
            $pais_dom,
            $provincia,
            $calle,
            $numero,
            $piso,
            $departamento,
            $edificio,
            $localidad,
            $partido,
            $codigo_postal,
            /* 6 datos */
            $nombre_escuela,
            $titulo_secundario,
            $anio_egreso,
            $titulo_certificado,
            $titulo_tecnico,
            $titulo_hab,
            /* 6 datos */
            $doc_completa,
            $ruta_archivo,
            $plan_carrera,
            $estado_inscripcion,
            $estado_estudiante,
            $observaciones
        );
        // Ejecutar la consulta preparada
        if (!$stmt_ins_est->execute()) {
            throw new Exception("Error al insertar los datos: " . $stmt_ins_est->error);
        }
        //2. Obtener el id_estudiante del último estudiante insertado
        $max_id = $conn->insert_id;

        // Crear una consulta preparada
        $insert_ca = "INSERT INTO carreras_adicionales (id_estudiante, carrera, institucion, estudio_finalizado, anio_de_egreso, titulo_academico, 
        carrera_2, institucion_2, estudio_finalizado_2, anio_de_egreso_2, titulo_academico_2
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_ins_ca = $conn->prepare($insert_ca);

        if (!$stmt_ins_ca) {
            throw new Exception("Error al preparar la consulta.");
        }

        // Vincular los parámetros(valores) a los marcadores de posición
        $stmt_ins_ca->bind_param(
            "issiisssiis",
            $max_id,
            $carreras[0],
            $instituciones[0],
            $estudios_finalizados[0],
            $anios_egresos2[0],
            $titulos_academicos[0],
            $carreras[1],
            $instituciones[1],
            $estudios_finalizados[1],
            $anios_egresos2[1],
            $titulos_academicos[1]
        );

        // Ejecutar la consulta preparada
        if (!$stmt_ins_ca->execute()) {
            throw new Exception("Error al insertar los datos: " . $stmt_ins_ca->error);
        }

         // Preparar la consulta SQL con marcadores de posición
         $insert_cbox = "INSERT INTO doc_check (id_estudiante, doc_dni, doc_medica, analitico, doc_nacimiento) VALUES (?, ?, ?, ?, ?)";

         // Preparar la consulta
         $stmt_ins_cbox = $conn->prepare($insert_cbox);
 
         if (!$stmt_ins_cbox) {
             throw new Exception("Error al preparar la consulta checkboxes.");
         }
 
         // Vincular los parámetros(valores) a los marcadores de posición
         $stmt_ins_cbox->bind_param("iiiii", $max_id, $doc_dni, $doc_medica, $doc_analitico, $doc_nacimiento);
 
         // Ejecutar la consulta preparada
         if (!$stmt_ins_cbox->execute()) {
             throw new Exception("Error al insertar los datos en la tabla doc_check: " . $stmt_ins_cbox->error);
         } 

    }
} catch (\Throwable $th) {
    // Manejo de la excepción o el error
    echo "Se capturó este error: " . $th->getMessage();
}


header("Location: tablaestudiantes.php");
//echo "<br>Los datos se han insertado con éxito.";

// Cerrar la consulta preparada
$stmt_ins_est->close();
$stmt_ins_ca->close();
$stmt_ins_cbox->close();

// Cierra la conexión a la base de datos
$conn->close();
?>