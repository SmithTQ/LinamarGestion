let vistaListarDistritosLimaGeneral = {
    controles: {
        listaDistritosLima: {}
    },
    init: function () {
        vistaListarDistritosLimaGeneral.peticiones.listarDistritosLima();
    },
    callbacks: {
        peticiones: {
            listarDistritosLima: {
                beforeSend: function () {
                },
                completo: function (respuesta) {
                    let datos = __app.parsearRespuesta(respuesta);
                    vistaListarDistritosLimaGeneral.controles.listaDistritosLima = datos;
                    console.log("DistritosLima:", datos);
                },
            },
        },
    },
    peticiones: {
        listarDistritosLima: function () {
            __app
                .get(RUTAS_API.DISTRITOSLIMA.LISTAR)
                .beforeSend(vistaListarDistritosLimaGeneral.callbacks.peticiones.listarDistritosLima.beforeSend)
                .success(vistaListarDistritosLimaGeneral.callbacks.peticiones.listarDistritosLima.completo)
                .error(vistaListarDistritosLimaGeneral.callbacks.peticiones.listarDistritosLima.completo)
                .send();
        },
    },
  };
  
  $(vistaListarDistritosLimaGeneral.init);