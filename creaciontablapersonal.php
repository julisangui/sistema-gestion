<?php
 
 require('./conexion.php');
$sql = "CREATE TABLE IF NOT EXISTS personal (
    id_personal INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    nombre_personal VARCHAR(50) NOT NULL,
    apellido_personal VARCHAR(50) NOT NULL,
    email_personal VARCHAR(100) NOT NULL,
    telefono_personal INT(11) NOT NULL,
    tipodoc_personal VARCHAR(10)  NULL,
   
    nrodni_personal VARCHAR(10) NOT NULL,
    nrocuil_personal VARCHAR(11) NOT NULL,
    sexo_personal VARCHAR(20) NOT NULL,
    fechanac_personal VARCHAR(15) NOT NULL,
    paisnac_personal VARCHAR(50) NOT NULL,
    
    lugarnac_personal VARCHAR(100) NULL,
    fecha_designacion VARCHAR(15) NOT NULL,
    nro_designacion INT(20)  NULL,
    paisdomic_personal VARCHAR(50)  NULL,
    provdomic_personal VARCHAR(50)  NULL,
    
    calle_personal VARCHAR(100) NOT NULL,
    nro_personal INT(10) NOT NULL,
    piso_personal INT(5)  NULL,
    depto_personal VARCHAR(5) null,
    edificio_personal VARCHAR(5)  NULL,
    
    localidad_personal VARCHAR(50) ,
    partido_personal VARCHAR(50)  NULL ,
    cp_personal INT(5) NULL,
    titulo VARCHAR(100) NOT NULL,
    titulo_institucion VARCHAR(100) NOT NULL,
   
    anio_egreso INT(4) NOT NULL,
    tipo_titulo VARCHAR(100)  NULL,
    carr1 VARCHAR(100) NULL,
    carr1_institucion VARCHAR(100)  NULL,
    carr1_estado VARCHAR(20) NULL ,
    
    carr1_anioegreso INT(5)NULL,
    carr1_titulo VARCHAR(100)  NULL,
    carr2 VARCHAR(100)  NULL,
    carr2_institucion VARCHAR(100) NULL,
    carr2_estado VARCHAR(20)  NULL,
   
    carr2_anioegreso INT(5) NULL,
    carr2_titulo VARCHAR(100)  NULL,
    estado_personal VARCHAR(15)  NULL,
    DNIchecked VARCHAR(5)  NULL,
    DNIchecked VARCHAR(5)  NULL,
    CVchecked VARCHAR(5)  NULL,
    CUILchecked VARCHAR(5)  NULL,
    TITchecked VARCHAR(5)  NULL
   )";
    

  if ($conn->query($sql)) {
    echo "Error al crear la tabla: " . $conn->error;
  }
  ;
  $conn->close();
  ?>