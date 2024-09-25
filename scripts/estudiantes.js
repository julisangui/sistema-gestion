// Llamar a la funcion desde que se carga la pagina web
// Funcion para que la primer letra de un input de texto sea mayuscula
window.onload = function () {
  let inputs = document.getElementsByClassName("upLetra");
  for (var i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener("blur", function (e) {
      this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
    });
  }
};

let email = document.getElementById("email");
let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9]{2,}(?:\.[a-zA-Z0-9]{2,})?$/;

// Chequear si el email es valido
function checkemail() {
  if (email.validity.valueMissing || !regex.test(email.value)) {
    //document.getElementById("check-email").style.display = "block";
    email.setCustomValidity(
      "Ingrese un email valido Ej: nombre@correo.com o com.ar"
    );
    //alert('ingrese un email valido ej: nombre@correo.com o com.ar');
  } else {
    email.setCustomValidity("");
  }
  email.reportValidity();
}

// email.addEventListener('input', checkemail)
email.addEventListener("blur", checkemail); // Este evento sucede cuando un elemento ha perdido su foco

const inputPais = document.getElementById("pais_dom"); // el input del pais
const inputProvincia = document.getElementById("provincias"); // el input de la provincias
const inputMunicipios = document.getElementById("partido"); // el input del partido o municipio
const inputLocalidad = document.getElementById("localidad"); // el input las localidades
const selectMunicipios = document.getElementById("municipios_select");
const selectProvincia = document.getElementById("provincias_select");
const selectLocalidades = document.getElementById("localidad_select");

function checkPais() {
  let pais = inputPais.value; // el value del input pais

  // Quitamos los espacios
  const paisValue = pais.trim();
  console.log(paisValue);
  if (paisValue == "Argentina") {
    // las provincias de Argentina
    var provincias = [
      "Buenos Aires",
      "Catamarca",
      "Chaco",
      "Chubut",
      "Cordoba",
      "Corrientes",
      "Entre Rios",
      "Formosa",
      "Jujuy",
      "La Pampa",
      "La Rioja",
      "Mendoza",
      "Misiones",
      "Neuquen",
      "Rio Negro",
      "Salta",
      "San Luis",
      "Santiago del Estero",
      "San Juan",
      "Santa Cruz",
      "Santa Fe",
      "Tucuman",
      "Tierra del Fuego"
    ];

    // cargar el select con las provincias
    for (var i = 0; i < provincias.length; i++) {
      let option = document.createElement("option"); // crear un elemento option
      option.value = provincias[i]; // asignarle el valor de la provincia
      option.text = provincias[i]; // asignarle el texto de la provincia
      selectProvincia.appendChild(option); // agregar el option al select
    }
    selectProvincia.style.display = "block";
    inputProvincia.style.display = "none";

    changeProv();
    changeMunicipio();

    //inputProvincia.parentNode.replaceChild(selectProvincia, inputProvincia); // reemplazar el inputProvincia por el selectProvincia
    //inputProvincia = selectProvincia; // actualizar la referencia al inputProvincia
  } else {
    selectProvincia.style.display = "none";
    inputProvincia.style.display = "block";
    selectMunicipios.style.display = "none";
    inputMunicipios.style.display = "block";
    selectLocalidades.style.display = "none";
    inputLocalidad.style.display = "block";
  }
}

function changeProv() {
  let optProvincia = selectProvincia.value; // el valor del select de provincia
  console.log(optProvincia);

  if (optProvincia == "Buenos Aires") {
    // los municipios de Buenos Aires
    const municipios = [
      "Capital Federal",
      "Adolfo Alsina",
      "Adolfo Gonzales Chaves",
      "Alberti",
      "Almirante Brown",
      "Arrecifes",
      "Avellaneda",
      "Ayacucho",
      "Azul",
      "Bahia Blanca",
      "Balcarce",
      "Baradero",
      "Benito Juarez",
      "Berazategui",
      "Berisso",
      "Bolivar",
      "Bragado",
      "Brandsen",
      "Capital Federal",
      "Campana",
      "Cañuelas",
      "Capitan Sarmiento",
      "Carlos Casares",
      "Carlos Tejedor",
      "Carmen de Areco",
      "Castelli",
      "Chacabuco",
      "Chascomus",
      "Chivilcoy",
      "Colon",
      "Coronel Dorrego",
      "Coronel Pringles",
      "Coronel Rosales",
      "Coronel Suarez",
      "Daireaux",
      "Dolores",
      "Ensenada",
      "Escobar",
      "Esteban Echeverria",
      "Exaltacion de la Cruz",
      "Florencio Varela",
      "General Alvarado",
      "General Alvear",
      "General Arenales",
      "General Belgrano",
      "General Guido",
      "General La Madrid",
      "General Las Heras",
      "General Lavalle",
      "General Madariaga",
      "General Paz",
      "General Pinto",
      "General Pueyrredon",
      "General Rodriguez",
      "General San Martin",
      "General Viamonte",
      "General Villegas",
      "Guamini",
      "Hipolito Yrigoyen",
      "Hurlingham",
      "Ituzaingo",
      "Jose C. Paz",
      "Junin",
      "La Costa",
      "La Matanza",
      "La Plata",
      "Lanus",
      "Laprida",
      "Las Flores",
      "Leandro N. Alem",
      "Lincoln",
      "Loberia",
      "Lobos",
      "Lomas de Zamora",
      "Lujan",
      "Magdalena",
      "Maipu",
      "Malvinas Argentinas",
      "Mar Chiquita",
      "Marcos Paz",
      "Mercedes",
      "Merlo",
      "Monte",
      "Monte Hermoso",
      "Moreno",
      "Moron",
      "Navarro",
      "Necochea",
      "Nueve de Julio",
      "Olavarria",
      "Patagones",
      "Pehuajo",
      "Pellegrini",
      "Pergamino",
      "Pila",
      "Pilar",
      "Pinamar",
      "Presidente Peron",
      "Puan",
      "Punta Indio",
      "Quilmes",
      "Ramallo",
      "Rauch",
      "Rivadavia",
      "Rojas",
      "Roque Perez",
      "Saavedra",
      "Saladillo",
      "Salliquelo",
      "Salto",
      "San Andres de Giles",
      "San Antonio de Areco",
      "San Carlos de Bolivar",
      "San Cayetano",
      "San Fernando",
      "San Isidro",
      "San Miguel",
      "San Nicolas",
      "San Pedro",
      "San Vicente",
      "Suipacha",
      "Tandil",
      "Tapalque",
      "Tigre",
      "Tordillo",
      "Tornquist",
      "Trenque Lauquen",
      "Tres Arroyos",
      "Tres de Febrero",
      "Tres Lomas",
      "Veinticinco de Mayo",
      "Vicente Lopez",
      "Villa Gesell",
      "Villarino",
      "Zarate"
    ];

    // Cargar el select con municipios
    for (var i = 0; i < municipios.length; i++) {
      let option = document.createElement("option"); // crear un elemento option
      option.value = municipios[i]; // asignarle el nombre del municipio
      option.text = municipios[i]; // asignarle el texto de el municipio
      selectMunicipios.appendChild(option); // agregar el option al select
    }

    selectMunicipios.value = municipios[54];
    selectMunicipios.style.display = "block";
    changeMunicipio();
    inputMunicipios.style.display = "none";

    //inputCiudad.parentNode.replaceChild(selectMunicipios, inputCiudad); // reemplazar el inputCiudad por el selectMunicipios
    //inputCiudad = selectMunicipios; // actualizar la referencia al inputCiudad
  } else {
    selectMunicipios.style.display = "none";
    inputMunicipios.style.display = "block";
    selectLocalidades.style.display = "none";
    inputLocalidad.style.display = "block";
  }
}

function changeMunicipio() {
  let optProvincia = selectProvincia.value; // el valor del select de provincia
  let optMunicipios = selectMunicipios.value; // el valor del select del municipio
  console.log(optProvincia);
  console.log(optMunicipios);
  
  if (optProvincia == "Buenos Aires"  &&  optMunicipios == "General San Martin") {
    // las localidades de General San Martin:
    const localidades = [
      "Billinghurst",
      "Loma Hermosa",
      "Jose Leon Suarez",
      "San Andres",
      "San Martin",
      "Villa Ayacucho",
      "Villa Chacabuco",
      "Villa Ballester",
      "Villa Maipu",
      "Villa Maria Irene de los Remedios de Escalada",
      "Villa Marques Alejandro Maria de Aguado",
      "Villa Parque San Lorenzo",
      "Villa Yapeyu",
      "Villa Libertad",
      "Villa Lynch",
      "Villa Gregoria Matorras",
      "Villa Godoy Cruz",
      "Villa Granaderos de San Martin",
      "Villa Juan Martin de Pueyrredon",
      "Villa Coronel Jose Maria Zapiola",
      "Villa General Antonio Jose de Sucre",
      "Villa General Eugenio Necochea",
      "Villa General Jose Tomas Guido",
      "Villa General Juan Gregorio de Las Heras",
      "Villa Barrio Para Jefes y Oficiales General San Martin",
      "Villa Barrio Parque Figueroa Alcorta",
      "Villa Bernardo de Monteagudo"
    ];

    // Cargar el select con localidades
    for (var i = 0; i < localidades.length; i++) {
      let option = document.createElement("option"); // crear un elemento option
      option.value = localidades[i]; // asignarle el nombre del municipio
      option.text = localidades[i]; // asignarle el texto de el municipio
      selectLocalidades.appendChild(option); // agregar el option al select
    }
    selectLocalidades.value = localidades[4];
    selectLocalidades.style.display = "block";
    inputLocalidad.style.display = "none";

    //inputCiudad.parentNode.replaceChild(selectlocalidades, inputCiudad); // reemplazar el inputCiudad por el selectlocalidades
    //inputCiudad = selectlocalidades; // actualizar la referencia al inputCiudad
  } else {
    selectLocalidades.style.display = "none";
    inputLocalidad.style.display = "block";
  }
}

document.addEventListener("DOMContentLoaded", checkPais);
document.addEventListener("DOMContentLoaded", changeProv);
document.addEventListener("DOMContentLoaded", changeMunicipio);
inputPais.addEventListener("input", checkPais);
selectProvincia.addEventListener("change", changeProv);
selectMunicipios.addEventListener("change", changeMunicipio);

// Funcion para agregar un nuevo div
let index = 0;
function agregarNuevoEstudio() {
  // Genera un nuevo ID unico para el div
  index++;
  //btnAgregarEstudio.disabled = index === 2 ? true : false;
  btnAgregarEstudio.style.display = index === 2 ? 'none' : 'block';
  console.log(index);
  
  const nuevoId = index;

  // Crea un nuevo div
  const nuevoDiv = document.createElement("div");
  nuevoDiv.id = nuevoId;

  // Agrega contenido al nuevo div
  nuevoDiv.innerHTML = `
  <div class="fila">
  <div class="columna">
    <label class="form-label text-black-50">Carrera</label>
    <input type="text" class="form-control" id="carrera_${nuevoId}" name="carrera[]" placeholder="Carrera" required />
  </div>

  <div class="columna">
    <label class="form-label text-black-50">Institucion</label>
    <input type="text" class="form-control" id="institucion_${nuevoId}" name="institucion[]" placeholder="Institucion" required />
  </div>
  </div>

  <div class="fila">
  <div class="columna">
    <label class="form-label text-black-50">Estudio finalizado</label>
    <select class="form-control select" id="estudio_finalizado_${nuevoId}" name="estudio_finalizado[]" required >
      <option>Si</option>
      <option>No</option>
    </select>
  </div>

  <div class="columna">
    <label class="form-label text-black-50">Año de egreso</label>
    <input type="number" class="form-control" min="1900" max="2050" id="anio_egreso2_${nuevoId}" name="anio_egreso2[]" placeholder="2023" required />
  </div>

  <div class="columna">
    <label class="form-label text-black-50">Titulo academico</label>
    <input type="text" class="form-control" id="titulo_academico_${nuevoId}" name="titulo_academico[]" placeholder="Titulo academico" required />
  </div>

  <!-- Agrega un boton para eliminar el div -->
  <div class="columna div-eliminar centrarflex">
    <button type="button" class="btn btn-danger" onclick="eliminarEstudio('${nuevoId}')">Eliminar</button>
  </div>

  </div>`;

  // Agrega el nuevo div al contenedor
  const contenedor = document.getElementById("contenedorEstudiosFinalizados");
  contenedor.appendChild(nuevoDiv);
}

// Agrega evento click al boton y vincular funcion agregarNuevoEstudio()
const btnAgregarEstudio = document.getElementById("agregarEstudioButton");
if (btnAgregarEstudio !== null) {
  // Si el elemento existe (no es null), entonces lo asignamos a miElemento
  btnAgregarEstudio.addEventListener("click", agregarNuevoEstudio);
  console.log('El elemento existe');
} else {
  console.log('El elemento no existe');
}


// Funcion para eliminar un div
function eliminarEstudio(id) {
  index--;
  //btnAgregarEstudio.disabled = index === 2 ? true : false;
  btnAgregarEstudio.style.display = index === 2 ? 'none' : 'block';
  console.log(index);
  const divAEliminar = document.getElementById(id);
  if (divAEliminar) {
    divAEliminar.parentNode.removeChild(divAEliminar);
  }
}

// Funcion para agregar click y Adjuntar Archivos
const btnAdjuntar = document.getElementById("btn-adj");
const inputAdjuntar = document.getElementById("adjunto");
btnAdjuntar.addEventListener("click", () => {
  inputAdjuntar.click();
});

// Función para verificar la validación del formulario y enviarlo
function enviarformulario() {
  // Seleccionar el formulario por su nombre
  let formulario = document.querySelector("form[name='formulario']");

  // Verificar que los inputs del formulario cumplan con los requisitos de validación
  let valido = formulario.checkValidity();

  // Verificar el archivo adjunto
  const adjunto = document.getElementById("adjunto");
  const okArchivo = adjunto.files[0];

  // Mostrar información sobre el archivo adjunto en la consola
  console.log(okArchivo);
  
  // Realizar la validación
  if (okArchivo && valido) {
    // Permitir el envío del formulario si es válido y hay un archivo adjunto
    return true;
  } else if (okArchivo == undefined) {
    // Mostrar un mensaje de error si no se adjunta un archivo
    alert("Debes adjuntar un archivo.");
    return false;
  } else {
    // En caso de cualquier otra situación, evitar el envío del formulario
    return false;
  }
}

const btnGuardar = document.getElementById("guardarDatos");
btnGuardar.addEventListener("click", enviarformulario);