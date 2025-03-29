let vistaListarUsuario = {
  controles: {
    tbodyListaUsuarios: $('#tablaListaUsuarios tbody'),
  },
  init: function () {
    vistaListarUsuario.eventos();
    vistaListarUsuario.peticiones.listarUsuarios();
  },
  eventos: function () {
    $(document).on(
      'click',
      '.btn-accion.eliminar',
      vistaListarUsuario.callbacks.eventos.onClickEliminar
    );
  },
  callbacks: {
    eventos: {
      onClickEliminar: function (evento) {
        const btnEliminar = $(evento.target);
        const idUsuario = btnEliminar.data('id');
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
            vistaListarUsuario.peticiones.eliminarUsuarioPorId(idUsuario);
          }
        });
      },
    },
    peticiones: {
      eliminarUsuarioPorId: {
        completo: function (respuesta) {
          const v = __app.validarRespuesta(respuesta);
          Swal.fire({
            title: v ? 'Correcto' : 'Error',
            text: respuesta.mensaje,
            icon: v ? 'success' : 'error',
          }).then(() => {
            if (v) {
              vistaListarUsuario.peticiones.listarUsuarios();
            }
          });
        },
      },
      listarUsuarios: {
        beforeSend: function () {
          let tbody = vistaListarUsuario.controles.tbodyListaUsuarios;
          tbody.html(vistaListarUsuario.utils.templates.consultando());
        },
        completo: function (respuesta) {
          let tbody = vistaListarUsuario.controles.tbodyListaUsuarios;
          let datos = __app.parsearRespuesta(respuesta);
          if (datos && datos.length > 0) {
            tbody.html('');
            for (let i = 0; i < datos.length; i++) {
              let dato = datos[i];
              tbody.append(vistaListarUsuario.utils.templates.item(dato));
            }
          } else {
            tbody.html(vistaListarUsuario.utils.templates.noHayRegistros());
          }
        },
      },
    },
  },
  peticiones: {
    eliminarUsuarioPorId: function (idUsuario) {
      __app
        .post(RUTAS_API.USUARIOS.ELIMINAR_USUARIO_POR_ID, {
          idUsuario,
        })
        .success(vistaListarUsuario.callbacks.peticiones.eliminarUsuarioPorId.completo)
        .error(vistaListarUsuario.callbacks.peticiones.eliminarUsuarioPorId.completo)
        .send();
    },
    listarUsuarios: function () {
      __app
        .get(RUTAS_API.USUARIOS.LISTAR)
        .beforeSend(vistaListarUsuario.callbacks.peticiones.listarUsuarios.beforeSend)
        .success(vistaListarUsuario.callbacks.peticiones.listarUsuarios.completo)
        .error(vistaListarUsuario.callbacks.peticiones.listarUsuarios.completo)
        .send();
    },
  },
  utils: {
    templates: {
      item: function (obj) {
        return (
          '<tr>' +
          '<td>' +
          obj.nombres +
          '</td>' +
          '<td>' +
          obj.apellidos +
          '</td>' +
          '<td>' +
          obj.edad +
          '</td>' +
          '<td>' +
          obj.correo +
          '</td>' +
          '<td>' +
          obj.telefono +
          '</td>' +
          '<td>' +
          '<a href="' +
          __app.urlTo('/usuarios/form/edicion/' + btoa(obj.id)) +
          '" class="btn-accion editar">Editar</a>' +
          '  |  ' +
          '<a href="javascript:;" class="btn-accion eliminar" data-id="' +
          obj.id +
          '">Eliminar</a>' +
          '</td>' +
          '</tr>'
        );
      },
      consultando: function () {
        return '<tr><td colspan="6">Consultando...</td></tr>';
      },
      noHayRegistros: function () {
        return '<tr><td colspan="6">No hay registros...</td></tr>';
      },
    },
  },
};

$(vistaListarUsuario.init);