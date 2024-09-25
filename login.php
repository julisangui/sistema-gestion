
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>


<?php
require('./conexion.php');
// Crear la tabla si no existe

$msge="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasenia = $_POST['contrasenia'];

    $resultado = mysqli_query($conn, "SELECT contrasenia FROM usuario WHERE nombre_usuario = '$nombre_usuario'");

    if ($resultado && $row = mysqli_fetch_assoc($resultado)) {
        $contrasenia_hash = $row['contrasenia'];

        // Verifica si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($contrasenia, $contrasenia_hash)) {
            // Contraseña válida, redirige al usuario
            $msge = "<h5 style='color: #2ECA6A;'>Bienvenido, ".$nombre_usuario.".</h5>";
            
            echo "<meta http-equiv='refresh' content='3;url=index.php'>";

        } else {
            $msge = "<h5 style='color: #CA2E2E;'>Usuario y/o contraseña incorrectos. Intente de nuevo.</h5>";
        }
    } else {
        $msge = "<h5 style='color: #CA2E2E;'>Usuario y/o contraseña incorrectos. Intente de nuevo.</h5>";
    }

    $conn->close();
}
?>
<body>
    <div class="d-flex">
        <!-- Login -->
        <div class="form flex-fill v-w-50">
            <div class="card mb-3 p-1">
                <div class="d-flex align-items-center bg-card-blue-darker text-light px-4 gap-1 ">
                    <img src="./assets/img/isftlogo.jpg" alt="Logo del isft 225" class="w-15 h-auto rounded-50 ml-5  p-2" />
                    <h4 class="text-sm-center">Login ISFT225</h4>
                </div>
                <div class="card-body py-5 px-md-5">
                    <form action="login.php" method="POST">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                    <?=$msge?>
                        <label class="form-label" for="nombre_usuario">Usuario</label>
                        <input type="text" id="nombre_usuario" class="form-control" name="nombre_usuario"/>
                    </div>
        
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="contrasenia">Contraseña</label>
                        <input type="password" id="contrasenia" class="form-control" name="contrasenia"/>
                        
                    </div>
        
                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-start">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <input class="form-check-input bg-blue-dark" type="checkbox" value="" id="form2Example31" checked />
                            <label class="form-check-label" for="form2Example31"> Recordarme </label>
                            
                        </div>
                        </div>
        
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-start">
                            <a class="link-dark " href="#!">Recuperar contraseña?</a>
                        </div>
                        <div class="col d-flex justify-content-start">
                            <a class="link-dark " href="register.php">Usuario Nuevo? Registrarse</a>
                        </div>
                    </div>
        
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-b btn-block menu-icon mb-4 text-light">Login</button>
                    </form>
        
                </div>
                
                </div>
            </div>
            <!-- Fin de Login -->
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
