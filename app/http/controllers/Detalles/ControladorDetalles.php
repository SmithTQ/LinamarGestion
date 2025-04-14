<?php

require_once 'App\Http\Controllers\Utils\Utils.php';
require_once 'app/libraries/JWT/JWT.php';
require_once 'app/libraries/JWT/Key.php';

class ControladorDetalles extends Controller {
    
    private $utils;
    private $authMiddleware;

    private $contanerImagenes = "/assets/images/archivos/detalles/";

    function __construct() {
        parent::__construct();     
        $this->utils = new Utils();
        $this->authMiddleware = new AuthMiddleware();
        $this->menuItems = new MenuItems();
    }

    public function index() {
        $variables = [
            "titulo" => "Detalles | Linamar",
            "navbar" => $this->view("global/navbar", ["menuItems" => $this->menuItems->items, "activeItem" => "Detalles"]),
            "header" => $this->view("global/header", ["titulo" => "DETALLES"])
        ];
        return $this->view("detalles/listardetalles", $variables);
    }

    public function listarDetalles(Request $request) {
        return $this->authMiddleware->handle($request, function($request) {
            
            $listDetallesModel = new ListDetalles();
            
            $query = "SELECT d.*, COALESCE(pd.inSolPrecioDetalle, '0.00') as inSolPrecioDetalle, COALESCE(pd.inDolarPrecioDetalle, '0.00') as inDolarPrecioDetalle  FROM tb_detalles d
                        left join tb_preciodetalles pd on d.inIdDetalle = pd.inIdDetalle order by d.tsFechaCreacion desc";
            $lista = $listDetallesModel->get($query);
            
            $v = count($lista);
            
            $respuesta = new Respuesta($v ? EMensajes::CORRECTO : EMensajes::ERROR);
            $respuesta->setDatos($lista);

            return $respuesta;

        });
    }

    public function buscarDetallePorId(Request $request) {
        $idDetalle = $request->inIdDetalle;
        $detallesModel = new ListDetalles();
        
        $query = "SELECT d.*, COALESCE(pd.inSolPrecioDetalle, '0.00') as inSolPrecioDetalle, COALESCE(pd.inDolarPrecioDetalle, '0.00') as inDolarPrecioDetalle  
                FROM tb_detalles d
                left join tb_preciodetalles pd on d.inIdDetalle = pd.inIdDetalle 
                where d.inIdDetalle = :inIdDetalle";

        $detalle = $detallesModel->first($query, [":inIdDetalle" => $idDetalle]);
        
        $v = ($detalle != null);
        $respuesta = new Respuesta($v ? EMensajes::CORRECTO : EMensajes::NO_HAY_REGISTROS);
        $respuesta->setDatos($detalle);
        return $respuesta;
    }

    public function registrarDetalle(Request $request) {
        return $this->authMiddleware->handle($request, function($request) {
            
            $detalleModel = new Detalles();

            // Validar existencia de detalle
            $detalle = $detalleModel->where("vcNombreDetalle", "=", $request->vcNombreDetalle)->first();
            if ($detalle) {
                return new Respuesta(EMensajes::ERROR, "Ya se encuentra registrado un detalle con el mismo nombre.");
            }

            // Validar formato de imagen
            if($request->imagen != "" && $request->imagen != null){
                if ($this->utils->validarImagen($_FILES['imagen']) == false) {
                    return new Respuesta(EMensajes::ERROR, "Formato de imagen no permitido. Solo JPG, PNG y GIF.");
                }
            }

            // Insertar Detalle
            $request = $this->getRequestDetalle($request);
            $id = $detalleModel->insert($request->all());
            $v = ($id > 0);
            
            // Insertar Precio Detalle
            $idPrecio = 0;
            $v2 = false;
            if($v){
                $idPrecio = $this->registrarPrecioDetalle($request, $id);

                // Guardar imagen
                if($request->imagen != "" && $request->imagen != null){
                    $image = $this->utils->guardarImagen($_FILES['imagen'], $id, "assets/images/archivos/detalles/");
                }
            }

            $v2 = ($idPrecio > 0);
            $respuesta = new Respuesta($v && $v2? EMensajes::INSERCION_EXITOSA : EMensajes::ERROR_INSERSION);
            $respuesta->setDatos($id);

            return $respuesta;
            
        });
    }

    private function registrarPrecioDetalle(Request $request, $idDetalle) {
            $precioDetalleModel = new PrecioDetalles();

            $request = $this->getRequestPrecioDetalle($request, $idDetalle);
            $id = $precioDetalleModel->insert($request->all());
            $v = ($id > 0);

            return $v;
    }

    public function actualizarDetalle(Request $request) {
        
        $request->tsFechaModificacion = $this->utils->todayTimestamp();
        
        $detalleModel = new Detalles();
        
        // Modificar Detalle
        $actualizados = $detalleModel->where("inIdDetalle", " = ", $request->idDetalle)->update($request->all());
        $v = ($actualizados >= 0);

        // Modificar Precio Detalle
        if ($v && (!isset($request->inSolPrecioDetalle) || !isset($request->inDolarPrecioDetalle))) {
            $v = $this->actualizarPrecioDetalle($request, $request->idDetalle);
        }

        // Modificar Imagen
        if ($v && isset($_FILES['imagen'])) {
            $tipoImagen = pathinfo($_FILES['imagen']["name"], PATHINFO_EXTENSION);
            $rutaImagen = URL::base() . $this->contanerImagenes . $request->idDetalle . ".". $tipoImagen;
            $image = $this->utils->guardarImagen($_FILES['imagen'], $request->idDetalle, "assets/images/archivos/detalles/");
            $v = ($image != null);
        }

        return new Respuesta($v ? EMensajes::ACTUALIZACION_EXITOSA : EMensajes::ERROR_ACTUALIZACION);
    }

    private function actualizarPrecioDetalle(Request $request, $idDetalle) {
        $precioDetalleModel = new PrecioDetalles();

        $actualizados = $precioDetalleModel->where("inIdDetalle", " = ", $idDetalle)->update($request->all());
        $v = ($actualizados >= 0);

        return $v;
}


    private function getRequestDetalle(Request $request) {

        $id = $this->utils->getUUID();
        $tipoImagen = null;
        $rutaImagen = null;

        if (isset($_FILES['imagen'])) {
            $tipoImagen = pathinfo($_FILES['imagen']["name"], PATHINFO_EXTENSION);
            $rutaImagen = URL::base() . $this->contanerImagenes . $id . ".". $tipoImagen;
       }   
        
        $request->inIdDetalle = $id;
        $request->vcCodigoDetalle = $this->utils->getNewCodigo("tb_detalles", "vcCodigoDetalle", "");
        $request->tsFechaCreacion = $this->utils->todayTimestamp();
        $request->vcUrlImagenDetalle = $rutaImagen != null ? $rutaImagen : null;
        $request->vcTipoImagenDetalle = $tipoImagen != null ? $tipoImagen : null;
        $request->inVersion = 1;
        $request->inHabilitado = 1;

        return $request;
    }
    
    private function getRequestPrecioDetalle(Request $request, $idDetalle) {

        $precioSol = $this->utils->formatNumber((!isset($request->inSolPrecioDetalle) ? $request->inSolPrecioDetalle : 0));
        $precioDolar = $this->utils->formatNumber((!isset($request->inDolarPrecioDetalle) ? $request->inDolarPrecioDetalle : 0));
        
        $request->inIdPrecioDetalle = $this->utils->getUUID();
        $request->inIdDetalle = $idDetalle;
        $request->inSolPrecioDetalle = $precioSol;
        $request->inDolarPrecioDetalle = $precioDolar;
        $request->tsFechaCreacion = $this->utils->todayTimestamp();
        $request->inVersion = 1;
        $request->inHabilitado = 1;

        return $request;
    }
}
