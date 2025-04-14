/* DETALLES */

function addCheckbox(option) {
    const optionsContainer = document.getElementById("optionsDetalles");

    const div = document.createElement("div");
    div.className = "col-3 card-wrapper";

    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.value = option.inIdDetalle;
    checkbox.className = "form-check-input";
    checkbox.checked = true;
    checkbox.id = `idCheckbox-${option.inIdDetalle}`;

    const btnDelete = document.createElement("button");
    btnDelete.className = "btn-delete";
    btnDelete.innerHTML = `<span class="material-symbols-rounded">delete</span>`;
    btnDelete.onclick = function () {
        deleteDetalle(this);
      };

    const img = document.createElement("img");
    img.src = insertarThumb(option.vcUrlImagenDetalle);
    img.alt = option.vcNombreDetalle;

    const textOverlay = document.createElement("div");
    textOverlay.className = "text-overlay";
    textOverlay.innerText = option.vcNombreDetalle;

    div.appendChild(btnDelete);
    div.appendChild(checkbox);
    div.appendChild(img);
    div.appendChild(textOverlay);

    optionsContainer.appendChild(div);
}

function deleteDetalle(button) {
    const padre = button.parentNode;
    padre.remove();
}

function addDetalles() {
    vistaListarDetalleGeneral.controles.listaDetalles.forEach((detalle) => {
        addCheckbox(detalle);
    });
}

function clearContainerDetalles() {
    const optionsContainer = document.getElementById("optionsDetalles");
    optionsContainer.innerHTML = "";
}

function insertarThumb(ruta) {
    const lastSlashIndex = ruta.lastIndexOf("/");
    return (
        ruta.slice(0, lastSlashIndex + 1) +
        "thumb_" +
        ruta.slice(lastSlashIndex + 1)
    );
}

function selectListDetalle(){

    const optionsDetallesContainer = document.getElementById("optionsDetalles");

    let filasTabla = "";

    vistaListarDetalleGeneral.controles.listaDetalles.forEach((detalle) => {

        const checkboxExistente = optionsDetallesContainer.querySelector(`input[type='checkbox'][value="${detalle.inIdDetalle}"]`);

        filasTabla += `
            <tr class="${checkboxExistente ? 'disabled' : ''}">
                <td><input type="checkbox" class="checkbox-fila form-check-input" value="${detalle.inIdDetalle}" ${checkboxExistente ? 'disabled' : ''}></td>
                <td><img src="${insertarThumb(detalle.vcUrlImagenDetalle)}" style="width: 50px; aspect-ratio: 1/1; object-fit: cover; object-position: center;"></td>
                <td>${detalle.vcCodigoDetalle}</td>
                <td>${detalle.vcNombreDetalle}</td>
            </tr>`;
    });

    let tablaHTML = `
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:left;">
            <thead>
                <tr>
                    <th style="width: 30px"></th>
                    <th>Imagen</th>
                    <th>Código</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                ${filasTabla}
            </tbody>
        </table>
    `;

    Swal.fire({
        title: 'Seleccionar Detalles',
        html: tablaHTML,
        width: '600px',
        showCancelButton: true,
        confirmButtonText: 'Agregar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            // Aquí recogemos los valores seleccionados
            const checkboxes = document.querySelectorAll('.checkbox-fila:checked');
            const idsSeleccionados = Array.from(checkboxes).map(cb => cb.value);

            if (idsSeleccionados.length === 0) {
                Swal.showValidationMessage('Debes seleccionar al menos un detalle');
                return false;
            }

            return idsSeleccionados;
        }
    }).then((result) => {
        if (result.isConfirmed) {

            const seleccionados = vistaListarDetalleGeneral.controles.listaDetalles.filter(p => result.value.includes(p.inIdDetalle));

            seleccionados.forEach((detalle) => {
                // Verificar si el detalle ya está agregado
                const checkboxExistente = optionsDetallesContainer.querySelector(`input[type='checkbox'][value="${detalle.inIdDetalle}"]`);
                if (checkboxExistente) {
                    console.log(`El detalle ${detalle.vcNombreDetalle} ya está agregado.`);
                    return; 
                }

                // Si no está agregado, lo agregamos
                addCheckbox(detalle);
            });
        }
    });
}


/* END DETALLES */


/* DISTRITOS */

function addOptionsDistrito() {
    const optionsContainer = document.getElementById("optionsDistritos");

    // Limpiar opciones previas si es necesario
    optionsContainer.innerHTML = "";

    vistaListarDistritosLimaGeneral.controles.listaDistritosLima.forEach((distrito) => {
        const option = document.createElement("option");
        option.value = distrito.inIdUbigeo; // Usa el campo adecuado
        option.textContent = distrito.vcDescdistrito; // Usa el campo adecuado para mostrar
        optionsContainer.appendChild(option);
    });
}

/* END DISTRITOS */


function addOptions(idContainer) {

    const optionsContainer = document.getElementById(idContainer);

    const div = document.createElement("div");
    const newOption = document.createElement("input");
    const btnDelete = document.createElement("button");

    btnDelete.className = "form-btn-delete";
    btnDelete.innerHTML = `<span class="material-symbols-rounded">close</span>`;
    btnDelete.onclick = function () {
        deleteDetalle(this);
    };

    newOption.type = "text";
    newOption.className = "option-item";
    newOption.placeholder = `Opción...`;

    div.className = "col-12";
    div.appendChild(newOption);
    div.appendChild(btnDelete);

    optionsContainer.appendChild(div);
}

function saveForm(){
    const optionsContainer = document.getElementById("optionsDetalles");
    const opciones = [];

    optionsContainer
                .querySelectorAll("input[type='checkbox']:checked")
                .forEach((opcionInput) => {
                    if (opcionInput.value.trim() !== "") {
                        opciones.push(opcionInput.value);
                    }
                });

    console.log(opciones);
}

$(document).ready(function () {
    setTimeout(() => {
        /* DISTRITOS */
        addOptionsDistrito();
        /* END DISTRITOS */
    }, 1000);
});