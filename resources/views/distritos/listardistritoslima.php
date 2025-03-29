<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $titulo ?></title>

        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

        <link rel="stylesheet" href="<?= URL::to("assets/plugins/DataTables/datatables.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/plugins/DataTables/datatables.responsive.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/plugins/sweetalert/sweetalert.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/plugins/uicons-regular-rounded/css/initialization-uicons.css")?>" />
        <link rel="stylesheet" href="<?= URL::to("assets/css/styles.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/css/form.css") ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= URL::to("assets/css/modal.css") ?>" rel="stylesheet" type="text/css"/>
    </head>
    <body data-urlbase="<?= URL::base() ?>">
        <?= $navbar ?>
        <main>
            <div class="row">
                <?= $header ?>
                <div class="col-12 px-4 mt-4">
                    <div class="card card-float">
                        <div class="card-header pb-0">
                            <h5 class="card-title">Listar Distritos Lima</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-12 container-button flex-start my-2 mx-4">
                                <button type="button" class="btn-modal btn btn-primary" data-id-modal="#modal-crear-usuario">
                                    Registrar Distrito
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <table class="table table-condensed table-hover table-striped display nowrap" id="tablaListaDistritosLima">
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>Distrito</th>
                                        <th>Provincia</th>
                                        <th>Region</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <div class="spinner-border text-primary">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="modal-crear-usuario">
            <div class="modal-dialog">
            <form id="formUsuario" action="usuarios/registrar" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel">Registrar Distrito</h4>
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
        <script src="<?= URL::to("assets/js/modulos/distritos/lista.distritoslima.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/DataTables/datatables.min.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/DataTables/datatables.responsive.js") ?>" type="text/javascript"></script>
    </body>
</html>