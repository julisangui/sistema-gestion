<!DOCTYPE html>
<html>
<head>
    <title>Formulario Checkbox</title>
</head>
<body>
    <?php
    require 'conexion.php'; // Asegúrate de que el archivo 'conexion.php' esté en la ubicación correcta y sea funcional.

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si el checkbox está marcado
        $CUILChecked = isset($_POST['check_lista']) && in_array('CUIL', $_POST['check_lista']) ? 1 : 0;

        // Insertar el valor en la base de datos
        $sql = "INSERT INTO personal (CUIL_checked) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $CUILChecked); // Usar "i" para enteros en lugar de "b" que se usa para valores binarios.

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "CUIL Checkbox: " . ($CUILChecked ? "Marcado" : "No marcado") . " - Guardado en la base de datos.";
            } else {
                echo "Error al guardar en la base de datos: " . $stmt->error;
            }
        } else {
            echo "Error en la ejecución de la consulta: " . $stmt->error;
        }
    }

    // Consulta SQL para seleccionar el valor almacenado
    $sql = "SELECT CUIL_checked FROM personal";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $CUILCheckedValue = $row['CUIL_checked'];
        echo "Valor en la base de datos: " . ($CUILCheckedValue ? "Marcado" : "No marcado");
    } else {
        echo "No se encontraron registros en la base de datos.";
    }

    $conn->close();
    ?>

    <form method="post">
        <div class="checkbox">
            <label><input type="checkbox" name="check_lista[]" value="CUIL">CUIL</label>
        </div>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>
