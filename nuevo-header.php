<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    header {
      background: linear-gradient(to right, #083461 5%, #2ca0dd 95%);
      height: 100px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 60px;
    }

    .logo {
      height: 80px;
      border-radius: 50%;
    }

    .nav-link, .nav-link.menu {
      color: rgb(254, 254, 254);
      text-decoration: none;
      margin: 8px;
      font-size: 15px;
      font-weight: bold;
      transition: color 0.5s;
    }

    .nav-link:hover {
      color: rgb(251, 200, 11);
    }

    .offcanvas-header{
      color: rgb(254, 254, 254);
    }

    .navbar-toggler {
      border: none;
      margin: 0;
      font-size: 24px;
      font-weight: bold;
      color: rgb(254, 254, 254);
    }

    .navbar-toggler-icon, .btn-close {
      filter: invert(100%);
    }

    .bi-people-fill {
      font-size: 25px;
      color: rgb(254, 254, 254);
      transition: 0.5s;
    }

    .bi-people-fill:hover, .nav-link.dropdown-toggle:hover {
      color: #fbc80b;
    }

    .offcanvas-end {
      background-color: rgb(20, 20, 20);
    }

  </style>
  </head>
  <body>
    <header>
      <a href="index.php"><img class="logo" src="assets/img/isftlogo.jpg" alt="Logo"></a>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header">
                <h3 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h3>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item"><a class="nav-link menu" href="index.php">Inicio</a></li>
                  <li class="nav-item"><a class="nav-link menu" href="tablaestudiantes.php">Estudiantes</a></li>
                  <li class="nav-item"><a class="nav-link menu" href="tablaspersonal.php">Personal</a></li>
                  <li class="nav-item"><a class="nav-link menu" href="tablalistadocarreras.php">Carreras</a></li>
                  <li class="nav-item"><a class="nav-link menu" href="tablalistadodematerias.php">Materias</a></li>
                  <li class="nav-item"><a class="nav-link menu" href="#">Notas</a></li>
                  <li class="nav-item"><a class="nav-link menu" href="#">Ciclo academico</a></li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
        <li class="nav dropdown">
        <a role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-people-fill"></i></a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="login.php">Login</a></li>
            <li><a class="dropdown-item" href="#">Logout</a></li>
            <hr>
            <li><a class="dropdown-item" href="register.php">Registrarse</a></li>
          </ul>
        </li>
    </header>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
</body>
</html>