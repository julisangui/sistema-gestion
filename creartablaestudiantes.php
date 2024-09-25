<?php
require("conexion.php"); // Incluye el archivo de conexión

$db_nombre = 'c1602068_isft225';
$table_name = 'estudiantes';

$check_tabla = "SELECT COUNT(*) > 0 AS table_exists FROM information_schema.tables WHERE table_schema = ? AND table_name = ?";
$check_tabla_stmt = $conn->prepare($check_tabla);
$check_tabla_stmt->bind_param("ss", $db_nombre, $table_name);

$check_tabla_stmt->execute();
$check_tabla_result = $check_tabla_stmt->get_result();

try {

    if ($check_tabla_result->fetch_assoc()['table_exists'] > 0) {
        // La tabla existe, ejecutar la consulta para recuperar el último número autonumérico
        $max_nro_legajo = "SELECT MAX(nro_legajo) AS max_nro_legajo FROM estudiantes";
        $max_legajo_result = $conn->query($max_nro_legajo);

        if ($max_legajo_result->num_rows > 0) {
            // La tabla existe con filas o registros
            // Recuperar el último número autonumérico utilizado
            $row = $max_legajo_result->fetch_assoc();
            $last_nro_legajo = $row["max_nro_legajo"];

            // Incrementar el último número autonumérico utilizado en uno
            $next_nro_legajo = intval(substr($last_nro_legajo, -3)) + 1;

            // Crear el nuevo número de legajo con formato decena-autonumérico
            $year = date("y");
            $new_nro_legajo = $year . "-" . str_pad($next_nro_legajo, 3, "0", STR_PAD_LEFT);
        } else {
            
            // Si no hay registros en la tabla, crear un nuevo número de legajo con formato decena-autonumérico
            $year = date("y");
            $new_nro_legajo = $year . "-001";
        }
    } else {
        // La tabla no existe, crea la tabla en total 37 campos
        $crear_tabla_estudiantes = "CREATE TABLE IF NOT EXISTS estudiantes (
        -- Datos personales 4 datos de identificacion, 3 campos en el frontend
        id_estudiante int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nro_legajo varchar(25) NOT NULL,     
        tipo_documento varchar(10) NOT NULL, 
        dni_estudiante varchar(9) NOT NULL,   
     
       -- Datos personales 11 campos 
        nombres varchar(50) NOT NULL,
        apellidos varchar(50) NOT NULL,
        email varchar(100) NOT NULL, 
        telefono varchar(15) NOT NULL,
        genero varchar(20) NOT NULL,
        fecha_nacimiento date NOT NULL,
        pais_nacimiento varchar(20) NOT NULL,
        lugar_nacimiento varchar(20) NOT NULL,
        familiares_a_cargo tinyint(1) NOT NULL,
        hijos varchar(8) NOT NULL,
        trabaja tinyint(1) NOT NULL,
     
        -- Domicilio 10 campos mas el ID
        id_domicilio varchar(25) DEFAULT NULL,
        pais_dom varchar(20) NOT NULL,
        provincia varchar(20) NOT NULL,
        calle varchar(50) NOT NULL,
        numero varchar(10) NOT NULL,
        edificio varchar(50),
        departamento varchar(10),
        piso int(2),
        partido varchar(50) NOT NULL,
        localidad varchar(50) NOT NULL,
        codigo_postal varchar(10) NOT NULL,
    
         -- Estudios Secundarios 6 campos
        nombre_escuela varchar(100) NOT NULL, 
        titulo_secundario varchar(100) NOT NULL, 
        anio_de_egreso int(4) NOT NULL,
        titulo_certificado varchar(50) NOT NULL, 
        titulo_tecnico tinyint(1) NOT NULL,          
        titulo_hab tinyint(1) NOT NULL,
        -- que nombre le escribo es el campo Certificado título nivel secundario ???
     
        -- Documentación Requerida 6 campos
        documentacion_completa tinyint(1) NOT NULL, 
        repositorio_documentacion varchar(150) DEFAULT NULL,
        plan_carrera varchar(100) NOT NULL,
        estado_inscripcion varchar(10) NOT NULL,
        estado_estudiante varchar(10) NOT NULL,
        observaciones varchar(255) NOT NULL
        )";

        $res_estudiante = $conn->query($crear_tabla_estudiantes);

        // La tabla no existe, crea la tabla en total 10 campos
        $crear_tabla_carreras_adc = "CREATE TABLE IF NOT EXISTS carreras_adicionales (
        -- Estudios Adicionales - Otro Recorrido Académico 10 campos
        id_estudiante int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        carrera varchar(100) DEFAULT NULL,
        institucion varchar(100) DEFAULT NULL,
        estudio_finalizado tinyint(1) DEFAULT NULL,
        anio_de_egreso int(4) DEFAULT NULL,
        titulo_academico varchar(100) DEFAULT NULL,
        carrera_2 varchar(100) DEFAULT NULL,
        institucion_2 varchar(100) DEFAULT NULL,
        estudio_finalizado_2 tinyint(1) DEFAULT NULL,
        anio_de_egreso_2 int(4) DEFAULT NULL,
        titulo_academico_2 varchar(100) DEFAULT NULL,
        FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante)
        )";

        $crear_tabla_estudiante_materia = "CREATE TABLE estudiante_materia (
        id_matricula int(10) UNSIGNED NOT NULL PRIMARY KEY,
        id_estudiante int(10) UNSIGNED NOT NULL,
        id_materia int(10) UNSIGNED NOT NULL,
        FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante),
        FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
        )";

        $crear_tabla_estudiante_carrera = "CREATE TABLE estudiante_carrera (
        id_matricula int(10) UNSIGNED NOT NULL PRIMARY KEY,
        id_estudiante int(10) UNSIGNED NOT NULL,
        id_carrera int(10) UNSIGNED NOT NULL,
        FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante),
        FOREIGN KEY (id_carrera) REFERENCES carrera(id_carrera)
        )";

        $crear_tabla_doc_check = "CREATE TABLE doc_check (
        id_estudiante int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        doc_dni tinyint(1) NOT NULL,
        doc_medica tinyint(1) NOT NULL,
        analitico tinyint(1) NOT NULL,
        doc_nacimiento tinyint(1) NOT NULL,
        FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante)
        )";

        $res_carreras_adc = $conn->query($crear_tabla_carreras_adc);
        $res_estudiante_materia = $conn->query($crear_tabla_estudiante_materia);
        $res_estudiante_carrera = $conn->query($crear_tabla_estudiante_carrera);
        $res_doc_check = $conn->query($crear_tabla_doc_check);

        if (!$res_estudiante || !$res_carreras_adc || !$res_estudiante_materia || !$res_estudiante_carrera || !$res_doc_check) {
            // Código que podría lanzar un error o una excepción
            throw new Exception("¡Error en la creación de las tablas!");
        } else {
            
            // Si no hay registros en la tabla, crear un nuevo número de legajo con formato decena-autonumérico
            $year = date("y");
            $new_nro_legajo = $year . "-001";
                
            echo'<script type="text/javascript"> alert("Conexion exitosa y tablas creadas");
            window.location.href="ingresarestudiantes.php";</script>';
        }
    }
} catch (\Throwable $th) {
    // Manejo de la excepción o el error
    echo "Se capturó este error: " . $th->getMessage();
}

// Cierra las consultas preparadas
$check_tabla_stmt->close();

?>