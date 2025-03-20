$(document).ready(function () {
    
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        // Enviar datos al servidor
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.codigo === 1) {
                    Swal.fire({
                        title: "Éxito",
                        text: response.mensaje,
                        icon: "success"
                    }).then(() => {
                        sessionStorage.setItem('authToken', response.datos.token);
                        window.location.href = $('body').attr('data-urlbase') + "/detalles/listar";
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.mensaje,
                        icon: "error"
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: "Error",
                    text: "Ocurrió un error al procesar la solicitud.",
                    icon: "error"
                });
            }
        });
    });
});