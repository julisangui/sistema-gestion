<?php

/* Debugging: Verificar los datos que llegan a través del formulario
echo "<pre>";
print_r($_POST); // Muestra todo lo que llega por el formulario
echo "</pre>"; */

// Conexión a la base de datos
require('./conexion.php');

// Asignar variables. Se accede a los datos enviados del formulario por medio de POST
$ciclo_lectivo = $_POST['ciclo_lectivo'];
$carrera = $_POST['carrera'];
$fecha = $_POST['fecha'];
$id_docente = $_POST['docente'];
$nombre_apellido = $_POST['nombre_apellido'];
$id_materia = $_POST['materia'];
$denominacion_materia = $_POST['denominacion_materia'];
$asistencias = $_POST['asistencia']; // Este es un vector

// Contadores y errores
$asistencias_guardadas = 0; // Cuenta las asistencias guardadas en la base de datos
$errores = []; // Almacena mensajes de error

// Iniciar transacción
$conn->begin_transaction();

try {
    // Prepara la sentencia para obtener el nombre del estudiante
    $sql_estudiante = "SELECT nombre FROM ESTUDIANTES WHERE dni_estudiante = ?"; // Consulta SQL para obtener nombre a través de DNI
    $stmt_estudiante = $conn->prepare($sql_estudiante); // Prepara la consulta SQL
    if (!$stmt_estudiante) { // Si la preparación falla, manda mensaje de error
        throw new Exception("Error al preparar la consulta de selección del estudiante: " . $conn->error);
    }

    // Prepara la sentencia de inserción
    $sql_insert = "INSERT INTO ASISTENCIAS (ciclo_lectivo, carrera, fecha, id_docente, nombre_apellido, tipo_asistencia, id_materia, denominacion_materia, nombre, dni_estudiante)  
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // Consulta para insertar asistencias en la tabla ASISTENCIAS. Igualdad de parámetros con valores
    $stmt_insert = $conn->prepare($sql_insert); // Comprueba la preparación de la consulta. Si falla lanza error
    if (!$stmt_insert) {
        throw new Exception("Error al preparar la consulta de inserción: " . $conn->error);
    }

    // Asistencias
    foreach ($asistencias as $dni_estudiante => $tipo_asistencia) { // Itera sobre cada elemento del vector Asistencias (Clave - Valor)
        // Valida el tipo de asistencia
        $tipos_validos = ['Presente', 'Ausente', 'Tarde']; // Vector que contiene los tipos de asistencias
        if (!in_array($tipo_asistencia, $tipos_validos)) { // Verifica si el valor de "tipo_asistencia" está dentro de los tipos válidos
            $errores[] = "Tipo de asistencia inválida para el estudiante $nombres (DNI: $dni_estudiante)"; // Añade mensaje de error al vector
            continue; // Omite resto del código y pasa al siguiente estudiante 
        }

        // Obtener el nombre del estudiante
        $stmt_estudiante->bind_param('s', $dni_estudiante); // Vincula el parámetro de la consulta preparada (?) con el valor de "dni_estudiante", La 's' indica que el parámetro es un string
        $stmt_estudiante->execute(); // Ejecuta la consulta preparada con el parámetro vinculado
        $result_estudiante = $stmt_estudiante->get_result(); // Obtiene el resultado de la consulta
        $estudiante = $result_estudiante->fetch_assoc(); // Recupera una fila del resultado como un vector. Si no se encuentra el alumno, estudiante es nulo.

        if ($estudiante) { // Verifica si se encontró un estudiante con el DNI proporcionado
            $nombres = $estudiante['nombre']; // Si existe, asigna el nombre del estudiante a "nombres" 
            
            // Parámetros y asistencia
            $stmt_insert->bind_param( // Vincula los parámetros de la consulta preparada con los valores correspondientes, abajo
                'sssississi',
                $ciclo_lectivo,
                $carrera,
                $fecha,
                $id_docente,
                $nombre_apellido,
                $tipo_asistencia,
                $id_materia,
                $denominacion_materia,
                $nombres,
                $dni_estudiante
            );

            if ($stmt_insert->execute()) { // Ejecuta la sentenica, si sale bien guarda las asistencias e incrementa el contador
                $asistencias_guardadas++;
            } else { // Si la ejecución falla salta mensaje de error
                $errores[] = "Error al guardar la asistencia para el estudiante $nombres (DNI: $dni_estudiante). Error: " . $stmt_insert->error;
            }
        } else { // Si el estudiante no existe, salta mensaje declarativo
            $errores[] = "No se encontró el estudiante con DNI: $dni_estudiante.";
        }
    }

    // Verifica si hubo errores en el vector
    if (count($errores) > 0) {
        // Revierte la transacción si hubo errores
        $conn->rollback(); 
        foreach ($errores as $error) { //  Itera sobre cada mensaje de error y lo muestra
            echo "<div class='alert alert-danger'>" . $error . "</div>";
        }
    } else {
        // Confirma la transacción si todo fue exitoso
        $conn->commit();
        echo "<div class='alert alert-success'>Se guardaron $asistencias_guardadas asistencias correctamente.</div>";
    }

} catch (Exception $e) {
    // Revierte la transacción en caso de excepción
    $conn->rollback(); 
    echo "Se produjo un error: " . $e->getMessage();
}

// Cierra las sentencias y la conexión
$stmt_estudiante->close();
$stmt_insert->close();
$conn->close();

// Redirige si no hay errores
if (empty($errores)) {
    header("refresh:2; url=asistencias.php");
    exit;
} 
?>
