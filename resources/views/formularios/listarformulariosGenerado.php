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

        <style>
            .form-container {
                background: white;
                border-radius: 8px;
                padding: 2rem;
                max-width: 800px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            .form-header {
                border-left: 8px solid #673ab7;
                padding-left: 1rem;
                margin-bottom: 2rem;
            }
            .question {
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1rem;
                background: #fafafa;
            }
        </style>
    </head>
    <body data-urlbase="<?= URL::base() ?>">
        <?= $navbar ?>
        <main>
            <div class="row">
                <?= $header ?>
                <div class="col-12 px-4 mt-4">
                    <div class="card card-float">
                        <div class="card-header pb-0">
                            <h5 class="card-title">Lista de formularios</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-12 container-button flex-start my-2 mx-4">
                                <button type="button" class="btn-modal btn btn-primary" data-id-modal="#modal-crear-formulario">
                                    Crear Formulario
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <table class="table table-condensed table-hover table-striped display nowrap" id="tablaListaFormularios">
                                <thead class="">
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre Formulario</th>
                                        <th>Fecha Creación</th>
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
        <div class="modal fade" id="modal-crear-formulario">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" data-title="Detalle" data-input-condition="inIdDetalle">Crear Formulario</h4>
                        <a type="button" class="btn-dismiss-modal btn-close">
                            <span class="material-symbols-rounded">
                                close
                            </span>
                        </a>
                    </div>
                    <div class="modal-body grid-container">
                        <div class="form-container col-12">
                            <div class="form-header grid-container">
                                <div class="col-12">
                                    <input type="text" id="form-title" placeholder="Título del formulario" class="form-control" required>
                                </div>
                                <div class="col-12">  
                                    <textarea id="form-description" placeholder="Descripción del formulario"></textarea>
                                </div>
                            </div>

                            <div id="questions-container"></div>

                            <button class="btn btn-primary" onclick="addQuestion()">+ Añadir pregunta</button>
                        </div>      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-dismiss-modal btn btn-secondary">Cerrar</button>
                        <button type="submit" class="btn btn-primary" onclick="saveForm()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?= URL::to("assets/plugins/jquery.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/funciones/functions.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/helperform.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/rutas.api.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/global/app.global.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/sweetalert/sweetalert.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/DataTables/datatables.min.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/plugins/DataTables/datatables.responsive.js") ?>" type="text/javascript"></script>
        
        <script src="<?= URL::to("assets/js/modulos/detalles/lista.detalles.general.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/modulos/formularios/form.generator.js") ?>" type="text/javascript"></script>

        
    </body>
</html>