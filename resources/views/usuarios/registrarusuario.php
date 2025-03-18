<html>
    <head>
        <title>WGo | <?= isset($titulo) ? $titulo : "Registrar usuario" ?></title>
        <link href="<?= URL::to("assets/css/styles.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= URL::to("assets/plugins/sweetalert/sweetalert.css") ?>" rel="stylesheet" type="text/css"/>
    </head>
    <body data-urlbase="<?= URL::base() ?>">
        <div class="container">
            <div class="card mt-5">
                <div class="card-header bg-dark text-white">
                <h4 class="card-title mb-4"><?= isset($titulo) ? $titulo : "Registrar Usuario" ?></h4>
                </div>
                <div class="card-body">
                    <div class="btn-group mb-3">
                        <a href="<?= URL::base() ?>" class="btn btn-primary">Listar usuarios</a>
                    </div>
                    
                    <form id="formUsuario" action="usuarios/registrar" method="POST" class="grid-container">
                        <?php if (isset($idUsuario)): ?>
                            <input type="hidden" id="idUsuario" value="<?= $idUsuario ?>" />
                        <?php endif; ?>

                        <div class="form-group col-sm-6">
                            <label for="nombres">Nombres (*):</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required="required" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="apellidos">Apellidos (*):</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required="required" />
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="edad">Edad (*):</label>
                            <input type="number" class="form-control" id="edad" name="edad" required="required" />
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="correo">Correo (*):</label>
                            <input type="email" class="form-control" id="correo" name="correo" required="required" />
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" />
                        </div>
                        <div class="form-group text-right  col-sm-12">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="<?= URL::to("assets/plugins/jquery.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/funciones/functions.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/helperform.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/rutas.api.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/app.global.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/sweetalert/sweetalert.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/modulos/registrar.usuarios.js") ?>" type="text/javascript"></script>
    </body>
</html>