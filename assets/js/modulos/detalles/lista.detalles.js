let vistaListarDetalle = {
    controles: {
      tbodyListaDetalles: $('#tablaListaDetalles tbody'),
    },
    init: function () {
      vistaListarDetalle.eventos();
      vistaListarDetalle.peticiones.listarDetalles();
    },
    eventos: function () {
      $(document).on(
        'click',
        '.btn-accion.eliminar',
        vistaListarDetalle.callbacks.eventos.onClickEliminar
      );
    },
    callbacks: {
      eventos: {
        onClickEliminar: function (evento) {
          const btnEliminar = $(evento.target);
          const idDetalle = btnEliminar.data('id');
          console.log('btnEliminar', btnEliminar);
          console.log('id', btnEliminar.data('id'));
  
          swal(
            {
              title: 'Estás seguro?',
              text: 'Esta acción no se puede deshacer',
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
              closeOnConfirm: false,
            },
            function (confirmado) {
              if (confirmado) {
                vistaListarDetalle.peticiones.eliminarDetalle(idDetalle);
              }
            }
          );
        },
      },
      peticiones: {
        eliminarDetalle: {
          completo: function (respuesta) {
            const v = __app.validarRespuesta(respuesta);
            swal(
              v ? 'Correcto' : 'Error',
              respuesta.mensaje,
              v ? 'success' : 'error'
            );
            v && vistaListarDetalle.peticiones.listarDetalles();
          },
        },
        listarDetalles: {
          beforeSend: function () {
            let tbody = vistaListarDetalle.controles.tbodyListaDetalles;
            tbody.html(vistaListarDetalle.utils.templates.consultando());
          },
          completo: function (respuesta) {
            let tbody = vistaListarDetalle.controles.tbodyListaDetalles;
            let datos = __app.parsearRespuesta(respuesta);
            if (datos && datos.length > 0) {

              // Se inicializa la tabla #tablaListaDetalles y carga data
              $('#tablaListaDetalles').DataTable( {
                destroy: true,
                responsive: true,
                order: [[4, 'desc']],
                data: datos,
                columns: [
                    { data: 'inIdDetalle' },
                    { data: 'vcNombreDetalle' },
                    { data: 'inSolPrecioDetalle' },
                    { data: 'inDolarPrecioDetalle' },
                    { data: 'tsFechaCreacion' },
                    { data: 'inHabilitado' },
                    { data: null },
                ],
                columnDefs: [
                  {
                      render: (data, type, row) => "<span class=\"badge " + (data > 0 ? "text-bg-success" : "text-bg-warning") +"\">" + (data > 0 ? "Habilitado" : "Inhabilitado") + "</span>",
                      targets: 5
                  },
                  {
                      render: (data, type, row) => "<div class=\"btn-group btn-group-sm float-end\">"+
                                                      "<button class=\"btn btn-dark\"><span class=\"material-symbols-rounded\">edit_square</span></button>" +
                                                      "<button class=\"btn btn-dark\"><span class=\"material-symbols-rounded\">close</span></button>" +
                                                    "</div>",
                      targets: 6
                  }
              ]
              } );

            } else {
              tbody.html(vistaListarDetalle.utils.templates.noHayRegistros());
            }
          },
        },
      },
    },
    peticiones: {
      eliminarDetalle: function (idDetalle) {
        __app
          .post(RUTAS_API.DETALLES.ELIMINAR_DETALLE_POR_ID, {
            idDetalle,
          })
          .success(vistaListarDetalle.callbacks.peticiones.eliminarDetalle.completo)
          .error(vistaListarDetalle.callbacks.peticiones.eliminarDetalle.completo)
          .send();
      },
      listarDetalles: function () {
        __app
          .get(RUTAS_API.DETALLES.LISTAR)
          .beforeSend(vistaListarDetalle.callbacks.peticiones.listarDetalles.beforeSend)
          .success(vistaListarDetalle.callbacks.peticiones.listarDetalles.completo)
          .error(vistaListarDetalle.callbacks.peticiones.listarDetalles.completo)
          .send();
      },
    },
    utils: {
      templates: {
        consultando: function () {
          return '<tr><td colspan="6">Consultando...</td></tr>';
        },
        noHayRegistros: function () {
          return '<tr><td colspan="6">No hay registros...</td></tr>';
        },
      },
    },
  };
  
  $(vistaListarDetalle.init);
  