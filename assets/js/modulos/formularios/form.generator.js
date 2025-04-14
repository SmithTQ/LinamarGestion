let questionCount = 0;

function addQuestion() {
    const container = document.getElementById("questions-container");
    const div = document.createElement("div");

    div.id = `question-${questionCount}`;
    div.className = "question grid-container";
    div.innerHTML = `
        <div class="col-6">
            <input type="text" placeholder="Pregunta sin título">
        </div>
        <div class="col-6">
            <select class="form-select" onchange="changeType(this)">
                <option value="text">✎ Respuesta corta</option>
                <option value="textarea">☰ Párrafo</option>
                <option value="select">▾ Desplegable</option>
                <option value="radio">◯ Opción múltiple</option>
                <option value="checkbox">☐ Casillas de verificación</option>
            </select>
        </div>
        <div class="options grid-container col-12">
            <div class="col-12"><input type="text" placeholder="Respuesta corta" disabled></div>
        </div>
        <div class="col-12">
            <div class="btn-group btn-group-sm float-end">
                <button class="btn btn-dark"  onclick="deleteQuestion(this)"><span class="material-symbols-rounded">delete</span></button>
            </div>
            <div class="float-end form-check" style="display: flex; height: 100%; align-items: center;">
                <input id="obligatorio-${questionCount}" type="checkbox" class="form-check-input">
                <label for="obligatorio-${questionCount}" class="form-check-label form-check-inline">Obligatorio</label>
            </div>
        </div>`;

    questionCount++;
    container.appendChild(div);
}

function deleteQuestion(button) {
    const question = button.closest(".question");
    if (question) {
        question.remove();
    }
}

function addOption(button) {
    const question = button.closest(".question");
    const optionsContainer = question.querySelector(".options");
    const div = document.createElement("div");
    const newOption = document.createElement("input");

    newOption.type = "text";
    newOption.className = "option-item";
    newOption.placeholder = `Opción ${
        optionsContainer.querySelectorAll(".option-item").length + 1
    }`;

    div.className = "col-12";
    div.appendChild(newOption);

    optionsContainer.insertBefore(div, optionsContainer.lastElementChild);
}

function addCheckbox(button, option) {
    const question = button.closest(".question");
    const optionsContainer = question.querySelector(".options");

    const div = document.createElement("div");
    div.className = "col-4";

    const label = document.createElement("label");
    label.className = "card-wrapper";
    label.for = `idCheckbox-${option.vcIdDetalle}`;

    const checkbox = document.createElement("input");
    checkbox.id = `idCheckbox-${option.vcIdDetalle}`;
    checkbox.type = "checkbox";
    checkbox.value = option.inIdDetalle;
    checkbox.className = "form-check-input";

    const img = document.createElement("img");
    img.src = insertarThumb(option.vcUrlImagenDetalle);
    img.alt = option.vcNombreDetalle;

    const span = document.createElement("span");
    span.className = "material-symbols-rounded check-icon";
    span.innerText = "check_circle";

    const textOverlay = document.createElement("div");
    textOverlay.className = "text-overlay";
    textOverlay.innerText = option.vcNombreDetalle;

    label.appendChild(checkbox);
    label.appendChild(img);
    label.appendChild(span);
    label.appendChild(textOverlay);

    div.appendChild(label);
    optionsContainer.appendChild(div);
}

function changeType(select) {
    const question = select.parentElement.parentElement;
    const optionsContainer = question.querySelector(".options");
    optionsContainer.innerHTML = "";
    const type = select.value;

    if (type === "text") {
        optionsContainer.innerHTML = `
            <div class="col-12">
                <input type="text" placeholder="Respuesta corta" disabled>
            </div>`;
    } else if (type === "textarea") {
        optionsContainer.innerHTML = `
            <div class="col-12">
                <textarea placeholder="Respuesta larga" disabled></textarea>
            </div>`;
    } else if (type === "select") {
        optionsContainer.innerHTML = `
            <div class="col-12"><label>Opciones:</label></div>
            <div class="col-12"><input type="text" placeholder="Opción 1"></div>
            <div class="col-12"><input type="text" placeholder="Opción 2"></div>
            <div class="col-12"><button class="btn btn-dark" onclick="addOption(this)">+</button></div>`;
    } else {
        optionsContainer.innerHTML = `
            <div class="col-12">
                <label>Opciones: </label>
                <span class="color-red">Seleccione las opciones que quiere mostrar en la lista</span>
            </div>`;

        vistaListarDetalleGeneral.controles.listaDetalles.forEach((detalle) => {
            addCheckbox(select, detalle);
        });
    }
}

function saveForm() {
    const formData = {
        tituloForm: document.getElementById("form-title").value,
        descripcionForm: document.getElementById("form-description").value,
        preguntas: [],
    };

    const questions = document.querySelectorAll(".question");

    questions.forEach((question) => {
        const pregunta = question.querySelector("input[type='text']").value;
        const tipo = question.querySelector("select").value;
        const obligatoria = question.querySelector(
            "input[type='checkbox']"
        ).checked;

        const opciones = [];

        const optionsContainer = question.querySelector(".options");
        if (tipo === "radio" || tipo === "checkbox") {
            optionsContainer
                .querySelectorAll("input[type='checkbox']:checked")
                .forEach((opcionInput) => {
                    if (opcionInput.value.trim() !== "") {
                        opciones.push(opcionInput.value);
                    }
                });
        } else if (tipo === "select") {
            optionsContainer
                .querySelectorAll("input[type='text']")
                .forEach((opcionInput) => {
                    if (opcionInput.value.trim() !== "") {
                        opciones.push(opcionInput.value);
                    }
                });
        }

        formData.preguntas.push({
            pregunta,
            tipo,
            obligatoria,
            opciones,
        });
    });

    console.log(formData);
}

function insertarThumb(ruta) {
    const lastSlashIndex = ruta.lastIndexOf("/");
    return (
        ruta.slice(0, lastSlashIndex + 1) +
        "thumb_" +
        ruta.slice(lastSlashIndex + 1)
    );
}
