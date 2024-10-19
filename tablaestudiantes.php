<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./styles/styletablas.css" type="text/css">
  <title>Tabla estudiantes</title>
</head>
<body>

  <?php
    include "variablesPath.php";
    require(rutas::$pathConection);
    include(rutas::$pathNuevoHeader);
  ?>

  <div class="container">
    <form class="search-form" role="search" action="" method="get">
      <a href="ingresarestudiantes.php" class="btn btn-primary custom-btn" role="button">Ingresar estudiante</a>
      <div class="search-container">
        <input class="form-control me-2 search-input" type="text" name="busqueda" placeholder="Buscar..." aria-label="Buscar">
        <button class="btn btn-outline-success custom-btn-search" type="submit" name="enviar" value="Buscar" aria-label="Buscar">Buscar</button>
      </div>
    </form>
  </div>

  <style>
    
    .table {
      width: 100%;
      margin: 0 auto;
    }

    th, td {
      text-align: center;
    }

    .search-form {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 25px;
      margin-top: 25px;
    }

    .btn.btn-primary.custom-btn, .btn.btn-outline-success.custom-btn-search {
      background-color: #083461;
      color: #f1f1f1;
      border: none;
    }

    .btn.btn-primary.custom-btn:hover, .btn.btn-outline-success.custom-btn-search:hover {
      background-color:#2ca0dd;
    }

    .search-container {
      display: flex;
    }

    .search-input {
      max-width: 300px;
    }

    i{
      color: #010101;
      transition: 0.5s;
    }

    i:hover{
      color: #2ca0dd;
    }

  </style>

  <?php

    $sql = "SELECT id_estudiante, nro_legajo, tipo_documento, dni_estudiante, nombre, apellido, email, telefono, estado_estudiante, documentacion_completa FROM estudiantes";

    if (isset($_GET['enviar'])) { //El if se ejecutara solo si el usuario presiona el boton buscar.
      $busqueda = $_GET['busqueda']; //Aca se lee lo que pone el usuario para buscar y el %(comodin) busca coincidencias.
      $sql .= " WHERE nro_legajo LIKE '%$busqueda%' 
        OR nombre LIKE '%$busqueda%' 
        OR apellido LIKE '%$busqueda%' 
        OR dni_estudiante LIKE '%$busqueda%'
        OR estado_estudiante LIKE '%$busqueda%'";
    }

    $result = $conn->query($sql); //Se conecta con la base de datos las consultas sql que estan siendo ejecutadas.

  ?>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>DNI</th>
            <th>Nro Legajo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>Documentación</th>
            <th>Editar</th>
            <th>Ver</th>
            <th>Asignar materia</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {//fetch_assoc() significa que te da los datos de cada fila de una tabla en la base de datos y los pasa a cada una de las filas de la tabla en la pagina.
                echo "<tr>";
                echo "<td>" . $row["dni_estudiante"] . "</td>";
                echo "<td>" . $row["nro_legajo"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["apellido"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "<td>" . $row["estado_estudiante"] . "</td>";
                echo "<td>" . $row["documentacion_completa"] . "</td>";
                echo "<td><a href='formeditarestudiantes.php?id_estudiante=" . $row["id_estudiante"] . "' class='text-primary' title='Editar información del estudiante'><i class='bi bi-pencil-fill'></i></a></td>";
                echo "<td><a href='listarestudiante.php?id_estudiante=" . $row["id_estudiante"] . "' class='text-primary' title='Ver estudiante'><i class='bi bi-eye-fill'></i></a></td>";
                echo "<td><a href='asignarmateriaestudiante.php?id_estudiante=" . $row["id_estudiante"] . "' class='text-primary' title='Asignar materia al estudiante'><i class='bi bi-journal-text'></i></a></td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='10' class='text-center'>No se encontraron resultados.</td></tr>";
            }
            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OPxiZjwhSQvv9B3ILwxf6UezeHAzVksLUw+HRTRWc1IfV6p10Bm4sTI6yU5U1mXt" crossorigin="anonymous"></script>
</body>
</html>