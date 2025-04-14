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
                background: #fafafa;
            }
            .question:has(> div > input[type="checkbox"]:not(:checked)) > div:nth-child(2){
                opacity: 0.3;
                pointer-events: none;
            }
            .question:has(> div > input[type="checkbox"]:not(:checked)){
                /* border: none; */
                background: transparent;
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
                        <h4 class="modal-title fs-5">Crear Formulario</h4>
                        <a type="button" class="btn-dismiss-modal btn-close">
                            <span class="material-symbols-rounded">
                                close
                            </span>
                        </a>
                    </div>
                    <div class="modal-body grid-container">
                        <input value="" type="hidden" id="inIdFormulario" name="inIdFormulario" checked/>
                        <div class="question col-12 grid-container">
                            <div class="col-12">
                                <label class="form-label">Titulo de Formulario:</label>
                                <input type="text" class="form-control form-text" name="vcTituloFormulario"/>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción de Formulario:</label>
                                <textarea type="text" class="form-control form-text" name="vcDescFormulario"></textarea>
                            </div>
                            <div class="col-12 drop-zone" data-index="1">
                                <label class="form-label">Imagen de portada:</label>
                                <img class="preview" style="display: none;">
                                <p class="file-name">Arrastre y suelte aquí o has clic</p>
                                <input type="file" class="file-input" name="imagen" accept="image/png, image/jpeg">
                                <button type="button" class="remove-btn">🗑</button>
                            </div>
                        </div>
                        
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blDetalleFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Detalle(*):</label>
                                </div>
                                <div class="col-12">
                                    <label>Opciones:</label>
                                    <div class="btn-group btn-group-sm float-end">
                                        <button class="btn btn-secondary" type="button" onclick="clearContainerDetalles()">Limpiar</button>
                                        <button class="btn btn-dark" type="button" onclick="selectListDetalle()">Agregar opciones</button>
                                    </div>
                                </div>
                                <div class="col-12 grid-container" id="optionsDetalles">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blRemitenteFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-6">
                                    <label class="form-label">Remitente(De):</label>
                                    <input type="text" class="form-control form-text" placeholder="Quien envía" disabled/>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Telefono:</label>
                                    <input type="text" class="form-control form-text" placeholder="+51987654321" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blDestinatarioFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-6">
                                    <label class="form-label">Destinatario(Para):</label>
                                    <input type="text" class="form-control form-text" placeholder="Quien recibe" disabled/>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Telefono:</label>
                                    <input type="text" class="form-control form-text" placeholder="+51987654321" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blDistritoFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Distrito:</label>
                                    <select id="optionsDistritos" class="form-select"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blDireccionFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Dirección exacta:</label>
                                    <textarea type="text" class="form-control form-text" placeholder="Dirección de entrega" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blReferenciaFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Referencia:</label>
                                    <textarea type="text" class="form-control form-text" placeholder="Referencia de la ubicación" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blFechaEntregaFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Fecha de Entrega:</label>
                                    <input type="date" class="form-control form-text"  disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blHorarioEntregaFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Horario de entrega:</label>
                                </div>
                                <div class="col-12">
                                    <label>Opciones:</label>
                                    <div class="btn-group btn-group-sm float-end">
                                        <button class="btn btn-dark" type="button" onclick="addOptions('optionsHorarioEntrega')">Agregar opción</button>
                                    </div>
                                </div>
                                <div class="col-12 grid-container" id="optionsHorarioEntrega">
                                    <div class="col-12">
                                        <input type="text" class="option-item form-control" placeholder="Opción...">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="option-item form-control" placeholder="Opción...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blTipoPagoFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Tipo de Pago:</label>
                                    <select class="form-select">
                                        <option value="Yape">Yape</option>
                                        <option value="Plin">Plin</option>
                                        <option value="PayPal">PayPal</option>
                                        <option value="Western Union">Western Union</option>
                                        <option value="Transferencia">Transferencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blNombreTapaFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Nombre en Tapa:</label>
                                    <input type="date" class="form-control form-text"  disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blDedicatoriaFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Dedicatoria:</label>
                                    <textarea type="text" class="form-control form-text" placeholder="Dedicatoria..." disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blAdicionalesFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Adicionales:</label>
                                </div>
                                <div class="col-12">
                                    <label>Opciones:</label>
                                    <div class="btn-group btn-group-sm float-end">
                                        <button class="btn btn-dark" type="button" onclick="addOptions('optionsAdicionales')">Agregar opción</button>
                                    </div>
                                </div>
                                <div class="col-12 grid-container" id="optionsAdicionales">
                                    <div class="col-12">
                                        <input type="text" class="option-item form-control" placeholder="Opción...">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="option-item form-control" placeholder="Opción...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 grid-container question">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="blFotoAdicionalFormulario" checked/>
                            </div>
                            <div class="col-11 grid-container">
                                <div class="col-12">
                                    <label class="form-label">Foto (Adicional):</label>
                                </div>
                                <div class="col-12 drop-zone disabled" data-index="1">
                                    <img class="preview" style="display: none;">
                                    <p class="file-name">Arrastre y suelte aquí o has clic</p>
                                    <input type="file" class="file-input" name="imagen" accept="image/png, image/jpeg">
                                    <button type="button" class="remove-btn">🗑</button>
                                </div>
                            </div>
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
        <script src="<?= URL::to("assets/js/modulos/distritos/lista.distritoslima.general.js") ?>" type="text/javascript"></script>
        <script src="<?= URL::to("assets/js/modulos/formularios/funciones.js") ?>" type="text/javascript"></script>

        
    </body>
</html>