let vistaRegistrarDetalles = {
    controles: {
        formDetalle: $('#formDetalle'),
        idDetalle: $('#inIdDetalle')
    },
    init: function () {
        vistaRegistrarDetalles.eventos();
        let idDetalle = vistaRegistrarDetalles.controles.idDetalle.val();
        vistaRegistrarDetalles.peticiones.consultarDetallePorId(idDetalle);
    },
    eventos: function () {
        vistaRegistrarDetalles.controles.formDetalle.on('submit', vistaRegistrarDetalles.callbacks.eventos.accionesFormRegistro.ejecutar);
    },
    callbacks: {
        eventos: {
            accionesFormRegistro: {
                ejecutar: function (evento) {
                    __app.detenerEvento(evento);
                    let form = vistaRegistrarDetalles.controles.formDetalle;
                    let obj = form.getFormData();
                    console.log(obj);
                    vistaRegistrarDetalles.peticiones.registrarDetalle(obj);
                }
            }
        },
        peticiones: {
            beforeSend: function () {
                vistaRegistrarDetalles.controles.formDetalle.find('input,button').prop('disabled', true);
            },
            completo: function () {
                vistaRegistrarDetalles.controles.formDetalle.find('input,button').prop('disabled', false);
            },
            finalizado: function (respuesta) {
                if (__app.validarRespuesta(respuesta)) {
                    if (!vistaRegistrarDetalles.controles.idDetalle.length) {
                        vistaRegistrarDetalles.controles.formDetalle[0].reset();
                        vistaRegistrarDetalles.controles.formDetalle.find('input').val('');
                    }
                    Swal.fire({
                        title: 'Correcto',
                        text: respuesta.mensaje,
                        icon: 'success'
                    }).then(() => {
                        $(vistaListarDetalle.init);
                    });
                    return;
                }
                Swal.fire({
                    title: 'Error',
                    text: respuesta.mensaje,
                    icon: 'error'
                });
            },
            consultarPorIdCompleto: function (respuesta) {
                if (__app.validarRespuesta(respuesta)) {
                    vistaRegistrarDetalles.controles.formDetalle.fillForm(respuesta.datos);
                    return;
                }
                Swal.fire({
                    title: 'Error',
                    text: respuesta.mensaje,
                    icon: 'error'
                });
            }
        }
    },
    peticiones: {
        registrarDetalle: function (obj) {
            let url = RUTAS_API.DETALLES.REGISTRAR_DETALLE;
            if (vistaRegistrarDetalles.controles.idDetalle.val() !== '') {
                url = RUTAS_API.DETALLES.ACTUALIZAR_DETALLE;
                obj.idDetalle = vistaRegistrarDetalles.controles.idDetalle.val();
                delete obj.inIdDetalle;
            }

            __app.post(url, obj)
                .beforeSend(vistaRegistrarDetalles.callbacks.peticiones.beforeSend)
                .complete(vistaRegistrarDetalles.callbacks.peticiones.completo)
                .success(vistaRegistrarDetalles.callbacks.peticiones.finalizado)
                .error(vistaRegistrarDetalles.callbacks.peticiones.finalizado)
                .send();
        },
        consultarDetallePorId: function (id) {
            if (!id) {
                return;
            }

            __app.post(RUTAS_API.DETALLES.CONSULTAR_DETALLE_POR_ID, {
                inIdDetalle: id,
            })
                .beforeSend(vistaRegistrarDetalles.callbacks.peticiones.beforeSend)
                .complete(vistaRegistrarDetalles.callbacks.peticiones.completo)
                .success(vistaRegistrarDetalles.callbacks.peticiones.consultarPorIdCompleto)
                .error(vistaRegistrarDetalles.callbacks.peticiones.consultarPorIdCompleto)
                .send();
        }
    }
};

$(vistaRegistrarDetalles.init);

function updateDetalle(idDetalle) {
    vistaRegistrarDetalles.controles.idDetalle.val(idDetalle);
    vistaRegistrarDetalles.peticiones.consultarDetallePorId(idDetalle);
}