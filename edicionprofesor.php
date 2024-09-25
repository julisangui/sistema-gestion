<?php
// Configuración de la conexión a la base de datos
require ('./conexion.php');



// Obtener el ID del registro a editar
$id = $_GET['id'];

// Procesar la actualización del registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los nuevos valores del formulario
    $newNombre = $_POST['texto1'];
    $newApellido = $_POST['texto2'];
    $newDestino = $_POST['texto3'];
    $newEmail = $_POST['texto4'];

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $sql = "UPDATE viajes SET nombre='$newNombre', apellido='$newApellido', destino='$newDestino', email='$newEmail' WHERE id=$id";
            
    if ($conn->query($sql) === TRUE) {
        //echo "Registro actualizado correctamente";
        // Redirección a la página deseada después del procesamiento
        header("Location: listados.php");
        exit(); // Asegura que el código se detenga después de la redirección
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }

    $conn->close();
}

// Obtener los datos del registro actual
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$sql = "SELECT id, nombre, apellido, destino, email FROM viajes WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Cerrar la conexión
$conn->close();
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>

<body>
    
   <h1>Argentina</h1>  

  <h2>Selecciona tu destino</h2>
<!-- Menú de navegación del sitio -->
    <nav>
       
        <ul>
                <li class="menu"><a href="indexacion.php">Página principal</a>
                <li class="menu"><a href="listados.php">Listado</a>
                <li class="menu"><a href="edicion.php">Editar</a>
                <li class="menu"><a href="eliminacion.php">Eliminar</a>
        </ul>
    </nav>   

 <!--   <footer class="footer">
</footer>
</body>-->



<div class="container">
    <h2>Editar Usuario</h2>
    <form class="form" action="edicion.php?id=<?= $id ?>" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        Nombre:<input class="form-control" type="text" name="texto1" value="<?= $row['nombre'] ?>">
        Apellido:<input class="form-control" type="text" name="texto2" value="<?= $row['apellido'] ?>">
        Destino:
            <!--<input class="form-control" type="text" name="texto3" id="texto3" required>-->
            <select name="destino" id="destino">
                <option value="cat">Cataratas del Iguazú</option>
                <option value="gla">Glaciar Perito moreno</option>
                <option value="mel">Lago Meliquia</option>
                <option value="est">Esteros del Ibera</option>
                <option value="pal">El palmar</option>
                <option value="gig">Los Gigantes</option>
                <option value="cer">Cerro La Cruz</option>
                <option value="pun">Valle de Punilla</option>
            </select>
            <br/>
        <!--Destino:<input class="form-control" type="text" name="texto3" value="     falta un signo<
        ?= $row['destino'] ?>">-->
        Email:<input class="form-control" type="email" name="texto4" value="<?= $row['email'] ?>"><br/>
        <input type="submit" class="btn btn-info" value="Actualizar">
    </form>

</div>
</body>
