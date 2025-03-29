let vistaListarDistritosLima = {
  controles: {
      tbodyListaDistritosLima: $('#tablaListaDistritosLima tbody'),
  },
  init: function () {
      vistaListarDistritosLima.eventos();
      vistaListarDistritosLima.peticiones.listarDistritosLima();
  },
  eventos: function () {
      $(document).on(
          'click',
          '.btn-accion.eliminar',
          vistaListarDistritosLima.callbacks.eventos.onClickEliminar
      );
  },
  callbacks: {
      eventos: {
          onClickEliminar: function (evento) {
              const btnEliminar = $(evento.target);
              const idDistrito = btnEliminar.data('id');
              console.log('btnEliminar', btnEliminar);
              console.log('id', btnEliminar.data('id'));

              Swal.fire({
                  title: '¿Estás seguro?',
                  text: 'Esta acción no se puede deshacer',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Sí, eliminar',
                  cancelButtonText: 'Cancelar',
              }).then((result) => {
                  if (result.isConfirmed) {
                      vistaListarDistritosLima.peticiones.eliminarDistritoLimaPorId(idDistrito);
                  }
              });
          },
      },
      peticiones: {
          eliminarDistritoLimaPorId: {
              completo: function (respuesta) {
                  const v = __app.validarRespuesta(respuesta);
                  Swal.fire({
                      title: v ? 'Correcto' : 'Error',
                      text: respuesta.mensaje,
                      icon: v ? 'success' : 'error',
                  }).then(() => {
                      if (v) {
                          vistaListarDistritosLima.peticiones.listarDistritosLima();
                      }
                  });
              },
          },
          listarDistritosLima: {
              beforeSend: function () {
                  let tbody = vistaListarDistritosLima.controles.tbodyListaDistritosLima;
                  tbody.html(vistaListarDistritosLima.utils.templates.consultando());
              },
              completo: function (respuesta) {
                  let tbody = vistaListarDistritosLima.controles.tbodyListaDistritosLima;
                  let datos = __app.parsearRespuesta(respuesta);
                  if (datos && datos.length > 0) {
                      // Se inicializa la tabla #tablaListaDistritosLima y carga data
                      $('#tablaListaDistritosLima').DataTable({
                          responsive: true,
                          data: datos,
                          columns: [
                              { data: 'inIdubigeo' },
                              { data: 'vcDescdistrito' },
                              { data: 'vcDescprovincia' },
                              { data: 'vcMacroregion' },
                              { data: 'inHabilitado' },
                              { data: null },
                          ],
                          columnDefs: [
                              {
                                  render: (data, type, row) =>
                                      `<span class="badge ${
                                          data > 0 ? 'text-bg-success' : 'text-bg-warning'
                                      }">${data > 0 ? 'Habilitado' : 'Inhabilitado'}</span>`,
                                  targets: 4,
                              },
                              {
                                  render: (data, type, row) =>
                                      `<div class="btn-group btn-group-sm float-end">
                                          <button class="btn btn-dark">X</button>
                                          <button class="btn btn-dark">+</button>
                                          <button class="btn btn-dark">X</button>
                                      </div>`,
                                  targets: 5,
                              },
                          ],
                      });
                  } else {
                      tbody.html(vistaListarDistritosLima.utils.templates.noHayRegistros());
                  }
              },
          },
      },
  },
  peticiones: {
      eliminarDistritoLimaPorId: function (idDistrito) {
          __app
              .post(RUTAS_API.DISTRITOSLIMA.ELIMINAR_DISTRITOLIMA_POR_ID, {
                  idDistrito,
              })
              .success(vistaListarDistritosLima.callbacks.peticiones.eliminarDistritoLimaPorId.completo)
              .error(vistaListarDistritosLima.callbacks.peticiones.eliminarDistritoLimaPorId.completo)
              .send();
      },
      listarDistritosLima: function () {
          __app
              .get(RUTAS_API.DISTRITOSLIMA.LISTAR)
              .beforeSend(vistaListarDistritosLima.callbacks.peticiones.listarDistritosLima.beforeSend)
              .success(vistaListarDistritosLima.callbacks.peticiones.listarDistritosLima.completo)
              .error(vistaListarDistritosLima.callbacks.peticiones.listarDistritosLima.completo)
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

$(vistaListarDistritosLima.init);