<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado Carreras-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/styletablas.css">
</head>
<body>

<?php
require('./conexion.php');
// Crear la tabla si no existe

$msge="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cargo = $_POST['cargo'];
    $nombreAdmin = $_POST['nombreadmin'];
    $contrasenia = $_POST['userpass'];
    $contrasenia2 = $_POST['userpass2'];
    $rol = $_POST['rol'];


    if( $contrasenia2==$contrasenia){
      $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
      $verifica_existencia = mysqli_query($conn, "SELECT * FROM usuario WHERE nombre_usuario='$nombreAdmin'");
      if (mysqli_num_rows($verifica_existencia)>0){
        $msge="<h5 style='color: #CA2E2E;'>Usuario existente, intente con otro.<h5>";
        echo "<meta http-equiv='refresh' content='5;url=register.php'>";
  
      }
      else{
        
        $stmt = $conn->prepare("INSERT INTO usuario (nombres, apellidos, cargo, nombre_usuario, contrasenia, id_rol) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssd", $nombres, $apellidos, $cargo, $nombreAdmin, $contrasenia, $rol);
        if ($stmt->execute()) {
            // Éxito
          $msge="<h5 style='color: #2ECA6A;'>Registro exitoso.<h5>";
          echo "<meta http-equiv='refresh' content='2;url=login.php'>";
        } else {
          $msge="<h5 style='color: #CA2E2E;'>Error al insertar el registro:". $conn->error."<h5>";
            echo "Error al insertar el registro: " . $stmt->error;
        }
        $stmt->close();
      }
    }
    else{
      $msge="<h5 style='color: #CA2E2E;'>Las contraseñas deben coincidir.<h5>";
        /* echo "Las contraseñas deben coincidir"; */
    }
      // Cerrar la conexión
  $conn->close();
}

?>

  <main>
<div class="container d-flex align-items-center justify-content-center vh-100 w-50">
  
  <div class="card mb-3">
    <div class="row g-0">
    <div class="d-flex align-items-center bg-card-blue-darker text-light px-4 gap-1 ">
        <img src="./assets/img/isftlogo.jpg" alt="Logo del isft 225" class="w-15 h-auto rounded-50 ml-5  p-2" />
        <h4 class="text-sm-center">Registro ISFT225</h4>
    </div>
      <div class="col-lg-4 d-none d-lg-flex col align-items-center justify-content-center align-items-center">
     
        <div class="row g-0">
          <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
            class="w-100 h-auto rounded ml-2" />
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card-body py-5 px-md-5">

          <form method="post" action="register.php">
            <?=$msge?>
            <div class="form-outline mb-2">
            <label class="form-label" for="nombres">Nombres </label>
              <input type="text" id="nombres" class="form-control" name="nombres" max="50"/>
              
            </div>
            
            <div class="form-outline mb-2">
              <label class="form-label" for="apellidos">Apellidos </label>
              <input type="text" id="apellidos" class="form-control" name="apellidos" max="50"/>
              
            </div>
            <!-- Nombre de usuario -->
            <div class="form-outline mb-2">
              <label class="form-label" for="nombreadmin">Nombre de usuario*</label>
              <input type="text" id="nombreadmin" class="form-control" name="nombreadmin" placeholder="maximo 20 caracteres" max="20" required/>
              
            </div>

            <!-- Cargo opcional -->
            <div class="form-outline mb-2">
              <label class="form-label" for="cargo">Cargo</label>
              <input type="text" id="cargo" class="form-control" placeholder="maximo 10 caracteres" max="10" name="cargo"/>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-2">
              <label class="form-label" for="userpass">Contraseña*</label>
              <input type="password" id="userpass" class="form-control" name="userpass" placeholder="entre 4 y 10 caracteres" min="4" max="10" required/>
            </div>
            

             <!-- Password input -->
             <div class="form-outline mb-2">
              <label class="form-label" for="contrasenia2">Repetir Contraseña*</label>
              <input type="password" id="contrasenia2" class="form-control" name="userpass2" placeholder="entre 4 y 10 caracteres" min="4" max="10" required/>    
              <label class="form-label visually-hidden" for="contrasenia2'"><?=$msge?></label>
              
            </div>
            <!-- Rol de acceso al sistema -->
            <div class="col-md-3 w-50">
              <label class="form-label text-black-50 text-nowrap" for="rol">Rol *</label>
              <select class="form-select form-select mb-3" name="rol" id="rol" aria-label="select rol" required>
                  <option value="1">Administrador</option>
                  <option value="2">Usuario</option>
                </select>
          </div>
          <div class="row mb-4">
            <h6 class="text-secondary">* Campos obligatorios</h6>
          </div>
            <!-- 2 column grid layout for inline styling -->
          <div class="row mb-4">
            <div class="col d-flex justify-content-center">
            </div>
          </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary px-4 nav-bar border-0 text-wrap">Registro</button>
            <a href="https://isft225.edu.ar/index/" type="button" class="btn btn-primary menu-icon border-0 px-4">Volver</a>
        </form>

        </div>
      </div>
    </div>
  </div>

</div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>                    
</body>
</html>
