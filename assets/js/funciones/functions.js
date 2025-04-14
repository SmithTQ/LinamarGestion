$(document).ready(function () {
    
    
    /* MODAL */

    $(document).on("click", ".btn-modal", function (e) {
        let idModal = $(this).data("id-modal");
        $(idModal).toggleClass("show");

        // Control de titulo del modal. Cambia el título del modal según el valor del input-condition
        let modalTitle = $(idModal).find('.modal-title');
        let inputCondition = $('#'+ modalTitle.data('input-condition')).val();

        if (inputCondition != undefined) {
            let titulo = inputCondition.length == 0 ? 'Registrar ' : 'Modificar '; 
            modalTitle.text(titulo + modalTitle.data('title')); 
        }
    });

    $(document).on("click", ".btn-dismiss-modal", function (e) {
        let idModal = "#" + $(this).closest(".modal").attr("id");
        $(idModal).toggleClass("show");

        // Resetea el formulario al cerrar el modal
        const modal = this.closest(".modal");
        const form = modal.querySelector("form");
        if (form) {
            form.reset();
            const hiddenInputs = form.querySelectorAll('input[type="hidden"]');
            hiddenInputs.forEach(input => {
                input.value = ''; 
            });
        }
    });

    /* window.addEventListener("click", function (e) {
        if (e.target.id.includes("modal")) {
            $(".modal").removeClass("show");
        }
    }); */

    /* END MODAL */



    /* ASIDE */

    $(".btn-toggle-aside").on("click", function (e) {
        $("aside").toggleClass("open");
    });

    /* END ASIDE */


    /* DROP IMAGEN (INPUT FILE) */

    document.querySelectorAll('.drop-zone').forEach(dropZone => {
        const fileInput = dropZone.querySelector('.file-input');
        const preview = dropZone.querySelector('.preview');
        const fileName = dropZone.querySelector('.file-name');
        const clearButton = dropZone.querySelector('.remove-btn');

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', event => handleFiles(event.target.files, preview, fileName, clearButton));

        dropZone.addEventListener('dragover', event => {
            event.preventDefault();
            dropZone.style.border = "2px dashed #fff";
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.style.border = "none";
        });

        dropZone.addEventListener('drop', event => {
            event.preventDefault();
            dropZone.style.border = "none";
            handleFiles(event.dataTransfer.files, preview, fileName, clearButton);
        });

        function handleFiles(files, preview, fileName, clearButton) {
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    fileName.innerText = file.name;
                    clearButton.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        clearButton.addEventListener('click', (event) => {
            event.stopPropagation();
            fileInput.value = '';
            preview.src = '';
            preview.style.display = 'none';
            fileName.innerText = "Arrastre y suelte aquí o has clic";
            clearButton.style.display = 'none';
        });

    });
    
    // Resetea los drop zones al resetear el formulario
    document.addEventListener('reset', (event) => {

        // Verifica que el evento de reset venga de un formulario
        if (event.target.tagName === 'FORM') {

            const fileInputs = event.target.querySelectorAll('.drop-zone');
            if (fileInputs.length === 0) return; // Sale de la función si no hay inputs file

            event.target.querySelectorAll('.drop-zone').forEach(dropZone => {
                const fileInput = dropZone.querySelector('.file-input');
                const preview = dropZone.querySelector('.preview');
                const fileName = dropZone.querySelector('.file-name');
                const clearButton = dropZone.querySelector('.remove-btn');
    
                event.stopPropagation();
                fileInput.value = '';
                preview.src = '';
                preview.style.display = 'none';
                fileName.innerText = "Arrastre y suelte aquí o has clic";
                clearButton.style.display = 'none';
            });
        }
    });
    
    /* END DROP IMAGEN (INPUT FILE) */

});
