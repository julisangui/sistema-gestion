<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Materia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
<?php
require('./conexion.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_alpha_n = $_POST['cod_alpha'];
    $tipo_aprobacion_n = $_POST['tipo_aprobacion'];
    $denominacion_materia_n = $_POST['denominacion_materia'];
    $trayecto_n = $_POST['trayecto'];
    $correlatividades_n = $_POST['correlatividades']; 
    $estado_materia_n = $_POST['estado_materia'];
    $ciclo_lectivo_n = $_POST['ciclo_lectivo'];
    $campo_formativo_n = $_POST['campo_formativo'];
    $cod_num = $_POST['cod_num'];
    $nota_min_aprobacion = $_POST['nota_min_aprobacion'];
    $carga_horaria_materia = $_POST['carga_horaria_materia'];
    
    $cod_alpha = htmlspecialchars($cod_alpha_n, ENT_QUOTES, 'UTF-8');
    $tipo_aprobacion = htmlspecialchars($tipo_aprobacion_n, ENT_QUOTES, 'UTF-8');
    $denominacion_materia = htmlspecialchars($denominacion_materia_n, ENT_QUOTES, 'UTF-8');
    $campo_formativo = htmlspecialchars($campo_formativo_n, ENT_QUOTES, 'UTF-8');
    $trayecto = htmlspecialchars($trayecto_n, ENT_QUOTES, 'UTF-8');
    $correlatividades = htmlspecialchars($correlatividades_n, ENT_QUOTES, 'UTF-8');
    $estado_materia = htmlspecialchars($estado_materia_n, ENT_QUOTES, 'UTF-8');
    $ciclo_lectivo = htmlspecialchars($ciclo_lectivo_n, ENT_QUOTES, 'UTF-8');
    
    $sql = "INSERT INTO materia (
        cod_num,
        cod_alpha,
        denominacion_materia,
        tipo_aprobacion,
        nota_min_aprobacion,
        trayecto,
        correlatividades,
        estado_materia,
        ciclo_lectivo,
        campo_formativo,
        carga_horaria_materia
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param(
        "isssisssisi",
        $cod_num,
        $cod_alpha,
        $denominacion_materia,
        $tipo_aprobacion,
        $nota_min_aprobacion,
        $trayecto,
        $correlatividades,
        $estado_materia,
        $ciclo_lectivo,
        $campo_formativo,
        $carga_horaria_materia
    );
    
    //Arreglo 03/12/2023
     if ($stmt->execute()){
         if ($stmt->affected_rows > 0) {
            echo "Registro insertado correctamente";
            echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
         } else {
             echo "Error al insertar el registro";
             echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
         }
     } else {
         echo "Error al ejecutar la consulta: " . $stmt->error;
         echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>";
     }
   /*  echo "<meta http-equiv='refresh' content='0.5;url=tablalistadodematerias.php'>"; */
    
    $stmt->close();
}
$conn->close();
include 'headernosearch.php';
?>

<main>
    <div class="d-flex flex-nowrap sidebar-height">
        <?php
        include "sidebar.php";
        ?>
        <div class="col-9 offset-3 bg-light-subtle pt-5">
            <div class="d-block p-3 m-4 h-100">
                <h3 class="card-footer-text mt-2 mb-5 p-2">Materia</h3>
                <div class="m-4">
                    <h2 class="text-dark-subtle title">Ingresar Nueva Materia</h2>
                </div>
                
                <div>
                    <form class="row g-3 m-4" method="post" action="ingresomateria.php">
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="cod_num">Año que se dicta la materia*:</label>
                            <input class="form-control" type="number" name="cod_num" id="cod_num" required>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="cod_alpha">Código alfabético *:</label>
                            <input class="form-control" type="text" name="cod_alpha" id="cod_alpha" required>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="denominacion_materia">Denominación*:</label>
                            <input class="form-control" type="text" name="denominacion_materia" id="denominacion_materia" required>
                        
                        </div>
                       
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="tipo_aprobacion">Tipo de aprobación</label>
                            <select class="form-select form-select mb-3" name="tipo_aprobacion" id="tipo_aprobacion" aria-label="tipo_aprobacion">
                                <option selected value="Promoción">Promoción</option>
                                <option value="Final">Final</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 position-relative">
                            <label class="form-label text-black-50" for="nota_min_aprobacion">Mínimo de aprobación para la materia*:</label>
                            <select class="form-select form-select mb-3" name="nota_min_aprobacion" id="nota_min_aprobacion" aria-label="nota_min_aprobacion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option selected value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label class="form-label text-black-50" for="trayecto">Trayecto:</label>
                            <input class="form-control" type="text" name="trayecto" id="trayecto">
                        </div>

                        <div class="col-md-4 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="correlatividades">Tiene Materias Correlativas*:</label>
                            <select class="form-select form-select mb-3" name="correlatividades" id="correlatividades" aria-label="select_correlatividades">
                                <option selected value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        


                        <div class="col-md-4 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="estado_materia">Estado de materia*:</label>
                            <select class="form-select form-select mb-3" name="estado_materia" id="estado_materia" aria-label="select_estado_materia">
                                <option selected value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>



                        <div class="col-md-4 position-relative">
                            <label class="form-label text-black-50" for="ciclo_lectivo">Ciclo Lectivo*:</label>
                            <input class="form-control" type="text" name="ciclo_lectivo" id="ciclo_lectivo" required>
                        </div>



                        <div class="col-md-4 position-relative">
                            <label class="form-label text-black-50 text-nowrap" for="campo_formativo">Campo Formativo*:</label>
                            <select class="form-select form-select mb-3" name="campo_formativo" id="campo_formativo" aria-label="select_campo_formativo">
                                <option selected value="fundamento">Campo de fundamento</option>
                                <option value="practica">Campo de la práctica</option>
                                <option value="especifico">Campo específico</option>
                                <option value="general">Campo general</option>
                            </select>
                        </div>




                        <div class="col-md-4 position-relative">
                            <label class="form-label text-black-50" for="carga_horaria_materia">Carga horaria*:</label>
                            <input class="form-control" type="number" name="carga_horaria_materia" id="carga_horaria_materia" required>
                        </div>



                        

                     
                     
                        <div class="col-md-6 offset-2 mb-5">
                            <div class="d-flex mb-5 gap-2 justify-content-between align-content-center">
                                <a href="tablalistadodematerias.php"><button class='btn btn-primary menu-icon border-0 px-4' type="button">Volver</button></a>
                                <input class="btn btn-primary px-4 nav-bar border-0 text-wrap" type="submit" value="Guardar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
