let vistaRegistrarUsuario = {
    controles: {
        formUsuario: $('#formUsuario'),
        idUsuario: $('#idUsuario')
    },
    init: function () {
        vistaRegistrarUsuario.eventos();
        let idUsuario = vistaRegistrarUsuario.controles.idUsuario.val();
        vistaRegistrarUsuario.peticiones.consultarUsuarioPorId(idUsuario);
    },
    eventos: function () {
        vistaRegistrarUsuario.controles.formUsuario.on('submit', vistaRegistrarUsuario.callbacks.eventos.accionesFormRegistro.ejecutar);
    },
    callbacks: {
        eventos: {
            accionesFormRegistro: {
                ejecutar: function (evento) {
                    __app.detenerEvento(evento);
                    let form = vistaRegistrarUsuario.controles.formUsuario;
                    let obj = form.getFormData();
                    console.log(obj);
                    vistaRegistrarUsuario.peticiones.registrarUsuario(obj);
                }
            }
        },
        peticiones: {
            beforeSend: function () {
                vistaRegistrarUsuario.controles.formUsuario.find('input,button').prop('disabled', true);
            },
            completo: function () {
                vistaRegistrarUsuario.controles.formUsuario.find('input,button').prop('disabled', false);
            },
            finalizado: function (respuesta) {
                if (__app.validarRespuesta(respuesta)) {
                    if (!vistaRegistrarUsuario.controles.idUsuario.length) {
                        vistaRegistrarUsuario.controles.formUsuario.find('input').val('');
                    }
                    swal('Correcto', respuesta.mensaje, 'success');
                    $(vistaListarUsuario.init);
                    return;
                }
                swal('Error', respuesta.mensaje, 'error');
            },
            consultarPorIdCompleto: function (respuesta) {
                if (__app.validarRespuesta(respuesta)) {
                    vistaRegistrarUsuario.controles.formUsuario.fillForm(respuesta.datos)
                    return;
                }
                swal('Error', respuesta.mensaje, 'error');
            }
        }
    },
    peticiones: {
        registrarUsuario: function (obj) {
            let url = RUTAS_API.USUARIOS.REGISTRAR_USUARIO;
            if (vistaRegistrarUsuario.controles.idUsuario.length) {
                url = RUTAS_API.USUARIOS.ACTUALIZAR_USUARIO;
                obj.idUsuario = vistaRegistrarUsuario.controles.idUsuario.val();
            }

            __app.post(url, obj)
                    .beforeSend(vistaRegistrarUsuario.callbacks.peticiones.beforeSend)
                    .complete(vistaRegistrarUsuario.callbacks.peticiones.completo)
                    .success(vistaRegistrarUsuario.callbacks.peticiones.finalizado)
                    .error(vistaRegistrarUsuario.callbacks.peticiones.finalizado)
                    .send();
        },
        consultarUsuarioPorId: function (id) {
            if(!id) {
                return;
            }

            __app.post(RUTAS_API.USUARIOS.CONSULTAR_USUARIO_POR_ID, {
                idUsuario: id,
            })
                    .beforeSend(vistaRegistrarUsuario.callbacks.peticiones.beforeSend)
                    .complete(vistaRegistrarUsuario.callbacks.peticiones.completo)
                    .success(vistaRegistrarUsuario.callbacks.peticiones.consultarPorIdCompleto)
                    .error(vistaRegistrarUsuario.callbacks.peticiones.consultarPorIdCompleto)
                    .send();
        }
    }
};
$(vistaRegistrarUsuario.init);