const btnAddCarrera = document.getElementById("addEstudioBtn");
let indice = 0;
let carrera;
let institucion;
let estudio_finalizado;
let anio_egreso_s;
let anio_egreso;
let titulo_academico;

// Funcion para agregar un nuevo div
function agregarNuevaCarrera() {
 
  // Genera un nuevo ID unico para el div
  indice++;
  //capturo las variables con tag, fetch, axios o ajax? 
  console.log(carreraJson); 
  console.log(carreraArray); 
  console.log(indice); 
 
  //console.log(carrera_1);
  //btnAgregarEstudio.disabled = indice === 2 ? true : false;
  btnAddCarrera.style.display = indice === 2 ? 'none' : 'block';
 
  if (indice === 1){
    carrera = carreraArray[1];
    institucion = carreraArray[2];
    estudio_finalizado = carreraArray[3]; 
    anio_egreso_s = carreraArray[4];
    titulo_academico = carreraArray[5];
  } else {
    carrera = carreraArray[6];
    institucion = carreraArray[7];
    estudio_finalizado = carreraArray[8];
    anio_egreso_s = carreraArray[9];
    titulo_academico = carreraArray[10];
  }

  carrera = (carrera === undefined || carrera === null) ? "" : carrera; 
  institucion = (institucion === undefined || institucion === null) ? "" : institucion; 
  let checkEf = (estudio_finalizado === undefined || estudio_finalizado === null) ? 0 : estudio_finalizado; 
  titulo_academico = (titulo_academico === undefined || titulo_academico === null) ? "" : titulo_academico; 
  anio_egreso = (anio_egreso_s === undefined) ? null : parseInt(anio_egreso_s);

  const nuevoId = indice;
  // Crea un nuevo div
  const nuevoDiv = document.createElement("div");
  nuevoDiv.id = nuevoId;

  // Agrega contenido al nuevo div
  nuevoDiv.innerHTML = `
  <div class="fila">
  <div class="columna">
    <label class="form-label text-black-50">Carrera</label>
    <input type="text" class="form-control" id="carrera_${nuevoId}" name="carrera[]" value="${carrera}" required />
  </div>

  <div class="columna">
    <label class="form-label text-black-50">Institucion</label>
    <input type="text" class="form-control" id="institucion_${nuevoId}" name="institucion[]" value="${institucion}" required />
  </div>
  </div>

  <div class="fila">
  <div class="columna">
    <label class="form-label text-black-50">Estudio finalizado</label>
    <select class="form-control select" id="estudio_finalizado_${nuevoId}" name="estudio_finalizado[]" required > 
      <option ${checkEf === 1 ? 'selected' : ''} value="Si">Si</option>
      <option ${checkEf === 0 ? 'selected' : ''} value="No">No</option>
    </select>
  </div>

  <div class="columna">
    <label class="form-label text-black-50">Año de egreso</label>
    <input type="number" class="form-control" id="anio_egreso2_${nuevoId}" name="anio_egreso2[]" min="1900" max="2050" value="${anio_egreso}" required />
  </div>

  <div class="columna">
    <label class="form-label text-black-50">Titulo academico</label>
    <input type="text" class="form-control" id="titulo_academico_${nuevoId}" name="titulo_academico[]" value="${titulo_academico}" required />
  </div>

  <!-- Agrega un boton para eliminar el div -->
  <div class="columna div-eliminar centrarflex">
    <button type="button" class="btn btn-danger" onclick="eliminarCarrera('${nuevoId}')">Eliminar</button>
  </div>

  </div>`;

  // Agrega el nuevo div al contenedor
  const contenedor = document.getElementById("contenedorEstudiosFinalizados");
  contenedor.appendChild(nuevoDiv);
}

// Funcion para eliminar un div
function eliminarCarrera(id) {
  indice--;
  //btnAgregarEstudio.disabled = indice === 2 ? true : false;
  btnAddCarrera.style.display = indice === 2 ? 'none' : 'block';
  console.log(indice);
  const divAEliminar = document.getElementById(id);
  if (divAEliminar) {
    divAEliminar.parentNode.removeChild(divAEliminar);
  }
}

if ( btnAddCarrera !== null) {
  // Si el elemento existe (no es null)
  btnAddCarrera.addEventListener("click", agregarNuevaCarrera);
  console.log('El elemento existe');
} else {
  console.log('El elemento no existe');
}