<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Usuarios | LinaMar</title>
        <link rel="stylesheet" href="<?= URL::to("assets/css/styles.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/css/form.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/css/modal.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/plugins/sweetalert/sweetalert.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    </head>
    <body data-urlbase="<?= URL::base() ?>">
        <div class="container">
            <div class="card mt-5">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Listar Usuarios</h4>
                </div>
                <div class="card-body">
                    <div class="btn-group mb-3">
                        <!-- <a href="<?= URL::to("usuarios/form/crear") ?>" class="btn btn-primary">Crear usuario</a> -->
                        <button type="button" class="btn-modal btn btn-primary" data-id-modal="#modal-crear-usuario">
                            Crear usuario
                        </button>
                    </div>
                    <table class="table table-condensed table-hover table-striped" id="tablaListaUsuarios">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Edad</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="spinner-border text-primary">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Crear Usuario -->
        <div class="modal fade" id="modal-crear-usuario">
            <div class="modal-dialog">
                <form id="formUsuario" action="usuarios/registrar" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel">Registrar Usuario</h4>
                        <a type="button" class="btn-dismiss-modal btn-close">
                            <span class="material-symbols-rounded">
                                close
                            </span>
                        </a>
                    </div>
                    <div class="modal-body grid-container">
                            <?php if (isset($idUsuario)): ?>
                                <input type="hidden" id="idUsuario" value="<?= $idUsuario ?>" />
                            <?php endif; ?>

                            <div class="col-sm-6">
                                <label for="nombres">Nombres (*):</label>
                                <input type="text" class="form-control form-text" id="nombres" name="nombres" required="required" />
                            </div>
                            <div class="col-sm-6">
                                <label for="apellidos">Apellidos (*):</label>
                                <input type="text" class="form-control form-text" id="apellidos" name="apellidos" required="required" />
                            </div>
                            <div class="col-sm-4">
                                <label for="edad">Edad (*):</label>
                                <input type="number" class="form-control form-text" id="edad" name="edad" required="required" />
                            </div>
                            <div class="col-sm-4">
                                <label for="correo">Correo (*):</label>
                                <input type="email" class="form-control form-text" id="correo" name="correo" required="required" />
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control form-text" id="telefono" name="telefono" />
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-dismiss-modal btn btn-secondary">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="<?= URL::to("assets/plugins/jquery.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/funciones/functions.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/helperform.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/rutas.api.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/app.global.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/sweetalert/sweetalert.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/modulos/lista.usuarios.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/modulos/registrar.usuarios.js") ?>" type="text/javascript"></script>
    </body>
</html>