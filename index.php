<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-ISFT 225</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <?php 
    try{
      include "variablesPath.php";
    require(rutas::$pathConection);
    include rutas::$pathHeader;
    // Consultar los datos
    $mensaje = "";
    
    function consultarContador($conn, $tabla,$mensaje) {
      
      $sql = "SELECT COUNT(*) as contador FROM $tabla";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          return $row['contador'];
      } else {
        $mensaje = "Sin datos";
          return 0;
      }
    }
    $count_estudiante = consultarContador($conn, 'estudiantes', $mensaje);
    $count_profesor = consultarContador($conn, 'personal', $mensaje);
    $count_materia = consultarContador($conn, 'materia', $mensaje);
    $count_carrera = consultarContador($conn, 'carrera', $mensaje);

    }catch(mysqli_sql_exception $e){
      $mensaje = "No se puede ejecutar la consulta" . $e->getMessage();
    }finally{
      
      $conn->close();
    }
  
    ?>
<main>
    <!-- Contenedor principal -->
    <div class=" d-flex flex-nowrap sidebar-height"> 
      <!-- Aside/Wardrobe/Sidebar Menu --> 
      <?php
      include rutas::$pathSlidebar; 
        ?>  
      <!-- Fin de sidebar/aside -->
      <!-- Contenedor de ventana de contenido -->
      <div class="col-9 offset-3 bg-light-subtle pt-5">
          <div class="d-block p-3 m-4 h-100">
            <h2 class="card-footer-text mt-2 mb-5 p-2">Inicio</h2>
              <h2><?= $mensaje ?></h2>
              <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3  g-3 m-2 ">
                  <div class="col">
                    <div class="card bg-card-teal border-0 w-100 card-title-height">
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="d-block text-center">
                          <h4 class="card-title text-light ">Estudiantes</h4>
                          <h4 class="card-title text-light "><?= $count_carrera ?></h4>
                        </div>
                   
                    </div>
                      <div class="card-footer card-footer-text d-flex align-items-center justify-content-between">
                        <h5 class="card-title px-2">Más Informacion</h5>
                        <a href="#" class="btn btn-outline-secondary text-center  m-0"><svg class="align-text-top" width="8" height="16"
                            viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M3.11246 1.49606C3.11246 1.64218 3.08368 1.78686 3.02776 1.92185C2.97185 2.05684 2.88989 2.17949 2.78658 2.28281C2.68326 2.38612 2.56061 2.46808 2.42562 2.52399C2.29063 2.57991 2.14594 2.60869 1.99983 2.60869C1.85372 2.60869 1.70904 2.57991 1.57405 2.52399C1.43906 2.46808 1.3164 2.38612 1.21309 2.28281C1.10977 2.17949 1.02782 2.05684 0.9719 1.92185C0.915986 1.78686 0.887207 1.64218 0.887207 1.49606C0.887207 1.20098 1.00443 0.917976 1.21309 0.709318C1.42175 0.500661 1.70475 0.383438 1.99983 0.383438C2.29492 0.383438 2.57792 0.500661 2.78658 0.709318C2.99523 0.917976 3.11246 1.20098 3.11246 1.49606ZM1.92108 3.732C2.46502 3.732 2.90546 4.17244 2.90546 4.71638V10.6733C2.90546 10.9343 2.80175 11.1847 2.61714 11.3693C2.43253 11.5539 2.18215 11.6576 1.92108 11.6576C1.66001 11.6576 1.40963 11.5539 1.22502 11.3693C1.04042 11.1847 0.936707 10.9343 0.936707 10.6733V4.71638C0.936707 4.17244 1.37771 3.732 1.92108 3.732Z"
                              fill="black" fill-opacity="0.6" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card bg-card-blue-darker border-0 w-100 card-title-height">
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="d-block text-center">
                          <h4 class="card-title text-light">Docentes</h4>
                          <h4 class="card-title text-light"><?= $count_profesor?></h4>
                        </div>
                 
                      </div>
                      <div class="card-footer card-footer-text d-flex align-items-center justify-content-between">
                        <h5 class="card-title px-2">Más Informacion</h5>
                        <a href="#" class="btn btn-outline-secondary text-center  m-0"><svg class="align-text-top" width="8" height="16"
                            viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M3.11246 1.49606C3.11246 1.64218 3.08368 1.78686 3.02776 1.92185C2.97185 2.05684 2.88989 2.17949 2.78658 2.28281C2.68326 2.38612 2.56061 2.46808 2.42562 2.52399C2.29063 2.57991 2.14594 2.60869 1.99983 2.60869C1.85372 2.60869 1.70904 2.57991 1.57405 2.52399C1.43906 2.46808 1.3164 2.38612 1.21309 2.28281C1.10977 2.17949 1.02782 2.05684 0.9719 1.92185C0.915986 1.78686 0.887207 1.64218 0.887207 1.49606C0.887207 1.20098 1.00443 0.917976 1.21309 0.709318C1.42175 0.500661 1.70475 0.383438 1.99983 0.383438C2.29492 0.383438 2.57792 0.500661 2.78658 0.709318C2.99523 0.917976 3.11246 1.20098 3.11246 1.49606ZM1.92108 3.732C2.46502 3.732 2.90546 4.17244 2.90546 4.71638V10.6733C2.90546 10.9343 2.80175 11.1847 2.61714 11.3693C2.43253 11.5539 2.18215 11.6576 1.92108 11.6576C1.66001 11.6576 1.40963 11.5539 1.22502 11.3693C1.04042 11.1847 0.936707 10.9343 0.936707 10.6733V4.71638C0.936707 4.17244 1.37771 3.732 1.92108 3.732Z"
                              fill="black" fill-opacity="0.6" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card bg-card-yellow-taxi border-0 w-100 card-title-height">
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="d-block text-center">
                          <h4 class="card-title text-light">Materias</h4>
                          <h4 class="card-title text-light"><?= $count_materia?></h4>
                        </div>
                      
                      </div>
                      <div class="card-footer card-footer-text d-flex align-items-center justify-content-between">
                        <h5 class="card-title px-2">Más Informacion</h5>
                        <a href="#" class="btn btn-outline-secondary text-center  m-0"><svg class="align-text-top" width="8" height="16"
                            viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M3.11246 1.49606C3.11246 1.64218 3.08368 1.78686 3.02776 1.92185C2.97185 2.05684 2.88989 2.17949 2.78658 2.28281C2.68326 2.38612 2.56061 2.46808 2.42562 2.52399C2.29063 2.57991 2.14594 2.60869 1.99983 2.60869C1.85372 2.60869 1.70904 2.57991 1.57405 2.52399C1.43906 2.46808 1.3164 2.38612 1.21309 2.28281C1.10977 2.17949 1.02782 2.05684 0.9719 1.92185C0.915986 1.78686 0.887207 1.64218 0.887207 1.49606C0.887207 1.20098 1.00443 0.917976 1.21309 0.709318C1.42175 0.500661 1.70475 0.383438 1.99983 0.383438C2.29492 0.383438 2.57792 0.500661 2.78658 0.709318C2.99523 0.917976 3.11246 1.20098 3.11246 1.49606ZM1.92108 3.732C2.46502 3.732 2.90546 4.17244 2.90546 4.71638V10.6733C2.90546 10.9343 2.80175 11.1847 2.61714 11.3693C2.43253 11.5539 2.18215 11.6576 1.92108 11.6576C1.66001 11.6576 1.40963 11.5539 1.22502 11.3693C1.04042 11.1847 0.936707 10.9343 0.936707 10.6733V4.71638C0.936707 4.17244 1.37771 3.732 1.92108 3.732Z"
                              fill="black" fill-opacity="0.6" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card bg-card-yellow-taxi border-0 w-100 card-title-height">
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="d-block text-center">
                           <h4 class="card-title text-light">Carreras</h4>
                            <h4 class="card-title text-light"><?= $count_carrera?></h4>
                        </div>
                     
                  
                      </div>
                      <div class="card-footer card-footer-text d-flex align-items-center justify-content-between">
                        <h5 class="card-title px-2">Más Informacion</h5>
                        <a href="#" class="btn btn-outline-secondary text-center  m-0"><svg class="align-text-top" width="8" height="16"
                            viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M3.11246 1.49606C3.11246 1.64218 3.08368 1.78686 3.02776 1.92185C2.97185 2.05684 2.88989 2.17949 2.78658 2.28281C2.68326 2.38612 2.56061 2.46808 2.42562 2.52399C2.29063 2.57991 2.14594 2.60869 1.99983 2.60869C1.85372 2.60869 1.70904 2.57991 1.57405 2.52399C1.43906 2.46808 1.3164 2.38612 1.21309 2.28281C1.10977 2.17949 1.02782 2.05684 0.9719 1.92185C0.915986 1.78686 0.887207 1.64218 0.887207 1.49606C0.887207 1.20098 1.00443 0.917976 1.21309 0.709318C1.42175 0.500661 1.70475 0.383438 1.99983 0.383438C2.29492 0.383438 2.57792 0.500661 2.78658 0.709318C2.99523 0.917976 3.11246 1.20098 3.11246 1.49606ZM1.92108 3.732C2.46502 3.732 2.90546 4.17244 2.90546 4.71638V10.6733C2.90546 10.9343 2.80175 11.1847 2.61714 11.3693C2.43253 11.5539 2.18215 11.6576 1.92108 11.6576C1.66001 11.6576 1.40963 11.5539 1.22502 11.3693C1.04042 11.1847 0.936707 10.9343 0.936707 10.6733V4.71638C0.936707 4.17244 1.37771 3.732 1.92108 3.732Z"
                              fill="black" fill-opacity="0.6" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card bg-card-teal border-0 w-100 card-title-height">
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="d-block text-center">
                          <h4 class="card-title text-light">Notas</h4>
                        </div>
                      
                  
                      </div>
                      <div class="card-footer card-footer-text d-flex align-items-center justify-content-between">
                        <h5 class="card-title px-2">Más Informacion</h5>
                        <a href="#" class="btn btn-outline-secondary text-center  m-0"><svg class="align-text-top" width="8" height="16"
                            viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M3.11246 1.49606C3.11246 1.64218 3.08368 1.78686 3.02776 1.92185C2.97185 2.05684 2.88989 2.17949 2.78658 2.28281C2.68326 2.38612 2.56061 2.46808 2.42562 2.52399C2.29063 2.57991 2.14594 2.60869 1.99983 2.60869C1.85372 2.60869 1.70904 2.57991 1.57405 2.52399C1.43906 2.46808 1.3164 2.38612 1.21309 2.28281C1.10977 2.17949 1.02782 2.05684 0.9719 1.92185C0.915986 1.78686 0.887207 1.64218 0.887207 1.49606C0.887207 1.20098 1.00443 0.917976 1.21309 0.709318C1.42175 0.500661 1.70475 0.383438 1.99983 0.383438C2.29492 0.383438 2.57792 0.500661 2.78658 0.709318C2.99523 0.917976 3.11246 1.20098 3.11246 1.49606ZM1.92108 3.732C2.46502 3.732 2.90546 4.17244 2.90546 4.71638V10.6733C2.90546 10.9343 2.80175 11.1847 2.61714 11.3693C2.43253 11.5539 2.18215 11.6576 1.92108 11.6576C1.66001 11.6576 1.40963 11.5539 1.22502 11.3693C1.04042 11.1847 0.936707 10.9343 0.936707 10.6733V4.71638C0.936707 4.17244 1.37771 3.732 1.92108 3.732Z"
                              fill="black" fill-opacity="0.6" />
                          </svg>
                        </a>
                      </div>
                  
                    </div>
                  </div>
                  <div class="col">
                    <div class="card bg-card-blue-darker border-0 w-100 card-title-height">
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <h4 class="card-title text-light">Algo..</h4>
                  
                      </div>
                      <div class="card-footer card-footer-text d-flex align-items-center justify-content-between">
                        <h5 class="card-title px-2">Más Informacion</h5>
                        <a href="#" class="btn btn-outline-secondary text-center  m-0"><svg class="align-text-top" width="8" height="16"
                            viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M3.11246 1.49606C3.11246 1.64218 3.08368 1.78686 3.02776 1.92185C2.97185 2.05684 2.88989 2.17949 2.78658 2.28281C2.68326 2.38612 2.56061 2.46808 2.42562 2.52399C2.29063 2.57991 2.14594 2.60869 1.99983 2.60869C1.85372 2.60869 1.70904 2.57991 1.57405 2.52399C1.43906 2.46808 1.3164 2.38612 1.21309 2.28281C1.10977 2.17949 1.02782 2.05684 0.9719 1.92185C0.915986 1.78686 0.887207 1.64218 0.887207 1.49606C0.887207 1.20098 1.00443 0.917976 1.21309 0.709318C1.42175 0.500661 1.70475 0.383438 1.99983 0.383438C2.29492 0.383438 2.57792 0.500661 2.78658 0.709318C2.99523 0.917976 3.11246 1.20098 3.11246 1.49606ZM1.92108 3.732C2.46502 3.732 2.90546 4.17244 2.90546 4.71638V10.6733C2.90546 10.9343 2.80175 11.1847 2.61714 11.3693C2.43253 11.5539 2.18215 11.6576 1.92108 11.6576C1.66001 11.6576 1.40963 11.5539 1.22502 11.3693C1.04042 11.1847 0.936707 10.9343 0.936707 10.6733V4.71638C0.936707 4.17244 1.37771 3.732 1.92108 3.732Z"
                              fill="black" fill-opacity="0.6" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </div>
        <!-- Fin de contenido -->
      </div>
      <!-- Fin de contenedor principal -->
 </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
