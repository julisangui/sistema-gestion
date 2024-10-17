
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
$msge = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escapar las entradas del usuario
    $nombre_usuario = htmlspecialchars($_POST['nombre_usuario'], ENT_QUOTES, 'UTF-8');
    $password_usuario = htmlspecialchars($_POST['password_usuario'], ENT_QUOTES, 'UTF-8');

    // Validar el nombre de usuario (ejemplo: solo letras y números, longitud de 3 a 20)
    if (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $nombre_usuario)) {
        $msge = "<h5 style='color: #CA2E2E;'>El nombre de usuario debe contener solo letras y números y tener entre 3 y 20 caracteres.</h5>";
    } 
    // Validar la contraseña (ejemplo: al menos 6 caracteres)
    else if (!preg_match("/^.{6,}$/", $password_usuario)) {
        $msge = "<h5 style='color: #CA2E2E;'>La contraseña debe tener al menos 6 caracteres.</h5>";
    } 
    else {
        // consultas preparadas para evitar inyección SQL
        $stmt = $conn->prepare("SELECT password_usuario FROM personal WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $row = $resultado->fetch_assoc()) {
            $stored_password = $row['password_usuario']; // Contraseña almacenada en la base de datos (texto plano)

            // Verifica si la contraseña ingresada coincide con la almacenada en texto plano
            if ($password_usuario === $stored_password) {
                // Contraseña válida, redirige al usuario
                $msge = "<h5 style='color: #2ECA6A;'>Bienvenido, " . htmlspecialchars($nombre_usuario, ENT_QUOTES, 'UTF-8') . ".</h5>";
                echo "<meta http-equiv='refresh' content='3;url=index.php'>";
            } else {
                $msge = "<h5 style='color: #CA2E2E;'>Usuario y/o contraseña incorrectos. Intente de nuevo.</h5>";
            }
        } else {
            $msge = "<h5 style='color: #CA2E2E;'>Usuario no encontrado.</h5>";
        }
        $stmt->close();
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
                        <label class="form-label" for="password_usuario">Contraseña</label>
                        <input type="password" id="password_usuario" class="form-control" name="password_usuario"/>
                        
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
