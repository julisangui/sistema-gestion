<div class="col-9 offset-3 bg-light-subtle">
  <div class="d-block p-3 m-4 h-100">
    <main class="main">
      <div class="rect">
        <!-- Encabezado -->
        <!-- Titulo -->
        <div class="titulo">
          <h4>Ingreso estudiante</h4>
        </div>
        <div class="subtitulo">
          <h5>Ingresar nuevo estudiante Estudiante</h5>
        </div>
      </div>

      <!-- Formulario -->
      <form class="formulario" name="formulario" method="POST" enctype="multipart/form-data" autocomplete="on" action="insertestudiantes.php">
        <!-- novalidate ESTA SECCION ES PARA PRODUCCION -->
        <div class="form">
          <div class="filas">
            <!-- Titulo -->
            <div class="titulo">
              <h5>Datos Personales</h5>
            </div>
            <!-- Fila 1 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="nombres">Nombre completo *</label>
                <input type="text" class="form-control upLetra" id="nombres" name="nombres" placeholder="Nombres"
                  required pattern="^[a-zA-Z\s]{3,}$" />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="apellido">Apellido completo *</label>
                <input type="text" class="form-control upLetra" id="apellido" name="apellido" placeholder="Apellido"
                  required pattern="^[a-zA-Z\s]{3,}$" />
              </div>
            </div>

            <!-- Fila 2 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="email">Email electrónico *</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="juan@ejemplo.com"
                  required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="telefono">Número de teléfono *</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required
                  pattern="\d{8,15}$" />
              </div>
            </div>

            <!-- Fila 3 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="tipo_documento">Tipo documento *</label>
                <select class="form-control select" id="tipo_documento" name="tipo_documento" required
                  pattern="\d{8,10}$">
                  <option class="option">DNI</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="nro_documento">Número de documento *</label>
                <input type="text" class="form-control" id="nro_documento" name="nro_documento" placeholder="12345678"
                  required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="nro_legajo">Número de legajo *</label>
                <input type="text" class="form-control" id="nro_legajo" name="nro_legajo"
                  <?php echo "value='$new_nro_legajo' placeholder='$new_nro_legajo'" ?> readonly />
              </div>
            </div>

            <!-- Fila 4 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="genero">Género *</label>
                <select class="form-control select" id="genero" name="genero" required>
                  <option>Masculino</option>
                  <option>Femenino</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="fecha_nac">Fecha Nacimiento *</label>
                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="pais_nac">País de nacimiento *</label>
                <input type="text" class="form-control upLetra" id="pais_nac" name="pais_nac"
                  placeholder="Pais de nacimiento" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="lugar_nac">Lugar de nacimiento *</label>
                <input type="text" class="form-control upLetra" id="lugar_nac" name="lugar_nac"
                  placeholder="Lugar de nacimiento" required />
              </div>
            </div>

            <!-- Fila 5 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="familia_cargo">Familia a Cargo *</label>
                <select class="form-control select" id="familia_cargo" name="familia_cargo" required>
                  <option>Si</option>
                  <option>No</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="hijos">Hijos *</label>
                <select class="form-control select" id="hijos" name="hijos" required>
                  <option>0</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4 o más</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="trabaja">Trabaja actualmente *</label>
                <select class="form-control select" id="trabaja" name="trabaja" required>
                  <option>Si</option>
                  <option>No</option>
                </select>
              </div>
            </div>

            <!-- Titulo -->
            <div class="titulo">
              <h5>Domicilio</h5>
            </div>
            <!-- Fila 6 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="pais_dom">País *</label>
                <input type="text" class="form-control upLetra" id="pais_dom" name="pais_dom"
                  placeholder="Pais del domicilio" value="Argentina" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="provincia">Provincia *</label>
                <select class="form-control select" id="provincias_select" name="provincia" required>
                </select>
                <input type="text" class="form-control upLetra dnone" id="provincias" name="provincia" placeholder="Provincia"
                  value="Buenos Aires" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="partido">Partido *</label>
                <input type="text" class="form-control upLetra dnone" id="partido" name="partido" placeholder="Partido"
                  required />
                <select class="form-control select" id="municipios_select" name="partido" required ></select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="localidad">Localidad *</label>
                <input type="text" class="form-control upLetra dnone" id="localidad" name="localidad" placeholder="Localidad"
                required />
                <select class="form-control select" id="localidad_select" name="localidad" required ></select>
              </div>
            </div>

            <!-- Fila 7 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="calle">Calle *</label>
                <input type="text" class="form-control upLetra" id="calle" name="calle" placeholder="Calle" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="numero">Número *</label>
                <input type="text" class="form-control" id="numero" name="numero" placeholder="Número 123" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="piso">Piso</label>
                <input type="text" class="form-control" id="piso" name="piso" placeholder="0" />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="departamento">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento"
                  placeholder="Departamento A" />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="edificio">Edificio</label>
                <input type="text" class="form-control" id="edificio" name="edificio" placeholder="Edificio ABC" />
              </div>
            </div>

            <!-- Fila 8 -->
            <div class="fila">         
              <div class="columna">
                <label class="form-label text-black-50" for="codigo_postal">Código Postal *</label>
                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="CP 1234"
                  required />
              </div>
            </div>

            <!-- Titulo -->
            <div class="titulo">
              <h5>Estudios secundario</h5>
            </div>

            <!-- Fila 9 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="nombre_escuela">Escuela secundaria *</label>
                <input type="text" class="form-control upLetra" id="nombre_escuela" name="nombre_escuela"
                  placeholder="Escuela Secundaria N° 123" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="titulo_secundario">Título nivel secundario *</label>
                <input type="text" class="form-control" id="titulo_secundario" name="titulo_secundario"
                  placeholder="Título nivel secundario" required />
              </div>
            </div>

            <!-- Fila 10 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="anio_egreso">Año de egreso *</label>
                <input type="number" class="form-control" id="anio_egreso" name="anio_egreso" min="1900" max="2050"
                  placeholder="2023" required />
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="titulo_certificado">Certificado del título</label>
                <select class="form-control select" id="titulo_certificado" name="titulo_certificado" required>
                  <option>Titulo legalizado</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="titulo_tecnico">Título Técnico*</label>
                <select class="form-control select" id="titulo_tecnico" name="titulo_tecnico" required>
                  <option>Si</option>
                  <option>No</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="titulo_hab">Título técnico habilitante*</label>
                <select class="form-control select" id="titulo_hab" name="titulo_hab" required>
                  <option>Si</option>
                  <option>No</option>
                </select>
              </div>
            </div>

            <!-- Titulo -->
            <div class="titulo">
              <h5>Otro Recorrido Académico</h5>
            </div>

            <!-- Fila 11 -->
            <!-- Agrega un contenedor donde se insertarán los nuevos divs -->
            <div id="contenedorEstudiosFinalizados"></div>

            <!-- Fila 12 -->
            <div class="fila">
              <!-- Agrega este botón al final de tu formulario -->
              <button id="agregarEstudioButton" class="btnf btn-agregar btn-bg btn btn-primary" type="button">Agregar Nuevo
                Estudio
                Finalizado
              </button>
            </div>

            <!-- Titulo -->
            <div class="titulo">
              <h5>Documentación Requerida</h5>
            </div>
            <!-- Fila 13 -->
            <!-- Lista de checkboxes -->
            <div class="fila">
              <div class="divf-btn w50 centrarflex">
                <div class="btn-form">
                  <ul>
                    <li><input type="checkbox" id="dni" name="doc_dni"> DNI (frente y dorso)</li>
                    <li><input type="checkbox" id="certificado_medico" name="doc_medica"> Certificado Médico</li>
                    <li><input type="checkbox" id="analitico" name="doc_analitico"> Analítico</li>
                    <li><input type="checkbox" id="partida" name="doc_nacimiento"> Partida Nacimiento</li>
                  </ul>
                </div>
              </div>
              <!-- Botones adjuntar/ver -->
              <div class="divf-btn w50">
                <div class="div-adj w50 centrarbox">
                  <h6>Adjuntar Documentación</h6>
                  <button type="button" id="btn-adj" class="btnf btn-adj btn-width btn btn-primary">Adjuntar</button>
                  <!-- Multiple Archivos -->
                  <input type="file" name="adjunto[]" class="btnf btn-adj btn-width dnone" id="adjunto" multiple required>
                  <!-- mensaje para error <span id="mensaje_adj" tabindex="-1"></span>-->
                  <button type="button" class="btnf btn-ver btn-bg btn-width btn btn-primary" id="ver" onclick="location.href='https://drive.google.com/drive/folders/1NhRRLU584VSyjcG66B6OYYEgOZNK1RNR?hl=es'">Ver</button> 
                  </div>
              </div>
            </div>

            <!-- Fila 14 -->
            <div class="fila">
              <div class="columna">
                <label class="form-label text-black-50" for="plan_carrera">Plan de Carrera *</label>
                <select class="form-control select" id="plan_carrera" name="plan_carrera" required>
                  <option>Seleccione</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="estado_inscripcion">Estado Inscripción *</label>
                <select class="form-control select" id="estado_inscripcion" name="estado_inscripcion">
                  <option>Completo</option>
                  <option>Incompleto</option>
                </select>
              </div>

              <div class="columna">
                <label class="form-label text-black-50" for="estado_estudiante">Estado estudiante *</label>
                <select class="form-control select" id="estado_estudiante" name="estado_estudiante">
                  <option>Activo</option>
                  <option>Inactivo</option>
                </select>
              </div>
            </div>

            <!-- Fila 15 -->
            <div class="fila">
              <div class="columna" id="div-observaciones">
                <label class="form-label text-black-50" for="observaciones">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
              </div>
            </div>

            <!-- Botones -->
            <div class="btn-form centrarflex">
              <div class="div-btn w50 centrarflex">
				<a class="btn-width btn btn-primary nav-bar border-0" href="https://app.isft225.edu.ar/tablaestudiantes.php">VOLVER</a>  
              </div>
              <div class="div-btn w50 centrarflex">
               <button type="submit" name="submit" id="guardarDatos" class="btn-width btn-bg btn btn-primary border-0">GUARDAR</button> 
              </div>
            </div>
          </div>
        </div>
      </form>
    </main>
  </div>
</div>