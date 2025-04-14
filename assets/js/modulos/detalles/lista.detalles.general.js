let vistaListarDetalleGeneral = {
    controles: {
        tbodyListaDetalles: $('#tablaListaDetalles tbody'),
        listaDetalles: {}
    },
    init: function () {
        vistaListarDetalleGeneral.peticiones.listarDetalles();
    },
    callbacks: {
        peticiones: {
            listarDetalles: {
                beforeSend: function () {
                   
                },
                completo: function (respuesta) {
                    let datos = __app.parsearRespuesta(respuesta);
                    vistaListarDetalleGeneral.controles.listaDetalles = datos;
                    console.log(datos);
                },
            },
        },
    },
    peticiones: {
        listarDetalles: function () {
            __app
                .get(RUTAS_API.DETALLES.LISTAR)
                .beforeSend(vistaListarDetalleGeneral.callbacks.peticiones.listarDetalles.beforeSend)
                .success(vistaListarDetalleGeneral.callbacks.peticiones.listarDetalles.completo)
                .error(vistaListarDetalleGeneral.callbacks.peticiones.listarDetalles.completo)
                .send();
        },
    }
  };
  
  $(vistaListarDetalleGeneral.init);

  